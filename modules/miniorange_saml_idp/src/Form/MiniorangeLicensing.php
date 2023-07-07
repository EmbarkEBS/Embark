<?php
/**
 * @file
 * Contains Licensing information for miniOrange SAML Login Module.
 */

/**
 * Showing Licensing form info.
 */
namespace Drupal\miniorange_saml_idp\Form;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\miniorange_saml_idp\Utilities;

class MiniorangeLicensing extends FormBase {

  public function getFormId() {
    return 'miniorange_saml_licensing';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    global $base_url;

    $form['miniorange_saml_licensing_tab'] = array(
      '#attached' => array(
        'library' => array(
          'miniorange_saml_idp/miniorange_saml_idp.register',
        )
      ),
    );

    $form['markup_library'] = array(
      '#attached' => array(
        'library' => array(
          'miniorange_saml_idp/miniorange_saml_idp.admin',
          'miniorange_saml_idp/miniorange_saml_idp.main'
        )
      ),
    );

    $form['markup_1'] = array(
      '#markup' =>'<div class="mo_saml_table_layout_1"><div class="mo_saml_table_layout"><br><h3>&emsp;'.t('UPGRADE PLANS').'  </h3><hr>'
    );

    $form['markup_free'] = array(
      '#markup' => t('<html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- Main Style -->
        </head>
        <body>
<!--Heading-->
    <br><h2 id="pricing-header">Drupal SAML IdP</h2>
<!--Heading End -->

<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 2%;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active ps-5 pe-5">
        <a class="mo-nav-link" href="#plans"><b>Plans</b><span class="sr-only"></span></a>
      </li>
      <li class="nav-item ps-5 pe-5">
        <a class="mo-nav-link" href="#feature_comparison"><b>Feature Comparison</b></a>
      </li>
      <li class="nav-item ps-5 pe-5">
        <a class="mo-nav-link" href="#steps_upgrade_premium"><b>Upgrade Steps</b></a>
      </li>
      <li class="nav-item ps-5 pe-5">
        <a class="mo-nav-link" href="#faq"><b>FAQs</b></a>
      </li>
      <li class="nav-item ps-5 pe-5">
        <a class="mo-nav-link" href="#payment_method"><b>Payment Methods</b></a>
      </li>
      <li class="nav-item ps-5 pe-5">
        <a class="mo-nav-link" href="#refund_policy"><b>Refund Policy</b></a>
      </li>
    </ul>
  </div>
</nav>
<!--End Navbar-->

<!-- Contact Us -->
<div id="contact">
<br>
<h2>Choose Your Licensing Plan</h2>
<h4>Are you not able to choose your plan?
<a href="mailto:drupalsupport@xecurify.com">Contact Us</a></h4>
    <h2>If you want to test any of our paid modules, please contact us at <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a></h2>
</div>
<!-- End of Contact US-->

<!-- Plans Cards -->

<div class="container mo-container plan_cards_main " id="plans">
    <div class="row">
        <div class="col-md-3 plan_cards_inner_divs" id="plan_card_divone">
        <div class="card">
            <h5 class="card-header pricing-card-head mt-0 mb-0">PREMIUM PLAN</h5>
            <div class="card-body mo-card-body">
            <h5 class="card-title"></h5>
            <p class="card-text card_module_description">(Users stored in your own Drupal database)</p>
            <p class="card-text sup_price" id="premium_price" style="color:#AB0000;">$ 450/year</p>
            <p id="premium_discount"></p>
                <span class="instance_dropdown">
                <label for="instances_premium">User Slab:</label>&nbsp;&nbsp;
                <select id="instances_premium" name="instances" onchange="Instance_Pricing(this.value)">
                    <option value="1">1-100</option>
                    <option value="2">101-200</option>
                    <option value="3">201-300</option>
                    <option value="4">301-400</option>
                    <option value="5">401-500</option>
                    <option value="6">501-1000</option>
                    <option value="7">1001-2000</option>
                    <option value="8">2001-3000</option>
                    <option value="9">3001-4000</option>
                    <option value="10">4001-5000</option>
                    <option value="11">5000+</option>
                </select>
                </span>
            </div>
            <a href="https://login.xecurify.com/moas/login?redirectUrl=https://login.xecurify.com/moas/initializepayment&requestOrigin=drupal_saml_idp_premium_plan_v8" target="_blank"><p class="card-footer mo-card-footer mb-0 mt-0 pt-3 pb-3">UPGRADE NOW</p></a>
        </div>
        </div>

    <div class="col-md-3  plan_cards_inner_divs" id="plan_card_divtwo">
        <div class="card">
            <h5 class="card-header pricing-card-head mt-0 mb-0">ALL-INCLUSIVE PLAN</h5>
            <div class="card-body  mo-card-body">
            <h5 class="card-title"></h5>
            <p class="card-text card_module_description">(Users hosted in miniOrange or Enterprise Directory)</p>
            <p  class="card-text sup_price" id="AllInclusive_price" style="font-size:1.5em; color:#AB0000;"><a href="https://www.miniorange.com/contact"><b>Request a Quote</b></a></p>
             <p id="AllInclusive_discount"></p>
                <p><b>Starts from $0.5/user/month</b></p>
            </div>
            <a href="https://www.miniorange.com/contact" target="_blank"><p class="card-footer mo-card-footer mb-0 mt-0 pt-3 pb-3">UPGRADE NOW</p></a>
        </div>
    </div>
</div>
</div>
<!-- Plan Cards End-->

<!--Features Comparison-->
 <div class="container" id="feature_comparison">
<h3 class="feature_comparison">FEATURES</h3><hr style="background-color:#E97D68;">
<table>
  <tr id="feature_head">
    <th>Features List</th>
    <th>Premium</th>
    <th>All-Inclusive</th>
  </tr>
  <tr>
    <td><b>User Storage Location</b></td>
    <td>Keep Users in Drupal Database</td>
    <td>Keep Users in miniOrange Database or Enterprise Directory<br> like Azure AD, Active Directory, LDAP, Office 365, Google Apps<br> or any 3rd party providers using SAML, OAuth, Database, APIs etc.</td>
  </tr>
  <tr>
    <td><b>Password Management</b></td>
    <td>Password will be stored in your Drupal Database</td>
    <td>Password can be manage by miniOrange or by the 3rd party Identity Provider</td>
  </tr>
  <tr>
    <td><b>SSO Protocol Support</b></td>
    <td>Single-Protocol SSO Support<br>SAML</td>
    <td>CrossProtocol SSO Supports <br>SAML<br>OAuth<br>OpenId Connect<br>JWT</td>
  </tr>
    <tr>
    <td><b>User Registration</b></td>
    <td>Use your own existing Drupal Sign-up Form</td>
    <td>Sign-up via miniOrange Login Page</td>
  </tr>
    <tr>
    <td><b>Login Page</b></td>
    <td>Use your own existing Drupal Login Page</td>
    <td>Fully customizable miniOrange Login Page</td>
  </tr>
  <tr>
    <td><b>Custom Domains</b></td>
    <td>Use your own Drupal Domain</td>
    <td>Fully custom Domain Provided</td>
  </tr>
  <tr>
    <td><b>Social Providers</b></td>
    <td>Not Included</td>
    <td>Included<br>(Facebook, Twitter, Google+, etc)</td>
  </tr>
  <tr>
    <td><b>Multi-Factor Authentication</b></td>
    <td><a href="https://plugins.miniorange.com/drupal-two-factor-authentication-2fa#pricing" target="_blank">Click here</a> to purchase Multi-Factor module separately</td>
    <td>Included</td>
  </tr>
  <tr>
    <td><b>User Provisioning</b></td>
    <td><a href="https://plugins.miniorange.com/drupal-scim-user-provisioning" target="_blank">Click here</a> to purchase user provisioning module separately</td>
    <td>Included</td>
  </tr>
</table>
</div>
<!-- Feature Comparison End -->

<!--How to upgrade to premium-->
<div class="container steps_upgrade_premium" id="steps_upgrade_premium">
<h3 style="text-align: center; margin-top:3%;">HOW TO UPGRADE TO PAID VERSION MODULE</h3><hr>
<div class="row">
  <div class="col-md-6">
  <div class="upgrade_step"><div class="upgrade_steps_wise">1</div> Click on <a href="#plans">Upgrade Now</a> button for required premium plan and you will be redirected to miniOrange login console.</div>
  <div class="upgrade_step"><div class="upgrade_steps_wise">2</div> Enter your username and password with which you have created an account with us. After that you will be redirected to payment page.</div>
  <div class="upgrade_step"><div class="upgrade_steps_wise">3</div> Enter your card details and proceed for payment. On successful payment completion, the premium module(s) will be available to download.</div>
  <div class="upgrade_step"><div class="upgrade_steps_wise">4</div> Download the premium module(s) from Module Releases and Downloads section.</div>
  </div>
  <div class="col-md-6">
  <div class="upgrade_step"><div class="upgrade_steps_wise">5</div> From the Drupal module directory, delete the free module currently installed.</div>
  <div class="upgrade_step"><div class="upgrade_steps_wise">6</div> Unzip the downloaded premium module and extract the files.</div>
  <div class="upgrade_step"><div class="upgrade_steps_wise">7</div> Add the unzipped module to Drupal Site. Clear Drupal Cache from <a href="'.$base_url.'/admin/config/development/performance" target="_blank">here.</a></div>

  <div class="upgrade_step"><div class="upgrade_steps_wise">8</div> After activating the premium module, login using the account you have registered with us. After login, enter the license key to activate the module. You can find the license keys <a href="https://login.xecurify.com/moas/login?redirectUrl=https://login.xecurify.com/moas/admin/customer/viewlicensekeys" target="_blank">here</a>.</div>
  </div>
</div>
</div><br><br>
<!-- End of Upgrade -->

<!--FAQ-->
<div class="container" id="faq">
<h3 style="text-align: center; margin:3%;">FAQs</h3><br><hr>
   <div class="row">
        <div class="col-md-6">
           <div id="accordion">
            <div class="card">
                <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                <div class="card-header">
                   Does miniorange provide developer license for paid module?
                </div>
                </a>
            </div>
            <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
                <div class="card-body">
                  We do not provide the developer license for our paid module and the source code is protected. It is strictly prohibited to make any changes in the code without having written permission from miniOrange. There are hooks provided in the module which can be used by the developers to extend the module\'s functionality.
                </div>
            </div>
           </div>
        </div>
        <div class="col-md-6">
           <div id="accordion">
            <div class="card">
                <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
                <div class="card-header">
                 What is the refund policy?
                </div>
                </a>
            </div>
            <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                <div class="card-body">
                 At miniOrange, we want to ensure you are 100% happy with your purchase. If the premium plugin you purchased is not working as advertised and you\'ve attempted to resolve any issues with our support team, which couldn\'t get resolved. We will refund the whole amount within 10 days of the purchase. Please email us at drupalsupport@xecurify.com for any queries regarding the return policy or contact us here.
                 The plugin licenses are perpetual and the Support Plan includes 12 months of maintenance (support and version updates). You can renew maintenance after 12 months at 50% of the current license cost.
                </div>
            </div>
            </div>
        </div>
   </div>
   <div class="row">
        <div class="col-md-6">
         <div id="accordion">
            <div class="card">
                <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseThree">
                <div class="card-header">
                        Does miniOrange offer technical support?
                </div>
                </a>
                <div id="collapseThree" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                    Yes, we provide 24*7 support for all and any issues you might face while using the plugin, which includes technical support from our developers. You can get prioritized support based on the Support Plan you have opted. You can check out the different Support Plans from here.
                    </div>
                </div>
            </div>
         </div>
        </div>
        <div class="col-md-6">
          <div id="accordion">
            <div class="card">
                <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseFour">
                <div class="card-header">
                  Does miniOrange store any user data?
                </div>
                </a>
            </div>
            <div id="collapseFour" class="collapse" data-bs-parent="#accordion">
                <div class="card-body">
                 MiniOrange does not store or transfer any data which is coming from the SAML IDP provider to the Drupal. All the data remains within your premises / server. We do not provide the developer license for our paid plugins and the source code is protected. It is strictly prohibited to make any changes in the code without having written permission from miniOrange. There are hooks provided in the plugin which can be used by the developers to extend the plugin\'s functionality.
                </div>
            </div>
          </div>
        </div>
   </div>

    <a href="https://faq.miniorange.com/kb/drupal/saml-drupal/" class="btn " role="button" target="_blank" id="mo_faq_button" >More  FAQs</a>
</div>

<!-- FAQ End-->

<!--Supported Payment methods-->
<div class="container payment_method_main_divs" id="payment_method">
    <h3 style="text-align: center; margin:3%;">PAYMENT METHODS</h3><hr><br><br>
    <div class="row">
    <div class="col-md-3 payment_method_inner_divs">
        <div><img src="'.$base_url . '/' . Utilities::moGetModulePath() . '/includes/images/card_payment.png" width="120" ><h4></h4></div><hr>
        <p>If the payment is made through Credit Card/International Debit Card, the license will be created automatically once the payment is completed.</p>
    </div>
    <div class="col-md-3 payment_method_inner_divs">
        <div><img src="'.$base_url . '/' . Utilities::moGetModulePath() . '/includes/images/bank_transfer.png" width="150" ><h4><h4></div><hr>
        <p>If you want to use bank transfer for the payment then contact us at <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a> so that we can provide you the bank details.</p>
    </div>
    <div class="col-md-3 payment_method_inner_divs">
        <div><img src="'.$base_url . '/' . Utilities::moGetModulePath() . '/includes/images/Paypal.png" width="120"><h4></h4></ iv><hr>
        <p>Please contact us <a href="https://www.miniorange.com/contact" target="_blank">here</a> or drop an email at <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a> for more information.</p>
    </div>
    </div>
</div>
</div>

<!-- End of supported payment methods-->

<!-- REFUND POLICY-->

<div class="container mo-container return_policy" id="refund_policy">
   <h3 style="text-align: center; margin:3%;">REFUND POLICY</h3><hr><br><br>
   <p>If the paid version module you purchased is not working as advertised and you’ve attempted to resolve any feature issues with our support team, which couldn\'t get resolved, we will refund the whole amount within 10 days of the purchase.</p>
   <p>Note that this policy does not cover the following cases:<br>

      1. Change of mind or change in requirements after purchase.<br>
      2. Infrastructure issues not allowing the functionality to work.<br><br>

      Please email us at <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a> for any queries regarding the refund policy.

       At miniOrange, we want to ensure that you are 100% happy with your purchase. If the module you purchased is not working as advertised and you have attempted to resolve any issues with our support team, which could not get resolved, we will refund the whole amount given that you raised a request for refund within the first 10 days of the purchase. Please email us at <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a> for any queries regarding the return policy.
   </p>
</div>

<!-- End 10 Days Return Policy -->
    </body>
    </html>'),
    );

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

  }
  function miniorange_saml_premium_button(){
    $admin_email = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email');
    $admin_email = (isset($admin_email) && !empty($admin_email)) ? $admin_email : 'none';
    $Premium_URL_Redirect = 'https://login.xecurify.com/moas/login?username='.$admin_email.'&redirectUrl=https://login.xecurify.com/moas/initializepayment&requestOrigin=drupal_saml_idp_premium_plan_v8';
    \Drupal::configFactory()->getEditable('miniorange_saml_idp.settings')->set('redirect_plan_after_registration_premium',$Premium_URL_Redirect)->save();
    return $this->return_url($Premium_URL_Redirect, 'premium');
  }

  function return_url($url, $payment_plan){
    if(Utilities::isCustomerRegistered()){
      return $url;
    }else{
      global $base_url;
      $SAMLrequestUrl = $base_url . '/register_user/?payment_plan=' . $payment_plan;
      return $SAMLrequestUrl;
    }
  }
}
