<?php

/**
 * @file
 * Contains \Drupal\miniorange_saml_idp\Form\MiniorangeSPInformation.
 */

namespace Drupal\miniorange_saml_idp\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Render\Markup;
use Drupal\miniorange_saml_idp\Utilities;
use Drupal\miniorange_saml_idp\MiniorangeSAMLIdpConstants;

class MiniorangeSPInformation extends FormBase
{
  public function getFormId() {
    return 'miniorange_sp_setup';
  }
  public function buildForm(array $form, FormStateInterface $form_state)
  {
      global $base_url;
      $login_url = $base_url . '/initiatelogon';
      $issuer = $base_url . '/?q=admin/config/people/miniorange_saml_idp/';
      $module_path = \Drupal::service('extension.list.module')->getPath('miniorange_saml_idp');
      $issuer_id = isset($issuer_id) && !empty($issuer_id)? $issuer_id:$issuer;

      $form['markup_library'] = array(
        '#attached' => array(
          'library' => array(
              'miniorange_saml_idp/miniorange_saml_idp.admin',
              'miniorange_saml_idp/miniorange_saml_idp_copy.icon',
          )
        ),
          '#markup' => '<div class="mo_saml_table_layout_1"><div class="mo_saml_table_layout mo_saml_container">',
      );

    list($statusCode,$effectiveUrl) = Utilities::GetURL($login_url);
    if($effectiveUrl !==$login_url){
      $form['markup_reg_msg'] = array(
        '#markup' => '<div class="mo_saml_register_message">You need to make the <a href="'.$login_url.'">'.$login_url.'</a> anonymously accessible.</div>',
      );
    }

      /**
       * Create container to hold @IdentityProviderMetadata form elements.
       */
      $form['mo_saml_identity_provider_metadata'] = array(
          '#type' => 'fieldset',
          //'#title' => t('Identity Provider Metadata'),
          '#attributes' => array( 'style' => 'padding:2% 2% 5%; margin-bottom:2%' ),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_saml_idp_div_st'] = array(
          '#markup' => t('<div class="mo_saml_idp_font_for_heading">Identity Provider Metadata</div>
                                <p style="clear: both"></p><hr><br>'),
      );

      $form['mo_saml_identity_provider_metadata']['mo_saml_metadata_option'] = array(
          '#markup' => t('<div class="mo_saml_font_idp_setup_for_heading">Provide this module information to your Service Provider team.<br> You can choose any one of the below options:</div>
                             <br><b>a) Provide this metadata URL to your Service Provider:</b><br>'),
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_oauth_client_name_attr_title'] = array(
          '#markup' => '<br><div class="container-inline"><div class="mo_oauth_attr_mapping_label mo-callback"></div>',
      );

      $form['mo_saml_identity_provider_metadata']['miniorange_oauth_client_callback_url'] = array(
          '#markup' => '<span id="saml_idp_metadeta_url"><code><strong>' . $base_url . '/moidp_metadata</strong></code></span>',
          '#prefix' => '<div class= "mo_idp_mo_saml_highlight_background_url_not">',
          '#suffix' => '</div>',
      );

      $form['mo_saml_identity_provider_metadata']['test'] = array(
          '#value' => t('&#128461; Copy'),
          '#type' => 'submit',
          '#id' => 'copy_button',
          '#attributes' => ['onclick' => 'CopyToClipboard(saml_idp_metadeta_url)', 'class' => ['use-ajax button--small']],
          '#ajax' => [
            'event' => 'click',
            'progress' => [
              'type' => 'throbber',
              'message' => $this->t('copying')
            ],
          ],
          '#suffix' => '</div>',
      );

      $form['mo_saml_identity_provider_metadata']['mo_saml_download_btn_title'] = array(
          '#markup' => t('<br><br><div id="download_metadata_file"><b>b) Download the Module XML metadata and upload it on your Service Provider : </b>
                                <span><a href="' . $base_url . '/moidp_metadata_download" class="mo_idp_btn mo_idp_btn-primary mo_idp_btn-sm">Download XML Metadata</a></span>
                        </div><br><br><div><b>c) Provide the following information to your Service Provider. Copy it and keep it handy.</b></div><br>'),
      );

      $idp_Entity       =  $issuer_id;
      $saml_login_url   = $login_url ;
      $saml_logout_url  = 'Available in <a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'">Premium</a> version.';
      $certificate      = '<a href="' .$base_url . '/moidp_certificate_download">Click Here</a> to download X509 certificate.';
      $response_signed  = 'Available in </b><a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'">Premium</a> version.';
      $assertion_signed = 'You can choose to sign your assertion in <a href="' . $base_url . '/admin/config/people/miniorange_saml_idp/idp_setup">Service Provider Setup</a>';
      $NameIDFormat     = 'You can choose nameID format in <a href="' . $base_url . '/admin/config/people/miniorange_saml_idp/idp_setup">Service Provider Setup</a>';


      $mo_table_content = array (
          'IDP Entity ID or Issuer' => $idp_Entity,
          'SAML Login URL' => $saml_login_url,
          'SAML Logout URI' => $saml_logout_url,
          'Certificate (Optional)' => $certificate,
          'Response Signed' => $response_signed,
          'Assertion Signed' => $assertion_signed,
          'NameID Format' => $NameIDFormat,
      );

      $form['mo_saml_identity_provider_metadata']['mo_dfg_saml_attrs_list_idp'] = array(
          '#type' => 'table',
          '#header'=> array( 'ATTRIBUTE', 'VALUE' ,''),
          '#empty' => t('Something is not right. Please run the update script or contact us at <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a>'),
          '#responsive' => TRUE ,
          '#sticky'=> TRUE,
          '#size'=> 2,
          '#suffix' => '</div>'
      );

      foreach ($mo_table_content as $key => $value) {
          $row = self::miniorange_saml_idp_metadata_table($key, $value);
          $form['mo_saml_identity_provider_metadata']['mo_dfg_saml_attrs_list_idp'][$key] = $row;
      }

      Utilities::spConfigGuide($form, $form_state);

      return $form;
  }

    public function miniorange_saml_idp_metadata_table($attr_name, $attr_value){
        $row[$attr_name] = [
            '#markup' => '<div class="container-inline"><strong>'. $attr_name . '</strong>',
        ];

        if($attr_name == 'IDP Entity ID or Issuer' || $attr_name == 'SAML Login URL'){
            $row[$attr_value] = [
                '#markup' => '<span id="copy_'.str_replace(' ', '_', $attr_name).'">'.$attr_value.'</span>',
            ];

            $row['copy_'.$attr_name] = array(
                '#value' => t('&#128461; Copy'),
                '#type' => 'button',
                '#id' => 'copy_button_'.str_replace(' ', '_', $attr_name),
                '#attributes' => ['onclick' => 'CopyMetaToClipboard(copy_'.str_replace(' ', '_', $attr_name).')', 'class' => ['use-ajax button--small']],
                '#ajax' => [
                  'event' => 'click',
                  'progress' => [
                    'type' => 'throbber',
                    'message' => $this->t('copying'),
                    ],
                ],
                '#suffix' => '</div>',
            );
        } else {
            $row[$attr_value] = [
                '#markup' => t($attr_value),
                '#suffix' => '</div>'
            ];
        }
        return $row;
    }
    public function submitForm(array &$form, FormStateInterface $form_state) { }
}
