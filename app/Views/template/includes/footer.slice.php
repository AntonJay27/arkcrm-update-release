

<!-- JS Libraries here! -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- ChartJS -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toaster -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/toastr/toastr.min.js"></script>
<!-- Loader -->
<script src="<?php echo base_url(); ?>/public/assets/lib/loader/waitMe.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/dist/js/adminlte.js"></script>

<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>

<script src="<?php echo base_url(); ?>/public/assets/js/helpers/common_helper.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/js/portal/global.js"></script>

<!-- ==========================================================================================> -->

<!-- Custom JS [JQuery Events] -->

<script type="text/javascript">
  let summernoteConfig = {
    toolbar: [
      // ['style', ['bold', 'italic', 'underline', 'clear']],
      // ['font', ['strikethrough', 'superscript', 'subscript']],
      // ['fontsize', ['fontname','fontsize']],
      // ['color', ['color']],
      // ['para', ['ul', 'ol', 'paragraph']],
      // ['height', ['height']],
      // ['insert', ['table','picture','link','video','hr']]
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      // ['insert', ['link', 'picture', 'video']],
    ],
    height: 300
  };

  let _waitMeLoaderConfig = {
    //none, rotateplane, stretch, orbit, roundBounce, win8,
    //win8_linear, ios, facebook, rotation, timer, pulse,
    //progressBar, bouncePulse or img
    effect:'roundBounce',
    //place text under the effect (string).
    text:'Processing, Please Wait...',
    //background for container (string).
    bg:'rgba(255,255,255,0.7)',
    //color for background animation and text (string).
    color:'#000',
    //max size
    // maxSize:'',
    //wait time im ms to close
    waitTime: 0,
    //url to image
    // source:'<?php echo base_url(); ?>/public/assets/img/upp-logo.png',
    //or 'horizontal'
    textPos:'vertical',
    //font size
    fontSize:'',
  };

  // HELPER.autoLogout();
</script>

@yield('custom_scripts')