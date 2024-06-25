<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(asset('public/img/logo.jpeg')); ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo e(asset('public/login/fonts/icomoon/style.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('public/login/css/owl.carousel.min.css')); ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public/login/css/bootstrap.min.css')); ?>">

    <!-- Style -->
    <link rel="stylesheet" href="<?php echo e(asset('public/login/css/style.css')); ?>">


    <title>Tracking | Login</title>
</head>

<body>


    <div class="d-lg-flex half">
        <div class="bg order-2 order-md-1" >
            <div id="carouselExampleIndicators" style="height: 100%" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" style="height: 100%">
                    <div class="carousel-item active" style="height: 100%">
                        <img class="d-block w-100" style="height: 100%" src="<?php echo e(asset('/public/img/login-back.gif')); ?>"
                            alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h1>This is my main heading for slider 1</h1>
                            <p>This is my pagaragraph for slider 1</p>
                        </div>
                    </div>
                    <div class="carousel-item" style="height: 100%">
                        <img class="d-block w-100" style="height: 100%" src="<?php echo e(asset('/public/img/login-back.gif')); ?>"
                            alt="Second slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h1>This is my main heading for slider 2</h1>
                            <p>This is my pagaragraph for slider 2</p>
                        </div>
                    </div>
                    <div class="carousel-item" style="height: 100%">
                        <img class="d-block w-100" style="height: 100%" src="<?php echo e(asset('/public/img/login-back.gif')); ?>"
                            alt="Third slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h1>This is my main heading for slider 3</h1>
                            <p>This is my pagaragraph for slider 3</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="contents order-1 order-md-2">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-11">
                        <div class="mb-5 d-flex justify-content-center align-items-center">
                            <img src="<?php echo e(asset('public/img/logo.jpeg')); ?>" width="150" alt="">
                        </div>
                        <h3>Login to <strong>Digitrack</strong></h3>
                        <!--<p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.-->
                        <!--</p>-->
                        <form action="<?php echo e(route('post.login')); ?>" method="post">
                            <div class="form-group first">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Your Username"
                                    id="username">
                            </div>
                            <div class="form-group last mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Your Password"
                                    id="password">
                            </div>

                            <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                                    <input type="checkbox" checked="checked" />
                                    <div class="control__indicator"></div>
                                </label>
                                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
                            </div>

                            <input type="submit" value="Log In" class="btn btn-block btn-primary">

                        </form>
                    </div>
                    <a href="https://track.digitrackgps.com/"
                        style="position: absolute; bottom: 10px; right: 10%;">www.track.digitrackgps.com/</a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('public/login/js/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/login/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/login/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/login/js/main.js')); ?>"></script>

    <script>
        const login = () => {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (!username || !password) {
                console.log("email password required");
            } else {
                $.ajax({
                    url: 'http://track.digitrackgps.com/func/fn_connect.php',
                    type: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        // 'Access-Control-Allow-Origin': 'http://localhost', // Add any other headers if needed
                    },
                    data: {
                        'cmd': 'login',
                        'mobile': false,
                        'password': password,
                        'remember_me': true,
                        'username': username
                    },
                    xhrFields: {
                        withCredentials: true // Include cookies in the request
                    },
                    success: (res, textStatus, jqXHR) => {
                        console.log(res);

                        // Access and store cookies
                        const cookies = document.cookie.split(';');
                        cookies.forEach(cookie => {
                            const [name, value] = cookie.trim().split('=');
                            localStorage.setItem(name, value);
                        });
                    }
                })
            }
        }
    </script>
</body>

</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/tracking/resources/views/pages/login.blade.php ENDPATH**/ ?>