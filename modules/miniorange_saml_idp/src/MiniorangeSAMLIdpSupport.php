<?php

namespace Drupal\miniorange_saml_idp;

/**
 * @file
 * Contains miniOrange Support class.
 */

class MiniorangeSAMLIdpSupport {
  public $email;
  public $phone;
  public $query;
  public $query_type;

  public function __construct( $email, $phone, $query, $query_type ) {
    $this->email = $email;
    $this->phone = $phone;
    $this->query = $query;
    $this->query_type = $query_type;
  }

  /**
   * Send support query.
   * Send request for demo
   */
	public function sendSupportQuery() {

		    $modulesInfo = \Drupal::service('extension.list.module')->getExtensionInfo('miniorange_saml_idp');
        $modulesVersion = $modulesInfo['version'];
        $php_version = phpversion();

        if( $this->query_type === 'Demo Request' ){
            $this->query = 'Demo request for ' . $this->phone . ' .<br> '. $this->query;
        }

        $this->query = '[Drupal ' . Utilities::mo_get_drupal_core_version() . ' SAML IDP ' . $this->query_type . ' | ' .$modulesVersion. ' | PHP: ' . $php_version .  '] ' . $this->query;

        $fields = array (
            'company' => $_SERVER['SERVER_NAME'],
            'email'   => $this->email,
            'phone'   => $this->query_type != 'Demo Request' ? $this->phone : '',
            'ccEmail' => 'drupalsupport@xecurify.com',
            'query'   => $this->query
        );

        $url = MiniorangeSAMLIdpConstants::BASE_URL . '/moas/rest/customer/contact-us';
        $customer = new MiniorangeSAMLCustomer(NULL,NULL,NULL,NULL);
        $response = $customer->callService($url,$fields);
        return $response=== 'Query submitted.';

  }
}
