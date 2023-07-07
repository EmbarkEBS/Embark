<?php

/**
 * @file
 * Contains \Drupal\miniorange_saml_idp\Form\MiniorangeSPInformation.
 */

namespace Drupal\miniorange_saml_idp\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_saml_idp\Utilities;
use Drupal\miniorange_saml_idp\MiniorangeSAMLSP;

class MiniorangeSignonSettings extends FormBase
{
  public function getFormId() {
    return 'miniorange_saml_login_setting';
  }
  public function buildForm(array $form, FormStateInterface $form_state)
  {
      global $base_url;

        $form['markup_idp_login_header'] = array(
            '#attached' => array(
                'library' => array(
                    "miniorange_saml_idp/miniorange_saml_idp_copy.icon",
                    "miniorange_saml_idp/miniorange_saml_idp.admin",
                )
            ),
          '#markup' => t('<div class="mo_saml_table_layout_1"><div class="mo_saml_table_layout mo_saml_container">
                               <div class="mo_saml_idp_font_for_heading">IDP Initiated Login <a href="'. $base_url .'/admin/config/people/miniorange_saml_idp/Licensing">[PREMIUM]</a></div>
                               <p style="clear: both"></p><hr><br>'),
        );

        $disabled = true;

        $form['sign_on_settings'] = array(
            '#type' => 'fieldset',
            '#attributes' => array( 'style' => 'padding:2% 2% 5%; margin-bottom:2%' ),
        );

        $form['sign_on_settings']['Checkbox'] = array(
            '#prefix' => '</div>',
            '#type' => 'checkbox',
            '#title' => t('Enable Identity Provider Initiated SSO &nbsp;&nbsp;&nbsp;&nbsp;') .'<a href="'. $base_url .'/admin/config/people/miniorange_saml_idp/Licensing">[PREMIUM]</a>',
            '#description' => '<b>Note: </b>'.t('Check this checkbox to enable IDP initiate SSO').'<br> ',
            '#disabled' => $disabled,
        );

        $form['sign_on_settings']['mo_saml_idp_debugging_log'] = array(
            '#type' => 'checkbox',
            '#title' => t('Enable logging &nbsp;&nbsp;&nbsp;&nbsp;') .'<a href="'. $base_url .'/admin/config/people/miniorange_saml_idp/Licensing">[PREMIUM]</a>',
            '#description' => t('Enabling this checkbox will add loggers under the <a target="_blank" href="'. $base_url .'/admin/reports/dblog"> Reports </a> section '),
            '#suffix' => '<br><br>',
            '#disabled' => $disabled,
          );

        $form['sign_on_settings']['mo_saml_idp_logging'] = array(
        '#type' => 'submit',
        '#value' => t('Save Configuration'),
        '#disabled' => $disabled,
        '#attributes' => array( 'class' => array('button button--primary')),
        );

       Utilities::advertise2fa($form, $form_state);

      return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

  }
}
