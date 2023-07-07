<?php
/**
 * @file
 * Contains Attribute for miniOrange SAML IDP Module.
 */

 /**
 * Showing Settings form.
 */
namespace Drupal\miniorange_saml_idp\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_saml_idp\Utilities;
use Drupal\miniorange_saml_idp\MiniorangeSAMLIdpConstants;

class Mapping extends FormBase {

  public function getFormId() {
    return 'miniorange_saml_mapping';
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

      $form['markup_idp_attr_header'] = array(
          '#markup' => t('<div class="mo_saml_table_layout_1"><div class="mo_saml_table_layout mo_saml_container">'),
      );

     /**
      * Create container to hold @IdentityProviderMapping form elements.
      */
     $form['mo_saml_IDP_mapping'] = array(
         '#type' => 'fieldset',
         //'#title' => t('Mapping'),
         '#attributes' => array( 'style' => 'padding:2% 2% 5%; margin-bottom:2%' ),
     );

     $form['mo_saml_IDP_mapping']['miniorange_saml_idp_div_st'] = array(
         '#markup' => t('<div class="mo_saml_idp_font_for_heading">Attribute Mapping (Optional)</div>
                               <p style="clear: both"></p><hr><br>'),
     );


      $form['mo_saml_IDP_mapping']['miniorange_saml_idp_nameid_attr_map'] = array(
        '#type' => 'select',
        '#title' => t('NameID Attribute:'),
        '#options' => array(
            'emailAddress' => t('Drupal Email Address'),
            'username' => t('Drupal Username'),),
        '#default_value' =>\Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_nameid_attr_map'),
        '#attributes' => array('style' => 'width:90%;height:30px;'),
      );

     $form['mo_saml_IDP_mapping']['markup_idp_sp_note'] = array(
         '#markup' => t('<div class = "mo_saml_highlight_background_note" ><b>Note:</b></divspan> This attribute value is sent in SAML Response. Users in your Service Provider
         will be searched (existing users) or created (new users) based on this attribute. Use <b>EmailAddress</b> by default.</b></div>
         <br/><br/><div id="Custom_Attribute_Mapping_start"><h3>Custom Attribute Mapping <a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'">[Premium]</a></h3>'),
     );

     for( $i = 1; $i < 4; $i++ ) {
         $form['mo_saml_IDP_mapping']['miniorange_saml_idp_attr'. $i .'_name'] = array(
             '#type' => 'textfield',
             '#title' => t('Attribute Name '. $i),
             '#attributes' => array('style' => 'width:90%;height:30px;','placeholder' => t('Enter Attribute Name')),
             '#disabled' => TRUE,
         );

         $form['mo_saml_IDP_mapping']['miniorange_saml_idp_attr' . $i . '_value'] = array(
             '#type' => 'select',
             '#title' => t('Drupal Attribute Value'),
             '#disabled' => TRUE,
             '#options' => array(
                 'Select Attribute Value' => t('Select Attribute Value'),
             ),
             '#attributes' => array('style' => 'width:90%;height:30px;'),
         );
     }

     $form['mo_saml_IDP_mapping']['miniorange_saml_idp_additional_user_attrs'] = array(
         '#markup' => '<br><hr><br><br><h3>Additional User Attributes (Optional) &nbsp;&nbsp;&nbsp;&nbsp;
                            <a id="addConstAttr" disabled="disabled" class="mo_idp_btn mo_idp_btn-primary mo_idp_btn-sm" style="padding:6px 12px;" onclick="">+</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'">[Premium]</a><br></h3>',

     );

     $form['mo_saml_IDP_mapping']['markup_idp_user_attr_note'] = array(
         '#markup' => '<div class="mo_saml_highlight_background_note" id="ConstAttrNote"><b>User Profile Attribute Name:</b>It is the name which you want to send to your SP. It should be unique.
                            <br /><b>Drupal User Profile Attribute Value:</b> It is the user attribute (machine name) whose value you want to send to SP.</div>',
     );

     $form['mo_saml_IDP_mapping']['mo_saml_constant_attr_top'] = array(
         '#markup' => '<div id = "mo_constant_attributes_parent">',
     );

     $form['mo_saml_IDP_mapping']['user_profile_attr_name_1'] = array(
         '#type' => 'textfield',
         '#title' => 'User Profile Attribute Name',
         '#disabled' => TRUE,
         '#attributes' => array('style' => 'width:90%'),
         '#prefix' => '<div class="mo_idp_attr_map_row" id="mo_idp_constant_attr_map_1"><div class="mo_idp_attr_map_sp_name">',
         '#suffix' => '</div>',
     );
     $form['mo_saml_IDP_mapping']['user_profile_attr_value_1'] = array(
         '#type' => 'textfield',
         '#disabled' => TRUE,
         '#attributes' => array('style' => 'width:80%'),
         '#title' => 'Drupal User Profile Attribute Value',
         '#prefix' => '<div class="mo_idp_attr_map_idp_name">',
         '#suffix' => '</div>',
     );

     $form['mo_saml_IDP_mapping']['miniorange_user_profile_attr_delete'] = array(
         '#type'       => 'button',
         '#value'      => t('-'),
         '#disabled' => TRUE,
         '#attributes' => array('class'=>array( 'button_class_attr', 'removeConstAttr' ), 'onclick' => "remove_constant_attibute"),
         '#prefix'     => '<div class="mo_idp_attr_map_delete">',
     );

     $form['mo_saml_IDP_mapping']['miniorange_saml_idp_constant_attrs'] = array(
         '#markup' => '</div><br><br><hr><br><br><h3>Constant  Attributes (Optional) &nbsp;&nbsp;&nbsp;&nbsp;
                            <a id="addConstAttr" disabled="disabled" class="mo_idp_btn mo_idp_btn-primary mo_idp_btn-sm" style="padding:6px 12px;" onclick="">+</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="' . $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL .'">[Premium]</a><br></h3>',

     );

     $form['mo_saml_IDP_mapping']['markup_idp_constant_attr_note'] = array(
         '#markup' => '<div class="mo_saml_highlight_background_note" id="ConstAttrNote"><b>Attribute Name:</b> It is the name which you want to send to your SP. It should be unique.
                            <br /><b>Attribute Value:</b> It is the constant value you want to send to your SP in every SSO.</div>',
     );

     $form['mo_saml_IDP_mapping']['mo_saml_constant_attr_top'] = array(
         '#markup' => '<div id = "mo_constant_attributes_parent">',
     );

     $form['mo_saml_IDP_mapping']['miniorange_saml_idp_constant_attr_name'] = array(
         '#type' => 'textfield',
         '#title' => 'Constant Attribute Name',
         '#disabled' => TRUE,
         '#attributes' => array('style' => 'width:90%'),
         '#prefix' => '<div class="mo_idp_attr_map_row" id="mo_idp_constant_attr_map_1"><div class="mo_idp_attr_map_sp_name">',
         '#suffix' => '</div>',
     );
     $form['mo_saml_IDP_mapping']['miniorange_saml_idp_constant_attr_value'] = array(
         '#type' => 'textfield',
         '#disabled' => TRUE,
         '#attributes' => array('style' => 'width:80%'),
         '#title' => 'Constant Attribute Value',
         '#prefix' => '<div class="mo_idp_attr_map_idp_name">',
         '#suffix' => '</div>',
     );

     $form['mo_saml_IDP_mapping']['miniorange_saml_idp_constant_attr_delete'] = array(
         '#type'       => 'button',
         '#value'      => t('-'),
         '#disabled' => TRUE,
         '#attributes' => array('class'=>array('button_class_attr','removeConstAttr'),'onclick' => "remove_constant_attibute"),
         '#prefix'     => '<div class="mo_idp_attr_map_delete">',
         '#suffix'     => '</div></div>',
     );


     $form['mo_saml_IDP_mapping']['mo_saml_constant_attr_bottom'] = array(
         '#markup' => '</div></div><br><br>',
     );


     $form['mo_saml_IDP_mapping']['miniorange_saml_idp_attr_map_submit'] = array(
         '#type' => 'submit',
         '#button_type' => 'primary',
         '#value' => t('Save Configuration'),
         '#suffix' => '<br><br></div></div>'
     );

     Utilities::advertise2fa($form, $form_state);

     return $form;

 }
  public function submitForm(array &$form, FormStateInterface $form_state){
      $form_value = $form_state->getValues();
      $nameid_attr = $form_value['miniorange_saml_idp_nameid_attr_map'];
      $nameid_attr_value = $nameid_attr == '' ? 'emailAddress' : $nameid_attr;
      \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings')->set('miniorange_saml_idp_nameid_attr_map', $nameid_attr_value)->save();
      \Drupal::messenger()->addMessage(t('Your settings are saved successfully.'));
  }
}
