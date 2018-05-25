<div class="modal fade" id="myModal88" tabindex="-1" role="dialog" aria-labelledby="myModal88"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Don't Wait, Login now!</h4>
            </div>
            <div class="modal-body modal-body-sub">
                <div class="row">
                    <div class="col-md-8 modal_body_left modal_body_left1"
                         style="border-right: 1px dotted #C2C2C2;padding-right:3em;">
                        <div class="sap_tabs">
                            <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
                                <ul>
                                    <li class="resp-tab-item" aria-controls="tab_item-0"><span>Sign in</span></li>
                                    <li class="resp-tab-item" aria-controls="tab_item-1"><span>Sign up</span></li>
                                </ul>
                                <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
                                    <div class="facts">
                                        <div class="register">
                                            <!--<form action="<?php echo site_url('login'); ?>" method="post"> -->
                                            <?php echo form_open('form/login', array('id'=>'form1')); ?>

                                            <input name="email_login" id="i_mail" placeholder="Email Address"
                                                   value="<?php echo set_value('email_login'); ?>" type="email"
                                                   required="">
                                            <input name="password" placeholder="Password" type="password"
                                                   required="">
                                            <div style="color: red; font-style: italic;">
                                                <p id="loginMessage">
                                                    <?php if (isset($login_errors)) {
                                                        echo $login_errors;
                                                    } ?>
                                                </p>
                                            </div>

                                            <div class="sign-up">
                                                <input type="submit" value="Sign in""/>
                                            </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-2 resp-tab-content" aria-labelledby="tab_item-1">
                                    <div class="facts">
                                        <div class="register">
                                            <?php echo form_open('form/registration', array('id'=>'form2')); ?>
                                            <input placeholder="Name" name="username"
                                                   value="<?php echo set_value('username'); ?>" type="text" required="">
                                            <input placeholder="Email Address" name="email"
                                                   value="<?php echo set_value('email'); ?>" type="email"
                                                   required="">
                                            <input placeholder="Password" name="password" type="password"
                                                   required="">
                                            <input placeholder="Confirm Password" name="passconf" type="password"
                                                   required="">
                                            <div style="color: red;">
                                                <p id="registrationMessage">
                                                    <?php if (isset($register_errors)) {
                                                        echo $register_errors;
                                                    } ?>
                                                </p>
                                            </div>
                                            <div class="sign-up">
                                                <input type="submit" value="Create Account"/>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script src="<?php echo base_url(); ?>/assets/js/easyResponsiveTabs.js"
                                type="text/javascript"></script>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#horizontalTab').easyResponsiveTabs({
                                    type: 'default', //Types: default, vertical, accordion
                                    width: 'auto', //auto or any width like 600px
                                    fit: true   // 100% fit in a container
                                });
                            });
                        </script>
                        <div id="OR" class="hidden-xs">OR</div>
                    </div>
                    <div class="col-md-4 modal_body_right modal_body_right1">
                        <div class="row text-center sign-with">
                            <div class="col-md-12">
                                <h3 class="other-nw">Sign in with</h3>
                            </div>
                            <div class="col-md-12">

                                <ul class="social">
                                    <li class="social_facebook"><a href="<?php echo base_url();?>index.php/facebook_login/fblogin" class="entypo-facebook"></a></li>
                                    <li class="social_dribbble"><a href="#" class="entypo-dribbble"></a></li>
                                    <li class="social_twitter"><a href="#" class="entypo-twitter"></a></li>
                                    <li class="social_behance"><a href="#" class="entypo-behance"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- header modal -->
<!-- header -->


<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>



    $('#form1').validate({

        //... your validation rules come here,
        rules: {
            login: {
                required:true,
                rangelength: [8,20]
            },
        },
        messages:{
            login:{
                required:"To pole jest wymagane!"
            }
        }



    });

    $('#form2').validate({

        //... your validation rules come here,
        rules: {
            username: {
                required:true,
                rangelength: [8,20]
            },

            password: {
                required: true,
                rangelength: [4,20]
            }
        },
        messages:{
            username:{
                required:"To pole jest wymagane!",
                rangelength:"Please enter your complete name!"
            }
        }



    });


    function loginMessage() {

       $.ajax({
            type: "POST",
            url: "form/ajaxLogin",
            data: null,
            dataType: 'JSON'
        })

            .done(function (reseponse) {
                //console.log(reseponse.html);

                if (reseponse.success) {
                    $('#loginMessage').html(reseponse.html);

                }

            });

    }

    function registrationMessage() {

        $.ajax({
            type: "POST",
            url: "form/ajaxRegistration",
            data: null,
            dataType: 'JSON'
        })
            .done(function (reseponse) {
                //console.log(reseponse.html);

                if (reseponse.success) {
                    $('#registrationMessage').text(reseponse.html);

                }
            });

    }


</script>