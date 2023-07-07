<?php
/**
 * @package    miniOrange
 * @subpackage Plugins
 * @license    GNU/GPLv3
 * @copyright  Copyright 2015 miniOrange. All Rights Reserved.
 *
 *
 * This file is part of miniOrange Drupal SAML IDP module.
 *
 * miniOrange Drupal SAML IDP module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * miniOrange Drupal IDP module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with miniOrange SAML module.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Drupal\miniorange_saml_idp;

use DOMElement;
use DOMDocument;
use DOMNode;
use DOMXPath;
use Drupal\Core\Render\Markup;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Utilities {
  static function GetURL($URL) {
    if( self::isCurlInstalled() ) {
      $ch = curl_init($URL);
      curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
      curl_exec($ch);
      $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
      curl_close($ch);
      return array( $code, $effectiveUrl );
    }
    return array( 200, $URL );

  }

    /**
     * HANDALE ALL THE DATABASE VARIABLE CALLS LIKE SET|GET|CLEAR
     * -----------------------------------------------------------------------
     * @variable_array:
     * FORMAT OF ARRAY FOR DIEFRENT @param
     * SET array( vaviable_name1(key) => value, vaviable_name2(key) => value )
     * GET and CLEAR array( vaviable_name1(value), vaviable_name2(value) )  note: key doesnt matter here
     * -----------------------------------------------------------------------
     * @mo_method:  SET | GET | CLEAR
     * -----------------------------------------------------------------------
     * @return array | void
     */
    public static function miniOrange_set_get_configurations( $variable_array, $mo_method ) {
        if( $mo_method === 'GET' ) {
            $variables_and_values = array();
            $miniOrange_config = \Drupal::config('miniorange_saml_idp.settings');
            foreach ( $variable_array as $variable => $value ) {
                $variables_and_values[$value] = $miniOrange_config->get( $value );
            }
            return $variables_and_values;
        }
        $configFactory = \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings');
        if( $mo_method === 'SET' ) {
            foreach ($variable_array as $variable => $value) {
                $configFactory->set($variable, $value)->save();
            }
            return;
        }
        foreach ($variable_array as $variable => $value) {
            $configFactory->clear($value)->save();
        }
    }

    public static function spConfigGuide(array &$form, FormStateInterface $form_state) {

        $form['miniorange_idp_guide_link1'] = array(
            '#markup' => '<div class="mo_saml_table_layout mo_saml_container_2">
                    <div style="font-size: 15px;">To see detailed documentation of how to configure
                    Drupal SAML IdP with any Service Provider</div></br>',
        );

      $mo_Tableau = Markup::create('<strong><a href="https://plugins.miniorange.com/configure-tableau-sp-as-sp-and-drupal-8-as-idp" class="mo_guide_text-color" target="_blank">Tableau</a></strong>');
      $mo_Zendesk = Markup::create('<strong><a href="https://plugins.miniorange.com/zendesk-single-sign-sso-for-drupal-8-idp" class="mo_guide_text-color" target="_blank">Zendesk</a></strong>');
      $mo_Workplace_by_facebook = Markup::create('<strong><a href="https://plugins.miniorange.com/guide-drupal-idp-workplace-sp" class="mo_guide_text-color" target="_blank">Workplace by Facebook</a></strong>');
      $mo_Canvas_LMS = Markup::create('<strong><a href="https://plugins.miniorange.com/guide-to-configure-canvas-lms-as-sp-and-drupal-as-idp" class="mo_guide_text-color" target="_blank">Canvas LMS</a></strong>');
      $mo_Owncloud = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/configure-owncloud-sp-and-drupal-as-idp" target="_blank">Owncloud</a></strong>');
      $mo_Inkling = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/configure-inkling-as-sp-for-drupal-8-idp" target="_blank">Inkling</a></strong>');
      $mo_appstream2 = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/guide-to-setup-drupal-as-idp-and-aws-appstream2-as-sp" target="_blank">AppStream2</a></strong>');
      $mo_moodle = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/moodle-sso-integration-with-drupal-saml-idp-module" target="_blank">Moodle</a></strong>');
      $mo_aws_congnito = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/amazon-cognito-sso-login-using-drupal-idp" target="_blank">AWS Cognito</a></strong>');
      $mo_zoho = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/zoho-sso-login-using-drupal-idp" target="_blank">Zoho</a></strong>');
      $mo_salesforce = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/salesforce-single-sign-on-sso-for-drupal" target="_blank">Salesforce</a></strong>');
      $mo_nextcloud = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/saml-sso-login-using-nextcloud-with-drupal-as-idp" target="_blank">Nextcloud</a></strong>');
      $mo_aws = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/aws-sso-login-using-drupal-idp" target="_blank">AWS</a></strong>');
      $mo_freshdesk = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/freshdesk-saml-single-sign-on-sso-integration-with-drupal-as-idp" target="_blank">Freshdesk</a></strong>');
      $mo_wordpress = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/wordpress-sso-login-with-drupal-idp" target="_blank">Wordpress</a></strong>');
      $mo_zoom = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/zoom-sso-login-using-drupal-idp" target="_blank">Zoom</a></strong>');
      $mo_jira = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/jira-saml-single-sign-on-with-drupal" target="_blank">Jira</a></strong>');
      $mo_drupal = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/configure-saml-sso-between-two-drupal-sites" target="_blank">Drupal (as SP)</a></strong>');
      $mo_joomla = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-with-drupal" target="_blank">Joomla</a></strong>');
      $mo_powerschool = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/powerschool-saml-single-sign-on-with-drupal" target="_blank">Powerschool</a></strong>');
      $mo_talent_lms = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/talentlms-single-sign-on-sso-using-drupal-as-idp" target="_blank">Talent LMS</a></strong>');
      $mo_rocketchat = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/rocketchat-sso-for-drupal-rocketchat-sso-login-using-drupal-idp" target="_blank">Rocketchat</a></strong>');
      $mo_klipfolio = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/klipfolio-sso-login-using-drupal-idp" target="_blank">Klipfolio</a></strong>');
      $mo_panopto = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/panopto-sso-for-drupal-panopto-sso-login-using-drupal-idp" target="_blank">Panopto</a></strong>');
      $mo_adobe_captive_prime = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/adobe-captivate-saml-single-sign-on-with-drupal" target="_blank">Adobe Captive Prime</a></strong>');
      $mo_clicdata = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/clicdata-saml-single-sign-on-with-drupal" target="_blank">ClicData</a></strong>');
      $mo_mimecast = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/mimecast-saml-single-sign-on-with-drupal" target="_blank">Minecast</a></strong>');
      $mo_tableau_online = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/tableau-online-saml-single-sign-on-with-drupal" target="_blank">Tableau Online</a></strong>');
      $mo_shopify = Markup::create('<strong><a class="mo_guide_text-color" href="https://plugins.miniorange.com/shopify-saml-single-sign-on-sso-with-drupal" target="_blank">Shopify</a></strong>');
      $mo_learnworlds = Markup::create('<strong><a class="mo_guide_text-color" href="https://www.drupal.org/docs/contributed-modules/saml-idp-20-single-sign-on-sso-saml-identity-provider/learnworlds-sso-login" target="_blank">Learnworlds</a></strong>');
      $mo_learnupon = Markup::create('<strong><a class="mo_guide_text-color" href="https://www.drupal.org/docs/contributed-modules/saml-idp-20-single-sign-on-sso-saml-identity-provider/learnupon-sso-login" target="_blank">Learnupon</a></strong>');
      $mo_for_any_other_sp = Markup::create('<strong><a href="https://plugins.miniorange.com/guide-enable-miniorange-drupal-saml-idp" class="mo_guide_text-color" target="_blank">For any Other SP</a></strong>');

      $mo_table_content = array(
        array($mo_Zendesk,$mo_Tableau),
        array($mo_Canvas_LMS,$mo_Workplace_by_facebook),
        array($mo_Inkling,$mo_Owncloud),
        array($mo_moodle, $mo_aws_congnito),
        array($mo_zoho, $mo_salesforce),
        array($mo_nextcloud, $mo_aws),
        array($mo_freshdesk, $mo_wordpress),
        array($mo_zoom, $mo_jira),
        array($mo_drupal, $mo_joomla),
        array($mo_powerschool, $mo_talent_lms),
        array($mo_rocketchat, $mo_klipfolio),
        array($mo_panopto, $mo_adobe_captive_prime),
        array($mo_clicdata, $mo_mimecast),
        array($mo_tableau_online, $mo_shopify),
        array($mo_learnworlds, $mo_learnupon),
        array($mo_appstream2,$mo_for_any_other_sp),
      );


        $header = array( array(
            'data' => t('Service Provider Setup Guides'),
            'colspan' => 2,
        ),
        );

        $form['modules'] = array(
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $mo_table_content,
            '#responsive' => TRUE ,
            '#sticky'=> TRUE,
        );
        self::faq($form, $form_state);
        $form['miniorange_idp_guide_link_end'] = array(
            '#markup' => '</div>',
        );
    }

    public static function faq(&$form, &$form_state){

        $form['miniorange_faq'] = array(
            '#markup' => '<br><div class="mo_saml_text_center"><b></b>
                          <a class="mo_idp_btn mo_idp_btn-primary-faq mo_idp_btn-large mo_faq_button_left" href="https://faq.miniorange.com/kb/drupal/saml-drupal/" target="_blank">FAQs</a>
                          <b></b><a class="mo_idp_btn mo_idp_btn-primary-faq mo_idp_btn-large mo_faq_button_right" href="https://forum.miniorange.com/" target="_blank">Ask questions on forum</a></div><br>',
        );
    }

    /** Advertise 2 FA */
    public static function advertise2fa(&$form, &$form_state){
        global $base_url;
        $form['miniorange_idp_guide_link3'] = array(
            '#markup' => '<div class="mo_saml_table_layout mo_saml_container_2">
                        ',
        );

        $form['mo_idp_net_adv']=array(
            '#markup'=>t('<form name="f1">
            <table id="idp_support" class="idp-table" style="border: none;">
            <h5>Secure your Drupal login using miniOrange 2FA/MFA</h5>
                <tr class="mo_ns_row">
                    <th class="mo_ns_image1"><img
                                src="'.$base_url . '/' . self::moGetModulePath() . '/includes/images/second_factor_autentication.jpg"
                                alt="miniOrange icon" height=12% width=55%>
                    <br>
                            <h4>Drupal Second-Factor Authentication</h4>
                    </th>
                </tr>

                <tr class="mo_ns_row">
                    <td class="mo_ns_align">
                        Two Factor Authentication (2FA) module adds a second layer of authentication at the time of login to secure your Drupal accounts.
                        It is a highly secure and easy to setup module which protects your site from hacks and unauthorized login attempts.
                        Also Two Factor Authentication (2FA) module provides 17+ 2fa methods including OTP Over SMS, Email, Phone call, WhatsApp, Google Authenticator, etc.
                    </td>
                </tr>
                <tr class="mo_ns_row">
                    <td class="mo_ns_td"><br> <a class="mo_idp_btn mo_idp_btn-primary-faq mo_idp_btn-large mo_faq_button_left" href="https://www.drupal.org/project/miniorange_2fa" target="_blank">Download Module</a>
                              <b></b><a class="mo_idp_btn mo_idp_btn-primary-faq mo_idp_btn-large mo_faq_button_right" href="https://plugins.miniorange.com/drupal-two-factor-authentication-2fa" target="_blank">Know More</a>
                    </td>
                </tr>
            </table>
        </form>')
            );
        return $form;
    }

    /**
     * Replacement of deprecated function drupal_get_path()
     * @return Modules path
     */
    static function moGetModulePath(){
        return \Drupal::service('extension.list.module')->getPath('miniorange_saml_idp');
    }

    public static function isCustomerRegistered() {
        if (   \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email') == NULL
            || \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_customer_id') == NULL
            || \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_customer_admin_token') == NULL
            || \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_customer_api_key') == NULL) {
            return false;
        }else {
            return true;
        }
    }

    public static function customer_setup_submit($username, $phone, $password, $login=false, $called_from_popup=false, $payment_plan=NULL){
        global $base_url;
        $customer_config = new MiniorangeSAMLCustomer($username, $phone, $password, NULL);
        $check_customer_response = json_decode($customer_config->checkCustomer());

        $db_config = \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings');
        if ($check_customer_response->status=='TRANSACTION_LIMIT_EXCEEDED'){
            if ($called_from_popup == true) {
                miniorange_saml_registration::register_data(true);
            }else{
                \Drupal::messenger()->addMessage(t('An error has been occured. Please try after some time or <a href="mailto:drupalsupport@xecurify.com"><i>contact us</i></a>.'), 'error');
                return;
            }
        }
        if ($check_customer_response->status == 'CUSTOMER_NOT_FOUND') {
            if ($login == true && $called_from_popup == false) {
                \Drupal::messenger()->addMessage(t('The account with username <i>'.$username.'</i> does not exist.'), 'error');
                return;
            }
            $db_config->set('miniorange_saml_idp_customer_admin_email', $username)->save();
            $db_config->set('miniorange_saml_customer_admin_phone', $phone)->save();
            $db_config->set('miniorange_saml_customer_admin_password', $password)->save();
            $send_otp_response = json_decode($customer_config->sendOtp());

            if ($send_otp_response->status == 'SUCCESS') {
                $db_config->set('miniorange_saml_tx_id', $send_otp_response->txId)->save();
                $db_config->set('miniorange_saml_status', 'VALIDATE_OTP')->save();

                if ($called_from_popup == true) {
                    miniorange_saml_registration::miniorange_otp(false,false,false);
                }else{
                    \Drupal::messenger()->addMessage(t('Verify email address by entering the passcode sent to @username', [
                        '@username' => $username
                    ]));
                }
            }else{
                if ($called_from_popup == true) {
                    miniorange_saml_registration::register_data(true);
                }else{
                    \Drupal::messenger()->addMessage(t('An error has been occured. Please try after some time.'),'error');
                    return;
                }
            }
        } elseif ($check_customer_response->status == 'CURL_ERROR') {
            if ($called_from_popup == true) {
                    miniorange_saml_registration::register_data(true);
            }else{
                \Drupal::messenger()->addMessage(t('cURL is not enabled. Please enable cURL'), 'error');
                return;
            }
        } else {
            $customer_keys_response = json_decode($customer_config->getCustomerKeys());

            if (json_last_error() == JSON_ERROR_NONE) {
                $db_config->set('miniorange_saml_customer_id', $customer_keys_response->id)->save();
                $db_config->set('miniorange_saml_customer_admin_token', $customer_keys_response->token)->save();
                $db_config->set('miniorange_saml_idp_customer_admin_email', $username)->save();
                $db_config->set('miniorange_saml_customer_admin_phone', $phone)->save();
                $db_config->set('miniorange_saml_customer_api_key', $customer_keys_response->apiKey)->save();
                $db_config->set('miniorange_saml_status', 'PLUGIN_CONFIGURATION')->save();

                if ($called_from_popup == true) {
                    $redirect_url = \Drupal::config('miniorange_saml_idp.settings')->get('redirect_plan_after_registration_' . $payment_plan);
                    $redirect_url = str_replace('none', $username, $redirect_url);
                    miniorange_saml_registration::miniorange_redirect_successful($redirect_url);
                }else{
                    \Drupal::messenger()->addMessage(t('Successfully retrieved your account.'));
                    $redirect_url = $base_url . '/admin/config/people/miniorange_saml_idp/customer_setup';
                    $response = new RedirectResponse($redirect_url);
                    $response->send();
                }
            } else {
                if ($called_from_popup == true) {
                    miniorange_saml_registration::register_data(false, true);
                }else{
                    \Drupal::messenger()->addMessage(t('Invalid credentials'), 'error');
                    return;
                }
            }
        }
    }

    public static function validate_otp_submit($otp_token, $called_from_popup=false, $payment_plan=NULL){
        $db_config = \Drupal::config('miniorange_saml_idp.settings');
        $db_edit = \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings');
        $username = $db_config->get('miniorange_saml_idp_customer_admin_email');
        $phone = $db_config->get('miniorange_saml_customer_admin_phone');
        $tx_id = $db_config->get('miniorange_saml_tx_id');
        $customer_config = new MiniorangeSAMLCustomer($username, $phone, NULL, $otp_token);
        $validate_otp_response = json_decode($customer_config->validateOtp($tx_id));

        if ($validate_otp_response->status == 'SUCCESS') {
            $db_edit->clear('miniorange_saml_tx_id')->save();
            $password = $db_config->get('miniorange_saml_customer_admin_password');
            $customer_config = new MiniorangeSAMLCustomer($username, $phone, $password, NULL);
            $create_customer_response = json_decode($customer_config->createCustomer());
            if ($create_customer_response->status == 'SUCCESS') {
                $db_edit->set('miniorange_saml_status', 'PLUGIN_CONFIGURATION')->save();
                $db_edit->set('miniorange_saml_idp_customer_admin_email', $username)->save();
                $db_edit->set('miniorange_saml_customer_admin_phone', $phone)->save();
                $db_edit->set('miniorange_saml_customer_admin_token', $create_customer_response->token)->save();
                $db_edit->set('miniorange_saml_customer_id', $create_customer_response->id)->save();
                $db_edit->set('miniorange_saml_customer_api_key', $create_customer_response->apiKey)->save();
                \Drupal::messenger()->addMessage(t('Customer account created.'));

                if ($called_from_popup == true) {
                    $redirect_url = \Drupal::config('miniorange_saml_idp.settings')->get('redirect_plan_after_registration_' . $payment_plan);
                    $redirect_url = str_replace('none', $username, $redirect_url);
                    miniorange_saml_registration::miniorange_redirect_successful($redirect_url);
                }else{
                    self::redirect_to_licensing();
                }
            } else if (trim($create_customer_response->status) == 'INVALID_EMAIL_QUICK_EMAIL') {

                \Drupal::messenger()->addMessage(t('There was an error creating an account for you.<br> You may have entered an invalid Email-Id
                <strong>(We discourage the use of disposable emails) </strong>
                <br>Please try again with a valid email.'), 'error');

                if ($called_from_popup == true)
                    self::saml_back(true);
                else
                    return;

            } else {

                \Drupal::messenger()->addMessage(t('There was an error while creating customer. Please try after some time.'), 'error');

                if ($called_from_popup == true)
                    self::saml_back(true);
                else
                    return;
            }
        } else {
            if ($called_from_popup == true) {
                miniorange_saml_registration::miniorange_otp(true,false,false);
            }else{
                \Drupal::messenger()->addMessage(t('Invalid  OTP'), 'error');
                return;
            }
        }
    }

    public static function saml_resend_otp($called_from_popup=false){
        $db_edit = \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings');
        $db_edit->clear('miniorange_saml_tx_id')->save();
        $username = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email');
        $phone = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_customer_admin_phone');
        $customer_config = new MiniorangeSAMLCustomer($username, $phone, NULL, NULL);
        $send_otp_response = json_decode($customer_config->sendOtp());
        if ($send_otp_response->status == 'SUCCESS') {
            // Store txID.
            $db_edit->set('miniorange_saml_tx_id', $send_otp_response->txId)->save();
            $db_edit->set('miniorange_saml_status', 'VALIDATE_OTP')->save();
            if ($called_from_popup == true) {
                miniorange_saml_registration::miniorange_otp(false,true,false);
            }else{
                \Drupal::messenger()->addMessage(t('Verify email address by entering the passcode sent to @username', array('@username' => $username)));
            }
        }else{
            if ($called_from_popup == true) {
                miniorange_saml_registration::miniorange_otp(false,false,true);
            }else{
                \Drupal::messenger()->addMessage(t('An error has been occured. Please try after some time'),'error');
            }
        }
    }

    public static function saml_back($called_from_popup=false){
        $db_edit = \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings');
        $db_edit->set('miniorange_saml_status', 'CUSTOMER_SETUP')->save();
        $db_edit->clear('miniorange_saml_idp_customer_admin_email')->save();
        $db_edit->clear('miniorange_saml_customer_admin_phone')->save();
        $db_edit->clear('miniorange_saml_tx_id')->save();

        if ($called_from_popup == true) {
            self::redirect_to_licensing();
        }else{
            \Drupal::messenger()->addMessage(t('Register/Login with your miniOrange Account'), 'status');
        }
    }

    public static function redirect_to_licensing(){
        global $base_url;
        $redirect_url = $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL;
        $response = new RedirectResponse($redirect_url);
        $response->send();
    }

    Public static function getClassNameForImport_Export(){
        $tab_class_name = array(
            "Identity_Provider" => 'mo_options_enum_identity_provider',
            "Service_Provider"  => 'mo_options_enum_service_provider',
            "Attribute_Mapping"  => 'mo_options_enum_attribute_mapping',
        );
        return $tab_class_name;
    }

    Public static function getVariableArrayForImport_Export($class_name){
        if($class_name == "mo_options_enum_identity_provider") {
            $class_object = array(
                'IdP_Entity_ID' => 'miniorange_saml_idp_entity_id_issuer',
                'IdP_Login_Url' => 'miniorange_saml_idp_login_url',
            );
        }
        else if($class_name == "mo_options_enum_service_provider") {
            $class_object = array(
                'Sevice_Provider_name' => 'miniorange_saml_idp_name',
                'SP_Entity_ID_or_Issuer' => 'miniorange_saml_idp_entity_id',
                'Name_ID_format' => 'miniorange_saml_idp_nameid_format',
                'ACS_URL' => 'miniorange_saml_idp_acs_url',
                'Relay_State' => 'miniorange_saml_idp_relay_state',
                'Assertion_Signed' => 'miniorange_saml_idp_assertion_signed',
            );
        }
        else if($class_name == "mo_options_enum_attribute_mapping") {
            $class_object = array(
                'NameID_Attribute' => 'miniorange_saml_idp_nameid_attr_map',
            );
        }
        return $class_object;
    }

    public static function upload_metadata( $file, $type ){

        if( empty( \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_name') ) ){
            \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings')->set('miniorange_saml_idp_name', 'Service Provider')->save();
        }
        $document = new \DOMDocument();
        $document->loadXML( $file );
        restore_error_handler();
        $first_child = $document->firstChild;
        if( !empty( $first_child ) ) {
            $metadata = new MetadataReader($document);
            $service_providers = $metadata->getServiceProviders();
            if( empty( $service_providers ) ) {
                \Drupal::messenger()->addMessage(t('Please provide a valid metadata '.$type.'.'),'error');
                return;
            }
            foreach( $service_providers as $key => $sp ) {
                $entityID_issuer = $sp->getEntityID();
                $acs_url = $sp->getAcsURL();
                $is_assertion_signed = $sp->getAssertionsSigned() == 'true' ? TRUE : FALSE;

                \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings')->set('miniorange_saml_idp_entity_id', $entityID_issuer)->save();
                \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings')->set('miniorange_saml_idp_acs_url', $acs_url)->save();
                \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings')->set('miniorange_saml_idp_assertion_signed', $is_assertion_signed)->save();
            }
            \Drupal::messenger()->addMessage(t('Service Provider Configuration successfully saved.'));
            return;
        }else {
            \Drupal::messenger()->addMessage(t('Please provide a valid metadata '.$type.'.'),'error');
            return;
        }
    }


    public static function isCurlInstalled() {
      if (in_array('curl', get_loaded_extensions())) {
        return 1;
      }else {
        return 0;
      }
    }

	public static function generateID() {
		return '_' . self::stringToHex(self::generateRandomBytes(21));
	}

	public static function stringToHex($bytes) {
		$ret = '';
		for($i = 0; $i < strlen($bytes); $i++) {
			$ret .= sprintf('%02x', ord($bytes[$i]));
		}
		return $ret;
	}

	public static function generateRandomBytes($length, $fallback = TRUE) {
		assert('is_int($length)');
        return openssl_random_pseudo_bytes($length);
	}

	public static function generateTimestamp($instant = NULL) {
		if($instant === NULL) {
			$instant = time();
		}
		return gmdate('Y-m-d\TH:i:s\Z', $instant);
	}

	public static function xpQuery(DOMNode $node, $query){
        static $xpCache = NULL;

        if ($node instanceof DOMDocument) {
            $doc = $node;
        }else {
            $doc = $node->ownerDocument;
        }

        if ($xpCache === NULL || !$xpCache->document->isSameNode($doc)) {
            $xpCache = new DOMXPath($doc);
            $xpCache->registerNamespace('soap-env', 'http://schemas.xmlsoap.org/soap/envelope/');
            $xpCache->registerNamespace('saml_protocol', 'urn:oasis:names:tc:SAML:2.0:protocol');
            $xpCache->registerNamespace('saml_assertion', 'urn:oasis:names:tc:SAML:2.0:assertion');
            $xpCache->registerNamespace('saml_metadata', 'urn:oasis:names:tc:SAML:2.0:metadata');
            $xpCache->registerNamespace('ds', 'http://www.w3.org/2000/09/xmldsig#');
            $xpCache->registerNamespace('xenc', 'http://www.w3.org/2001/04/xmlenc#');
        }

        $results = $xpCache->query($query, $node);
        $ret = array();
        for ($i = 0; $i < $results->length; $i++) {
            $ret[$i] = $results->item($i);
        }
		return $ret;
    }

	public static function parseNameId(DOMElement $xml)
    {
        $ret = array('Value' => trim($xml->textContent));

        foreach (array('NameQualifier', 'SPNameQualifier', 'Format') as $attr) {
            if ($xml->hasAttribute($attr)) {
                $ret[$attr] = $xml->getAttribute($attr);
            }
        }
        return $ret;
    }

	public static function xsDateTimeToTimestamp($time){
        $matches = array();

        // We use a very strict regex to parse the timestamp.
        $regex = '/^(\\d\\d\\d\\d)-(\\d\\d)-(\\d\\d)T(\\d\\d):(\\d\\d):(\\d\\d)(?:\\.\\d+)?Z$/D';
        if (preg_match($regex, $time, $matches) == 0) {
            echo sprintf("nvalid SAML2 timestamp passed to xsDateTimeToTimestamp: ".$time);
            exit;
        }
        // Extract the different components of the time from the  matches in the regex.
        // intval will ignore leading zeroes in the string.
        $year   = intval($matches[1]);
        $month  = intval($matches[2]);
        $day    = intval($matches[3]);
        $hour   = intval($matches[4]);
        $minute = intval($matches[5]);
        $second = intval($matches[6]);

        // We use gmmktime because the timestamp will always be given
        //in UTC.
        $ts = gmmktime($hour, $minute, $second, $month, $day, $year);
        return $ts;
    }

	public static function extractStrings(DOMElement $parent, $namespaceURI, $localName)
    {
        assert('is_string($namespaceURI)');
        assert('is_string($localName)');

        $ret = array();
        for ($node = $parent->firstChild; $node !== NULL; $node = $node->nextSibling) {
            if ($node->namespaceURI !== $namespaceURI || $node->localName !== $localName) {
                continue;
            }
            $ret[] = trim($node->textContent);
        }
        return $ret;
    }

	public static function validateElement(DOMElement $root)
    {
        /* Create an XML security object. */
        $objXMLSecDSig = new XMLSecurityDSig();

        /* Both SAML messages and SAML assertions use the 'ID' attribute. */
        $objXMLSecDSig->idKeys[] = 'ID';

        /* Locate the XMLDSig Signature element to be used. */
        $signatureElement = self::xpQuery($root, './ds:Signature');

        if (count($signatureElement) === 0) {
            /* We don't have a signature element to validate. */
            return FALSE;
        }elseif (count($signatureElement) > 1) {
        	echo sprintf("XMLSec: more than one signature element in root.");
        	exit;
        }

        $signatureElement = $signatureElement[0];
        $objXMLSecDSig->sigNode = $signatureElement;

        /* Canonicalize the XMLDSig SignedInfo element in the message. */
        $objXMLSecDSig->canonicalizeSignedInfo();

       /* Validate referenced xml nodes. */
        if (!$objXMLSecDSig->validateReference()) {
        	echo sprintf("XMLsec: digest validation failed");
        	exit;
        }

		/* Check that $root is one of the signed nodes. */
        $rootSigned = FALSE;
        /** @var DOMNode $signedNode */
        foreach ($objXMLSecDSig->getValidatedNodes() as $signedNode) {
            if ($signedNode->isSameNode($root)) {
                $rootSigned = TRUE;
                break;
            } elseif ($root->parentNode instanceof DOMDocument && $signedNode->isSameNode($root->ownerDocument)) {
                /* $root is the root element of a signed document. */
                $rootSigned = TRUE;
                break;
            }
        }

		if (!$rootSigned) {
			echo sprintf("XMLSec: The root element is not signed.");
			exit;
        }

        /* Now we extract all available X509 certificates in the signature element. */
        $certificates = array();
        foreach (self::xpQuery($signatureElement, './ds:KeyInfo/ds:X509Data/ds:X509Certificate') as $certNode) {
            $certData = trim($certNode->textContent);
            $certData = str_replace(array("\r", "\n", "\t", ' '), '', $certData);
            $certificates[] = $certData;
        }

        $ret = array(
            'Signature' => $objXMLSecDSig,
            'Certificates' => $certificates,
            );

        return $ret;
    }

    public static function castKey(XMLSecurityKey $key, $algorithm, $type = 'public')
    {
    	assert('is_string($algorithm)');
    	assert('$type === "public" || $type === "private"');

    	// do nothing if algorithm is already the type of the key
    	if ($key->type === $algorithm) {
    		return $key;
    	}

    	$keyInfo = openssl_pkey_get_details($key->key);
    	if ($keyInfo === FALSE) {
    		echo sprintf('Unable to get key details from XMLSecurityKey.');
    		exit;
    	}
    	if (!isset($keyInfo['key'])) {
    		echo sprintf('Missing key in public key details.');
    		exit;
    	}

    	$newKey = new XMLSecurityKey($algorithm, array('type'=>$type));
    	$newKey->loadKey($keyInfo['key']);

    	return $newKey;
    }
    /**
     * Decrypt an encrypted element.
     *
     * This is an internal helper function.
     *
     * @param  DOMElement     $encryptedData The encrypted data.
     * @param  XMLSecurityKey $inputKey      The decryption key.
     * @param  array          &$blacklist    Blacklisted decryption algorithms.
     * @return DOMElement     The decrypted element.
     * @throws Exception
     */
    private static function doDecryptElement(DOMElement $encryptedData, XMLSecurityKey $inputKey, array &$blacklist)
    {
        $enc = new XMLSecEnc();
        $enc->setNode($encryptedData);

        $enc->type = $encryptedData->getAttribute("Type");
        $symmetricKey = $enc->locateKey($encryptedData);
        if (!$symmetricKey) {
        	echo sprintf('Could not locate key algorithm in encrypted data.');
        	exit;
        }

        $symmetricKeyInfo = $enc->locateKeyInfo($symmetricKey);
        if (!$symmetricKeyInfo) {
			echo sprintf('Could not locate <dsig:KeyInfo> for the encrypted key.');
			exit;
        }
        $inputKeyAlgo = $inputKey->getAlgorithm();
        if ($symmetricKeyInfo->isEncrypted) {
            $symKeyInfoAlgo = $symmetricKeyInfo->getAlgorithm();
            if (in_array($symKeyInfoAlgo, $blacklist, TRUE)) {
                echo sprintf('Algorithm disabled: ' . var_export($symKeyInfoAlgo, TRUE));
                exit;
            }
            if ($symKeyInfoAlgo === XMLSecurityKey::RSA_OAEP_MGF1P && $inputKeyAlgo === XMLSecurityKey::RSA_1_5) {
                /*
                 * The RSA key formats are equal, so loading an RSA_1_5 key
                 * into an RSA_OAEP_MGF1P key can be done without problems.
                 * We therefore pretend that the input key is an
                 * RSA_OAEP_MGF1P key.
                 */
                $inputKeyAlgo = XMLSecurityKey::RSA_OAEP_MGF1P;
            }
            /* Make sure that the input key format is the same as the one used to encrypt the key. */
            if ($inputKeyAlgo !== $symKeyInfoAlgo) {
                echo sprintf( 'Algorithm mismatch between input key and key used to encrypt ' .
                    ' the symmetric key for the message. Key was: ' .
                    var_export($inputKeyAlgo, TRUE) . '; message was: ' .
                    var_export($symKeyInfoAlgo, TRUE));
                exit;
            }
            /** @var XMLSecEnc $encKey */
            $encKey = $symmetricKeyInfo->encryptedCtx;
            $symmetricKeyInfo->key = $inputKey->key;
            $keySize = $symmetricKey->getSymmetricKeySize();
            if ($keySize === NULL) {
                /* To protect against "key oracle" attacks, we need to be able to create a
                 * symmetric key, and for that we need to know the key size.
                 */
				echo sprintf('Unknown key size for encryption algorithm: ' . var_export($symmetricKey->type, TRUE));
				exit;
            }
            try {
                $key = $encKey->decryptKey($symmetricKeyInfo);
                if (strlen($key) != $keySize) {
                	echo sprintf('Unexpected key size (' . strlen($key) * 8 . 'bits) for encryption algorithm: ' .
                        var_export($symmetricKey->type, TRUE));
                	exit;
                }
            } catch (Exception $e) {
                /* We failed to decrypt this key. Log it, and substitute a "random" key. */

                /* Create a replacement key, so that it looks like we fail in the same way as if the key was correctly padded. */
                /* We base the symmetric key on the encrypted key and private key, so that we always behave the
                 * same way for a given input key.
                 */
                $encryptedKey = $encKey->getCipherValue();
                $pkey = openssl_pkey_get_details($symmetricKeyInfo->key);
                $pkey = sha1(serialize($pkey), TRUE);
                $key = sha1($encryptedKey . $pkey, TRUE);
                /* Make sure that the key has the correct length. */
                if (strlen($key) > $keySize) {
                    $key = substr($key, 0, $keySize);
                } elseif (strlen($key) < $keySize) {
                    $key = str_pad($key, $keySize);
                }
            }
            $symmetricKey->loadkey($key);
        } else {
            $symKeyAlgo = $symmetricKey->getAlgorithm();
            /* Make sure that the input key has the correct format. */
            if ($inputKeyAlgo !== $symKeyAlgo) {
            	echo sprintf( 'Algorithm mismatch between input key and key in message. ' .
                    'Key was: ' . var_export($inputKeyAlgo, TRUE) . '; message was: ' .
                    var_export($symKeyAlgo, TRUE));
            	exit;
            }
            $symmetricKey = $inputKey;
        }
        $algorithm = $symmetricKey->getAlgorithm();
        if (in_array($algorithm, $blacklist, TRUE)) {
            echo sprintf('Algorithm disabled: ' . var_export($algorithm, TRUE));
            exit;
        }
        /** @var string $decrypted */
        $decrypted = $enc->decryptNode($symmetricKey, FALSE);
        /*
         * This is a workaround for the case where only a subset of the XML
         * tree was serialized for encryption. In that case, we may miss the
         * namespaces needed to parse the XML.
         */
        $xml = '<root xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion" '.
                     'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' .
            $decrypted .
            '</root>';
        $newDoc = new DOMDocument();
        if (!@$newDoc->loadXML($xml)) {
        	echo sprintf('Failed to parse decrypted XML. Maybe the wrong sharedkey was used?');
        	throw new Exception('Failed to parse decrypted XML. Maybe the wrong sharedkey was used?');
        }
        $decryptedElement = $newDoc->firstChild->firstChild;
        if ($decryptedElement === NULL) {
        	echo sprintf('Missing encrypted element.');
        	throw new Exception('Missing encrypted element.');
        }

        if (!($decryptedElement instanceof DOMElement)) {
        	echo sprintf('Decrypted element was not actually a DOMElement.');
        }

        return $decryptedElement;
    }
    /**
     * Decrypt an encrypted element.
     *
     * @param  DOMElement     $encryptedData The encrypted data.
     * @param  XMLSecurityKey $inputKey      The decryption key.
     * @param  array          $blacklist     Blacklisted decryption algorithms.
     * @return DOMElement     The decrypted element.
     * @throws Exception
     */
    public static function decryptElement(DOMElement $encryptedData, XMLSecurityKey $inputKey, array $blacklist = array(), XMLSecurityKey $alternateKey = NULL)
    {
        try {
        	echo "trying primary";
            return self::doDecryptElement($encryptedData, $inputKey, $blacklist);
        } catch (Exception $e) {
        	//Try with alternate key
        	try {
        		echo "trying secondary";
        		return self::doDecryptElement($encryptedData, $alternateKey, $blacklist);
        	} catch(Exception $t) {

        	}
        	/*
        	 * Something went wrong during decryption, but for security
        	 * reasons we cannot tell the user what failed.
        	 */
        	echo sprintf('Failed to decrypt XML element.');
        	exit;
        }
    }

    /**
     * Parse a boolean attribute.
     *
     * @param  \DOMElement $node          The element we should fetch the attribute from.
     * @param  string     $attributeName The name of the attribute.
     * @param  mixed      $default       The value that should be returned if the attribute doesn't exist.
     * @return bool|mixed The value of the attribute, or $default if the attribute doesn't exist.
     * @throws \Exception
     */
    public static function parseBoolean(DOMElement $node, $attributeName, $default = null)
    {

        if (!$node->hasAttribute($attributeName)) {
            return $default;
        }
        $value = $node->getAttribute($attributeName);
        switch (strtolower($value)) {
            case '0':
            case 'false':
                return FALSE;
            case '1':
            case 'true':
                return TRUE;
            default:
                throw new Exception('Invalid value of boolean attribute ' . var_export($attributeName, TRUE) . ': ' . var_export($value, TRUE));
        }
    }

	public static function getEncryptionAlgorithm($method){
		switch($method){
			case 'http://www.w3.org/2001/04/xmlenc#tripledes-cbc':
				return XMLSecurityKey::TRIPLEDES_CBC;
				break;

			case 'http://www.w3.org/2001/04/xmlenc#aes128-cbc':
				return XMLSecurityKey::AES128_CBC;

			case 'http://www.w3.org/2001/04/xmlenc#aes192-cbc':
				return XMLSecurityKey::AES192_CBC;
				break;

			case 'http://www.w3.org/2001/04/xmlenc#aes256-cbc':
				return XMLSecurityKey::AES256_CBC;
				break;

			case 'http://www.w3.org/2001/04/xmlenc#rsa-1_5':
				return XMLSecurityKey::RSA_1_5;
				break;

			case 'http://www.w3.org/2001/04/xmlenc#rsa-oaep-mgf1p':
				return XMLSecurityKey::RSA_OAEP_MGF1P;
				break;

			case 'http://www.w3.org/2000/09/xmldsig#dsa-sha1':
				return XMLSecurityKey::DSA_SHA1;
				break;

			case 'http://www.w3.org/2000/09/xmldsig#rsa-sha1':
				return XMLSecurityKey::RSA_SHA1;
				break;

			case 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256':
				return XMLSecurityKey::RSA_SHA256;
				break;
			case 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha384':
				return XMLSecurityKey::RSA_SHA384;
				break;

			case 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha512':
				return XMLSecurityKey::RSA_SHA512;
				break;

			default:
				echo sprintf('Invalid Encryption Method: '.$method);
				exit;
				break;
		}
	}

    /**
     * Add premium tag for premium features
     * @param $mo_tag
     * @return string
     */
    public static function mo_add_premium_tag( $mo_tag ) {
        global $base_url ;
        $url = $base_url .'/admin/config/people/miniorange_saml_idp/Licensing';
        $mo_premium_tag = '<a href= "'.$url.'" style="color: red; font-weight: lighter;">['. $mo_tag .']</a>';
        return $mo_premium_tag;
    }

	public static function mo_get_drupal_core_version() {
        return \DRUPAL::VERSION;
    }


  public static function drupal_is_cli()
  {
    $server = \Drupal::request()->server;
    $server_software = $server->get('SERVER_SOFTWARE');
    $server_argc = $server->get('argc');
    return !isset($server_software) && (php_sapi_name() == 'cli' || (is_numeric($server_argc) && $server_argc > 0));

  }
}
