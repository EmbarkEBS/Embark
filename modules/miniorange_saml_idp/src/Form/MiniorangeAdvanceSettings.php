<?php

/**
 * @file
 * Contains \Drupal\miniorange_saml\Form\Export.
 */
namespace Drupal\miniorange_saml_idp\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\miniorange_saml_idp\MiniorangeSAMLIdpConstants;
use Drupal\miniorange_saml_idp\Utilities;

class MiniorangeAdvanceSettings extends FormBase
{
    public function getFormId(){
        return 'miniorange_saml_advance_settings';
    }
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        global $base_url;

      $form['markup_library'] = array(
        '#attached' => array(
          'library' => array(
            'miniorange_saml_idp/miniorange_saml_idp.admin',
          )
        ),
      );
        $idp_entity_id = $base_url . '/?q=admin/config/people/miniorange_saml_idp/';
        $idp_login_url = $base_url . '/initiatelogon';
        \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings')->set('miniorange_saml_idp_entity_id_issuer', $idp_entity_id)->save();
        \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings')->set('miniorange_saml_idp_login_url', $idp_login_url)->save();

        $form['markup_start'] = array(
            '#markup' => t('<div class="mo_saml_table_layout_1"><div class="mo_saml_table_layout mo_saml_container">
                            <div class="mo_saml_idp_font_for_heading">Advance Settings</div><p style="clear: both"></p><hr/>')
        );

        /**
         * Create container to hold @moSAMLAdvanseSettings form elements.
         */
        $form['mo_saml_import_export_configurations'] = array(
            '#type' => 'details',
            '#title' => t('Import/Export configurations' ),
            '#open' => TRUE,
            '#attributes' => array( 'style' => 'padding:0% 2%; margin-bottom:2%' )
        );


        $form['mo_saml_import_export_configurations']['markup_1'] = array(
            '#markup' => t('<hr><br><div class="mo_saml_highlight_background_note_export"><p><b>NOTE: </b>This tab will help you to transfer your module configurations when you change your Drupal instance.
                        <br>Example: When you switch from test environment to production.<br>Follow these 3 simple steps to do that:<br>
                        <br><strong>1.</strong> Download module configuration file by clicking on the Download Configuration button given below.
                        <br><strong>2.</strong> Install the module on new Drupal instance.<br><strong>3.</strong> Upload the configuration file in Import module Configurations section.<br>
                        <br><b>And just like that, all your module configurations will be transferred!</b></p></div>'),
        );

        $form['mo_saml_import_export_configurations']['markup_top_2'] = array (
            '#markup' => t('<br><br><div class="mo_saml_font_for_sub_heading">Export Configuration</div><hr/>
                    <div id="Exort_Configuration"><p>Click on the button below to download module configuration.</p>')
        );

        $entity_id = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_entity_id');
        $ACS_URL = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_acs_url');
        $disableButton = FALSE;
        if($entity_id == NULL || $ACS_URL == NULL){
            $disableButton = TRUE;
            $form['mo_saml_import_export_configurations']['markup_note'] = array(
                '#markup' => t('<div class="mo_saml_configure_message"> Please <a href="' . $base_url . '/admin/config/people/miniorange_saml_idp/idp_setup">Configure module </a> first to export the configurations.</div><br>'),
            );
        }

        $form['mo_saml_import_export_configurations']['miniorange_saml_imo_option_exists_export'] = array(
            '#type' => 'submit',
            '#value' => t('Download Configuration'),
            '#button_type' => 'primary',
            '#submit' => array('::miniorange_import_export'),
            '#disabled' => $disableButton,
            '#suffix' => '<br/><br/></div><div id="Import_Configuration"><br/>'
        );

        $form['mo_saml_import_export_configurations']['markup_prem_plan'] = array(
            '#markup' => t('<br><div class="mo_saml_font_for_sub_heading">Import Configuration</div><hr><br><div class="mo_saml_highlight_background_note_export"><b>Note: </b>Available in
            <a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'">Premium</a> version of the module</div>'),
        );

        $form['mo_saml_import_export_configurations']['markup_import_note'] = array(
            '#markup' => t('<p>This tab will help you to<span style="font-weight: bold"> Import your module configurations</span> when you change your Drupal instance.</p>
               <p>choose <b>"json"</b> Extened module configuration file and upload by clicking on the button given below. </p>'),
        );

        $form['mo_saml_import_export_configurations']['import_Config_file'] = array(
            '#type' => 'file',
            '#disabled' => TRUE,
            '#prefix' => '<div class="container-inline">',
        );

        $form['mo_saml_import_export_configurations']['miniorange_saml_idp_import'] = array(
            '#type' => 'submit',
            '#value' => t('Upload'),
            '#disabled' => TRUE,
            '#suffix' => '</div><br><br></div>',
        );

        /**
         * Create container to hold @moSAMLCustomCertificate form elements.
         */
        $form['mo_saml_custom_certificate'] = array(
            '#type' => 'details',
            '#title' => t('Custom Certificate ( Add or Generate Custom Certificate ) ' . Utilities::mo_add_premium_tag( 'PREMIUM' ) ),
            //'#open' => TRUE,
            '#attributes' => array( 'style' => 'padding:0% 2%; margin-bottom:6%' )
        );

        $form['mo_saml_custom_certificate']['markup_top'] = array(
            '#markup' =>t('<br><div class="mo_saml_font_idp_setup_for_heading">You can add or generate custom certificate from here.</div><br><div class="mo_saml_font_for_sub_heading">Add Custom Certificate</div><hr><br>'),
        );

        $form['mo_saml_custom_certificate']['miniorange_saml_private_certificate'] = array(
            '#type' => 'textarea',
            '#title' => t('X.509 Private Certificate'),
            '#attributes' => array(
                'style' => 'width:80%; background-color: hsla(0,0%,0%,0.08) !important;',
                'placeholder' => t('Copy and Paste the content from the downloaded certificate or copy the content enclosed in X509Certificate tag (has parent tag KeyDescriptor use=signing) in SP-Metadata XML file.')
            ),
            '#disabled' => TRUE,
            '#description'=> t('<strong>Note :</strong> Format of the Private key:<br /><strong>-----BEGIN PRIVATE KEY-----<br />
                  XXXXXXXXXXXXXXXXXXXXXXXXXXX<br />-----END PRIVATE KEY-----</strong><br /><br />'),
        );

        $form['mo_saml_custom_certificate']['miniorange_saml_publ_certificate'] = array(
            '#type' => 'textarea',
            '#title' => t('X.509 Public Certificate '),
            '#attributes' => array(
                'style' => 'width:80%; background-color: hsla(0,0%,0%,0.08) !important;',
                'placeholder' => t('Copy and Paste the content from the downloaded certificate or copy the content enclosed in X509Certificate tag (has parent tag KeyDescriptor use=signing) in SP-Metadata XML file.')
            ),
            '#disabled' => TRUE,
            '#description'=> t('<strong>Note :</strong> Format of the certificate:<br><strong>-----BEGIN CERTIFICATE-----<br />
                  XXXXXXXXXXXXXXXXXXXXXXXXXXX<br />-----END CERTIFICATE-----</strong><br><br>'),
        );

        $form['mo_saml_custom_certificate']['save_config_elements'] = array(
            '#type' => 'submit',
            '#name'=>'submit',
            '#button_type' => 'primary',
            '#value' => t('Upload'),
            '#submit' => array('::submitForm'),
            '#disabled' => TRUE,
        );

        $form['mo_saml_custom_certificate']['save_config_elements1'] = array(
            '#type' => 'submit',
            '#value' => t('Reset'),
            '#suffix' => '<br><br>',
            '#disabled' => TRUE,
        );

        $form['mo_saml_custom_certificate']['generate_certificate_markup'] = array(
            '#markup' =>t('<br><br><div class="mo_saml_font_for_sub_heading">Generate Custom Certificate</div><hr><br>'),
        );


        $form['mo_saml_custom_certificate']['mo_saml_country_code_text'] = array(
            '#type' => 'textfield',
            '#title' => t('Country Code:'),
            '#description' => t('<b>Note: </b>Check your country code <a>here</a>.'),
            '#attributes' => array(
                'style' => 'width:80%; background-color: hsla(0,0%,0%,0.08) !important;',
                'placeholder' => t('Enter Country code')
            ),
            '#disabled' => TRUE,
        );

        $form['mo_saml_custom_certificate']['mo_saml_certificate_state_name'] = array(
            '#type' => 'textfield',
            '#title' => t('State:'),
            '#attributes' => array(
                'style' => 'width:80%; margin-bottom:1.5%; background-color: hsla(0,0%,0%,0.08) !important;',
                'placeholder' => t('State Name')
            ),
            '#disabled' => TRUE,
        );

        $form['mo_saml_custom_certificate']['mo_saml_certificate_company_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Company:'),
            '#attributes' => array(
                'style' => 'width:80%; margin-bottom:1.5%; background-color: hsla(0,0%,0%,0.08) !important;',
                'placeholder' => t('Company Name')
            ),
            '#disabled' => TRUE,
        );

        $form['mo_saml_custom_certificate']['miniorange_saml_unit_name'] = array(
            '#type' => 'textfield',
            '#title' => 'Unit:',
            '#attributes' => array(
                'style' => 'width:80%; margin-bottom:1.5%; background-color: hsla(0,0%,0%,0.08) !important;',
                'placeholder' => t('Unit name')
            ),
            '#disabled' => TRUE,
        );

        $form['mo_saml_custom_certificate']['mo_saml_certificate_common_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Common:'),
            '#attributes' => array(
                'style' => 'width:80%; margin-bottom:1.5%; background-color: hsla(0,0%,0%,0.08) !important;',
                'placeholder' => t('Common Name')
            ),
            '#disabled' => TRUE,
        );

        $form['mo_saml_custom_certificate']['mo_saml_select_digest_algo'] = array(
            '#type' => 'select',
            '#title' => t('Digest Algorithm:'),
            '#options' => array(
                'sha512' => t('SHA512'),
                'sha384' => t('SHA384'),
                'sha256' => t('SHA256'),
                'sha1' => t('SHA1'),
            ),
            '#attributes' => array('style' => 'width:80%; margin-bottom:1.5%;height:29px;'),

        );

        $form['mo_saml_custom_certificate']['mo_saml_select_private_key_bit'] = array(
            '#type' => 'select',
            '#title' => t('Bits to generate the private key:'),
            '#options' => array(
                '2048' => t('2048 bits'),
                '1024' => t('1024 bits'),
            ),
            '#attributes' => array('style' => 'width:80%; margin-bottom:1.5%;height:29px;'),

        );

        $form['mo_saml_custom_certificate']['mo_saml_select_valid_days'] = array(
            '#type' => 'select',
            '#title' => t('Valid Days:'),
            '#options' => array(
                '365' => t('365 days'),
                '180' => t('180 days'),
                '90' => t('90 days'),
                '45' => t('45 days'),
                '30' => t('30 days'),
                '15' => t('15 days'),
                '7' => t('7 days'),
            ),
            '#attributes' => array('style' => 'width:80%; margin-bottom:1.5%;height:29px;'),
        );

        $form['mo_saml_custom_certificate']['generate_config_elements'] = array(
            '#type' => 'submit',
            '#button_type' => 'primary',
            '#value' => t('Generate Self-Signed Certs'),
            '#prefix' => '<br><br>',
            '#disabled' => TRUE,
        );

        $form['mo_saml_custom_certificate']['clear_genrate_certificate_data'] = array(
            '#type' => 'submit',
            '#value' => t('Clear Data'),
            '#suffix' => '<br><br></div>',
            '#disabled' => TRUE,
        );

        Utilities::advertise2fa($form, $form_state);

        return $form;
    }
    function miniorange_import_export()
    {
        $tab_class_name = Utilities::getClassNameForImport_Export();
        $configuration_array = array();
        foreach($tab_class_name as $key => $value) {
            $configuration_array[$key] = self::mo_get_configuration_array($value);
        }
        $configuration_array["Version_dependencies"] = self::mo_get_version_informations();
        header("Content-Disposition: attachment; filename = miniorange_saml_idp_config.json");
        echo(json_encode($configuration_array, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
        exit;
    }

    function mo_get_configuration_array($class_name) {
        $class_object = Utilities::getVariableArrayForImport_Export($class_name);
        $mo_array = array();
        foreach($class_object as $key => $value) {
            $mo_option_exists = \Drupal::config('miniorange_saml_idp.settings')->get($value);
            if($mo_option_exists) {
                $mo_array[$key] = $mo_option_exists;
            }
        }
        return $mo_array;
    }

    function mo_get_version_informations() {
        $array_version = array();
        $array_version["PHP_version"] = phpversion();
        $array_version["Drupal_version"] = Utilities::mo_get_drupal_core_version();
        $array_version["OPEN_SSL"] = self::mo_saml_is_openssl_installed();
        $array_version["CURL"] = self::mo_saml_is_curl_installed();
        $array_version["ICONV"] = self::mo_saml_is_iconv_installed();
        $array_version["DOM"] = self::mo_saml_is_dom_installed();
        return $array_version;
    }

    function mo_saml_is_openssl_installed() {
        if (in_array( 'openssl', get_loaded_extensions())) {
            return 1;
        }else {
            return 0;
        }
    }

    function mo_saml_is_curl_installed() {
        if (in_array( 'curl', get_loaded_extensions())) {
            return 1;
        }else {
            return 0;
        }
    }

    function mo_saml_is_iconv_installed() {
        if (in_array( 'iconv', get_loaded_extensions())) {
            return 1;
        } else {
            return 0;
        }
    }

    function mo_saml_is_dom_installed() {
        if (in_array( 'dom', get_loaded_extensions())) {
            return 1;
        } else {
            return 0;
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {

    }
}
