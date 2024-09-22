<!-- bottom bar -->
<section class="bottom-bar">
    <div class="bottom-bar__toggler">
        <i class="text-white fa fa-sort-desc"></i>
    </div>
    <div class="bottom-bar__content">
        <div class="p-0 container-fluid">
            <div class="d-flex">
                <div class="bottom-bar__white-space">
                    <div class="d-flex flex-column align-items-center justify-content-between h-100">
                        <img class="mt-auto mb-auto opacity-50" src="<?php echo e(asset('public/img/logo.jpeg')); ?>" width="200" alt="logo image" />
                        <p class="p-2 m-0 text-center text-white bg-primary-dark w-100">
                            Copyright © 2021 Resq 911 Communication
                        </p>
                    </div>
                </div>
                <div class="bottom-bar__tracking">
                    <ul class="nav nav-tabs" id="footer-tabs">
                        <li class="nav-item">
                            <a href="#overview" class="nav-link active">
                                Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#synopsis">
                                Synopsis
                        </a>
                        </li>
                        <li class="nav-item">
                            <a href="#vehicle-detail" class="nav-link" >
                                Vehicle-Detail
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact-person" class="nav-link">
                                Contact Person
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#services" class="nav-link" >
                                Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#finance" class="nav-link">
                                Finance
                            </a>
                        </li>
                    </ul>
                    <div class="bottom-bar__tracking">
                        <div class="tab-content" id="overview">
                            <div class="bottom-bar__tab">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-question fa-fw" aria-hidden="true"></i>
                                            <span>Protocol : </span>
                                            <span id="protocol"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-user fa-fw" aria-hidden="true"></i>
                                            <span>Username : </span>
                                            <span id="username"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>
                                            <span>Device : </span>
                                            <span id="device"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>
                                            <span>Sim No : </span>
                                            <span id="sim_no"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-key fa-fw" aria-hidden="true"></i>
                                            <span>Vehicle Status : </span>
                                            <span id="vehicle_status"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>
                                            <span>Vehicle Stop : </span>
                                            <span id="vehicle_stop"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-mobile fa-fw" aria-hidden="true"></i>
                                            <span>Vehicle Iddle : </span>
                                            <span id="vehicle_iddle"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-mobile fa-fw" aria-hidden="true"></i>
                                            <span>Odometer Type : </span>
                                            <span id="odometer_type"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-lock fa-fw" aria-hidden="true"></i>
                                            <span>Engine Hour : </span>
                                            <span id="engine_hour"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-key fa-fw" aria-hidden="true"></i>
                                            <span>Model : </span>
                                            <span id="model"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-book fa-fw" aria-hidden="true"></i>
                                            <span>Vin : </span>
                                            <span id="vin"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-mobile fa-fw" aria-hidden="true"></i>
                                            <span>Plate Number : </span>
                                            <span id="plate_no"></span>
                                        </div>
                                        
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="synopsis" >
                            <div class="bottom-bar__tab">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>
                                            <span>Server Date & Time : </span>
                                            <span id="server_date_time"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>
                                            <span>Tracker Date & Time : </span>
                                            <span id="tracker_date_time"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-tachometer fa-fw" aria-hidden="true"></i>
                                            <span>Average Speed : </span>
                                            <span id="average_speed"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-hourglass-half fa-fw" aria-hidden="true"></i>
                                            <span>Running Duration : </span>
                                            <span id="running_duration"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-stop-circle fa-fw" aria-hidden="true"></i>
                                            <span>Stop Duration : </span>
                                            <span id="stop_duration"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-mobile fa-fw" aria-hidden="true"></i>
                                            <span>Connection Status : </span>
                                            <span id="connect_status"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-address-card fa-fw" aria-hidden="true"></i>
                                            <span>Current Address : </span>
                                            <span id="current_address"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-tachometer fa-fw" aria-hidden="true"></i>
                                            <span>Maximum Speed : </span>
                                            <span id="maximum_speed"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-hourglass fa-fw" aria-hidden="true"></i>
                                            <span>Idle Duration : </span>
                                            <span id="idle_duration"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-times fa-fw" aria-hidden="true"></i>
                                            <span>NR Duration : </span>
                                            <span id="nr_duration"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-heart fa-fw" aria-hidden="true"></i>
                                            <span>Protocol : </span>
                                            <span id="sn_protocol"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-tachometer fa-fw" aria-hidden="true"></i>
                                            <span>Current Speed : </span>
                                            <span id="current_speed"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-tachometer fa-fw" aria-hidden="true"></i>
                                            <span>Heart Beat Time : </span>
                                            <span id="heart_beat_time"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
                                            <span>Distance Covered : </span>
                                            <span id="distance_speed"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-balance-scale fa-fw" aria-hidden="true"></i>
                                            <span>Odometer : </span>
                                            <span id="odometer"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-address-card fa-fw" aria-hidden="true"></i>
                                            <span>Driver : </span>
                                            <span id="driver"></span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-stethoscope fa-fw" aria-hidden="true"></i>
                                            <span>Status : </span>
                                            <span id="status"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="vehicle-detail">
                            <div class="bottom-bar__tab">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Vehicle Name</span>
                                            <input type="text" disabled />
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Color</span>
                                            <input type="text" disabled />
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Trailer</span>
                                            <input type="text" disabled />
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Remarks</span>
                                            <input type="text" disabled />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Engine Number</span>
                                            <input type="text" disabled />
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Cluster Name</span>
                                            <input type="text" disabled />
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Maker</span>
                                            <input type="text" disabled />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Chassis Number</span>
                                            <input type="text" disabled />
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Device Brand</span>
                                            <input type="text" disabled />
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Model</span>
                                            <input type="text" disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="contact-person">
                            <div class="bottom-bar__tab">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Primary User</span>
                                            <input type="text" disabled />
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Secondary User</span>
                                            <input type="text" disabled />
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                            <span>Emergency Contact</span>
                                            <input type="text" disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="services">
                            <div class="bottom-bar__tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                            <span>Ignition Alert</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-bell" aria-hidden="true"></i>
                                            <span>Geofences Alert</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="finance">
                            <div class="bottom-bar__tab">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            <span>Cash Flow</span>
                                        </div>
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-book" aria-hidden="true"></i>
                                            <span>Finance Instructions</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            <span>Last Payment Date</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="bottom-bar__widget">
                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                            <span>Payment Status</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\tracking\resources\views/layouts/footer.blade.php ENDPATH**/ ?>