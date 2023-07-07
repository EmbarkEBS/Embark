<?php

/**
 * @file
 * Contains \Drupal\miniorange_saml\Form\MiniorangeSamlCustomerSetup.
 */

namespace Drupal\miniorange_saml_idp\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Form\FormBase;
use Drupal\miniorange_saml_idp\Utilities;

class MiniorangeSamlCustomerSetup extends FormBase
{

    public function getFormId()
    {
        return 'miniorange_saml_customer_setup';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        global $base_url;

        $current_status = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_status');

        $form['markup_library'] = array(
          '#attached' => array(
            'library' => array(
              'miniorange_saml_idp/miniorange_saml_idp.admin',
            )
          ),
        );

        if ($current_status == 'VALIDATE_OTP') {

            $form['markup_top'] = array(
                '#markup' => '<div class="mo_saml_table_layout_1"><div class="mo_saml_table_layout mo_saml_container">'
            );

            /**
             * Create container to hold @validateOTP form elements.
             */
            $form['mo_saml_validate_otp'] = array(
                '#type' => 'fieldset',
                //'#title' => t('Validate OTP'),
                '#attributes' => array( 'style' => 'padding:2% 2% 5%; margin-bottom:2%' ),
            );

            $form['mo_saml_validate_otp']['markup_15'] = array(
                '#markup' => t('<div class="mo_saml_idp_font_for_heading">Validate OTP</div><p style="clear: both"></p><hr><br>'),
            );

            $form['mo_saml_validate_otp']['miniorange_saml_customer_otp_token'] = array(
                '#type' => 'textfield',
                '#title' => t('OTP<span style="color: red">*</span>'),
                '#attributes' => array('style' => 'width:80%'),
                '#description' => t('<strong>Note:</strong> We have sent an OTP. Please enter the OTP to verify your email.'),
                '#suffix' => '<br/>',
            );

            $form['mo_saml_validate_otp']['miniorange_saml_customer_validate_otp_button'] = array(
                '#type' => 'submit',
                '#button_type' => 'primary',
                '#value' => t('Validate OTP'),
                '#submit' => array('::miniorange_saml_idp_validate_otp_submit'),
            );

            $form['mo_saml_validate_otp']['miniorange_saml_customer_setup_resendotp'] = array(
                '#type' => 'submit',
                '#value' => t('Resend OTP'),
                '#submit' => array('::miniorange_saml_idp_resend_otp'),
            );

            $form['mo_saml_validate_otp']['miniorange_saml_customer_setup_back'] = array(
                '#type' => 'submit',
                '#value' => t('Back'),
                '#button_type' => 'danger',
                '#submit' => array('::miniorange_saml_idp_back'),
                '#suffix' => '<br><br><br><br><br><br><br><br>
                        <br><br><br><br><br><br></div>',
            );

            Utilities::advertise2fa($form, $form_state);

            return $form;
        } elseif ($current_status == 'PLUGIN_CONFIGURATION') {
            $form['markup_top_message'] = array(
                '#markup' => t('<div class="mo_saml_table_layout_1"><div class="mo_saml_table_layout mo_saml_container">')
            );
            /**
             * Create container to hold @UserProfile form elements.
             */
            $form['mo_saml_user_profile'] = array(
                '#type' => 'fieldset',
                //'#title' => t('Profile'),
                '#attributes' => array( 'style' => 'padding:2% 2% 5%; margin-bottom:2%' ),
            );
            $form['mo_saml_user_profile']['markup_top_'] = array(
                '#markup' => t('<div class="mo_saml_welcome_message">Thank you for registering with miniOrange</div><br><h4>Your Profile: </h4>')
            );

            $header = array( t('Attribute'),  t('Value'),);
            $options = array(
              array( 'Customer Email', \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email'),),
              array( 'Customer ID', \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_customer_id'),),
              array( 'Token Key', \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_customer_admin_token'),),
              array( 'API Key', \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_customer_api_key'),),
              array( 'Drupal Version', Utilities::mo_get_drupal_core_version(),),
              array( 'PHP Version', phpversion(),),
            );

          $form['mo_saml_user_profile']['fieldset']['customerinfo'] = array(
                '#theme' => 'table',
                '#header' => $header,
                '#rows' => $options,
                '#suffix' => '<br><br><br>',
                '#attributes' => array( 'style' => 'margin:1% 0% 7%;' ),
            );

            $form['mo_saml_user_profile']['miniorange_saml_customer_Remove_Account_info'] = array(
                '#markup' => t('<br><br><br><br><br/><h4>Remove Account:</h4><p>This section will help you to remove your current
                        logged in account without losing your current configurations.</p>')
            );

            $form['mo_saml_user_profile']['miniorange_saml_customer_Remove_Account'] = array(
                '#type' => 'link',
                '#title' => $this->t('Remove Account'),
                '#url' => Url::fromRoute('miniorange_saml_idp.modal_form'),
                '#attributes' => [
                    'class' => [
                        'use-ajax',
                        'button',
                    ],
                ],
                '#suffix' => '</div>'
            );

            $form['#attached']['library'][] = 'core/drupal.dialog.ajax';

            Utilities::advertise2fa($form, $form_state);

            return $form;
        }

        $url = $base_url . '/admin/config/people/miniorange_saml_idp/customer_setup';

        $tab = isset($_GET['tab']) && $_GET['tab'] == 'login' ? $_GET['tab'] : 'register';

        $form['markup_top'] = array(
            '#markup' => '<div class="mo_saml_table_layout_1"><div id="Register_Section" class="mo_saml_table_layout mo_saml_container">'
        );

            if ( $tab == 'register' ) {

            /**
             * Create container to hold @Registration form elements.
             */
            $form['mo_saml_register'] = array(
                '#type' => 'fieldset',
                //'#title' => t('Register with miniOrange'),
                '#attributes' => array( 'style' => 'padding:2% 2% 5%; margin-bottom:2%' ),
            );

            $form['mo_saml_register']['markup_15'] = array(
                '#markup' => t('<div class="mo_saml_idp_font_for_heading">Register with mini<span class="mo_orange"><b>O</b></span>range (Optional)</div><p style="clear: both"></p><hr>'),
            );

            $form['mo_saml_register']['markup_msg_1'] = array(
                '#markup' => t('<br/>
                            <div class="mo_saml_highlight_background_note_export"><h3>Why should I register?</h3>You should register so that in case you need help, we can help you with step by step instructions.
                    <b>You will also need a miniOrange account to upgrade to the premium version of the module.</b>
                    We do not store any information except the email that you will use to register with us.</div>
                    ')
            );

            $form['mo_saml_register']['mo_register'] = array(
            '#markup' => t('<br><div class="mo_saml_highlight_background_note_export" style="width: auto">If you face any issues during registration then you can <a href="https://www.miniorange.com/businessfreetrial" target="_blank">click here</a> to register and use the same credentials below to login into the module.</div><br>'),
          );

            $form['mo_saml_register']['miniorange_saml_customer_register_username'] = array(
                '#type' => 'email',
                '#title' => t('Email<span style="color: red">*</span>'),
                '#description' => t('<b>Note:</b> Use valid EmailId. ( We discourage the use of disposable emails )'),
                '#attributes' => array('style' => 'width:50%'),
            );

            $form['mo_saml_register']['miniorange_saml_customer_register_phone'] = array(
                '#type' => 'textfield',
                '#title' => t('Phone'),
                '#description' => t('<b>Note:</b> We will only call if you need support.'),
                '#attributes' => array('style' => 'width:50%'),
            );

            $form['mo_saml_register']['miniorange_saml_customer_register_password'] = array(
                '#type' => 'password_confirm',
                '#attributes' => array('style' => 'width:50%'),
            );

            $form['mo_saml_register']['miniorange_saml_customer_register_button'] = array(
                '#type' => 'submit',
                '#button_type' => 'primary',
                '#value' => t('Register'),
                '#limit_validation_errors' => array(),
                '#prefix' => '<br><div class="ns_row"><div class="ns_name">',
                '#suffix' => '</div>'
            );

            $form['mo_saml_register']['already_account_link'] = array(
                '#markup' => t('<a href="'.$url.'/?tab=login" class="button">Already have an account?</a>'),
                '#prefix' => '<div class="ns_value">',
                '#suffix' => '</div></div>'
            );

        }else{

            /**
             * Create container to hold @Registration form elements.
             */
            $form['mo_saml_login'] = array(
                '#type' => 'fieldset',
                //'#title' => t('Register with miniOrange'),
                '#attributes' => array( 'style' => 'padding:2% 2% 20%; margin-bottom:2%' ),
            );

            $form['mo_saml_login']['markup_15'] = array(
                '#markup' => t('<div class="mo_saml_idp_font_for_heading">Login with mini<span class="mo_orange"><b>O</b></span>range</div><p style="clear: both"></p><hr>'),
            );

            $form['mo_saml_login']['markup_16'] = array(
                '#markup' => t('<br><div class="mo_saml_highlight_background_note" style="width:45% !important;">Please login with your miniorange account.</b></div><br>')
            );

            $form['mo_saml_login']['miniorange_saml_customer_login_username'] = array(
                '#type' => 'email',
                '#title' => t('Email <span style="color: red">*</span>'),
                '#attributes' => array('style' => 'width:50%'),
            );

            $form['mo_saml_login']['miniorange_saml_customer_login_password'] = array(
                '#type' => 'password',
                '#title' => t('Password <span style="color: red">*</span>'),
                '#attributes' => array('style' => 'width:50%'),
            );

            $form['mo_saml_login']['miniorange_saml_customer_login_button'] = array(
                '#type' => 'submit',
                '#value' => t('Login'),
                '#button_type' => 'primary',
                '#limit_validation_errors' => array(),
                '#prefix' => '<div class="ns_row"><div class="ns_name">',
                '#suffix' => '</div>'
            );

            $form['mo_saml_login']['register_link'] = array(
                '#markup' => t('<a href="'.$url.'" class="button">Create an account?</a>'),
                '#prefix' => '<div class="ns_value">',
                '#suffix' => '</div></div><br>'
            );
        }

        $form['div_for_end'] = array(
            '#markup' => '</div>'
        );

        Utilities::advertise2fa($form, $form_state);

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'register';
        $phone = '';
        if ($tab == 'register') {
            $username = trim($_POST['miniorange_saml_customer_register_username']);
            $phone    = trim($_POST['miniorange_saml_customer_register_phone']);
            $password = trim($_POST['miniorange_saml_customer_register_password']['pass1']);
        }else{
            $username = trim($_POST['miniorange_saml_customer_login_username']);
            $password = trim($_POST['miniorange_saml_customer_login_password']);
        }

        if (empty($username) || empty($password)) {
            \Drupal::messenger()->addMessage(t('The <b><u>Email Address</u></b> and <b><u>Password</u></b> fields are mandatory.'), 'error');
            return;
        }

        if ($tab == 'register')
            Utilities::customer_setup_submit($username, $phone, $password);
        else
            Utilities::customer_setup_submit($username, $phone, $password, true);

    }

    public function miniorange_saml_idp_back(&$form, $form_state)
    {
        Utilities::saml_back();
    }

    public function miniorange_saml_idp_resend_otp(&$form, $form_state)
    {
        Utilities::saml_resend_otp();
    }

    public function miniorange_saml_idp_validate_otp_submit(&$form, FormStateInterface $form_state)
    {
        $otp_token = trim($_POST['miniorange_saml_customer_otp_token']);
        if (empty($otp_token)) {
            \Drupal::messenger()->addMessage(t('OTP field is required.'), 'error');
            return;
        }
        Utilities::validate_otp_submit($otp_token);
    }
}
