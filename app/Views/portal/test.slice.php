@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">

<!-- BS-STEPPER -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bs-stepper/css/bs-stepper.min.css">

<!-- BS-DUALLISTBOX -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

<style type="text/css">
  /*INTERNAL STYLES*/
  .tbl tr td{
    border : none !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow b
  {
    margin-top: 2px !important;
  }

  .select2-container .select2-selection--single .select2-selection__rendered
  {
    padding-left: 0px !important;
  }

  .select2-container--default .select2-selection--single
  {
    border: 1px solid #ced4da;
  }
  
</style>

@endsection



@section('page_content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header pt-2 pb-2">

  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fa fa-upload"></i> Batch Import Contact
              </h3>
            </div>
            <div class="card-body p-0">
              
            </div>
          </div>

        </div>
      </div>

      <div class="modal fade" id="modal_importOrganizations" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header--sticky">
              <h5 class="modal-title"><i class="fa fa-plus mr-1"></i> Import Organizations</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="bs-stepper linear">
                <div class="bs-stepper-header" role="tablist">
                  <div class="step active" data-target="#step-one">
                    <button type="button" class="step-trigger" role="tab" aria-controls="step-one" id="step-one-trigger" aria-selected="true">
                      <span class="bs-stepper-circle">1</span>
                      <span class="bs-stepper-label">Upload CSV File</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#step-two">
                    <button type="button" class="step-trigger" role="tab" aria-controls="step-two" id="step-two-trigger" aria-selected="false" disabled>
                      <span class="bs-stepper-circle">2</span>
                      <span class="bs-stepper-label">Duplicate Handling</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#step-three-2">
                    <button type="button" class="step-trigger" role="tab" aria-controls="step-three" id="step-three-trigger" aria-selected="false" disabled>
                      <span class="bs-stepper-circle">3</span>
                      <span class="bs-stepper-label">Field Mapping</span>
                    </button>
                  </div>
                </div>
                <div class="bs-stepper-content">

                  <div id="step-one" class="content active dstepper-block" role="tabpanel" aria-labelledby="step-one-trigger">
                    <div class="container-fluid mt-5">
                      <h6>Import from CSV file</h6>
                      <hr>
                      <div class="row">
                        <div class="col-lg-3" style="margin: auto;">
                          <label class="text-muted">Select CSV File Only</label>
                        </div>
                        <div class="col-lg-9">
                          <input type="file" class="form-control" id="file_contactList" name="file_contactList" style="padding: 3px 3px 3px 3px !important;" accept=".csv" required>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-lg-3" style="margin: auto;">
                          <label class="text-muted">Has Header</label>
                        </div>
                        <div class="col-lg-9">
                          <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="exampleCheck2" checked>
                          <label class="form-check-label" for="exampleCheck2"></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="step-two" class="content" role="tabpanel" aria-labelledby="step-two-trigger">
                    <div class="container-fluid mt-5">
                      <h6>Duplicate record handling</h6>
                      <hr>
                      <label class="text-muted">Select how duplicate records should be handled</label>
                      <select class="form-control form-select">
                        <option value="Skip">Skip</option>
                        <option value="Override">Override</option>
                        <option value="Merge">Merge</option>
                      </select>
                      <div class="form-group">
                      <label>Multiple</label>
                      <div class="bootstrap-duallistbox-container row moveonselect moveondoubleclick"> <div class="box1 col-md-6">   <label for="bootstrap-duallistbox-nonselected-list_" style="display: none;"></label>   <span class="info-container">     <span class="info">Showing all 7</span>     <button type="button" class="btn btn-sm clear1" style="float:right!important;">show all</button>   </span>   <input class="form-control filter" type="text" placeholder="Filter">   <div class="btn-group buttons">     <button type="button" class="btn moveall btn-outline-secondary" title="Move all">&gt;&gt;</button>        </div>   <select multiple="multiple" id="bootstrap-duallistbox-nonselected-list_" name="_helper1" style="height: 101.333px;"><option selected="">Alabama</option><option>Alaska</option><option>California</option><option>Delaware</option><option>Tennessee</option><option>Texas</option><option>Washington</option></select> </div> <div class="box2 col-md-6">   <label for="bootstrap-duallistbox-selected-list_" style="display: none;"></label>   <span class="info-container">     <span class="info">Empty list</span>     <button type="button" class="btn btn-sm clear2" style="float:right!important;">show all</button>   </span>   <input class="form-control filter" type="text" placeholder="Filter">   <div class="btn-group buttons">          <button type="button" class="btn removeall btn-outline-secondary" title="Remove all">&lt;&lt;</button>   </div>   <select multiple="multiple" id="bootstrap-duallistbox-selected-list_" name="_helper2" style="height: 101.333px;"></select> </div></div><select class="duallistbox" multiple="multiple" style="display: none;">
                      <option selected="">Alabama</option>
                      <option>Alaska</option>
                      <option>California</option>
                      <option>Delaware</option>
                      <option>Tennessee</option>
                      <option>Texas</option>
                      <option>Washington</option>
                      </select>
                      </div>
                    </div>
                  </div>
                  <div id="step-three" class="content" role="tabpanel" aria-labelledby="step-three-trigger">
                    <div class="container-fluid mt-5">
                      <h6>Map the coloumns to CRM fields</h6>
                      <hr>
                      <div class="row mb-3">
                        <div class="col-lg-2" style="margin-top:auto; margin-bottom: auto;">
                          <label>Use Save Maps</label>
                        </div>
                        <div class="col-lg-4">
                          <select class="form-control form-select"></select>
                        </div>
                      </div>
                      <table class="table table-bordered mb-3">
                        <thead>
                          <tr>
                            <th>HEADER</th>
                            <th>ROW 1</th>
                            <th>CRM FIELDS</th>
                            <th>DEFAULT VALUE</th>
                          </tr>
                        </thead>
                      </table>

                      <div class="row">
                        <div class="col-lg-3" style="margin-top:auto; margin-bottom: auto;">
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck2" checked>
                            <label class="form-check-label" for="exampleCheck2"> Save as Custom Mapping</label>
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <input type="text" class="form-control" name="">
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer modal-footer--sticky">
                <button type="button" class="btn btn-primary" id="btn_nextToStepTwo">Next</button>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container flued -->
  </div><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer pt-2 pb-2">
  Powered by <strong>Arkonor LLC CRM</strong> &#169; <?php echo date('Y') ?>
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0.0
  </div>
  <!-- <center>
    <button type="button" class="btn btn-info btn-sm"><i class="fa fa-save mr-1"></i> Save</button>
    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-times mr-1"></i> Cancel</button>
  </center> -->
</footer>

@endsection



@section('custom_scripts')

<!-- Plugins -->
<!-- Select2 -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/js/select2.full.min.js"></script>

<!-- BS STEPPER -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bs-stepper/js/bs-stepper.min.js"></script>

<!-- BS DUALLISTBOX -->
<script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

<!-- Custom Scripts -->

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_employees').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-user-tie mr-2"></i>
    <b>TEST</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    //
    // ======================================================>
    //

    $('#modal_importOrganizations').modal({'backdrop':'static'});
    
  });
</script>

@endsection
