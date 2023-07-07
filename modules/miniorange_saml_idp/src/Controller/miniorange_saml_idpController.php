<?php /**
 * @file
 * Contains \Drupal\miniorange_saml_idp\Controller\DefaultController.
 */

namespace Drupal\miniorange_saml_idp\Controller;

use DOMDocument;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Url;
use Drupal\miniorange_saml_idp\Utilities;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use \Symfony\Component\HttpFoundation\Cookie;
use \Symfony\Component\HttpFoundation\Response;
use Drupal\miniorange_saml_idp\GenerateResponse;
use Drupal\miniorange_saml_idp\MiniOrangeAuthnRequest;
use Drupal\miniorange_saml_idp\MiniorangeSAMLCustomer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\miniorange_saml_idp\miniorange_saml_registration;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\miniorange_saml_idp\MiniorangeSAMLIdpConstants;

class miniorange_saml_idpController extends ControllerBase {
    protected $formBuilder;

    public function __construct(FormBuilder $formBuilder = NULL){
        $this->formBuilder = $formBuilder;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get("form_builder")
        );
    }

    /**
     * Handles Feedback
     */

    public function miniorange_saml_idp_feedback_func() {
        $modulesInfo = \Drupal::service('extension.list.module')->getExtensionInfo('miniorange_saml_idp');
        $modulesVersion = $modulesInfo['version'];

        $drupalCoreVersion = Utilities::mo_get_drupal_core_version();

        $res = json_encode($_POST);
        $outarr = json_decode($res, TRUE);
        $_SESSION['mo_other'] = "False";
        $reason = isset($outarr['reason']) ? $outarr['reason'] : '';
        $q_feedback = isset($outarr['q_feedback']) ? $outarr['q_feedback'] : '';
        $message = 'Reason: ' . $reason . '<br>Feedback: ' . $q_feedback;
        $url = 'https://login.xecurify.com/moas/api/notify/send';
        $ch = curl_init($url);
        $email = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email');

        if (empty($email)) {
            $email = isset($outarr['email']) ? $outarr['email'] : '';
        }

        if (\Drupal::service('email.validator')->isValid($email)) {
            $phone = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_phone');
            $customerKey = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_id');
            if ($customerKey == '') {
                $customerKey = "16555";
            }

            $customer = new MiniorangeSAMLCustomer($email, $phone,NULL,NULL);
            $fromEmail = $email;
            $subject = "Drupal " . $drupalCoreVersion . " SAML IDP Free Module Feedback | " . $modulesVersion;
            $query   = '[Drupal ' . $drupalCoreVersion . ' SAML IDP Free | ' . $modulesVersion . ']: ' . $message;
            $content = '<div >Hello, <br><br>Company :<a href="' . $_SERVER['SERVER_NAME'] . '" target="_blank" >' . $_SERVER['SERVER_NAME'] . '</a><br><br>Phone Number :' . $phone . '<br><br>Email :<a href="mailto:' . $fromEmail . '" target="_blank">' . $fromEmail . '</a><br><br>Query: ' . $query . '</div>';
            $fields  = array(
                'customerKey' => $customerKey,
                'sendEmail' => true,
                'email' => array(
                    'customerKey' => $customerKey,
                    'fromEmail' => $fromEmail,
                    'fromName' => 'miniOrange',
                    'toEmail' => 'drupalsupport@xecurify.com',
                    'toName' => 'drupalsupport@xecurify.com',
                    'subject' => $subject,
                    'content' => $content
                ),
            );
          $customer->callService($url,$fields,TRUE);
        }
        return new Response();
    }

    public function openModalForm() {
        $response = new AjaxResponse();
        $modal_form = $this->formBuilder->getForm('\Drupal\miniorange_saml_idp\Form\MiniorangeSAMLRemoveLicense');
        $response->addCommand(new OpenModalDialogCommand('Remove Account', $modal_form, ['width' => '800']));
        return $response;
    }

    public function miniorange_saml_register(){
        $payment_plan = isset($_GET['payment_plan']) ? $_GET['payment_plan'] : '';
        miniorange_saml_registration::miniorange_saml_register_popup($payment_plan);
        return new Response();
    }

    public function miniorange_saml_close_registration(){
        Utilities::saml_back(true);
        return new Response();
    }

    public function uninst_mod()
    {
        global $base_url;
        \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings')->clear('miniorange_saml_idp_feedback')->save();
        \Drupal::service('module_installer')->uninstall(['miniorange_saml_idp']);
        $uninstall_redirect = $base_url . '/admin/modules';
        $response = new RedirectResponse($uninstall_redirect);
        $response->send();
        return new Response();
    }

    /**
     * This function is used to get the timestamp value
     */
    public function get_oauth_timestamp()
    {
        $url = 'https://login.xecurify.com/moas/rest/mobile/get-timestamp';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // required for https urls
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        $content = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error in sending curl Request';
            exit ();
        }
        curl_close($ch);
        if (empty($content)) {
            $currentTimeInMillis = round(microtime(true) * 1000);
            $currentTimeInMillis = number_format($currentTimeInMillis, 0, '', '');
        }
        return empty($content) ? $currentTimeInMillis : $content;
    }

    function miniorange_saml_idp_metadata(){
        self::_generate_metadata();
    }

    function _generate_metadata($download = false){
        global $base_url;
        $site_url = $base_url . '/';
        $entity_id = $site_url . '?q=admin/config/people/miniorange_saml_idp/';
        $login_url = $site_url . 'initiatelogon';
        $logout_url = $site_url;

        define('DRUPAL_BASE_ROOT', dirname(__FILE__));

        $certificate_raw = MiniorangeSAMLIdpConstants::MINIORANGE_PUBLIC_CERTIFICATE;
        $certificate = preg_replace("/[\r\n]+/", "", $certificate_raw);
        $certificate = str_replace("-----BEGIN CERTIFICATE-----", "", $certificate);
        $certificate = str_replace("-----END CERTIFICATE-----", "", $certificate);
        $certificate = str_replace(" ", "", $certificate);

        if ($download === 'certificate'){
          header('Content-Disposition: attachment; filename="idp-certificate.crt"');
          echo $certificate_raw; exit;
        }

        if ($download) {
            header('Content-Disposition: attachment; filename="Metadata.xml"');
        } else {
            header('Content-Type: text/xml');
        }
        echo '<?xml version="1.0" encoding="UTF-8"?>
<md:EntityDescriptor xmlns:md="urn:oasis:names:tc:SAML:2.0:metadata" entityID="' . $entity_id . '">
    <md:IDPSSODescriptor WantAuthnRequestsSigned="true" protocolSupportEnumeration="urn:oasis:names:tc:SAML:2.0:protocol">
        <md:KeyDescriptor use="signing">
            <ds:KeyInfo xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
                <ds:X509Data>
                    <ds:X509Certificate>' . $certificate . '</ds:X509Certificate>
                </ds:X509Data>
            </ds:KeyInfo>
        </md:KeyDescriptor>
        <md:NameIDFormat>urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified</md:NameIDFormat>
        <md:SingleSignOnService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST" Location="' . $login_url . '"/>
        <md:SingleSignOnService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect" Location="' . $login_url . '"/>
    </md:IDPSSODescriptor>
</md:EntityDescriptor>';
        exit;
    }

    function miniorange_saml_idp_metadata_download(){
        self::_generate_metadata(true);
    }

    function miniorange_saml_idp_certificate_download(){
      self::_generate_metadata('certificate');
    }

    public function test_configuration(){
        $relayState = '/';
        $acs = \Drupal::config('miniorange_saml_idp.settings')->get("miniorange_saml_idp_acs_url");
        $sp_issuer = \Drupal::config('miniorange_saml_idp.settings')->get("miniorange_saml_idp_entity_id");

        if ($acs == '' || is_null($acs) || $sp_issuer == '' || is_null($sp_issuer)) {
            echo '<div style="font-family:Calibri;padding:0 3%;">';
            echo '<div style="color: #a94442;background-color: #f2dede;padding: 15px;margin-bottom: 20px;text-align:center;border:1px solid #E6B3B2;font-size:18pt;"> ERROR</div>
                <div style="color: #a94442;font-size:14pt; margin-bottom:20px;"><p><strong>Error: </strong>Please configure your Service Provider (SP) first and then click on Test Configuration.</p>
                <p><strong>Possible Cause: </strong> ACS URL or SP Entity ID not found.</p>

                </div>
                <div style="margin:3%;display:block;text-align:center;">';
            ?>
            <div style="margin:3%;display:block;text-align:center;"><input
                        style="padding:1%;width:100px;background: #0091CD none repeat scroll 0% 0%;cursor: pointer;font-size:15px;border-width: 1px;border-style: solid;border-radius: 3px;white-space: nowrap;box-sizing: border-box;border-color: #0073AA;box-shadow: 0px 1px 0px rgba(120, 200, 230, 0.6) inset;color: #FFF;"
                        type="button" value="Done" onClick="self.close();"></a></div>
            <?php
            exit;
        }
        self::mo_idp_authorize_user($acs, $sp_issuer, $relayState);
    }

    public function mo_idp_authorize_user($acs_url, $audience, $relayState, $inResponseTo = null) {
        if (\Drupal::currentUser()->isAuthenticated()) {
            self::mo_idp_send_reponse($acs_url, $audience, $relayState, $inResponseTo);

        } else {

            $saml_response_params = array('moIdpsendResponse' => "true", "acs_url" => $acs_url, "audience" => $audience, "relayState" => $relayState, "inResponseTo" => $inResponseTo);
            $responsec = new Response();
            $cookie = Cookie::create("response_params", json_encode($saml_response_params));
            $responsec->headers->setCookie($cookie);
            $responsec->sendHeaders();
            $responsec->sendContent();

            global $base_url;
            $redirect_url = $base_url . '/user/login';
            $response = new RedirectResponse($redirect_url);

            $response->send();
        }
    }

    public static function mo_idp_send_reponse( $acs_url, $audience, $relayState, $inResponseTo = null ) {
        $user     = \Drupal::currentUser();
        $email    = $user->getEmail();
        $username = $user->getAccountName();

        if (!in_array('administrator', $user->getRoles())) {
            ob_end_clean();
            echo t('<div style="color: #a94442;background-color: #f2dede;padding: 15px;margin-bottom: 20px;text-align:center;border:1px solid #E6B3B2;font-size:18pt;"> ERROR</div>
				<div style="color: #a94442;font-size:14pt; margin-bottom:20px;"><p><strong>Single Sign On not Allowed</strong> </p>
				<p>This is a trial module meant for Super User/Administrator use only.</p>
				<p>The Single Sign On feature for end users is available in the premium version of the module.</p>
				</div>
				<div style="margin:3%;display:block;text-align:center;">');
            exit;
        }

        global $base_url;
        $issuer = $base_url . '/?q=admin/config/people/miniorange_saml_idp/';

        $name_id_attr = (\Drupal::config('miniorange_saml_idp.settings')->get("miniorange_saml_idp_nameid_attr_map") == '') ? 'emailAddress' : \Drupal::config('miniorange_saml_idp.settings')->get("miniorange_saml_idp_nameid_attr_map");
        $name_id_attr_format = \Drupal::config('miniorange_saml_idp.settings')->get("miniorange_saml_idp_nameid_format");
        $idp_assertion_signed = \Drupal::config('miniorange_saml_idp.settings')->get("miniorange_saml_idp_assertion_signed");
        $state = \Drupal::config('miniorange_saml_idp.settings')->get("miniorange_saml_idp_relay_state");
        if (!empty($state) && !is_null($state)) {
            $relayState = $state;
        }

        $saml_response_obj = new GenerateResponse($email, $username, $acs_url, $issuer, $audience, $inResponseTo, $name_id_attr, $name_id_attr_format, $idp_assertion_signed);

        $saml_response = $saml_response_obj->createSamlResponse();
        setcookie("response_params", "");

        self::_send_response($saml_response, $relayState, $acs_url);
    }

    public static function _send_response($saml_response, $ssoUrl, $acs_url)
    {
        $response = new RedirectResponse($acs_url);
        $request = \Drupal::request();
        // Save the session so things like messages get saved.
        $request->getSession()->save();
        $response->prepare($request);
        \Drupal::service('kernel')->terminate($request, $response);
        $saml_response = base64_encode($saml_response);
        ?>
        <form id="responseform" action="<?php echo $acs_url; ?>" method="post">
            <input type="hidden" name="SAMLResponse" value="<?php echo htmlspecialchars($saml_response); ?>"/>
            <input type="hidden" name="RelayState" value="<?php echo $ssoUrl; ?>"/>
        </form>
        <script>
            setTimeout(function () {
                document.getElementById('responseform').submit();
            }, 100);
        </script>
        <?php
        exit;
    }

    public function miniorange_saml_idp_login_request() {
        if (array_key_exists('SAMLRequest', $_REQUEST) && !empty($_REQUEST['SAMLRequest'])) {
            self::_read_saml_request($_REQUEST, $_GET);
            return new Response();
        }
        return new Response();
    }

    public function _read_saml_request($REQUEST, $GET)
    {
        $samlRequest = $REQUEST['SAMLRequest'];
        $relayState = '/';
        if (array_key_exists('RelayState', $REQUEST)) {
            $relayState = $REQUEST['RelayState'];
        }

        $samlRequest = base64_decode($samlRequest);
        if (array_key_exists('SAMLRequest', $GET) && !empty($GET['SAMLRequest'])) {
            $samlRequest = gzinflate($samlRequest);
        }

        $document = new DOMDocument();
        $document->loadXML($samlRequest);
        $samlRequestXML = $document->firstChild;
        $authnRequest = new MiniOrangeAuthnRequest($samlRequestXML);

        $errors = '';
        if (strtotime($authnRequest->getIssueInstant()) > (time() + 60))
            $errors .= '<strong>INVALID_REQUEST: </strong>Request time is greater than the current time.<br/>';
        if ($authnRequest->getVersion() !== '2.0')
            $errors .= 'We only support SAML 2.0! Please send a SAML 2.0 request.<br/>';

        $acs_url                = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_acs_url');
        $sp_issuer              = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_entity_id');
        $acs_url_from_request   = $authnRequest->getAssertionConsumerServiceURL();
        $sp_issuer_from_request = $authnRequest->getIssuer();
        if ( empty( $acs_url ) || empty ( $sp_issuer ) ) {
            $errors .= '<strong>INVALID_SP: </strong>Service Provider is not configured. Please configure your Service Provider.<br/>';
        } else {
              if ((!is_null($acs_url_from_request)) && (strcmp($acs_url, $acs_url_from_request) !== 0)) {
                $errors .= '<strong>INVALID_ACS: </strong>Invalid ACS URL!. Please check your Service Provider Configurations.<br/>';
              }
            if (strcmp($sp_issuer, $sp_issuer_from_request) !== 0) {
                $errors .= '<strong>INVALID_ISSUER: </strong>Invalid Issuer! Please check your configuration.<br/>';
            }
        }

        $inResponseTo = $authnRequest->getRequestID();

        if (empty($errors)) {
            $module_path = \Drupal::service('extension.list.module')->getPath('miniorange_saml_idp');
            ?>
            <div style="vertical-align:center;text-align:center;width:100%;font-size:25px;background-color:white;">
                <img src="<?php echo $module_path; ?>/includes/images/loader_gif.gif"></img>
                <h3>PROCESSING...PLEASE WAIT!</h3>
            </div>
            <?php
           self::mo_idp_authorize_user($acs_url, $sp_issuer_from_request, $relayState, $inResponseTo);
        } else {

            $errors = t( $errors );
            echo sprintf($errors);
            exit;
        }
    }

    public function openDemoRequestForm() {
        $response = new AjaxResponse();
        if(is_null(\Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email'))){
          $command = new RedirectCommand(Url::fromRoute('miniorange_saml_idp.customer_setup')->toString());
            \Drupal::messenger()->addWarning(t('You will have to create an account with us in order to request a 7-day trial!'));
            return $response->addCommand($command);
        }
      $modal_form = $this->formBuilder->getForm('\Drupal\miniorange_saml_idp\Form\MiniorangeSAMLIDPRequestDemo');
      $response->addCommand(new OpenModalDialogCommand('Request 7-Days Full Feature Trial License', $modal_form, ['width' => '40%'] ) );
      return $response;
    }

    public function openContactUsForm() {
        $response = new AjaxResponse();
        $modal_form = $this->formBuilder->getForm('\Drupal\miniorange_saml_idp\Form\MiniorangeContactUs');
        $response->addCommand(new OpenModalDialogCommand('Contact Us', $modal_form, ['width' => '40%'] ) );
        return $response;
    }
}