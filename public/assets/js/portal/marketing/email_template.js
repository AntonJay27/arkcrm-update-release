let baseUrl = $('#txt_baseUrl').val();

const EMAIL_TEMPLATE = (function(){

	let thisEmailTemplate = {};

  let _arrContactSubstitutions = [
    '__salutation__',
    '__first_name__',
    '__last_name__',
    '__organization_name__',
    '__primary_email__',
    '__secondary_email__',
    '__office_phone__',
    '__mobile_phone__',
    '__home_phone__',
    '__secondary_phone__',
    '__fax__',
    '__date_of_birth__',
    '__intro_letter__',
    '__linkedin_url__',
    '__twitter_url__',
    '__facebook_url__',
    '__instagram_url__',
    '__lead_source__',
    '__department__',
    '__mailing_street__',
    '__mailing_po_box__',
    '__mailing_city__',
    '__mailing_state__',
    '__mailing_zip__',
    '__mailing_country__',
    '__other_street__',
    '__other_po_box__',
    '__other_city__',
    '__other_state__',
    '__other_zip__',
    '__other_country__'
  ];

  let _arrOrganizationSubstitutions = [
    '__organization_name__',
    '__primary_email__',
    '__secondary_email__',
    '__main_website__',
    '__other_website__',
    '__phone_number__',
    '__fax__',
    '__linkedin_url__',
    '__facebook_url__',
    '__twitter_url__',
    '__instagram_url__',
    '__industry__',
    '__naics_code__',
    '__employee_count__',
    '__annual_revenue__',
    '__billing_street__',
    '__billing_city__',
    '__billing_state__',
    '__billing_zip__',
    '__billing_country__',
    '__shipping_street__',
    '__shipping_city__',
    '__shipping_state__',
    '__shipping_zip__',
    '__shipping_country__'
  ];

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisEmailTemplate.loadTemplates = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* EmailTemplateController->loadTemplates() */
      url : `${baseUrl}/tools/load-templates/All`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        let tbody = '';
        data.forEach(function(value,key){
          let templateStatus = (value['template_status'] == "1")? 'Active' : 'Inactive';
          let strLen = value['template_subject'].length;
          let templateSubject = (strLen > 20)? value['template_subject'].substring(0,20) + '...' : value['template_subject']; 
          
          let selectEmailTemplate = `<a href="javascript:void(0)" class="mr-2" onclick="EMAIL_TEMPLATE.selectTemplate(${value['id']})">
                                      <i class="fa fa-pen"></i>
                                    </a>`;
          let deleteEmailTemplate = `<a href="javascript:void(0)" class="text-red" onclick="EMAIL_TEMPLATE.removeTemplate(${value['id']})">
                                      <i class="fa fa-trash"></i>
                                    </a>`;
          tbody += `<tr>
                      <td class="p-1 pl-4">${value['template_name']}</td>
                      <td class="p-1">${value['template_category']}</td>
                      <td class="p-1">${value['created_by']}</td>
                      <td class="p-1">${templateSubject}</td>
                      <td class="p-1">${value['template_visibility']}</td>
                      <td class="p-1">${templateStatus}</td>
                      <td class="p-1">${value['created_date']}</td>
                      <td class="p-1" width="40">
                        ${($('#txt_updateEmailTemplate').val() == '1')? selectEmailTemplate:''}
                        <a href="javascript:void(0)" class="mr-2" onclick="alert('Under Construction!')">
                          <i class="fa fa-eye"></i>
                        </a>
                        ${($('#txt_deleteEmailTemplate').val() == '1')? deleteEmailTemplate:''}
                      </td>
                    </tr>`;
        });

        $('#tbl_emailTemplates').DataTable().destroy();
        $('#tbl_emailTemplates tbody').html(tbody);
        $('#tbl_emailTemplates').DataTable({
          "responsive": true,
          "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 10001, targets: 0 }
          ]
        });
      }
    });
  }

  thisEmailTemplate.loadContactSubstitutions = function()
  {
    let tbody = '';
    for (var i = 0; i <= _arrContactSubstitutions.length - 1; i++) 
    {
      tbody += `<tr>
                  <td class="pt-1 pb-1">${_arrContactSubstitutions[i]}</td>
                </tr>`;
    }
    $('#tbl_contactSubstitutions tbody').html(tbody);
  }

  thisEmailTemplate.loadOrganizationSubstitutions = function()
  {
    let tbody = '';
    for (var i = 0; i <= _arrOrganizationSubstitutions.length - 1; i++) 
    {
      tbody += `<tr>
                  <td class="pt-1 pb-1">${_arrOrganizationSubstitutions[i]}</td>
                </tr>`;
    }
    $('#tbl_organizationSubstitutions tbody').html(tbody);
  }

  thisEmailTemplate.addTemplate = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $.ajax({
      /* EmailTemplateController->addTemplate() */
      url : `${baseUrl}/tools/add-template`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        if(result == "Success")
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New email template has been saved.',
          });
          $('#modal_emailTemplate').modal('hide');
          
          setTimeout(function(){
            window.location.replace(`${baseUrl}/email-template`);
          }, 2000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: result,
          });
        }
      }
    });
  }

  thisEmailTemplate.selectTemplate = function(templateId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* EmailTemplateController->selectTemplate() */
      url : `${baseUrl}/tools/select-template`,
      method : 'get',
      dataType: 'json',
      data : {templateId : templateId},
      success : function(data)
      {
        $('body').waitMe('hide');
        $('#lbl_stateTemplate span').text('Edit Email Template');
        $('#lbl_stateTemplate i').removeClass('fa-plus');
        $('#lbl_stateTemplate i').addClass('fa-pen');

        $('#txt_templateId').val(data['id']);

        $('#txt_templateName').val(data['template_name']);
        $('#slc_category').val(data['template_category']);
        $('#slc_templateVisibility').val(data['template_visibility']);
        $('#txt_description').val(data['template_description']);

        $('#txt_subject').val(data['template_subject']);
        $('#txt_content').summernote('destroy');
        $('#txt_content').val(data['template_content']);
        $('#txt_content').summernote(summernoteConfig);

        EMAIL_TEMPLATE.loadContactSubstitutions();
        EMAIL_TEMPLATE.loadOrganizationSubstitutions();

        $('#modal_emailTemplate').modal('show');
      }
    });
  }

  thisEmailTemplate.editTemplate = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $.ajax({
      /* EmailTemplateController->editTemplate() */
      url : `${baseUrl}/tools/edit-template`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        if(result == "Success")
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Email template has been saved.',
          });
          $('#modal_emailTemplate').modal('hide');
          
          setTimeout(function(){
            window.location.replace(`${baseUrl}/email-template`);
          }, 2000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: result,
          });
        }
      }
    });
  }

  thisEmailTemplate.removeTemplate = function(templateId)
  {
    if(confirm('Are you sure you want to remove this item? \nClick OK button to proceed!'))
    {
      $('body').waitMe(_waitMeLoaderConfig);
      let formData = new FormData();
      formData.set('templateId',templateId);
      $.ajax({
        /* EmailTemplateController->removeTemplate() */
        url : `${baseUrl}/tools/remove-template`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          $('body').waitMe('hide');
          if(result == "Success")
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Email template has been removed.',
            });
            
            setTimeout(function(){
              window.location.replace(`${baseUrl}/email-template`);
            }, 2000);
          }
          else
          {
            Toast.fire({
              icon: 'error',
              title: result,
            });
          }
        }
      });
    }    
  }

  return thisEmailTemplate;

})();