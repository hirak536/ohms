<?php
session_start();
error_reporting(0);
include ("include/config.php");
if (isset ($_POST['submit'])) {
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

        header("location:reg-login.php");
    }
}
if (isset ($_POST['create'])) {
    $fname = $_POST['full_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    // $gender = $_POST['gender'];
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

<html>

<head>
    <link rel="stylesheet" href="style.css">
    <link
        href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="miscellaneous/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="miscellaneous/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="miscellaneous/themify-icons/themify-icons.min.css">
    <link href="miscellaneous/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="miscellaneous/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="miscellaneous/switchery/switchery.min.css" rel="stylesheet" media="screen">

    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="#">
                <div id="container">
                    <form id="createAccountForm">
                        <div id="section1">
                            <h2>Create Account</h2>
                            <p>
                                Enter your personal details below:
                            </p>
                            <div class="form-group">
                                <input type="text" class="form-control" name="full_name" placeholder="Full Name"
                                    required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email"
                                    onBlur="userAvailability()" placeholder="Email" required>
                            </div>
                            <br>
                            <button type="submit" id="next1" class="btn btn-primary">Next</button>
                        </div>
                        <div id="section2" style="display: none;">
                            <select name="gender" id="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <button type="button" id="previous2" class="btn btn-primary pull-left"
                                style="padding: 5px !important;">Previous</button>
                            <button type="submit" id="create" class="btn btn-primary pull-right">Next</button>
                        </div>
                        <div id="section3" style="display: none;">
                            <h2>Password</h2>
                            <div class="form-group">
                                <span class="input-icon">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required>
                                    <i class="fa fa-lock"></i> </span>
                            </div>
                            <div class="form-group">
                                <span class="input-icon">
                                    <input type="password" class="form-control" id="password_again"
                                        name="password_again" placeholder="Password Again" required>
                                    <i class="fa fa-lock"></i> </span>
                            </div>
                            <div class="form-group">
                                <div class="checkbox clip-check check-primary">
                                    <input type="checkbox" id="agree" value="agree" checked="true" readonly=" true">
                                    <label for="agree">
                                        I agree
                                    </label>
                                </div>
                            </div>
                            <button type="button" id="previous3" class="btn btn-primary pull-left">Previous</button>
                            <button type="submit" class="btn btn-primary pull-right" id="create" name="submit">
                                Submit <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form method="post">
                <h1>Sign in</h1>
                <div class="form-group">
                    <span class="input-icon">
                        <input type="text" class="form-control" name="username" placeholder="Email ID">
                        <i class="fa fa-user"></i> </span>
                </div>
                <div class="form-group form-actions">
                    <span class="input-icon">
                        <input type="password" class="form-control password" name="password" placeholder="Password">
                        <i class="fa fa-lock"></i><br>
                    </span><a href="forgot-password.php">
                        Forgot Password ?
                    </a>
                </div><br>
                <button type="submit" name="submit">
                    Login <i class="fa fa-arrow-circle-right"></i>
                </button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="miscellaneous/jquery/jquery.min.js"></script>
    <script src="miscellaneous/bootstrap/js/bootstrap.min.js"></script>
    <script src="miscellaneous/modernizr/modernizr.js"></script>
    <script src="miscellaneous/jquery-cookie/jquery.cookie.js"></script>
    <script src="miscellaneous/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="miscellaneous/switchery/switchery.min.js"></script>
    <script src="miscellaneous/jquery-validation/jquery.validate.min.js"></script>

    <script src="assets/js/main.js"></script>

    <script src="assets/js/login.js"></script>
    <script>
        jQuery(document).ready(function () {
            Main.init();
            Login.init();
        });
    </script>
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });

        document.getElementById('next1').addEventListener('click', function () {
            document.getElementById('section1').style.display = 'none';
            document.getElementById('section2').style.display = 'block';
        });

        document.getElementById('next2').addEventListener('click', function () {
            document.getElementById('section2').style.display = 'none';
            document.getElementById('section3').style.display = 'block';
        });

        document.getElementById('previous2').addEventListener('click', function () {

            document.getElementById('section2').style.display = 'none';
            document.getElementById('section1').style.display = 'block';
        });

        document.getElementById('previous3').addEventListener('click', function () {
            document.getElementById('section2').style.display = 'block';
            document.getElementById('section3').style.display = 'none';
        });
    </script>

</html>
</body>



</html>