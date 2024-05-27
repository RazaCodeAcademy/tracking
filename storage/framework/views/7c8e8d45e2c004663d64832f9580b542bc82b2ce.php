<!-- Bootstrap 4.6x -->
<!-- jQuery and Bootstrap Bundle (includes Popper)  -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!-- <script src="js/bootstrap-4.6x/bootstrap.bundle.min.js"></script> -->

<!-- Bootstrap 5.0 beta 2 -->
<!-- Bootstrap Bundle with Popper -->
<script src="<?php echo e(asset('public/js/bootstrap-5.0/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/toast/toastr.js')); ?>"></script>
<script src="<?php echo e(asset('public/toast/toastr.min.js')); ?>"></script>

<!-- Leaflet JavaScript -->
<script src="<?php echo e(asset('public/js/leaflet.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/leaflet.markercluster.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/leaflet.markercluster.layersupport.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/leaflet-routing-machine.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/leaflet-realtime.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/leaflet-moving-marker.js')); ?>"></script>

<!-- Custom JS -->
<script src="<?php echo e(asset('public/js/map-customizations.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/main.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/pagination-and-search.js')); ?>"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "escapeHtml": false,
        };

     </script>

<?php echo $__env->yieldContent('scripts'); ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/tracking/resources/views/layouts/scripts.blade.php ENDPATH**/ ?>