<!DOCTYPE html>
<html lang="en">
<head>
    <title> Magazin online </title>
    <meta name="google-signin-client_id"
          content="920755770625-a8su6d2l3kpfrap3cjed3ctkf0kq6ffk.apps.googleusercontent.com">
    <!--    pentru google login-->


    <!-- for-mobile-apps -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="Electronic Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
	SmartPhone Compatible web template, free web designs for Nokia, Samsung, LG, SonyEricsson, Motorola web design"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <!-- //for-mobile-apps -->
    <!-- Custom Theme files -->
    <link href="<?php echo base_url() . '/assets/css/bootstrap.css'; ?> " rel="stylesheet" type="text/css" media="all"/>
    <link href="<?php echo base_url() . '/assets/css/style.css'; ?>" rel="stylesheet" type="text/css" media="all"/>
    <link href="<?php echo base_url() . '/assets/css/user.css'; ?>" rel="stylesheet" type="text/css" media="all"/>
    <link href="<?php echo base_url() . '/assets/css/fasthover.css'; ?>" rel="stylesheet" type="text/css" media="all"/>
    <link href="<?php echo base_url() . '/assets/css/popuo-box.css'; ?>" rel="stylesheet" type="text/css" media="all"/>
    <!-- //Custom Theme files -->
    <!-- font-awesome icons -->
    <link href="<?php echo base_url() . '/assets/css/font-awesome.css'; ?>" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!-- js -->
    <script src="<?php echo base_url() . '/assets/js/jquery.min.js'; ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url() . '/assets/css/jquery.countdown.css'; ?>"/> <!-- countdown -->
    <!-- //js -->
    <!-- web fonts -->
    <link href='//fonts.googleapis.com/css?family=Glegoo:400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic'
          rel='stylesheet' type='text/css'>
    <!-- //web fonts -->
    <!-- for bootstrap working -->
    <script type="text/javascript" src="<?php echo base_url() . '/assets/js/bootstrap-3.1.1.min.js'; ?>"></script>
    <!-- //for bootstrap working -->
    <!-- start-smooth-scrolling -->
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
            });
        });
    </script>
    <!-- //end-smooth-scrolling -->

<!--    <script src='https://www.google.com/recaptcha/api.js'></script>-->
    <!--    for reCAPTCHA checkbox-->

</head>

<body>

<!-- header modal -->
<div class="header" id="home1">
    <div class="container">
        <div class="w3l_login">
            <a href="#" data-toggle="modal" data-target="#myModal88">
                <span class="glyphicon glyphicon-user" aria-hidden="true">

                </span>
            </a>
        </div>
        <div class="w3l_login" style=" margin-top: 10px; margin-left: 5px;">
            <?php
            if ($this->session->userdata('validated')) {
                echo 'Hi, '.$this->session->userdata('name').' </br>My account.';
            }
            ?>
        </div>
        <div class="w3l_logo">
            <h1><a href="index.html">Web magazin<span> Dorian </span></a></h1>
        </div>
        <div class="search">
            <input class="search_box" type="checkbox" id="search_box">
            <label class="icon-search" for="search_box"><span class="glyphicon glyphicon-search"
                                                              aria-hidden="true"></span></label>
            <div class="search_form">
                <form action="#" method="post">
                    <input type="text" name="Search" placeholder="Search...">
                    <input type="submit" value="Send">
                </form>
            </div>
        </div>
        <div class="cart cart box_1">
            <form action="#" method="post" class="last">
                <input type="hidden" name="cmd" value="_cart"/>
                <input type="hidden" name="display" value="1"/>
                <button class="w3view-cart" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down"
                                                                                    aria-hidden="true"></i></button>
            </form>
        </div>
    </div>
</div>
<!-- //header -->