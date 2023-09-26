
const SETTINGS = (function(){

	let thisSetting = {};

  let baseUrl = $('#txt_baseUrl').val();

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisSetting.addEmailConfig = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $('#btn_submitEmailConfig').html('<i>Please Wait</i>');
    $('#btn_submitEmailConfig').prop('disabled',true);
    $.ajax({
      /* EmailConfigurationController->addEmailConfig() */
      url : `${baseUrl}/settings/add-email-config`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#btn_submitEmailConfig').html('Save Configuration');
        $('#btn_submitEmailConfig').prop('disabled',false);
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Email Config saved successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/settings`);
          }, 1000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
      }
    });
  }

  thisSetting.selectEmailConfig = function()
  { 
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* EmailConfigurationController->selectEmailConfig() */
      url : `${baseUrl}/settings/select-email-config`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        if(data != null)
        {
          $('#txt_emailConfigId').val(data['id']);
          $('#txt_smtpHost').val(data['smtp_host']);
          $('#txt_smtpPort').val(data['smtp_port']);
          $('#slc_smtpCrypto').val(data['smtp_crypto']);
          $('#txt_smtpUser').val(data['smtp_user']);
          $('#txt_smtpPassword').val(data['smtp_pass']);
          $('#slc_mailType').val(data['mail_type']);
          $('#slc_charset').val(data['charset']);
          $('#slc_wordWrap').val(data['word_wrap']);
          $('#txt_fromEmail').val(data['from_email']);
        }
      }
    });
  }

  thisSetting.editEmailConfig = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $('#btn_submitEmailConfig').html('<i>Please Wait</i>');
    $('#btn_submitEmailConfig').prop('disabled',true);
    $.ajax({
      /* EmailConfigurationController->editEmailConfig() */
      url : `${baseUrl}/settings/edit-email-config`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#btn_submitEmailConfig').html('Save Configuration');
        $('#btn_submitEmailConfig').prop('disabled',false);
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Email Config saved successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/settings`);
          }, 1000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
      }
    });
  }

  thisSetting.testEmailConfiguration = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $('#btn_testEmailConfig').html('<i>Please Wait</i>');
    $('#btn_testEmailConfig').prop('disabled',true);
    $.ajax({
      /* EmailConfigurationController->testEmailConfiguration() */
      url : `${baseUrl}/settings/test-email-config`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#btn_testEmailConfig').html('Test Email Configuration');
        $('#btn_testEmailConfig').prop('disabled',false);
        $('#txt_testEmailAddress').val();
        if(result[0] == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Test Email sent successfully.',
          });

          let successMsg = `<div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <h5><i class="icon fas fa-check"></i> Success!</h5>
                              Test Email sent successfully.
                            </div>`;
          $('#div_testEmailMsgResult').html(successMsg);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: `Error! <br>${result[1]}`
          });

          let successMsg = `<div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <h5><i class="icon fas fa-check"></i> Error!</h5>
                              ${result[1]}
                            </div>`;
          $('#div_testEmailMsgResult').html(successMsg);
        }
      }
    });
  }

  thisSetting.checkSystemUpdates = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* SystemUpdateController->checkSystemUpdates() */
      url : `${baseUrl}/settings/check-system-updates`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        if(data[0] == '')
        {
          $('#btn_applySystemUpdates').prop('disabled',true);
          $('#lbl_systemUpdateCount').text('');
        }
        else
        {
          $('#btn_applySystemUpdates').prop('disabled',false);
          $('#lbl_systemUpdateCount').text('New');
        }
      }
    });
  }

  thisSetting.applySystemUpdates = function()
  {
    if(confirm('Please Confirm!'))
    {
      $('body').waitMe(_waitMeLoaderConfig);
      $('#btn_systemUpdates').prop('disabled',true);
      // $('#div_systemUpdateResult').html(`<code>Processing, please wait...</code>`);
      $.ajax({
        /* SystemUpdateController->applySystemUpdates() */
        url : `${baseUrl}/settings/apply-system-updates`,
        method : 'get',
        dataType: 'json',
        success : function(data)
        {
          $('body').waitMe('hide');
          $('#btn_systemUpdates').prop('disabled',false);
          // $('#div_systemUpdateResult').html(`<code>${data[0]}</code>`);

          Toast.fire({
            icon: 'success',
            title: `Success! <br>${data[0]}`,
          });

          setTimeout(function(){
            window.location.replace(`${baseUrl}/settings`);
          }, 1000);
        }
      });
    }
  }

  thisSetting.updateDatabase = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $('#btn_test').prop('disabled',true);
    $.ajax({
      /* SystemUpdateController->updateDatabase() */
      url : `${baseUrl}/settings/update-database`,
      method : 'get',
      dataType: 'json',
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#btn_test').prop('disabled',false);
        if(result[0] == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: `Success! <br>${result[1]}`,
          });
        }
        else
        {
          Toast.fire({
            icon: 'warning',
            title: `Warning! <br>${result[1]}`,
          });
        }
      }
    });
  }

  return thisSetting;

})();