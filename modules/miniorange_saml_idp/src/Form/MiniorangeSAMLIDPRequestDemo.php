<?php

namespace Drupal\miniorange_saml_idp\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\miniorange_saml_idp\MiniorangeSAMLIdpSupport;
use Drupal\miniorange_saml_idp\MiniorangeSAMLIdpConstants;

class MiniorangeSAMLIDPRequestDemo extends FormBase {

  public function getFormId() {
    return 'miniorange_saml_idp_request_demo';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#prefix'] = '<div id="miniorange_saml_idp_form">';
    $form['#suffix'] = '</div>';
    $form['status_messages'] = [
      '#type' => 'status_messages',
      '#weight' => -10,
    ];

    $user_email = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email');

    $form['miniorange_saml_idp_trial_email_address'] = array(
      '#type' => 'email',
      '#title' => t('Email'),
      '#required'=>TRUE,
      '#default_value' => $user_email,
      '#attributes' => array('placeholder' => t('Enter your email'), 'style' => 'width:99%;margin-bottom:1%;'),
    );

    $form['miniorange_saml_idp_number_of_users'] = array(
      '#type' => 'number',
      '#title' => $this->t('Number of users'),
      '#required'=>TRUE,
      '#default_value' => 100,
       '#min' => 25,
      '#description' => $this->t('The "Number of users" is the users who will be using the SSO service, not the number of users present on your Drupal site.')
    );

    $form['miniorange_saml_idp_service_provider_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Service Provider Name'),
      '#description' => $this->t('The application name where you want to login using SSO service.')
    );

    $form['miniorange_saml_idp_trial_description'] = array(
      '#type' => 'textarea',
      '#rows' => 4,
      '#title' => t('Description'),
      '#required'=>TRUE,
      '#attributes' => array('placeholder' => t('Describe your use case here!'), 'style' => 'width:99%;'),
      '#suffix' => '<br>',
    );

    $form['markup_trial_note'] = array(
      '#markup' => t('<div>If you are not sure with which plan you should go with, get in touch with us on <a href="mailto:'.MiniorangeSAMLIdpConstants::SUPPORT_EMAIL.'">'.MiniorangeSAMLIdpConstants::SUPPORT_EMAIL.'</a> and we will assist you with the suitable plan.</div>'),
    );

    $form['actions'] = array('#type' => 'actions');
    $form['actions']['send'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => [
        'class' => [
          'use-ajax',
          'button--primary'
        ],
      ],
      '#ajax' => [
        'callback' => [$this, 'submitModalFormAjax'],
        'event' => 'click',
      ],
    ];

    $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    return $form;
  }

  public function submitModalFormAjax(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $form_values = $form_state->getValues();
    // If there are any form errors, AJAX replace the form.
    if ( $form_state->hasAnyErrors() ) {
      $response->addCommand(new ReplaceCommand('#miniorange_saml_idp_form', $form));
    } else {
      $email = $form['miniorange_saml_idp_trial_email_address']['#value'];
      $query = $form['miniorange_saml_idp_trial_description']['#value'];

      $query_content = '<strong>Number of Users: </strong>' . $form_values['miniorange_saml_idp_number_of_users'];
      $query_content .= '<br><br><strong>Service Provider Name: </strong>' . $form_values['miniorange_saml_idp_service_provider_name'];

      $query .= "<br><br>Usecase Details:<br><pre style=\"border:1px solid #444;padding:10px;\"><code>" . $query_content . "</code></pre>";

      $query_type = 'Trial Request';

      $support = new MiniorangeSAMLIdpSupport($email, '', $query, $query_type);
      $support_response = $support->sendSupportQuery();

      \Drupal::messenger()->addStatus(t('Success! We will review and add the trial licence under your account. We will reach out to you over email. Reach out to us at drupalsupport@xecurify.com if you have any other queries.'));

        if( isset( $_SERVER['HTTP_REFERER'] ) && !empty( $_SERVER['HTTP_REFERER'] ) ) {
            global $base_url;
            $current_path = explode($base_url, $_SERVER['HTTP_REFERER']);
            $url_object = \Drupal::service('path.validator')->getUrlIfValid($current_path[1]);
            $route_name = $url_object->getRouteName();
            $response->addCommand(new RedirectCommand(Url::fromRoute($route_name)->toString()));
        }
        else{
            $response->addCommand(new RedirectCommand(Url::fromRoute('miniorange_saml_idp.sp_setup')->toString()));
        }
    }
    return $response;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
  }
}