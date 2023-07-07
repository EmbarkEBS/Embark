<?php

/**
 * @file
 * Contains \Drupal\miniorange_saml_idp\Form\MiniorangeIDPSetup.
 */

namespace Drupal\miniorange_saml_idp\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_saml_idp\Utilities;
use Drupal\miniorange_saml_idp\MiniorangeSAMLIdpConstants;

class MiniorangeIDPSetup extends FormBase {

  public function getFormId() {
    return 'miniorange_saml_idp_setup';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
      global $base_url;
      $login_url = $base_url . '/initiatelogon';

      $form['miniorange_saml_SP_tab'] = array(
          '#attached' => array(
              'library' => array(
                  'miniorange_saml_idp/miniorange_saml_idp.admin',
                  'miniorange_saml_idp/miniorange_saml_idp.test',
              )
          ),
      );

      $form['metadata_1'] = array(
          '#markup' => t('<div class="mo_saml_table_layout_1"><div class="mo_saml_table_layout mo_saml_container"><div class="mo_saml_idp_font_for_heading">Service Provider Setup</div>
                                <p style="clear: both"></p><hr><br><div class="mo_saml_font_idp_setup_for_heading">Enter the information gathered from your Service Provider</div>'),
      );
    list($statusCode,$effectiveUrl) = Utilities::GetURL($login_url);
    if($effectiveUrl !==$login_url){
      $form['markup_reg_msg'] = array(
        '#markup' => '<div class="mo_saml_register_message">You need to make the <a href="'.$login_url.'">'.$login_url.'</a> anonymously accessible.</div>',
      );
    }

      /**
       * Create container to hold @moSAMLSPSetup form elements.
       */
      $form['mo_saml_SP_setup'] = array(
          '#type' => 'details',
          '#title' => t('Upload SP Metadata' ),
          //'#open' => TRUE,
          '#attributes' => array( 'style' => 'padding:0% 2%; margin-bottom:2%' ),
      );


      $form['mo_saml_SP_setup']['metadata_file'] = array(
          '#type' => 'file',
          '#title' => 'Upload Metadata',
          '#prefix' => '<hr><br><div class="container-inline">',
      );

      $form['mo_saml_SP_setup']['metadata_upload'] = array(
          '#type' => 'submit',
          '#value' => t('Upload'),
          '#button_type' => 'primary',
          '#submit' => array('::miniorange_saml_upload_file'),
          '#suffix'  => t('</div><br><h2>&emsp;&emsp;&emsp;OR</h2><br>'),
      );

      $form['mo_saml_SP_setup']['metadata_URL'] = array(
          '#type' => 'url',
          '#title' => t('Enter metadata URL'),
          '#attributes' => array('style' => 'width:65%','placeholder' => t('Enter metadata URL of your SP.')),
          '#prefix' => '<div class="container-inline">',
      );

      $form['mo_saml_SP_setup']['metadata_fetch'] = array(
          '#type' => 'submit',
          '#value' => t('Fetch Metadata'),
          '#button_type' => 'primary',
          '#submit' => array('::miniorange_saml_fetch_metadata'),
          '#suffix' => '</div><br>',
      );

      /**
       * Create container to hold @IdentityProviderSetup form elements.
       */
      $form['mo_saml_identity_provider_metadata'] = array(
          '#type' => 'fieldset',
          //'#title' => t('Service Provider Metadata'),
          '#attributes' => array( 'style' => 'padding:2% 2% 5%; margin-bottom:2%' ),
      );

      $form['mo_saml_identity_provider_metadata']['markup_idp_note'] = array(
        '#markup' => t('<div><br><div class = "mo_saml_highlight_background_note"><b>Note: </b>Please note down the following information from your
                           Service Provider and keep it handy to configure your Identity Provider.</div><br>'),
      );

      $form['mo_saml_identity_provider_metadata']['markup_idp_list'] = array(
            '#markup' => t('<b><ol><li>SP Entity ID / Issuer</li>
              <li>ACS URL</li>
              <li>X.509 Certificate for Signing if you are using HTTP-POST Binding. [This is a
              <a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'">Premium</a> feature]</li>
              <li>X.509 Certificate for Encryption. [This is a
              <a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'">Premium</a> feature]</li>
              <li>NameID Format</li></ol></b><br>'),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_name'] = array(
          '#type' => 'textfield',
          '#title' => t('Service Provider Name<span style="color: red">*</span>'),
          '#default_value' => \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_name'),
          '#attributes' => array(
              'style' => 'width:90%',
              'placeholder' => t('Enter Service Provider Name')
          ),
          '#prefix' => '<div>'
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_entity_id'] = array(
        '#type' => 'textfield',
        '#title' => t('SP Entity ID or Issuer<span style="color: red">*</span>'),
        '#description' => t('<b>Note :</b> You can find the EntityID in Your SP-Metadata XML file enclosed in <code>EntityDescriptor</code> tag having attribute as <code>entityID</code>.'),
        '#default_value' => \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_entity_id'),
        '#attributes' => array('style' => 'width:90%','placeholder' => t('Enter SP Entity ID or Issuer')),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_acs_url'] = array(
        '#type' => 'url',
        '#title' => t('ACS URL<span style="color: red">*</span>'),
        '#default_value' => \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_acs_url'),
          '#attributes' => array('style' => 'width:90%','placeholder' => t('Enter ACS URL')),
          '#description' => t('<b>Note :</b> You can find the ACS URL in Your SP-Metadata XML file enclosed in <code>AssertionConsumerService </code> tag having attribute as <code>Location</code>.<br><br>'),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_nameid_format'] = array(
          '#type' => 'select',
          '#title' => t('NameID Format:'),
          '#options' => array(
              '1.1:nameid-format:emailAddress' => t('urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress'),
              '1.1:nameid-format:unspecified' => t('urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified'),
              '2.0:nameid-format:transient' => t('urn:oasis:names:tc:SAML:1.1:nameid-format:transient'),
              '2.0:nameid-format:persistent' => t('urn:oasis:names:tc:SAML:1.1:nameid-format:persistent'),
          ),
          '#default_value' =>\Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_nameid_format'),
          '#attributes' => array('style' => 'width:90%;background-image: inherit;background-color: white;-webkit-appearance: menulist;'),
          '#description' => t('<b>Note:</b> urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress is selected by default'),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_relay_state'] = array(
        '#type' => 'textfield',
        '#title' => t('Relay State'),
        '#description' => t('<b>Note:</b> To identify the specific resource at the resource provider in the IDP initiated SSO. It specifes the landing page at the service provider once SSO completes.<br><br>'),
        '#default_value' => \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_relay_state'),
        '#attributes' => array('style' => 'width:90%','placeholder' => t('Enter Relay State (optional)')),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_single_logout_url'] = array(
          '#type' => 'textfield',
          '#title' => t('Single Logout URL (optional):<a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'"> [Premium]</a>'),
          '#attributes' => array('style' => 'width:90%','placeholder' => t('Enter Sinle Logout URL')),
          '#disabled' => TRUE,
          '#suffix' => '<br>',
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_x509_certificate_request'] = array(
          '#type' => 'textarea',
          '#title' => t('x.509 Certificate Value  <b>[Note: For Signed Request.] </b><a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'"> [Premium]</a>'),
          '#cols' => '10',
          '#rows' => '5',
          '#attributes' => array('style' => 'width:90%','placeholder' => t('Copy and Paste the content from the downloaded certificate or copy the content enclosed in X509Certificate tag (has parent tag KeyDescriptor use=signing) in SP-Metadata XML file)')),
          '#disabled' => TRUE,
          '#description' => t('<b>Note:</b> Format of the certificate:<br><b>-----BEGIN CERTIFICATE-----<br>XXXXXXXXXXXXXXXXXXXXXXXXXXX<br>-----END CERTIFICATE-----</b>'),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_x509_certificate_assertion'] = array(
          '#type' => 'textarea',
          '#title' => t('x.509 Certificate Value <b>[Note: For Encrypted Assertion.]</b> <a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'"> [Premium]</a>'),
          '#cols' => '10',
          '#rows' => '5',
          '#attributes' => array('style' => 'width:90%','placeholder' => t('Copy and Paste the content from the downloaded certificate or copy the content enclosed in X509Certificate tag (has parent tag KeyDescriptor use=encryption)')),
          '#disabled' => TRUE,
          '#description' => t('<b>Note:</b> Format of the certificate:<br><b>-----BEGIN CERTIFICATE-----<br>XXXXXXXXXXXXXXXXXXXXXXXXXXX<br>-----END CERTIFICATE-----</b>'),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_assertion_signed'] = array(
          '#type' => 'checkbox',
          '#title' => t('<b>Assertion Signed</b>'),
          '#default_value' => \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_assertion_signed'),
          '#description' => t('<b>Note:</b> Check this if you want to sign SAML Assertion.'),
          '#prefix' => '<div id="assertion_signed"><br>',
          '#suffix' => '</div>',
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_response_signed'] = array(
         '#markup' => '<br>',
         '#type' => 'checkbox',
         '#title' => t('<b>Response Signed:</b>'),
         '#disabled' => TRUE,
          '#description' => t('<b>Note:</b> This feature is available in the<a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'"> Premium </a>version of the module.'),
         '#prefix' => '<div class="mo_saml_highlight_background_note">',
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_encrypt_signed'] = array(
         '#type' => 'checkbox',
         '#title' => t('<b>Encrypted Assertion:</b>'),
         '#disabled' => TRUE,
          '#description' => t('<b>Note:</b> This feature is available in the<a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'"> Premium </a>version of the module.'),
         '#suffix' => '</div><br><br><br>',
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_config_submit'] = array(
          '#type' => 'submit',
          '#button_type' => 'primary',
          '#value' => t('Save Configuration'),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_test_config_button'] = array (
        '#type' => 'button',
        '#value' => t('Test Configuration'),
        '#attributes' => array('id'=>'testConfigButton', 'style'=>'color:white;background-color:green;'),
    );

      $entity_id = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_entity_id');
      $ACS_URL = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_acs_url');
      $disableButton = FALSE;
      if($entity_id == NULL || $ACS_URL == NULL)
          $disableButton = TRUE;

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_config_delete'] = array(
          '#type' => 'submit',
          '#value' => t('Delete Configuration'),
          '#submit' => array('::miniorange_saml_idp_delete_idp_config'),
          '#button_type' => 'danger',
          '#disabled' => $disableButton,
          '#suffix' => '<br><br></div></div></div>',
      );

      Utilities::spConfigGuide($form, $form_state);

  return $form;
 }

 function getTestUrl() {
    global $base_url;
    $testUrl = $base_url . '/?q=testConfig';
    return $testUrl;
 }


 function submitForm(array &$form, FormStateInterface $form_state) {
     $utilities = new Utilities();
     $form_values         = $form_state->getValues();
     if( empty( $form_values['miniorange_saml_idp_name'] ) || empty( $form_values['miniorange_saml_idp_entity_id'] ) || empty( $form_values['miniorange_saml_idp_acs_url'] ) ){
         \Drupal::messenger()->addMessage(t('The <b>Service Provider Name, SP Entity ID or Issuer, ACS URL</b> field is required.'), 'error');
         return;
     }
     $variables_and_values = array(
         'miniorange_saml_idp_name'             => $form_values['miniorange_saml_idp_name'],
         'miniorange_saml_idp_entity_id'        => str_replace(' ', '', $form_values['miniorange_saml_idp_entity_id'] ),
         'miniorange_saml_idp_acs_url'          => str_replace(' ', '', $form_values['miniorange_saml_idp_acs_url'] ),
         'miniorange_saml_idp_relay_state'      => $form_values['miniorange_saml_idp_relay_state'],
         'miniorange_saml_idp_nameid_format'    => $form_values['miniorange_saml_idp_nameid_format'],
         'miniorange_saml_idp_assertion_signed' => $form_values['miniorange_saml_idp_assertion_signed'] == 1 ? TRUE : FALSE,
     );

     $utilities->miniOrange_set_get_configurations( $variables_and_values, 'SET' );
     \Drupal::messenger()->addMessage(t('Your Service Provider configuration are successfully saved. You can click on Test Configuration button below to test these configurations.'));
     return;
 }

    function miniorange_saml_idp_delete_idp_config(array &$form, FormStateInterface $form_state) {
        $variables_and_values = array(
            'miniorange_saml_idp_name',
            'miniorange_saml_idp_entity_id',
            'miniorange_saml_idp_acs_url',
            'miniorange_saml_idp_relay_state',
            'miniorange_saml_idp_nameid_format',
            'miniorange_saml_idp_assertion_signed',
        );
        Utilities::miniOrange_set_get_configurations( $variables_and_values, 'CLEAR' );
        \Drupal::messenger()->addMessage(t('Service Provider Configuration successfully deleted.'));
        return;
    }

    function miniorange_saml_upload_file(array &$form, FormStateInterface $form_state) {
        $file_name = $_FILES['files']['tmp_name']['metadata_file'];
        if(!empty($file_name)){
          $file = file_get_contents($file_name);
          Utilities::upload_metadata( $file, $type = 'file' );
        }
        else
          \Drupal::messenger()->addMessage(t('Select a metadata file to configure.'),'error');
    }

    function miniorange_saml_fetch_metadata(array &$form, FormStateInterface $form_state) {
        $form_values = $form_state->getValues();
        $url         = filter_var( $form_values['metadata_URL'],FILTER_SANITIZE_URL );
       if( !empty($url ) ) {
         $arrContextOptions=array(
              "ssl"=>array(
                  "verify_peer"=>false,
                  "verify_peer_name"=>false,
              ),
         );
         $file = file_get_contents($url, false, stream_context_create($arrContextOptions));
         Utilities::upload_metadata( $file, $type = 'URL' );
       }
       else
       \Drupal::messenger()->addMessage(t('Enter metadata url to configure.'),'error');
    }
}
