<?php
namespace Drupal\miniorange_saml_idp;
use Drupal\miniorange_saml_idp\Utilities;

class miniorange_saml_registration{

  public static function miniorange_saml_register_popup($payment_plan){
    $status = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_status');
    if ((isset($_POST['mo_otp_resend'])) && ($_POST['mo_otp_resend'] == "True")) {
      Utilities::saml_resend_otp(true);
    }
    elseif ((isset($_POST['mo_otp_check'])) && ($_POST['mo_otp_check'] == "True")) {
      $otp_token = trim($_POST['otp']);
      Utilities::validate_otp_submit($otp_token,true,$payment_plan);
    }
    elseif ((isset($_POST['mo_saml_check'])) && ($_POST['mo_saml_check'] == "True")) {
      $username = $_POST['Email'];
      $phone = '';
      $password = $_POST['password'];

      Utilities::customer_setup_submit($username, $phone, $password, false, true, $payment_plan);

    }
    elseif ($status == 'VALIDATE_OTP') {
      self::miniorange_otp(false,false,false);
    }
    else{
      self::register_data();
    }
  }

  public static function register_data($transaction_limit=false, $invalid_credential=false){
    global $base_url;

    $base_module_path = Utilities::moGetModulePath();
    $requestUrl = $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL;
    $myArray = array();
    $myArray = $_POST;
    $form_id = isset($_POST['form_id'])?$_POST['form_id']:'';
    $form_token = isset($_POST['form_token'])?$_POST['form_token']:'';
    $admin_email = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email');
    ?>

    <html>
    <head>
      <title>Register with miniOrange</title>
      <link href="https://fonts.googleapis.com/css?family=PT+Serif" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="<?php echo $base_url.'/'.$base_module_path . '/css/miniorange_saml_idp.admin.css'; ?>">

      <script type="text/javascript">
        $(document).ready(function () {
          $("#myModal").modal({
            backdrop: 'static',
            keyboard: false
          });
          $('.button').click(function() {
            document.getElementById('saml_loader').style.display = 'block';
          });
        });
        function check() {
          if (document.getElementById("password").value == document.getElementById("confirm_password").value) {
            if (document.getElementById("password").value.length < 6) {
              document.getElementById("saml_continue").disabled = true;
              document.getElementById("message").innerHTML = "<p style=color:green;>Password match: <b style=color:green;>Yes</b></p>";
              document.getElementById("password_error").innerHTML = "<p style=color:green;>Minimum Length: <b style=color:red;>6</b></p>";
            }else{
              document.getElementById("saml_continue").disabled = false;
              document.getElementById("message").innerHTML = "<p style=color:green;>Password match: <b style=color:green;>Yes</b></p>";
              document.getElementById("password_error").innerHTML = "<p></p>";
            }

          } else {
            if (document.getElementById("password").value.length < 6) {
              document.getElementById("password_error").innerHTML = "<p style=color:green;>Minimum Length: <b style=color:red;>6</b></p>";
            }else{
              document.getElementById("password_error").innerHTML = "<p></p>";
            }
            document.getElementById("saml_continue").disabled = true;
            document.getElementById("message").innerHTML = "<p style=color:green>Password match: <b style=color:red;>No</b></p>";
          }
          if (document.getElementById("Email").value.length == 0 || document.getElementById("password").value.length == 0 || document.getElementById("confirm_password").value.length == 0) {
            document.getElementById("saml_continue").disabled = true;
            document.getElementById("message").innerHTML = "<p></p>";
          }
        }
      </script>
    </head>
    <body>
    <div class="container">
      <div class="modal fade" id="myModal" role="dialog" style="background: rgba(0,0,0,0.1);">
        <div class="modal-dialog" style="width: 500px;">
          <div class="modal-content mo_popup" style="border-radius: 20px;">
            <?php if($transaction_limit == true){ ?>
              <p style="color: red;font-size: 11px;">An error has been occured. Please try after some time.</p>
            <?php }elseif($invalid_credential == true){ ?>
              <p style="color: red;font-size: 11px;text-align: center;">Invalid Credentials!</p>
            <?php }else { ?>
              <p style="color: green;font-size: 11.2px;text-align: center;">You need to register with mini<span style="color:orange;"><b>O</b></span>range in order to upgrade to the licensed versions of this module.</p>
            <?php } ?>
            <h2 class="mo_popup-header1">Register/Login with mini<span style="color:orange;"><b>O</b></span>range</h2>


            <form name="f" method="post" action="" id="mo_register">
              <div>
                <p class="mo_popup-para1">
                  <label for="Email" class="mo_floatLabel mo_popup-label">Email</label>
                  <input id="Email" name="Email" type="email" class="mo_popup-input">
                </p>
                <p class="mo_popup-para1">
                  <label for="password" class="mo_floatLabel mo_popup-label">Password</label>
                  <input id="password" name="password" type="password" class="mo_popup-input" oninput="check();"><br>
                  <span id="password_error" style="float:left;font-size:11px;"></span>
                </p>
                <p class="mo_popup-para1">
                  <label for="confirm_password" class="mo_floatLabel mo_popup-label">Confirm Password</label>
                  <input id="confirm_password" name="confirm_password" type="password" class="mo_popup-input" oninput="check();">
                  <span id="message" style="float:left;font-size:11px;"></span>
                </p>

                <br>
                <input type="hidden" name="mo_saml_check" value="True">
                <input type="hidden" name="form_token" value=<?php echo $form_token ?>>
                <input type="hidden" name="form_id" value= <?php echo $form_id ?>>

                <div class="modal-footer">
                  <a type="button" href=<?php echo $requestUrl ?> class="btn btn-default"  style="float:left;" >Close</a>
                  <input type="submit" class="btn btn-danger" id="saml_continue" disabled="disabled" value="Submit" onclick="" /><br>
                  <div class="mo_saml_loader" id="saml_loader" style="display: none;"></div>
                  <br>
                  <h6 style="text-align:center;">In case of any queries or issues, <br> please <a href="mailto:drupalsupport@xecurify.com"><strong>contact us</strong>.</a> </h6>
                </div>
                </p>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
    </body>
    </html>

    <?php
    exit;
  }

  public static function miniorange_otp($wrong_otp=false, $resend_otp=false, $resend_limit=false){

    global $base_url;

    $base_module_path = Utilities::moGetModulePath();
    $close_url = $base_url . '/close_registration';
    $myArray = array();
    $myArray = $_POST;
    $otp_form_id = isset($_POST['otp_form_id'])?$_POST['otp_form_id']:'';
    $otp_form_token = isset($_POST['otp_form_token'])?$_POST['otp_form_token']:'';
    $admin_email = \Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email');
    ?>

    <html>
    <head>
      <title>Validate OTP</title>
      <link href="https://fonts.googleapis.com/css?family=PT+Serif" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
      <link rel="stylesheet" content="<?php echo $base_module_path . '/css/miniorange_saml_idp.admin.css'; ?>">

      <script type="text/javascript">
        $(document).ready(function () {
          $("#myModal").modal({
            backdrop: 'static',
            keyboard: false
          });
          $('.button').click(function() {
            document.getElementById('saml_loader').style.display = 'block';
          });
          if (document.getElementById("otp").value.length != 0) {
            document.getElementById("validate").disabled = false;
          }else{
            document.getElementById("validate").disabled = true;
          }
        });
        function check_empty(){
          if (document.getElementById("otp").value.length == 0) {
            document.getElementById("validate").disabled = true;
          }else{
            document.getElementById("validate").disabled = false;
          }
        }

      </script>
    </head>
    <body>
    <div class="container">
      <div class="modal fade" id="myModal" role="dialog" style="background: rgba(0,0,0,0.1);">
        <div class="modal-dialog" style="width: 500px;">
          <div class="modal-content mo_popup" style="border-radius: 20px;padding:20px 0 0 20px;">
            <?php if ($resend_limit == true){ ?>
              <p class="mo_popup-header2" style="color: red;font-size: 11px;">An error occured while sending OTP. Please try after some time.</p>
            <?php }elseif ($resend_otp == true){ ?>
              <h4 class="mo_popup-header2"> An OTP has been resent to <?php echo $admin_email ?></h4>
            <?php }elseif ($resend_otp == false){ ?>
              <h4 class="mo_popup-header2"> Please enter the OTP sent to <?php echo $admin_email ?></h4>
            <?php } ?>

            <form name="ff" method="post" action="" id="mo_otp_verify">
              <div>
                <?php if ($wrong_otp == true) { ?>
                  <p class="mo_popup-para2">
                    <label for="otp" class="mo_floatLabel mo_popup-label">Enter OTP</label>
                    <input id="otp" name="otp" type="text" class="mo_popup-input" style="border: 1px solid red !important;" onkeyup="check_empty();">
                  <p style="color: red;font-size: 11px;">Invalid OTP</p>
                  </p>
                <?php } ?>
                <?php if ($wrong_otp == false) { ?>
                  <p class="mo_popup-para2">
                    <label for="otp" class="mo_floatLabel mo_popup-label">Enter OTP</label>
                    <input id="otp" name="otp" type="text" class="mo_popup-input" onkeyup="check_empty();">
                  </p>
                <?php } ?>

                <br>
                <input type="hidden" name="mo_otp_check" value="True">
                <input type="hidden" name="otp_form_token" value=<?php echo $otp_form_token ?>>
                <input type="hidden" name="otp_form_id" value= <?php echo $otp_form_id ?>>

                <div class="modal-footer">
                  <input type="submit" class="btn btn-danger" id="validate" value="Validate" style="float:left;" onclick="" />
                  <button class="btn btn-danger" id="resend" value="Resend" style="float:left;width:80px;margin-left: 24px;" onclick="submitResendForm();" >Resend</button>
                  <a type="button" href=<?php echo $close_url ?> class="btn btn-default" >Close</a>

                  <div class="mo_saml_loader" id="saml_loader" style="display: none;"></div>
                </div>
              </div>
            </form>
            <form name="f" method="post" action="" id="mo_otp_resend">
              <input type="hidden" name="mo_otp_resend" value="True">
              <input type="hidden" class="btn btn-danger" id="resend" value="Resend" style="float:left;margin-left: 24px;"  />
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
    <script>
      function submitResendForm(){document.getElementById("mo_otp_resend").submit();}

    </script>
    </body>
    </html>

    <?php
    exit;
  }

  public static function miniorange_redirect_successful($redirectUrl){
    global $base_url;
    $redirect = $base_url . MiniorangeSAMLIdpConstants::LICENSE_PAGE_URL;
    ?>
    <html>
    <head>
      <title> Redirecting to Xecurify</title>
    </head>
    <body>
    <script type="text/javascript">

      window.location="<?php echo $redirect; ?>";
      var new_window_reference = window.open("<?php echo $redirectUrl; ?>","_blank" );
      if (new_window_reference == null) {
        window.location = "<?php echo $redirectUrl; ?>";
      }
    </script>
    </body>
    </html>
    <?php

  }
}
