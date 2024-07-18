<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" lang="en">

<head prefix="og: http://ogp.me/ns#">
    <!-- Page Title Here -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="google-site-verification" content="q_k3UKhbYpU_dfyf4d8M1uus_FxSwWB78rxieg3eEyc" />
    <!-- Favicons Icon -->

    <link rel="icon" href="<?php echo base_url() ?>/favicon.ico" type="image/x-icon" />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title itemprop="name"><?php if (isset($title)) {
                                echo $title;
                            } ?></title>
    <meta itemprop="description" name="description" content="<?php if (isset($description)) {
                                                                    echo $description;
                                                                } ?>">
    <meta name="keywords" content="<?php if (isset($keyword)) {
                                        echo $keyword;
                                    } ?>">
    <link rel="canonical" href="<?php if (isset($url)) {
                                    echo $url;
                                } ?>" />
    <?php if (isset($amphtml)) { ?>
        <link rel="amphtml" href=" <?php echo $amphtml; ?>">
    <?php } ?>

    <?php
    if (isset($noindex)) {
        echo $noindex;
    } else { ?>
        <meta name="ROBOTS" content="INDEX,FOLLOW"><?php } ?>
    <meta property="og:title" content="<?php if (isset($title)) {
                                            echo $title;
                                        } ?>" />
    <meta property="og:description" content="<?php if (isset($description)) {
                                                    echo $description;
                                                } ?>" />
    <meta property="og:url" content="<?php if (isset($url)) {
                                            echo $url;
                                        } ?>" />
    <meta property="og:image" content="<?php if (isset($og_image)) {
                                            echo $og_image;
                                        } ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content='@ExcellAutovista' />

    <meta name='twitter:title' content="<?php if (isset($title)) {
                                            echo $title;
                                        } ?>" />
    <meta name='twitter:description' content="<?php if (isset($description)) {
                                                    echo $description;
                                                } ?>" />
    <meta name="twitter:image" content="<?php if (isset($og_image)) {
                                            echo $og_image;
                                        } ?>" />
    <meta name="p:domain_verify" content="6972b2533bbfec56ec6565e8a267018c" />


    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/combine.css" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.min.css" crossorigin="anonymous">


    <!-- Google Tag Manager -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XR06NMGBYZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-XR06NMGBYZ');
    </script>
    <!-- End Google Tag Manager -->

    <script>
        function gtag_report_conversion(url) {
            var callback = function() {
                if (typeof(url) != 'undefined') {
                    window.location = url;
                }
            };
            gtag('event', 'conversion', {
                'send_to': 'AW-901563551/56LJCJ-P9IEZEJ-J860D',
                'value': 100.0,
                'currency': 'INR',
                'event_callback': callback
            });
            return false;
        }
    </script>
    <?php
    header('Set-Cookie:SameSite=Strict; Secure');

    ?>
</head>


<body class="loading about cbp-spmenu-push">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3KGHP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <noscript id="deferred-styles">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/revolution/v5.4.3/css/settings.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/sweetalert.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/fontawesome/css/font-awesome.min.css" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/flaticon/css/flaticon.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/animate.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/scroll/scrollbar.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">

        <!-- carasole on the book your car page -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/templete.css">

        <link class="skin" rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/skin/skin-1.css">

        <!-- Google fonts -->
        <link href="<?php echo base_url(); ?>assets/css/font_goggleapis.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom.css?version=00001">
    </noscript>

    <script>
        var loadDeferredStyles = function() {
            var addStylesNode = document.getElementById("deferred-styles");
            var replacement = document.createElement("div");
            replacement.innerHTML = addStylesNode.textContent;
            document.body.appendChild(replacement)
            addStylesNode.parentElement.removeChild(addStylesNode);
        };
        var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
            window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
        if (raf) raf(function() {
            window.setTimeout(loadDeferredStyles, 0);
        });
        else window.addEventListener('load', loadDeferredStyles);
    </script>

    <?php if (empty($this->session->userdata('location_url'))) {
        $this->session->set_userdata('location_web', 'Mumbai');
        $this->session->set_userdata('location_url', 'mumbai');
    } ?>



    <style>
        .container-landing-page {
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .landingformdiv {
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            padding-bottom: 12px;
        }

        .form-header img {
            font-family: Arial, sans-serif;
            width: 100%;
            height: auto;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 9px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .btn-primary {
            border-radius: 5px;
        }
    </style>


    <div class="container-landing-page">
        <div class="landingformdiv mt-5">
            <div class="form-header">

                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="<?php echo base_url(); ?>assets/images/valentine_nexa.webp" alt="Valentine nexa">
                        </div>

                        <div class="item">
                            <img src="<?php echo base_url(); ?>assets/images/valentine_arena.webp" alt="valentine arena">
                        </div>

                        <div class="item">
                            <img src="<?php echo base_url(); ?>assets/images/book_car_nexa.jpeg" alt="maruti nexa">
                        </div>

                        <div class="item">
                            <img src="<?php echo base_url(); ?>assets/images/maruti_arena.jpg" alt="maruti arena">
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>


                <div style="text-align:center; margin-left:10%; margin-right:10%; padding-bottom:5%;">
                    <label><b>Now you can bring home your favourite <b style="color:red"> Maruti Suzuki </b>Car, Register your interest today!</b></label><br>
                </div>
            </div>

            <!-- Carosule script code -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


            <form id="carForm" onsubmit="return validate_form_banner()" action="<?php echo site_url() ?>book_your_car/landing_form" method="post">
                <div class="form-group">
                    <label for="customerName">Enter Name:</label>
                    <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Enter Your Name" required>
                </div>

                <div class="form-group">
                    <label for="customerMobile">Enter Mobile Number:</label>
                    <input type="tel" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" class="form-control" id="customerMobile" name="customerMobile" placeholder="Enter Your Mobile Number" required>
                </div>

                <div class="form-group">
                    <label class="m-b10" id="send_otp_div"> <a onclick="send_otp_user()">Get OTP</a>
                        <input type="hidden" id="main_otp" placeholder="Enter OTP" name="main_otp" class="form-control">
                    </label>
                    <input type="text" id="otp" placeholder="Enter OTP" name="otp" class="form-control">
                </div>

                <div class="form-group">
                    <label for="customerLocation">Select Location:</label>
                    <select class="form-control" id="customerLocation" name="customerLocation" required>
                        <option value="" disabled selected>Please Select Location</option>
                        <option value="Pune">Pune</option>
                        <option value="Mumbai">Mumbai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="carModel">Select Car Model:</label>
                    <select class="form-control" id="carModel" name="carModel" required>
                        <option value="">Please Select Car Model</option>
                        <?php
                        foreach ($query as $row) {
                        ?>
                            <option value="<?php echo $row->model_id; ?>"><?php echo $row->model_name; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Are you interested in exchange of your old car to purchase a new car?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="exchange_car" id="exchangeYes" value="Yes">
                        <label class="form-check-label" for="exchangeYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="exchange_car" id="exchangeNo" value="No" checked>
                        <label class="form-check-label" for="exchangeNo">No</label>
                    </div>
                </div>

                <input type="hidden" id="enq_from" name="enq_from" value="Google Adwords">
                <input type="hidden" id="path" name="path" value="Google Adwords">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="receiveUpdates" name="receiveUpdates">
                        <label class="form-check-label" for="receiveUpdates">
                            I'm ok with receiving updates from Excell Autovista on WhatsApp, SMS, and Email.
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>
                    <div id="captcha_error" class="text-danger col-md-12" style="padding: 10px;font-weight:600;font-size:14px"><?php echo $this->session->flashdata('flashError') ?></div>
                </div>

                <div class="form-group text-center">
                    <button onclick="validate_form_banner()" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Validation check -->


    <script>
        function validate_form_banner() {

            var name = document.getElementById('customerName').value;
            if (name === "") {
                sweetAlert("Please enter name");
                return false;
            }

            var phone = document.getElementById('customerMobile').value;
            if (phone === "") {
                sweetAlert("Please enter mobile number");
                return false;
            }

            var phone1 = document.forms["carForm"]["customerMobile"].value;
            var no = /^\d{10}$/;
            if (!no.test(phone1)) {
                sweetAlert("Mobile Number must be 10 Digit!");
                return false;
            }

            var otp = document.getElementById('otp').value;
            if (otp == '') {
                sweetAlert("Please Send OTP");
                return false;
            }

            var main_otp = document.getElementById('main_otp').value;
            if (otp != main_otp) {
                sweetAlert("Please Check OTP");
                return false;
            }

            var location = document.getElementById('customerLocation').value;
            if (location === "") {
                sweetAlert("Please select location");
                return false;
            }

            var carModel = document.getElementById('carModel').value;
            if (carModel === "") {
                sweetAlert("Please select Car Model");
                return false;
            }

            var recaptcha = $("#g-recaptcha-response").val();

            if (recaptcha === "") {
                document.getElementById('captcha_error').innerHTML = 'Please check the recaptcha';
                return false;
            }

        }


        function send_otp_user() {
            var customerMobile = document.getElementById('customerMobile').value;
            if (customerMobile == '') {
                sweetAlert("Please enter mobile number");
                return false;
            }
            $.ajax({
                url: "<?php echo site_url(); ?>book-your-car/send-otp",
                type: "POST",
                data: {
                    'customerMobile': customerMobile
                },
                success: function(result) {
                    $("#send_otp_div").html(result);
                }
            });
        }
    </script>

    <!-- End of the pop up form -->




    <!-- JavaScript  files ========================================= -->
    <script src="<?php echo base_url() ?>assets/js/combine.js"></script>
    <!--script  src="<?php echo base_url() ?>assets/js/rev.slider.js"  ></script-->
    <script src="<?php echo base_url() ?>assets/js/wow.js" defer crossorigin="anonymous"></script>
    <script src="<?php echo base_url() ?>assets/js/sweetalert.min.js" defer crossorigin="anonymous"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery-ui_1_11_2_min.js" defer crossorigin="anonymous"></script>

    <!-- wow.min js -->

    <!-- revolution JS FILES -->
    <script src="<?php echo base_url() ?>assets/plugins/revolution/v5.4.3/js/jquery.themepunch.tools.min.js" defer></script>
    <script src="<?php echo base_url() ?>assets/plugins/revolution/v5.4.3/js/jquery.themepunch.revolution.min.js" defer></script>
    <script src="<?php echo base_url() ?>assets/plugins/revolution/v5.4.3/js/extensions/revolution.extension.layeranimation.min.js" defer></script>
    <script src="<?php echo base_url() ?>assets/plugins/revolution/v5.4.3/js/extensions/revolution.extension.migration.min.js" defer></script>
    <script src="<?php echo base_url() ?>assets/plugins/revolution/v5.4.3/js/extensions/revolution.extension.parallax.min.js" defer></script>

    <script src="<?php echo base_url() ?>assets/plugins/revolution/v5.4.3/js/extensions/revolution.extension.slideanims.min.js" defer></script>
    <script src="<?php echo base_url() ?>assets/js/moblie_nav.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js" defer></script>
    <script src="<?php echo base_url() ?>assets/js/custom.js" defer></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- custom fuctions  -->



    <!--<script src="https://app.chat360.io/widget/chatbox/common_scripts/script.js"></script>-->

    <!-- <script>
        loadChat360Bot("22c5bc29-ab2b-45f2-9681-af5f90838013")
    </script> -->

</body>

</html>