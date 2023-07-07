<?php
namespace Drupal\miniorange_saml_idp;
    class feedback{
	public static function miniorange_saml_idp_feedback()
	{
			global $base_url;
			$feedback_url = $base_url.'/feedback';
            $uninstall_url = $base_url . '/uninstall_module';
            $_SESSION['mo_other']= "True";
			$myArray = array();
			$myArray = $_POST;
			$form_id=$_POST['form_id'];
			$form_token=$_POST['form_token'];

?>
        <html>
        <head>
            <title>Feedback</title>
            <link href="https://fonts.googleapis.com/css?family=PT+Serif" rel="stylesheet">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
            <style>
                .idp_loader {
                    margin: auto;
                    display: block;
                    border: 5px solid #f3f3f3; /* Light grey */
                    border-top: 5px solid #3498db; /* Blue */
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    animation: spin 2s linear infinite;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#myModal").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    if(document.getElementById('miniorange_feedback_email').value == '') {
                        document.getElementById('email_error').style.display = "block";
                        document.getElementById('submit_button').disabled = true;
                    }
                });

                function validateEmail(emailField) {
                    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

                    if (reg.test(emailField.value) == false) {
                        document.getElementById('email_error').style.display = "block";
                        document.getElementById('submit_button').disabled = true;
                    } else {
                        document.getElementById('email_error').style.display = "none";
                        document.getElementById('submit_button').disabled = false;
                    }
                }

                $(function () {
                    $(".button").click(function (e) {
                      var get_value = $(this).attr('id');
                      if(get_value === 'submit_button')
                      {
                        document.getElementById('idp_loader').style.display = 'block';
                        var reason = $("input[name='deactivate_plugin']:checked").val();
                        var q_feedback = document.getElementById("query_feedback").value;
                        var email = "";
                        <?php if(empty(\Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email'))) { ?>
                        email = document.getElementById("miniorange_feedback_email").value;
                        <?php } else { ?>
                        email = "";
                        <?php } ?>
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $feedback_url; ?>',
                            data: {
                                reason: reason,
                                q_feedback: q_feedback,
                                email: email
                            },
                            success: function (result) {
                                document.getElementById('idp_loader').style.display = 'none';
                                window.location = '<?php echo $uninstall_url; ?>';
                            }
                        });
                      }
                      else {
                        window.location = '<?php echo $uninstall_url; ?>';
                      }
                        return false;
                    });
                })
            </script>
        </head>
        <body>
        <div class="container">
            <div class="modal fade" id="myModal" role="dialog" style="background: rgba(0,0,0,0.1);">
                <div class="modal-dialog" style="width: 500px;">
                    <div class="modal-content" style="border-radius: 20px">
                        <div class="modal-header"
                             style="padding: 25px; border-top-left-radius: 20px; border-top-right-radius: 20px; background-color: #8fc1e3;">
                            <h4 class="modal-title" style="color: white; text-align: center;">Hey, it seems like you want to deactivate miniOrange SAML IDP module</h4>
                            <hr>
                            <h4 style="text-align: center; color: white;">What happened?</h4>
                        </div>
                        <div class="modal-body"
                             style="font-size: 11px; padding-left: 25px; padding-right: 25px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; background-color: #ececec;">
                            <form name="f" id="mo_feedback">
                                <div>
                                    <p>
                                        <?php
                                        if (empty(\Drupal::config('miniorange_saml_idp.settings')->get('miniorange_saml_idp_customer_admin_email'))) { ?>
                                        <br>Email ID: <input onblur="validateEmail(this)" class="form-control"
                                                             type="email" id="miniorange_feedback_email"
                                                             name="miniorange_feedback_email"/>
                                    <p style="display: none;color:red" id="email_error">Invalid Email</p>
                                    <?php
                                    } ?>
                                    <br>
                                    <?php
                                    $deactivate_reasons = array(
                                        t("Not Working"),
                                        t("Not receiving OTP during registration"),
                                        t("Does not have the features I'm looking for"),
                                        t("Redirecting back to login page after Authentication"),
                                        t("Confusing interface"),
                                        t("Bugs in the module"),
                                        t("Other reasons: ")
                                    );
                                    foreach ($deactivate_reasons as $deactivate_reasons) {
                                        ?>
                                        <div class="radio" style="vertical-align: middle;">
                                            <label for="<?php echo $deactivate_reasons; ?>">
                                                <input type="radio" name="deactivate_plugin" id="deactivate_plugin"
                                                       value="<?php echo $deactivate_reasons; ?>" required>
                                                <?php echo $deactivate_reasons; ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" name="mo_saml_idp_check" value="True">
                                    <input type="hidden" name="form_token" value=<?php echo $form_token ?>>
                                    <input type="hidden" name="form_id" value= <?php echo $form_id ?>>
                                    <br>
                                    <textarea class="form-control" id="query_feedback" name="query_feedback" rows="4"
                                              cols="50" placeholder="Write your query here"></textarea>
                                    <br><br>
                                    <div class="mo2f_modal-footer">
                                    <input type="submit" id="submit_button" name="miniorange_feedback_submit"
                                               class="button btn btn-primary" value="Submit and Continue"
                                               style="margin: auto; display: block; font-size: 12px; float: left; padding: revert;"/>
                                      <input type="submit" id="skip_button"
                                             style="margin: auto; display: block; font-size: 12px; float: right; padding: revert;"
                                             name="miniorange_feedback_skip" class="button btn btn-primary" value="Skip" />
                                    </div>
                                    <div class="idp_loader" id="idp_loader" style="display: none;"></div>
                                    <?php
                                    foreach ($_POST as $key => $value) {
                                        self::hiddenSamlIdpFields($key, $value);
                                    }
                                    ?>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>

        </html>
			<?php
			exit;
	}


	static function hiddenSamlIdpFields($key,$value)
	{
		$hiddenSamlIdpField = "";
        $value2 = array();
        if(is_array($value)) {
            foreach($value as $key2 => $value2)
            {
                if(is_array($value2)){
                    $hiddenSamlIdpField($key."[".$key2."]",$value2);
                } else {
                    $hiddenSamlIdpField = "<input type='hidden' name='".$key."[".$key2."]"."' value='".$value2."'>";
                }
            }
        }else{
            $hiddenSamlIdpField = "<input type='hidden' name='".$key."' value='".$value."'>";
        }

		echo $hiddenSamlIdpField;
	}
}
