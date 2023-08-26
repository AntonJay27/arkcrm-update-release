@extends('template.layout')

@section('page_title',$pageTitle)



@section('custom_styles')
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/select2/css/select2.min.css">

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

      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="lnk_emailConfiguration" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Email Configuration</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Messages</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">System Updates 
                <span class="badge badge-danger ml-1" id="lbl_systemUpdateCount"></span>
              </a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-four-tabContent">
            <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="lnk_emailConfiguration">
               <div class="row">
                  <div class="col-lg-6">
                     <h6>Mail Server Settings</h6>
                     <form id="form_emailConfiguration">
                       <input type="hidden" id="txt_emailConfigId" name="txt_emailConfigId">
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle">SMTP Host *</td>
                             <td class="p-1">
                               <input type="text" class="form-control form-control-sm" id="txt_smtpHost" name="txt_smtpHost" placeholder="(smtp.googlemail.com)" required>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle">SMTP Port *</td>
                             <td class="p-1">
                               <input type="text" class="form-control form-control-sm" id="txt_smtpPort" name="txt_smtpPort" placeholder="(465)" required>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle">SMTP Crypto *</td>
                             <td class="p-1">
                               <select class="form-control form-control-sm" id="slc_smtpCrypto" name="slc_smtpCrypto" required>
                                 <option value="ssl">SSL</option>
                                 <option value="tls">TLS</option>
                               </select>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle">SMTP User *</td>
                             <td class="p-1">
                               <input type="text" class="form-control form-control-sm" id="txt_smtpUser" name="txt_smtpUser" placeholder="(ajhay.dev@gmail.com)" required>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle">SMTP Password *</td>
                             <td class="p-1">
                               <div class="input-group input-group-sm">
                                  <input type="password" class="form-control form-control-sm" id="txt_smtpPassword" name="txt_smtpPassword" placeholder="(*********************)" required>
                                  <span class="input-group-append">
                                    <button type="button" class="btn btn-default btn-flat" id="btn_smtpPasswordHideShow">
                                       <i class="fas fa-eye"></i>
                                    </button>
                                  </span>
                               </div>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle">Mail Type *</td>
                             <td class="p-1">
                               <select class="form-control form-control-sm" id="slc_mailType" name="slc_mailType" required>
                                 <option value="html">HTML</option>
                                 <option value="text">TEXT</option>
                               </select>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle">Charset *</td>
                             <td class="p-1">
                               <select class="form-control form-control-sm" id="slc_charset" name="slc_charset" required>
                                 <option value="iso-8859-1">iso-8859-1</option>
                                 <option value="utf-8">utf-8</option>
                               </select>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle">Word Wrap *</td>
                             <td class="p-1">
                               <select class="form-control form-control-sm" id="slc_wordWrap" name="slc_wordWrap" required>
                                 <option value="true">True</option>
                                 <option value="false">False</option>
                               </select>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle">From Email *</td>
                             <td class="p-1">
                               <input type="email" class="form-control form-control-sm" id="txt_fromEmail" name="txt_fromEmail" placeholder="(ajhay.work@gmail.com)" required>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <table class="table tbl mb-1">
                         <tbody>
                           <tr>
                             <td class="p-1 text-muted" width="40%;" valign="middle"></td>
                             <td class="p-1">
                               <button type="submit" class="btn btn-sm btn-primary float-right" id="btn_submitEmailConfig">Save Configuration</button>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                     </form>
                  </div>
                  <div class="col-lg-6">
                     <h6>Test Email Configuration</h6>
                     <form id="form_testEmailConfiguration">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1">
                                <input type="email" class="form-control form-control-sm" id="txt_testEmailAddress" name="txt_testEmailAddress" placeholder="(ajhay.work@gmail.com)" required>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1 text-muted" width="40%;" valign="middle"></td>
                              <td class="p-1">
                                <button type="submit" class="btn btn-sm btn-primary float-right" id="btn_testEmailConfig">Test Email Configuration</button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1">
                                <div id="div_testEmailMsgResult">
                                   
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                     </form>

                  </div>
               </div>              
            </div>
            <!-- <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
              Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
            </div>
            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
              Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
            </div> -->
            <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
              <button type="button" class="btn btn-primary" id="btn_systemUpdates">System Updates</button>
              <div id="div_systemUpdateResult"></div>
            </div>
          </div>
        </div>

      </div>

      <div class="p-2"></div>

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

<!-- Custom Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/js/portal/{{ $customScripts }}.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //jQuery Events

    //sideNav active/inactive

    $('.nav-item').removeClass('menu-open');
    $('.nav-link').removeClass('active');
    $('#nav_settings').addClass('active');

    //topNav icon & label

    let topNav = `<i class="fas fa-cog mr-2"></i>
                  <b>SETTINGS</b>`;
    $('#lnk_topNav').html(topNav);

    //events
    $('.select2').select2();

    $('#lnk_emailConfiguration').addClass('active');

    //
    // ======================================================>
    //

    SETTINGS.selectEmailConfig();
    SETTINGS.checkSystemUpdates();

    $('#btn_smtpPasswordHideShow').on('click',function(){
      if($('#txt_smtpPassword').attr('type') == 'password')
      {
         $(this).find('i').removeClass('fa-eye');
         $(this).find('i').addClass('fa-eye-slash');
         $('#txt_smtpPassword').attr('type','text');
      }
      else
      {
         $(this).find('i').removeClass('fa-eye-slash');
         $(this).find('i').addClass('fa-eye');
         $('#txt_smtpPassword').attr('type','password');
      }
    });

    $('#form_emailConfiguration').on('submit',function(e){
      e.preventDefault();
      let emailConfigId = $('#txt_emailConfigId').val();
      (emailConfigId == "")? SETTINGS.addEmailConfig(this) : SETTINGS.editEmailConfig(this);
    });

    $('#form_testEmailConfiguration').on('submit',function(e){
      e.preventDefault();
      SETTINGS.testEmailConfiguration(this);
    });

    $('#btn_systemUpdates').on('click',function(){
      SETTINGS.applySystemUpdates();
    });
    
  });
</script>

@endsection
