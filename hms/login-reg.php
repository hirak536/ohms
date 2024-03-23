<?php
session_start();
error_reporting(0);
include("include/config.php");
if (isset($_POST['submit'])) {
    $puname = $_POST['username'];
    $ppwd = md5($_POST['password']);
    $ret = mysqli_query($con, "SELECT * FROM users WHERE email='$puname' and password='$ppwd'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $pid = $num['id'];
        $host = $_SERVER['HTTP_HOST'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        // For stroing log if user login successfull
        $log = mysqli_query($con, "insert into userlog(uid,username,userip,status) values('$pid','$puname','$uip','$status')");
        header("location:dashboard.php");
    } else {
        // For stroing log if user login unsuccessfull
        $_SESSION['login'] = $_POST['username'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 0;
        mysqli_query($con, "insert into userlog(username,userip,status) values('$puname','$uip','$status')");
        $_SESSION['errmsg'] = "Invalid username or password";

        header("location:user-login.php");
    }
}
if (isset($_POST['submitr'])) {
    $fname = $_POST['full_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $query = mysqli_query($con, "insert into users(fullname,address,city,gender,email,password) values('$fname','$address','$city','$gender','$email','$password')");
    if ($query) {
        echo "<script>alert('Successfully Registered. You can login now');</script>";
        //header('location:user-login.php');
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>User-Login</title>

    <link
        href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">

    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

    <script type="text/javascript">
        function valid() {
            if (document.registration.password.value != document.registration.password_again.value) {
                alert("Password and Confirm Password Field do not match  !!");
                document.registration.password_again.focus();
                return false;
            }
            return true;
        }
    </script>

</head>
<br>
<br>
<div class="cont">
    <!----------------------------Login-Page------------------------------>
    <div class="form sign-in">
        <form class="form-login" method="post">
            <div class="form sign-in">
                <h2>Welcome</h2>
                <div>
                    <label>
                        <i class="fa fa-user "></i>
                        <div>
                            <input class="in_login" name="username" placeholder="Username">
                        </div>
                    </label>
                </div>
                <div>
                    <label>
                        <i class="fa fa-lock"></i>
                        <input type="password" class="in_login" name="password" placeholder="Password">

                    </label>
                </div>
                <div class="form-actions">
                    <button type="submit" class="submit" name="submit">
                        Login <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
                <p class="forgot-pass">
                    <a href="forgot-password.php">Forget Password
                    </a>
                </p>


            </div>
        </form>
    </div>
    <!-------------------------End-Login------------------------------------>
    <div class="sub-cont">
        <div class="img">
            <div class="img__text m--up">

                <h6>Don't have an account? Please Sign up!<h6>
            </div>
            <div class="img__text m--in">

                <h6>If you already has an account, just sign in.<h6>
            </div>
            <div class="img__btn">
                <span class="m--up">Sign Up</span>
                <span class="m--in">Sign In</span>
            </div>
        </div>
        <!--------Registration---------------------->
        <div>
            <form name="registration" id="registration" method="post" onSubmit="return valid();">
                <p style="font-weight: bold; font-size: 150%; text-align: center; color: black; padding-top: 5%;">
                    Enter your personal details below
                </p>
                <div>
                    <label>

                        <input name="full_name" class="in_sign mar" placeholder="Full Name" required>
                    </label>
                </div>
                <br>
                <div class="together">
                    <div class="co1">
                        <input name="address" class="in_sign mar" placeholder="Address" required>
                    </div>
                    <div class="co2">
                        <input name="city" class="in_sign" placeholder="City" required>
                    </div>
                </div>
                <p class="tit">
                    Enter your account details below
                </p>
                <br>
                <div class="em">
                    <input type="email" class="in_sign mar" name="email" id="email" onBlur="userAvailability()"
                        placeholder="Email" required>
                    <span id="user-availability-status1" class="center" style="font-size:12px;">
                    </span>
                </div>

                <div class="together">
                    <span>
                        <input class="in_sign pos" id="password" name="password" placeholder="Password" required>
                    </span>
                    <span class="co2">
                        <input class="in_sign pos1" id="password_again" name="password_again"
                            placeholder="Password Again" required>
                    </span>
                </div>
                <div>
                    <div class="checkbox clip-check check-primary">
                        <input type="checkbox" class="cb" id="agree" value="agree" checked="true" readonly=" true" Agree of all terms>
                    </div>
                    <label class="tc"> Agree to all Terms & Condition</label>

                </div>
                <br>
                <div>
                    <p class="cb">
                        Already have an account?
                        <a href="user-login.php">
                            Log-in
                        </a>
                    </p>
                    <button type="submit" class="btn btn-primary pull-right" id="submitr" name="submitr">
                        Submit <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>

            </form>

            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="vendor/modernizr/modernizr.js"></script>
            <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
            <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="vendor/switchery/switchery.min.js"></script>
            <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
            <script src="assets/js/main.js"></script>
            <script src="assets/js/login.js"></script>
            <script>
                jQuery(document).ready(function () {
                    Main.init();
                    Login.init();
                });
            </script>
            <script>
                function userAvailability() {
                    $("#loaderIcon").show();
                    jQuery.ajax({
                        url: "check-login-reg.php",
                        data: 'email=' + $("#email").val(),
                        type: "POST",
                        success: function (data) {
                            $("#user-availability-status1").html(data);
                            $("#loaderIcon").hide();
                        },
                        error: function () { }
                    });
                }
            </script>
        </div>
    </div>

</div>
























































































































<script>
    document.querySelector('.img__btn').addEventListener('click', function () {
        document.querySelector('.cont').classList.toggle('s--signup');
    });
</script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>

<script src="assets/js/main.js"></script>

<script src="assets/js/login.js"></script>
<script>
    jQuery(document).ready(function () {
        Main.init();
        Login.init();
    });
</script>