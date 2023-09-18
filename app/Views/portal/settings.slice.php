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
              <div class="container-fluid">
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
            </div>
            <!-- <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
              Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
            </div>
            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
              Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
            </div> -->
            <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">

              <div class="container-fluid">
                <!-- <h5>CHANGELOG</h5> -->
                <h5 class="text-red">NEW UPDATES !</h5>

                <div class="callout callout-info">
                  <h5>BUILD <small class="text-muted">AUGUST 8, 2023</small></h5>
                  <p>
                    <ul>
                      <li>System Update Revision</li>
                      <li>GIT initialization</li>
                      <li>Update Logs</li>
                    </ul>
                  </p>
                </div>

                <button type="button" class="btn btn-primary" id="btn_applySystemUpdates" disabled>Apply System Updates</button>

                <hr>

                <div class="card shadow-none">
                  <div class="card-header p-0">
                    <h3 class="card-title">BUILD <small class="text-muted">AUGUST 8, 2023</small></h3>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    </div>
                  </div>
                  <div class="card-body p-0" style="display: block;">
                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1">
                                <ul>
                                    <li>Various syntax highlighting improvements</li>
                                    <li>Added <tt>"fold_style"</tt> setting for controlling syntax-based code folding</li>
                                    <li>Last tab in a group can now be selected with <tt>alt+9</tt> (Windows/Linux) and <tt>cmd+9</tt> (Mac)</li>
                                    <li><em>Split View</em> retains the original view's viewport position</li>
                                    <li>Added WebP support</li>
                                    <li>Improved minimap viewport contrast with large amounts of visible text</li>
                                    <li>The window title now indicates whether Sublime Text is running with administrator privileges</li>
                                    <li>Improved indentation detection for files with many single space indents</li>
                                    <li>Improved caret positioning when using text wrapping</li>
                                    <li>Fixed files in side-bar not properly reflecting their git status</li>
                                    <li>Find in Files: Tab multi-select modifier keys are now supported</li>
                                    <li>Find in Files: Fixed search results not being ordered</li>
                                    <li>Find in Files: Paths can now be quoted</li>
                                    <li>Find in Files: Added <tt>"find_in_files_suppress_errors"</tt> settings</li>
                                    <li>Find in Files: Added <tt>"find_in_files_context_lines"</tt> settings</li>
                                    <li>Find in Files: Added <tt>"find_in_files_side_by_side"</tt> setting</li>
                                    <li>Find in Files: Ongoing searches are no longer canceled on renamed buffer</li>
                                    <li>Find in Files: Fixed <tt>./</tt> not working in the "Where" field</li>
                                    <li>Find: Added <tt>"regex_auto_escape"</tt> setting</li>
                                    <li>Find: Fixed find settings confusion when run immediately after <tt>find_under_expand</tt></li>
                                    <li>Find: Fixed find in selection skipping empty selections</li>
                                    <li>Fixed word wrap being too early in some cases</li>
                                    <li>Fixed scrolling by page not always including a full line of context</li>
                                    <li>Fixed first character beyond ASCII range not being decoded/encoded for short code pages</li>
                                    <li>Improved performance when drag selecting columns</li>
                                    <li>Fixed annotations displaying incorrectly when <tt>"ui_scale"</tt> is set to something other than <tt>1</tt></li>
                                    <li>Fixed recent file list not being updated when quitting with hot exit disabled</li>
                                    <li>Fixed high memory usage edge case in minihtml parsing</li>
                                    <li>Fixed case where open file/folder dialogs didn't respect <tt>"default_dir"</tt> setting</li>
                                    <li><em>Reopen Closed File</em> now uses the window's file history by default rather than global history</li>
                                    <li>Fixed tabs of deleted files incorrectly showing as modified in some cases</li>
                                    <li>Fixed <tt>"draw_centered"</tt> setting causing incorrect gutter rendering in some cases</li>
                                    <li>Fixed extra commands being included for macros in some situations</li>
                                    <li>Fixed goto-symbol not showing inside empty groups</li>
                                    <li>Fixed column number in the status bar not updating upon changing tab width</li>
                                    <li>Fixed issue where the command palette could consume key presses while not having input focus</li>
                                    <li>Syntax Highlighting: Improved scope selector performance</li>
                                    <li>Syntax Highlighting: Fixed syntax-based folding not working correctly with some indented code</li>
                                    <li>Syntax Highlighting: Fixed syntax definition negative symbol tests</li>
                                    <li>Syntax Highlighting: Fixed edge case that could break syntax highlighting</li>
                                    <li>Syntax Highlighting: Fixed backtracking bug where tokens were being dropped</li>
                                    <li>Syntax Highlighting: Fixed some hangs caused by syntax backtracking</li>
                                    <li>Syntax Highlighting: Fixed a syntax highlighting performance issue due to backtracking</li>
                                    <li>Syntax Highlighting: Fixed a crash when a lazy loaded syntax doesn't exist</li>
                                    <li>API: Updated to Python 3.8.12 and OpenSSL 1.1.1s</li>
                                    <li>API: The Python 3.3 plugin environment now uses the same OpenSSL as 3.8</li>
                                    <li>API: Added support for the <tt>"context"</tt> key in mousemaps</li>
                                    <li>API: Fixed inconsistent focus after <tt>Window.open_file()</tt></li>
                                    <li>API: The <tt>open_file</tt> command now supports <tt>"transient"</tt>, <tt>"force_group"</tt>, <tt>"clear_to_right"</tt> and <tt>"force_clone"</tt> arguments</li>
                                    <li>API: Added <tt>Window.num_views_in_group()</tt></li>
                                    <li>API: Added <tt>sublime.project_history()</tt></li>
                                    <li>API: Added <tt>sublime.folder_history()</tt></li>
                                    <li>Windows: Added <tt>alt+shift+p</tt> as default keybinding for Quick Switch Project</li>
                                    <li>Windows: Fixed a packaging error with the installers</li>
                                    <li>Windows: Fixed tooltips sometimes not being removed</li>
                                    <li>Windows: Fixed select folder dialog not respecting the initial directory</li>
                                    <li>Windows: Fixed lockup that could occur when menus and popups interfere</li>
                                    <li>Linux: Files for printing are saved in <tt>~/Downloads</tt> if possible to work around snap/flatpak limitations</li>
                                    <li>Linux: User config and cache paths are now created at startup if not present</li>
                                    <li>Linux: Fixed incorrect mouse behavior at window edges</li>
                                    <li>Linux, Mac: Attempt to find the license key for the user when using sudo</li>
                                    <li>Mac: Better support for running as root</li>
                                    <li>Mac: Fixed extra window being created when ST is launched by opening a file from finder</li>
                                    <li>Mac: System setting <em>"click in the scroll bar to"</em> is now respected</li>
                                    <li>Mac: Added workaround for Monterey bug causing scrolling to misbehave</li>
                                    <li>Mac: Added security entitlements allowing plugins &amp; build systems to request the camera and microphone</li>
                                </ul>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12"></div>
                    </div>
                  </div>
                </div>

                <div class="card shadow-none">
                  <div class="card-header p-0">
                    <h3 class="card-title">BUILD <small class="text-muted">AUGUST 8, 2023</small></h3>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    </div>
                  </div>
                  <div class="card-body p-0" style="display: block;">
                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <table class="table tbl mb-1">
                          <tbody>
                            <tr>
                              <td class="p-1">
                                ---
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-lg-6 col-sm-12"></div>
                    </div>
                  </div>
                </div>

              </div>
              
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

    $('#btn_applySystemUpdates').on('click',function(){
      SETTINGS.applySystemUpdates();
    });
    
  });
</script>

@endsection
