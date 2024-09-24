<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public/css/style.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Etqan UAE</title>
</head>

<body>
    <div class="parent-container">
        <div class="form-setting">
            <div class="d-flex align-items-center jutify-content-center h-100">
                <form action="<?php echo e(route('post.login')); ?>" class="form w-100" method="post">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="public/img/Untitled (1080 x 900 px).png" alt="" style="width: 220px;">
                    </div>
                    
                    <div class="form-align">
                        <label for="">Username</label> <br>
                        <input class="spl" type="text" name="username" placeholder="Enter Your User"> <br>
                        <label for="">Password</label> <br>
                        <input class="spl" type="password" name="password" placeholder="Enter Your Password">
                        <br>
                        <input class="box-set" type="checkbox">
                        <span class="box-set">Remember me</span>
                        <span><a href="#">Frogot Password?</a></span> <br>
                        <button class="spl-btn">Sign in</button>
                        <hr>
                        
                        <div class="d-flex justify-content-between gap-1">
                            <img class="form-img" src="public/img/apple-store.png" alt="">
                            <img class="form-img" src="public/img/google-play.png" alt="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active img-spl">
                    <img src="public/img/p1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item img-spl">
                    <img src="public/img/p2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item img-spl">
                    <img class="" src="public/img/p3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>


        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\tracking\resources\views/pages/login.blade.php ENDPATH**/ ?>