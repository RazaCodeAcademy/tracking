<!-- Header -->
<header class="header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <a href="#">
                    <img class="header__logo" src="<?php echo e(asset('public/img/logo.jpeg')); ?>" alt="logo" width="50" />
                </a>
            </div>
            <div class="col">
                <div class="user-info">
                    
                    <div class="notification dropdown me-5">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell-o" aria-hidden="true"></i>
                            <span class="notification__counter">10</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="text-center">
                                <a class="dropdown-item" href="#">Notification with some text with another
                                    text</a>
                            </li>
                            <li class="text-center"><a class="dropdown-item" href="#">Notification</a></li>
                            <li class="text-center"><a class="dropdown-item" href="#">Notification</a></li>
                            <div class="mt-2 mb-2 text-center">
                                <a href="#" class="btn btn-sm btn-dark">See More</a>
                            </div>
                        </ul>
                    </div>
                    <div class="language dropdown me-5">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo e(asset('public/icons/english.png')); ?>" class="flag" alt="flag" /> English
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item" href="#"><img src="<?php echo e(asset('public/icons/english.png')); ?>"
                                        class="language__figure" alt="flag" />
                                    English</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><img src="<?php echo e(asset('public/icons/urdu.png')); ?>"
                                        class="language__figure" alt="flag" /> Urdu</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><img src="<?php echo e(asset('public/icons/arabic.png')); ?>"
                                        class="language__figure" alt="flag" />
                                    Arabic</a>
                            </li>
                        </ul>
                    </div>
                    <div class="user-dropdown dropdown me-5">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="user-dropdown__icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                            System
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item" href="#"><span class="user-dropdown__icon--sm me-1">
                                        <i class="fa fa-user fa-fw" aria-hidden="true"></i> </span>My Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <span class="user-dropdown__icon--sm me-1">
                                        <i class="fa fa-cog fa-fw" aria-hidden="true"></i>
                                    </span>
                                    Settings</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('login')); ?>">
                                    <span class="user-dropdown__icon--sm me-1">
                                        <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>
                                    </span>
                                    Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/tracking/resources/views/layouts/header.blade.php ENDPATH**/ ?>