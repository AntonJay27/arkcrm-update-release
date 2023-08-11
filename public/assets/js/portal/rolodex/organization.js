
const ORGANIZATION = (function(){

	let thisOrganization = {};

  let baseUrl = $('#txt_baseUrl').val();

  let _arrSelectedDocuments = [];
  let _arrSelectedCampaigns = [];

  let _arrEmptyValues = [null,""];

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

  thisOrganization.loadOrganizations = function(loadTo, elemId = '', organizationId = '')
  {
    $.ajax({
      /* OrganizationController->loadOrganizations() */
      url : `${baseUrl}/marketing/load-organizations`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        if(loadTo == 'table')
        {
          let tbody = '';
          data.forEach(function(value,key){
            let website = (HELPER.checkEmptyFields(value['main_website'],"") == "")? '---' : `<a href="${value['main_website']}" title="${value['main_website']}" target="_blank">${value['main_website'].substring(0,25)}...</a>`;
            
            let selectOrganization = `<a href="javascript:void(0)" onclick="ORGANIZATION.selectOrganization('edit',${value['id']})" class="mr-2">
                                        <i class="fa fa-pen"></i>
                                      </a>`;
            let deleteOrganization = `<a href="javascript:void(0)" onclick="ORGANIZATION.removeOrganization(${value['id']})" class="text-red">
                                        <i class="fa fa-trash"></i>
                                      </a>`;
            tbody += `<tr>
                        <td class="p-1 pl-4"><a href="${baseUrl}/organization-preview/${value['id']}">${value['organization_name']}</a></td>
                        <td class="p-1"><a href="javascript:void(0)" onclick="ORGANIZATION.selectOrganizationEmail(${value['id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                        <td class="p-1">${website}</td>
                        <td class="p-1">${(HELPER.checkEmptyFields(value['billing_state'],"") == "")? '---' : value['billing_state']}</td>
                        <td class="p-1">${(HELPER.checkEmptyFields(value['billing_city'],"") == "")? '---' : value['billing_city']}</td>
                        <td class="p-1">${(HELPER.checkEmptyFields(value['billing_country'],"") == "")? '---' : value['billing_country']}</td>
                        <td class="p-1">${(_arrEmptyValues.includes(value['assigned_to']))? '---' : value['assigned_to']}</td>
                        <td class="p-1">
                          ${($('#txt_updateOrganization').val() == '1')? selectOrganization:''}
                          ${($('#txt_deleteOrganization').val() == '1')? deleteOrganization:''}                          
                        </td>
                      </tr>`;
          });

          $('#tbl_organizations').DataTable().destroy();
          $('#tbl_organizations tbody').html(tbody);
          $('#tbl_organizations').DataTable({
            "responsive": true,
            "columnDefs": [
              { responsivePriority: 1, targets: 0 },
              { responsivePriority: 2, targets: 1 },
              { responsivePriority: 3, targets: 2 },
              { responsivePriority: 10001, targets: 0 }
            ]
          });
        }
        else if(loadTo == 'select')
        {
          let options = '<option value="">--Select organization--</option>';
          data.forEach(function(value,key){
            if(organizationId == value['id'])
            {
              options += `<option value="${value['id']}" selected>${value['organization_name']}</option>`;
            }
            else
            {
              options += `<option value="${value['id']}">${value['organization_name']}</option>`;
            }
          });
          $(elemId).html(options);
        }
      }
    });
  }

  thisOrganization.loadUsers = function(elemId, userId = '')
  {
    $.ajax({
      /* OrganizationController->loadUsers() */
      url : `${baseUrl}/marketing/organizations/load-users`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        let options = '<option value="">--Select user--</option>';
        data.forEach(function(value,key){
          let userName = `${HELPER.checkEmptyFields(value['salutation'],'')} ${HELPER.checkEmptyFields(value['first_name'],'')} ${HELPER.checkEmptyFields(value['last_name'],'')}`;
          if(userId == value['user_id'])
          {
            options += `<option value="${value['user_id']}" selected>${userName}</option>`;
          }
          else
          {
            options += `<option value="${value['user_id']}">${userName}</option>`;
          }         
        });
        $(elemId).html(options);
      }
    });
  }

  thisOrganization.uploadOrganizationPicturePreview = function(imageFile)
  {
    let fileLen = imageFile.files.length;

    if(fileLen > 0)
    {
      let imageName = imageFile.files[0]['name'];
      let imageSize = imageFile.files[0]['size'] / 1000;
      let imageStatus = '';
      let fileType = ['image/jpg','image/jpeg','image/png','image/gif'];
      let numRows = 0;

      if(imageSize > 3024)
      {
        imageStatus = '<span class="info-bot-number text-danger">Image size must be not greater than 3mb!</span>';
      }
      else if(!fileType.includes(imageFile.files[0]['type']))
      {
        imageStatus = '<span class="info-bot-number text-danger">Not an image file!</span>';
      }
      else
      {
        imageStatus = '<span class="info-bot-number text-success">Good to go!</span>';
      }

      var reader = new FileReader();
      reader.onload = function(e) 
      {
        let strImage = `<img class="profile-user-img img-fluid img-circle"
                         src="${e.target.result}"
                         alt="User profile picture">`;
        $('#div_imagePreview').html(strImage);

        $('#lbl_fileName').html(imageName);
        $('#lbl_fileSize').html(`(${imageSize.toFixed(2)} KB)`);
        $('#lbl_fileStatus').html(imageStatus);

        $('#div_imageDetails').show();
      }
      reader.readAsDataURL(imageFile.files[0]);
    }
    else
    {
      $('#div_imagePreview').html(`<img class="profile-user-img img-fluid img-circle" id="img_profilePicture"
                         src="${baseUrl}/public/assets/img/organization-placeholder.png"
                         alt="User profile picture">`);

      $('#lbl_fileName').html('');
      $('#lbl_fileSize').html('');
      $('#lbl_fileStatus').html('');

      $('#div_imageDetails').hide();

      alert('Please select image file.');
    }
  }

  thisOrganization.loadContactSubstitutions = function()
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

  thisOrganization.loadOrganizationSubstitutions = function()
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

  thisOrganization.addOrganization = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.append("profilePicture", $('#file_profilePicture')[0].files[0]);

    $.ajax({
      /* OrganizationController->addOrganization() */
      url : `${baseUrl}/marketing/add-organization`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_organization').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New organization added successfully.',
          });

          setTimeout(function(){
            window.location.replace(`${baseUrl}/organizations`);
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

  thisOrganization.selectOrganization = function(action, organizationId)
  {
    $.ajax({
      /* OrganizationController->selectOrganization() */
      url : `${baseUrl}/marketing/select-organization`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);
        if(action == 'edit')
        {
          $('#lbl_stateOrganization span').text('Edit Organization');
          $('#lbl_stateOrganization i').removeClass('fa-plus');
          $('#lbl_stateOrganization i').addClass('fa-pen');
          $('#modal_organization').modal({backdrop:'static',keyboard: false});
          $('#txt_organizationId').val(organizationId);

          $('#txt_organizationName').val(data['organization_name']);
          ORGANIZATION.loadUsers('#slc_assignedTo', data['assigned_to']);
          $('#txt_primaryEmail').val(data['primary_email']);
          $('#txt_secondaryEmail').val(data['secondary_email']);
          $('#txt_mainWebsite').val(data['main_website']);
          $('#txt_otherWebsite').val(data['other_website']);
          $('#txt_phoneNumber').val(data['phone_number']);
          $('#txt_fax').val(data['fax']);
          $('#txt_linkedinUrl').val(data['linkedin_url']);
          $('#txt_facebookUrl').val(data['facebook_url']);
          $('#txt_twitterUrl').val(data['twitter_url']);
          $('#txt_instagramUrl').val(data['instagram_url']);
          $('#slc_industry').val(data['industry']);
          $('#txt_naicsCode').val(data['naics_code']);
          $('#txt_employeeCount').val(data['employee_count']);
          $('#txt_annualRevenue').val(data['annual_revenue']);
          $('#slc_type').val(data['type']);
          $('#txt_ticketSymbol').val(data['ticket_symbol']);
          // $('#slc_memberOf').val(data['member_of']);
          $('#slc_emailOptOut').val(data['email_opt_out']);

          $('#txt_billingStreet').val(data['billing_street']);
          $('#txt_billingCity').val(data['billing_city']);
          $('#txt_billingState').val(data['billing_state']);
          $('#txt_billingZip').val(data['billing_zip']);
          $('#txt_billingCountry').val(data['billing_country']);
          $('#txt_shippingStreet').val(data['shipping_street']);
          $('#txt_shippingCity').val(data['shipping_city']);
          $('#txt_shippingState').val(data['shipping_state']);
          $('#txt_shippingZip').val(data['shipping_zip']);
          $('#txt_shippingCountry').val(data['shipping_country']);

          $('#txt_description').val(data['description']);

          if(data['picture'] != null)
          {
            $('#img_profilePicture').prop('src',`${baseUrl}/public/assets/uploads/images/organizations/${data['picture']}`);
            $('#lbl_fileName').text(data['picture']);
          }         
        }
        else if(action == 'load')
        {
          if(data['picture'] != null)
          {
            $('#img_organizationProfilePicture').prop('src',`${baseUrl}/public/assets/uploads/images/organizations/${data['picture']}`);
          }

          let organizationName = `${data['organization_name']}`;
          $('#lnk_organization').text(organizationName);
          $('#lnk_organization').attr('href',`${baseUrl}/organization-preview/${data['id']}`);

          $('#lbl_organizationName').text(organizationName);

          let organizationWebsite = (_arrEmptyValues.includes(data['main_website']))? '---' : `<a href="${data['main_website']}" target="_blank">${data['main_website']}</a>`;
          $('#lbl_organizationWebSite').html(organizationWebsite);

          let organizationEmail = (_arrEmptyValues.includes(data['primary_email']))? '---' : data['primary_email'];
          $('#lbl_organizationEmail').text(organizationEmail);
        }
      }
    });
        
  }

  thisOrganization.editOrganization = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.set("txt_organizationId", $('#txt_organizationId').val());
    formData.append("profilePicture", $('#file_profilePicture')[0].files[0]);

    $.ajax({
      /* OrganizationController->editOrganization() */
      url : `${baseUrl}/marketing/edit-organization`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_organization').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Organization edited successfully.',
          });

          setTimeout(function(){
            window.location.replace(`${baseUrl}/organization-preview/${$('#txt_organizationId').val()}`);
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

  thisOrganization.removeOrganization = function(organizationId)
  {
    if(confirm('Please Confirm!'))
    {
      let formData = new FormData();

      formData.set("organizationId", organizationId);

      $.ajax({
        /* OrganizationController->removeOrganization() */
        url : `${baseUrl}/marketing/remove-organization`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          if(result == 'Success')
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Organization removed successfully.',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/organizations`);
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
  }

  function urlencode(obj, prefix) 
  {
      str = (obj + '').toString();
      return (
          encodeURIComponent(str)
            // The following creates the sequences %27 %28 %29 %2A (Note that
            // the valid encoding of "*" is %2A, which necessitates calling
            // toUpperCase() to properly encode). Although RFC3986 reserves "!",
            // RFC5987 does not, so we do not need to escape it.
            .replace(/['()*]/g, (c) => `%${c.charCodeAt(0).toString(16).toUpperCase()}`)
            // The following are not required for percent-encoding per RFC5987,
            // so we can allow for a little better readability over the wire: |`^
            .replace(/%(7C|60|5E)/g, (str, hex) =>
              String.fromCharCode(parseInt(hex, 16))
            )
        );
  }

  thisOrganization.checkCSVFile = function(thisInput)
  {
    var fileName = thisInput.files[0].name;

    let formData = new FormData();
    formData.set('organizationList',thisInput.files[0],fileName);
    
    $('#lbl_loader').show();
    $('#div_checkResult').hide();
    $('#div_errorResult').hide();
    $('#btn_submitContactList').prop('disabled',true);
    $.ajax({
      // OrganizationController->checkOrganizationFile
      url : `${baseUrl}/rolodex/check-organization-file`,
      method : 'POST',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        __arrFileResult = result;
        $('#lbl_loader').hide();
        if(result['upload_res'] == "")
        {
          let forUpdate = result['for_update'].length;
          let forInsert = result['for_insert'].length;
          let conflictRows = result['conflict_rows'].length;

          $('#lbl_forUpdate').text(forUpdate);
          $('#lbl_forInsert').text(forInsert);
          $('#lbl_conflictRows').text(conflictRows);
          $('#div_checkResult').show();
          (conflictRows == 0)? $('#lbl_download').hide() : $('#lbl_download').show();

          let conflictRowData = result['conflict_rows'];
          
          var myJSON = JSON.stringify(conflictRowData);
          var trafficFilterHolder = urlencode(myJSON);

          // console.log(trafficFilterHolder);
            
          $('#lnk_download').attr('href',`${baseUrl}/rolodex/organization-conflicts/${trafficFilterHolder}`);

          if(forInsert != 0)
          {
            $('#btn_submitOrganizationList').prop('disabled',false);
          }
        }
        else
        {
          $('#div_errorResult > p').text(result['upload_res']);
          $('#div_errorResult').show();
        }
      }
    });
  }

  thisOrganization.uploadOrganizations = function()
  {
    $('#lbl_uploadingProgress').show();
    if(confirm("Please confirm!"))
    {
      let rawData = __arrFileResult;
      $.ajax({
        // OrganizationController->uploadOrganizations
        url : `${baseUrl}/rolodex/upload-organizations`,
        method : 'POST',
        dataType: 'json',
        data : {
          'rawData' : 
          {
            'forInsert' : JSON.stringify(rawData['for_insert'])
          }
        },
        success : function(result)
        {
          console.log(result);
          $('#lbl_uploadingProgress').html("<i>Upload complete!</i>");
          location.reload();      
        }
      });
    }
  }


  // Send Email
  thisOrganization.selectEmailConfig = function(from, organizationId=null, organizationEmail=null)
  {
    $.ajax({
      /* EmailConfigurationController->selectEmailConfig() */
      url : `${baseUrl}/settings/select-email-config`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        if(data != null)
        {
          ORGANIZATION.loadEmailTemplates();
          if(from == 'organization-form')
          {
            $('#txt_to').val($('#lbl_organizationEmail').text());
          }
          else
          {
            $('#txt_organizationId').val(organizationId);
            $('#txt_to').val(organizationEmail);
          }
          $('#txt_subject').val('');
          $('#txt_content').summernote('destroy');
          $('#txt_content').val('');
          $('#txt_content').summernote(summernoteConfig);
          ORGANIZATION.loadContactSubstitutions();
          ORGANIZATION.loadOrganizationSubstitutions();
          $('#modal_sendOrganizationEmail').modal({backdrop:'static',keyboard: false});
        }
        else
        {
          if(confirm(`Unable to Send Email, Please check your Email Configuration Setup on SETTINGS->Email Configuration. Thank you! \n\nDo you want me to redirect you to Email Configuration module? \nClick OK to proceed.`))
          { 
            window.location.replace(`${baseUrl}/settings`);
          }
        }
      }
    });
  }

  thisOrganization.selectOrganizationEmail = function(organizationId, organizationEmail)
  {
    ORGANIZATION.selectEmailConfig('organization-list', organizationId, organizationEmail);
  }

  thisOrganization.loadEmailTemplates = function()
  {
    $.ajax({
      /* EmailTemplateController->loadTemplates() */
      url : `${baseUrl}/tools/load-templates/Organizations`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        let options = '<option value="">--Optional--</option>';
        data.forEach(function(value,key){
          options += `<option value="${value['id']}">${value['template_name']}</option>`;
        });

        $('#slc_emailTemplate').html(options);
      }
    });
  }

  thisOrganization.selectEmailTemplate = function(organizationId,templateId)
  {
    $.ajax({
      /* OrganizationController->selectEmailTemplate() */
      url : `${baseUrl}/marketing/select-organization-email-template`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId, templateId : templateId},
      success : function(data)
      {
        console.log(data);
        $('#txt_subject').val(data['template_subject']);
        $('#txt_content').summernote('destroy');
        $('#txt_content').val(data['template_content']);
        $('#txt_content').summernote(summernoteConfig);
      }
    });
  }

  thisOrganization.sendOrganizationEmail = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.set("txt_organizationId", $('#txt_organizationId').val());

    if($('#chk_unsubscribe').is(':checked'))
    {
      formData.set("chk_unsubscribe", 1);
    }

    $('#btn_sendOrganizationEmail').html('<i class="fa fa-paper-plane mr-1"></i> Sending...');
    $('#btn_sendOrganizationEmail').prop('disabled',true);

    $.ajax({
      /* OrganizationController->sendOrganizationEmail() */
      url : `${baseUrl}/marketing/send-organization-email`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_sendOrganizationEmail').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Message sent successfully.',
          });

          setTimeout(function(){
            window.location.replace(`${baseUrl}/organization-preview/${$('#txt_organizationId').val()}`);
          }, 1000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
        $('#btn_sendOrganizationEmail').html('<i class="fa fa-paper-plane mr-1"></i> Send Email');
        $('#btn_sendOrganizationEmail').prop('disabled',false);
      }
    });
  }

  // start of details

  //summary
  thisOrganization.loadOrganizationSummary = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationSummary() */
      url : `${baseUrl}/marketing/load-organization-summary`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);
        // Summary
        $('#lbl_orgName').html(data['organization_name']);
        $('#lbl_assignedTo').text(data['assigned_to_name']);
        $('#lbl_billingCity').text((_arrEmptyValues.includes(data['billing_city']))? '---' : data['billing_city']);
        $('#lbl_billingCountry').text((_arrEmptyValues.includes(data['billing_country']))? '---' : data['billing_country']);
      }
    });
  }


  thisOrganization.loadOrganizationDocumentSummary = function(organizationId)
  {
    
  }

  thisOrganization.loadOrganizationActivitySummary = function(organizationId)
  {

  }

  thisOrganization.loadOrganizationCommentSummary = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationComments() */
      url : `${baseUrl}/marketing/load-organization-comments`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);

        let divCommentSummary = '';
        
        data.forEach(function(value, index){
          if(value['comment_id'] == null)
          {
            let imgSrc = (value['user_picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${value['user_picture']}`;
            divCommentSummary += `<div class="card-comment p-1">
                                    <img class="img-circle img-sm" src="${imgSrc}" alt="User Image">
                                    <div class="comment-text">
                                      <span class="username">
                                      ${value['created_by_name']}
                                      <span class="text-muted float-right">${value['created_date']}</span>
                                      </span>
                                      <div class="p-2 mt-1 mb-1 bg-light" style="border-radius: 5px;">${value['comment']}</div>
                                      <a href="#" class="mr-2">Like</a>
                                      <a href="javascript:void(0)" onclick="ORGANIZATION.replyCommentSummary(this,${value['id']})" class="mr-2">Reply</a>
                                      <span>${HELPER.dateTimePast(value['created_date'], value['date_now'])}</span>
                                      <div class="div_replyToComment"></div>
                                      ${ORGANIZATION.loadOrganizationCommentReplySummary(value['id'], data)}
                                    </div>
                                  </div>`;
          }
        });

        $('#tbl_recentComments tbody tr td #div_loadCommentSummary').html(divCommentSummary);
      }
    });
  }

  thisOrganization.loadOrganizationCommentReplySummary = function(commentId, data)
  {
    let devReplyCommentSummary = '';
    data.forEach(function(value, index){
      if(commentId == value['comment_id'])
      {
        let imgSrc = (value['user_picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${value['user_picture']}`;
        devReplyCommentSummary += `<div class="ml-3 pt-1">
                              <div class="card-comment p-0">
                                <img class="img-circle img-sm" src="${imgSrc}" alt="User Image">
                                <div class="comment-text">
                                  <span class="username">
                                  ${value['created_by_name']}
                                  <span class="text-muted float-right">${value['created_date']}</span>
                                  </span>
                                  <div class="p-2 mt-1 mb-1 bg-light" style="border-radius: 5px;">${value['comment']}</div>
                                  <a href="#" class="mr-2">Like</a>
                                  <a href="javascript:void(0)" onclick="ORGANIZATION.replyCommentSummary(this,${value['id']})" class="mr-2">Reply</a>
                                  <span>${HELPER.dateTimePast(value['created_date'], value['date_now'])}</span>
                                  <div class="div_replyToComment"></div>
                                  ${ORGANIZATION.loadOrganizationCommentReplySummary(value['id'], data)}
                                </div>
                              </div>
                            </div>`;
      }
    });

    return devReplyCommentSummary;
  }

  thisOrganization.addOrganizationCommentSummary = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.set("txt_organizationId", $('#txt_organizationId').val());

    $.ajax({
      /* OrganizationController->addOrganizationCommentSummary() */
      url : `${baseUrl}/marketing/add-organization-comment-summary`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New comment posted successfully.',
          });
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
        $('#txt_summaryComments').val('');
        ORGANIZATION.loadOrganizationCommentSummary($('#txt_organizationId').val());
      }
    });
  }

  thisOrganization.replyCommentSummary = function(elem,commentId)
  {
    let formComment = `<div class="card card-info" style="box-shadow: none;">
                        <form class="form-horizontal" id="form_replyToComment">
                          <input type="hidden" id="txt_replyCommentId" name="txt_replyCommentId" value="${commentId}">
                          <div class="card-body" style="padding: 0px;">
                            <textarea class="form-control mb-1" rows="3" id="txt_replyComments" name="txt_replyComments" placeholder="Type to compose" required></textarea>
                          </div>
                          <div class="card-footer" style="background-color: white; padding: 0px;">
                            <button type="button" onclick="ORGANIZATION.replyOrganizationCommentSummary();" class="btn btn-sm btn-primary float-right">Post Comment</button>
                          </div>
                        </form>
                      </div>`;
    $('.div_replyToComment').html('');       
    $(elem).closest('div').find('.div_replyToComment:eq(0)').html(formComment);  
    $('#txt_replyComments').focus();            
  }

  thisOrganization.replyOrganizationCommentSummary = function()
  {
    let formData = new FormData();

    formData.set("txt_organizationId", $('#txt_organizationId').val());
    formData.set("txt_replyCommentId", $('#txt_replyCommentId').val());
    formData.set("txt_replyComments", $('#txt_replyComments').val());

    $.ajax({
      /* OrganizationController->replyOrganizationComment() */
      url : `${baseUrl}/marketing/reply-organization-comment`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New comment posted successfully.',
          });
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
        ORGANIZATION.loadOrganizationCommentSummary($('#txt_organizationId').val());
      }
    });
  }


  //details
  thisOrganization.loadOrganizationDetails = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationDetails() */
      url : `${baseUrl}/marketing/load-organization-details`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);

        let mainWebsite = (_arrEmptyValues.includes(data['main_website']))? '---' : `<a href="${data['main_website']}" title="${data['main_website']}" target="_blank">${data['main_website'].substring(0,25)}...</a>`;
        let otherWebsite = (_arrEmptyValues.includes(data['other_website']))? '---' : `<a href="${data['other_website']}" title="${data['other_website']}" target="_blank">${data['other_website'].substring(0,25)}...</a>`;

        let linkedIn = (_arrEmptyValues.includes(data['linkedin_url']))? '---' : `<a href="${data['linkedin_url']}" title="${data['linkedin_url']}" target="_blank">${data['linkedin_url'].substring(0,25)}...</a>`;
        let facebook = (_arrEmptyValues.includes(data['facebook_url']))? '---' : `<a href="${data['facebook_url']}" title="${data['facebook_url']}" target="_blank">${data['facebook_url'].substring(0,25)}...</a>`;
        let twitter = (_arrEmptyValues.includes(data['twitter_url']))? '---' : `<a href="${data['twitter_url']}" title="${data['twitter_url']}" target="_blank">${data['twitter_url'].substring(0,25)}...</a>`;
        let instagram = (_arrEmptyValues.includes(data['instagram_url']))? '---' : `<a href="${data['instagram_url']}" title="${data['instagram_url']}" target="_blank">${data['instagram_url'].substring(0,25)}...</a>`;
        // Details
        $('#div_details table:eq(0) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['organization_name']))? '---' : data['organization_name']);
        $('#div_details table:eq(1) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['assigned_to_name']))? '---' : data['assigned_to_name']);
        $('#div_details table:eq(2) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['primary_email']))? '---' : data['primary_email']);
        $('#div_details table:eq(3) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['secondary_email']))? '---' : data['secondary_email']);
        $('#div_details table:eq(4) tbody tr td:eq(1)').html(mainWebsite);
        $('#div_details table:eq(5) tbody tr td:eq(1)').html(otherWebsite);
        $('#div_details table:eq(6) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['phone_number']))? '---' : data['phone_number']);
        $('#div_details table:eq(7) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['fax']))? '---' : data['fax']);
        $('#div_details table:eq(8) tbody tr td:eq(1)').html(linkedIn);
        $('#div_details table:eq(9) tbody tr td:eq(1)').html(facebook);
        $('#div_details table:eq(10) tbody tr td:eq(1)').html(twitter);
        $('#div_details table:eq(11) tbody tr td:eq(1)').html(instagram);
        $('#div_details table:eq(12) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['industry']))? '---' : data['industry']);
        $('#div_details table:eq(13) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['naics_code']))? '---' : data['naics_code']);
        $('#div_details table:eq(14) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['employee_count']))? '---' : data['employee_count']);
        $('#div_details table:eq(15) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['annual_revenue']))? '---' : `$ ${data['annual_revenue']}`);
        $('#div_details table:eq(16) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['type']))? '---' : data['type']);
        $('#div_details table:eq(17) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['ticket_symbol']))? '---' : data['ticket_symbol']);
        $('#div_details table:eq(18) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['member_of']))? '---' : data['member_of']);
        $('#div_details table:eq(19) tbody tr td:eq(1)').html((data['email_opt_out'] == 0)? 'No':'Yes');

        $('#div_details table:eq(20) tbody tr:eq(0) td:eq(1)').html((_arrEmptyValues.includes(data['billing_street']))? '---' : data['billing_street']);
        $('#div_details table:eq(20) tbody tr:eq(1) td:eq(1)').html((_arrEmptyValues.includes(data['billing_city']))? '---' : data['billing_city']);
        $('#div_details table:eq(20) tbody tr:eq(2) td:eq(1)').html((_arrEmptyValues.includes(data['billing_state']))? '---' : data['billing_state']);
        $('#div_details table:eq(20) tbody tr:eq(3) td:eq(1)').html((_arrEmptyValues.includes(data['billing_zip']))? '---' : data['billing_zip']);
        $('#div_details table:eq(20) tbody tr:eq(4) td:eq(1)').html((_arrEmptyValues.includes(data['billing_country']))? '---' : data['billing_country']);

        $('#div_details table:eq(21) tbody tr:eq(0) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_street']))? '---' : data['shipping_street']);
        $('#div_details table:eq(21) tbody tr:eq(1) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_city']))? '---' : data['shipping_city']);
        $('#div_details table:eq(21) tbody tr:eq(2) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_state']))? '---' : data['shipping_state']);
        $('#div_details table:eq(21) tbody tr:eq(3) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_zip']))? '---' : data['shipping_zip']);
        $('#div_details table:eq(21) tbody tr:eq(4) td:eq(1)').html((_arrEmptyValues.includes(data['shipping_country']))? '---' : data['shipping_country']);

        $('#div_details table:eq(22) tbody tr td').html((_arrEmptyValues.includes(data['description']))? '---' : data['description']);
      }
    });
  }

  thisOrganization.loadOrganizationUpdates = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationUpdates() */
      url : `${baseUrl}/marketing/load-organization-updates`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);

        let div_organizationUpdates = '';
        let createdDate = '';

        data.forEach(function(value,key){

          let actionDetails = ``;

          if(value['actions'].replace(/\s/g,'-') == 'Created-Organization')
          {
            actionDetails += `<span><b>Organization Name : </b> ${value['action_details']['organization_name']}</span><br>`;
            actionDetails += `<span><b>Primary Email : </b> ${value['action_details']['primary_email']}</span><br>`;
            actionDetails += `<span><b>Main Website : </b> ${value['action_details']['main_website']}</span><br>`;
            actionDetails += `<span><b>Phone Number : </b> ${value['action_details']['phone_number']}</span><br>`;
            actionDetails += `<span><b>Facebook : </b> ${value['action_details']['facebook_url']}</span><br>`;
            
            // actionDetails += `<a href="javascript:void(0)"><i>More details ...</i></a>`;
          }

          if(value['actions'].replace(/\s/g,'-') == 'Updated-Organization')
          {
            actionDetails += `<span><b>Organization Name : </b> ${value['action_details']['organization_name']}</span><br>`;
            actionDetails += `<span><b>Primary Email : </b> ${value['action_details']['primary_email']}</span><br>`;
            actionDetails += `<span><b>Main Website : </b> ${value['action_details']['main_website']}</span><br>`;
            actionDetails += `<span><b>Phone Number : </b> ${value['action_details']['phone_number']}</span><br>`;
            actionDetails += `<span><b>Facebook : </b> ${value['action_details']['facebook_url']}</span><br>`;
            
            // actionDetails += `<a href="javascript:void(0)"><i>More details ...</i></a>`;
          }

          if(value['actions'].replace(/\s/g,'-') == 'Linked-Contact-To-Organization')
          {
            value['action_details'].forEach(function(val,k){
              var salutation  = `${val['salutation']}`;
              var firstName   = `${val['first_name']}`;
              var lastName    = `${val['last_name']}`;
              actionDetails += `<span><b>Contact Name : </b> <a href="${baseUrl}/contact-preview/${val['contact_id']}" target="_blank">${salutation} ${firstName} ${lastName}</a></span><br>`;
            });
          }

          if(value['actions'].replace(/\s/g,'-') == 'Unlink-Contact-From-Organization')
          {
            var salutation  = `${value['action_details']['salutation']}`;
            var firstName   = `${value['action_details']['first_name']}`;
            var lastName    = `${value['action_details']['last_name']}`;
            actionDetails += `<span><b>Contact Name : </b> <a href="${baseUrl}/contact-preview/${value['action_details']['contact_id']}" target="_blank">${salutation} ${firstName} ${lastName}</a></span><br>`;
          }

          if(value['actions'].replace(/\s/g,'-') == 'Sent-Email')
          {
            actionDetails += `<span><b>Subject : </b> ${value['action_details']['email_subject']}</span><br>`;
            actionDetails += `<span><b>Contect : </b></span> <div style="width:100%; background-color:#E4E4E4; padding:5px;">${value['action_details']['email_content']}</div>`;
            actionDetails += `<span><b>Status : </b> ${value['action_details']['email_status']}</span><br>`;
            actionDetails += `<span><b>Date & Time : </b> ${value['created_date']}</span><br>`;
          }

          if(value['actions'].replace(/\s/g,'-') == 'Linked-Organization-Document')
          {
            let count = 1;
            let len = value['action_details'].length;
            value['action_details'].forEach(function(val,k){
              actionDetails += `<span><b>Document Title : </b> ${val['title']}</span><br>`;
              actionDetails += `<span><b>Document Type : </b> ${(val['type'] == 1)? 'Uploaded File':'URL'}</span><br>`;
              if(val['type'] == 1)
              {
                actionDetails += `<span><b>File Name : </b> ${val['file_name']}</span><br>`;
                actionDetails += `<span><b>File Size : </b> ${HELPER.formatFileSize(parseFloat(val['file_size']),2)}</span><br>`;
              }
              else
              {
                actionDetails += `<span><b>File URL : </b> ${val['file_url']}</span><br>`;
              }
              actionDetails += `<span><b>Notes : </b> ${val['notes']}</span><br>`;
              actionDetails += `<span><b>Date & Time : </b> ${val['created_date']}</span><br>`;

              if(count >= 1 && count < len)
              {
                actionDetails += `<hr>`;
              }

              count++;
            });
          }

          if(value['actions'].replace(/\s/g,'-') == 'Unlinked-Organization-Document')
          {
            actionDetails += `<span><b>Document Title : </b> ${value['action_details']['title']}</span><br>`;
            actionDetails += `<span><b>Document Type : </b> ${(value['action_details']['type'] == 1)? 'Uploaded File':'URL'}</span><br>`;
            if(value['action_details']['type'] == 1)
            {
              actionDetails += `<span><b>File Name : </b> ${value['action_details']['file_name']}</span><br>`;
              actionDetails += `<span><b>File Size : </b> ${HELPER.formatFileSize(parseFloat(value['action_details']['file_size']),2)}</span><br>`;
            }
            else
            {
              actionDetails += `<span><b>File URL : </b> ${value['action_details']['file_url']}</span><br>`;
            }
            actionDetails += `<span><b>Notes : </b> ${value['action_details']['notes']}</span><br>`;
            actionDetails += `<span><b>Date & Time : </b> ${value['action_details']['created_date']}</span><br>`;
          }

          if(value['actions'].replace(/\s/g,'-') == 'Linked-Organization-Campaign')
          {
            let count = 1;
            let len = value['action_details'].length;
            value['action_details'].forEach(function(val,k){
              actionDetails += `<span><b>Campaign Name : </b> ${val['campaign_name']}</span><br>`;
              actionDetails += `<span><b>Campaign Status : </b> ${val['campaign_status']}</span><br>`;
              actionDetails += `<span><b>Campaign Type : </b> ${val['campaign_type']}</span><br>`;
              actionDetails += `<span><b>Expected Close Date : </b> ${val['expected_close_date']}</span><br>`;
              actionDetails += `<span><b>Expected Revenue : </b> ${val['expected_revenue']}</span><br>`;
              actionDetails += `<span><b>Date & Time : </b> ${value['created_date']}</span><br>`;

              if(count >= 1 && count < len)
              {
                actionDetails += `<hr>`;
              }

              count++;
            });
          }

          if(value['actions'].replace(/\s/g,'-') == 'Unlinked-Organization-Campaign')
          {
            actionDetails += `<span><b>Campaign Name : </b> ${value['action_details']['campaign_name']}</span><br>`;
            actionDetails += `<span><b>Campaign Status : </b> ${value['action_details']['campaign_status']}</span><br>`;
            actionDetails += `<span><b>Campaign Type : </b> ${value['action_details']['campaign_type']}</span><br>`;
            actionDetails += `<span><b>Expected Close Date : </b> ${value['action_details']['expected_close_date']}</span><br>`;
            actionDetails += `<span><b>Expected Revenue : </b> ${value['action_details']['expected_revenue']}</span><br>`;
            actionDetails += `<span><b>Date & Time : </b> ${value['created_date']}</span><br>`;
          }

          if(value['actions'].replace(/\s/g,'-') == 'Comment')
          {
            actionDetails += `<span><b>Comment : </b> ${value['action_details']['comment']}</span><br>`;
            actionDetails += `<span><b>Date & Time : </b> ${value['created_date']}</span><br>`;
          }

          if(value['actions'].replace(/\s/g,'-') == 'Replied-Comment')
          {
            actionDetails += `<span><b>Comment : </b> ${value['action_details']['comment']}</span><br>`;
            actionDetails += `<span><b>Date & Time : </b> ${value['created_date']}</span><br>`;
          }

          if(createdDate != value['date_created'])
          {
            div_organizationUpdates += `<div class="time-label">
                                          <span class="bg-danger">
                                            ${value['date_created']}
                                          </span>
                                        </div>`;

            div_organizationUpdates += `<div>
                                      <i class="fas ${value['action_icon']} ${value['action_background']}"></i>
                                      <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> ${HELPER.dateTimePast(value['created_date'],value['date_now'])}</span>
                                        <h3 class="timeline-header"><a href="#">${value['created_by_name']}</a> ${value['actions']}</h3>
                                        <div class="timeline-body">
                                          ${actionDetails}
                                        </div>
                                      </div>
                                    </div>`;

            createdDate = value['date_created'];
          }
          else
          {
            // if(value['actions'] == 'Created Organization')
            // {
            //   div_organizationUpdates += `<div>
            //                             <i class="fas ${value['action_icon']} ${value['action_background']}"></i>
            //                             <div class="timeline-item">
            //                               <span class="time"><i class="far fa-clock"></i> ${HELPER.dateTimePast(value['created_date'],value['date_now'])}</span>
            //                               <h3 class="timeline-header"><a href="#">${value['created_by_name']}</a> ${value['actions']}</h3>
            //                               <div class="timeline-body">
            //                                 ${actionDetails}
            //                               </div>
            //                             </div>
            //                           </div>`;
            // }
            // else
            // {
              
            // }

            div_organizationUpdates += `<div>
                                      <i class="fas ${value['action_icon']} ${value['action_background']}"></i>
                                      <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> ${HELPER.dateTimePast(value['created_date'],value['date_now'])}</span>
                                        <h3 class="timeline-header"><a href="#">${value['created_by_name']}</a> ${value['actions']}</h3>
                                        <div class="timeline-body">
                                          ${actionDetails}
                                        </div>
                                      </div>
                                    </div>`;
          }
        });

        div_organizationUpdates += `<div>
                                  <i class="far fa-clock bg-gray"></i>
                                </div>`;

        $('#div_organizationUpdates').html(div_organizationUpdates);
      }
    });
  }

  //contacts
  thisOrganization.loadOrganizationContacts = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationContacts() */
      url : `${baseUrl}/marketing/load-organization-contacts`,
      method : 'get',
      dataType: 'json',
      data : {organizationId:organizationId},
      success : function(data)
      {
        console.log(data);
        let tbody = '';
        let count = 0;
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['id']}">${value['first_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['id']}">${value['last_name']}</a></td>
                      <td class="p-1">Leader</td>
                      <td class="p-1"><a href="${baseUrl}/organization-preview/${value['organization_id']}">${value['organization_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['id']}">${value['primary_email']}</a></td>
                      <td class="p-1">Juan</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="ORGANIZATION.unlinkOrganizationContact(${value['id']},${organizationId})">
                          <i class="fa fa-unlink"></i>
                        </a>
                      </td>
                    </tr>`;
          count++;
        });

        $('#tbl_contacts').DataTable().destroy();
        $('#tbl_contacts tbody').html(tbody);
        $('#tbl_contacts').DataTable({
          "responsive": true,
          "columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 },
            {
              "targets": [0],
              "visible": false,
              "searchable": false
            }
          ],
          "order": [[ 0, "desc" ]]
        });

        let buttons = `<button type="button" onclick="ORGANIZATION.addContactModal(${organizationId})" class="btn btn-sm btn-default"><i class="fa fa-user-plus mr-1"></i> Add Contact</button>
                        <button type="button" onclick="ORGANIZATION.selectContactModal(${organizationId})" class="btn btn-sm btn-default"><i class="fa fa-user mr-1"></i> Select Contact</button>`;

        $(`#tbl_contacts_length`).html(buttons);
        
        if(count > 0)
        {
          $('#lbl_contactCount').prop('hidden',false);
          $('#lbl_contactCount').text(count);
        }
        else
        {
          $('#lbl_contactCount').prop('hidden',true);
          $('#lbl_contactCount').text(count);
        }
      }
    });
  }

  thisOrganization.addContactModal = function(organizationId)
  {
    $('#modal_addContact').modal({'backdrop':'static'});
    ORGANIZATION.loadUsers('#slc_assignedToContact');
    ORGANIZATION.loadOrganizations('select','#slc_companyName',organizationId);
  }

  thisOrganization.addContactToOrganization = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $.ajax({
      /* OrganizationController->addContactToOrganization() */
      url : `${baseUrl}/rolodex/add-contact-to-organization`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_contact').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New contact added successfully.',
          });
          setTimeout(function(){
            ORGANIZATION.loadOrganizationContacts($('#slc_companyName').val());
          }, 1000);
          $('#modal_addContact').modal('hide');
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

  thisOrganization.unlinkOrganizationContact = function(contactId, organizationId)
  {
    if(confirm('Please confirm!'))
    {
      let formData = new FormData();

      formData.set("contactId", contactId);

      $.ajax({
        /* OrganizationController->unlinkOrganizationContact() */
        url : `${baseUrl}/marketing/unlink-organization-contact`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          console.log(result);
          $('#modal_organization').modal('hide');
          if(result == 'Success')
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Contact unlinked successfully.',
            });
            ORGANIZATION.loadOrganizationContacts(organizationId);
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
  }

  thisOrganization.selectContactModal = function(organizationId)
  {
    $('#modal_selectContact').modal({backdrop:'static',keyboard: false});
    $('#btn_addSelectedContacts').prop('disabled',true);
    _arrSelectedContacts = [];
    ORGANIZATION.loadUnlinkContacts(organizationId);
  }

  thisOrganization.loadUnlinkContacts = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadUnlinkOrganizationContacts() */
      url : `${baseUrl}/marketing/load-unlink-organization-contacts`,
      method : 'get',
      dataType: 'json',
      data : {organizationId:organizationId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1 pl-4"><input type="checkbox" onchange="ORGANIZATION.selectContacts(this)" value="${value['id']}"/></td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1">${value['first_name']}</td>
                      <td class="p-1">${value['last_name']}</td>
                      <td class="p-1">${value['position']}</td>
                      <td class="p-1">${HELPER.checkEmptyFields(value['organization_name'],'---')}</td>
                      <td class="p-1">${value['primary_email']}</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                    </tr>`;
        });

        $(`#tbl_allContacts`).DataTable().destroy();
        $(`#tbl_allContacts tbody`).html(tbody);
        $(`#tbl_allContacts`).DataTable({
          "responsive": true,
          "columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 }
          ],
          "order": [[ 0, "desc" ]]
        });
      }
    });
  }

  thisOrganization.selectContacts = function(thisCheckBox)
  {
    if($(thisCheckBox).is(':checked'))
    {
      _arrSelectedContacts.push($(thisCheckBox).val());
    }
    else
    {
      let index = _arrSelectedContacts.indexOf($(thisCheckBox).val());
      if (index > -1) 
      {
        _arrSelectedContacts.splice(index, 1); 
      }
    }

    $('#btn_addSelectedContacts').prop('disabled',(_arrSelectedContacts.length > 0)? false : true);    
  }

  thisOrganization.addSelectedContacts = function()
  {
    let formData = new FormData();

    formData.set("organizationId", $('#txt_organizationId').val());
    formData.set("arrSelectedContacts", _arrSelectedContacts);

    $.ajax({
      /* OrganizationController->addSelectedOrganizationContacts() */
      url : `${baseUrl}/marketing/add-selected-organization-contacts`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_selectContact').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New contact added successfully.',
          });
          ORGANIZATION.loadOrganizationContacts($('#txt_organizationId').val());
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

  //activities
  thisOrganization.loadOrganizationActivities = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationActivities() */
      url : `${baseUrl}/marketing/load-organization-activities`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);
        // Activities
        let tbody = '';
        let count = 0;
        data.forEach(function(value,key){
          // tbody += `<tr>
          //             <td class="p-1">${value['id']}</td>
          //             <td class="p-1 pl-4">${value['sent_by_name']}</td>
          //             <td class="p-1">${value['email_subject']}</td>
          //             <td class="p-1">${value['sent_to_name']}</td>
          //             <td class="p-1">${value['date_sent']}</td>
          //             <td class="p-1">${value['time_sent']}</td>
          //             <td class="p-1">${value['email_status']}</td>
          //             <td class="p-1">Action</td>
          //           </tr>`;
          // count++;
        });

        $('#tbl_organizationActivities').DataTable().destroy();
        $('#tbl_organizationActivities tbody').html(tbody);
        $('#tbl_organizationActivities').DataTable({
          "responsive": true,
          "columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 },
            {
              "targets": [0],
              "visible": false,
              "searchable": false
            }
          ],
          "order": [[ 0, "desc" ]]
        });

        let buttons = `<button type="button" onclick="ORGANIZATION.addEventModal(${organizationId})" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> Add Event</button>
                        <button type="button" onclick="ORGANIZATION.addTaskModal(${organizationId})" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> Add Task</button>`;

        $(`#tbl_organizationActivities_length`).html(buttons);

        if(count > 0)
        {
          $('#lbl_activityCount').prop('hidden',false);
          $('#lbl_activityCount').text(count);
        }
        else
        {
          $('#lbl_activityCount').prop('hidden',true);
          $('#lbl_activityCount').text(count);
        }
      }
    });
  }

  thisOrganization.addEventModal = function(organizationId)
  {
    alert('In Progress!');
  }

  thisOrganization.addEvent = function(thisForm)
  {
    alert('In Progress!');
  }

  thisOrganization.addTaskModal = function(organizationId)
  {
    alert('In Progress!');
  }

  thisOrganization.addTask = function(thisForm)
  {
    alert('In Progress!');
  }

  //emails
  thisOrganization.loadOrganizationEmails = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationEmails() */
      url : `${baseUrl}/marketing/load-organization-emails`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        let count = 0;
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4">${value['sent_by_name']}</td>
                      <td class="p-1">${value['email_subject']}</td>
                      <td class="p-1">${value['sent_to_name']}</td>
                      <td class="p-1">${value['date_sent']}</td>
                      <td class="p-1">${value['time_sent']}</td>
                      <td class="p-1">${value['email_status']}</td>
                    </tr>`;
          count++;
        });

        $('#tbl_organizationEmails').DataTable().destroy();
        $('#tbl_organizationEmails tbody').html(tbody);
        $('#tbl_organizationEmails').DataTable({
          "responsive": true,
          "columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 },
            {
              "targets": [0],
              "visible": false,
              "searchable": false
            }
          ],
          "order": [[ 0, "desc" ]]
        });

        if(count > 0)
        {
          $('#lbl_emailCount').prop('hidden',false);
          $('#lbl_emailCount').text(count);
        }
        else
        {
          $('#lbl_emailCount').prop('hidden',true);
          $('#lbl_emailCount').text(count);
        }
      }
    });
  }

  //documents
  thisOrganization.loadOrganizationDocuments = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationDocuments() */
      url : `${baseUrl}/marketing/load-organization-documents`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);
        // Documents
        let tbody = '';
        let count = 0;
        data.forEach(function(value,key){
          let fileLink = '';
          if(value['file_url'] != null)
          {
            fileLink = `<a href="${value['file_url']}" target="_blank">${value['file_url'].substring(0, 20)}...</a>`;
          }
          else
          {
            fileLink = `<a href="${baseUrl}assets/uploads/documents/${value['file_name']}" target="_blank">${value['file_name'].substring(0, 20)}...</a>`;
          }
          tbody += `<tr>
                      <td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4">${value['title']}</td>
                      <td class="p-1">${fileLink}</td>
                      <td class="p-1">${value['created_date']}</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">${(_arrEmptyValues.includes(value['download_count']))? 0 : value['download_count']}</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="alert('Coming Soon')" class="mr-2" title="Download">
                          <i class="fa fa-download"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="ORGANIZATION.unlinkOrganizationDocument(${value['id']})" title="Unlink">
                          <i class="fa fa-unlink"></i>
                        </a>
                      </td>
                    </tr>`;
          count++;
        });

        $('#tbl_organizationDocuments').DataTable().destroy();
        $('#tbl_organizationDocuments tbody').html(tbody);
        $('#tbl_organizationDocuments').DataTable({
          "responsive": true,
          "columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 },
            {
              "targets": [0],
              "visible": false,
              "searchable": false
            }
          ],
          "order": [[ 0, "desc" ]]
        });

        let buttons = `<button type="button" onclick="ORGANIZATION.selectDocumentModal(${organizationId})" class="btn btn-sm btn-default"><i class="fa fa-file mr-1"></i> Select Documents</button>
                        <button type="button" onclick="ORGANIZATION.addDocumentModal()" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> New Document</button>`;

        $(`#tbl_organizationDocuments_length`).html(buttons);

        if(count > 0)
        {
          $('#lbl_documentCount').prop('hidden',false);
          $('#lbl_documentCount').text(count);
        }
        else
        {
          $('#lbl_documentCount').prop('hidden',true);
          $('#lbl_documentCount').text(count);
        }
      }
    });
  }

  thisOrganization.unlinkOrganizationDocument = function(organizationDocumentId)
  {
    if(confirm('Please confirm!'))
    {
      let formData = new FormData();

      formData.set("organizationDocumentId", organizationDocumentId);

      $.ajax({
        /* OrganizationController->unlinkOrganizationDocument() */
        url : `${baseUrl}/marketing/unlink-organization-document`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          console.log(result);
          if(result == 'Success')
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Document unlinked successfully.',
            });
            ORGANIZATION.loadOrganizationDocuments($('#txt_organizationId').val());
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
  }

  thisOrganization.selectDocumentModal = function(organizationId)
  {
    $('#modal_selectDocuments').modal({backdrop:'static',keyboard: false});
    $('#btn_addSelectedDocuments').prop('disabled',true);
    _arrSelectedDocuments = [];
    ORGANIZATION.loadUnlinkOrganizationDocuments(organizationId);
  }

  thisOrganization.loadUnlinkOrganizationDocuments = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadUnlinkOrganizationDocuments() */
      url : `${baseUrl}/marketing/load-unlink-organization-documents`,
      method : 'get',
      dataType: 'json',
      data : {organizationId:organizationId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          let fileLink = '';
          if(value['file_url'] != null)
          {
            fileLink = `<a href="${value['file_url']}" target="_blank">${value['file_url'].substring(0, 20)}...</a>`;
          }
          else
          {
            fileLink = `<a href="${baseUrl}assets/uploads/documents/${value['file_name']}" target="_blank">${value['file_name'].substring(0, 20)}...</a>`;
          }
          tbody += `<tr>
                      <td class="p-1 pl-4"><input type="checkbox" onchange="ORGANIZATION.selectDocuments(this)" value="${value['id']}"/></td>
                      <td class="p-1 pl-4">${value['title']}</td>
                      <td class="p-1">${fileLink}</td>
                      <td class="p-1">${value['created_date']}</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">${(_arrEmptyValues.includes(value['download_count']))? 0 : value['download_count']}</td>
                    </tr>`;
        });

        $(`#tbl_allDocuments`).DataTable().destroy();
        $(`#tbl_allDocuments tbody`).html(tbody);
        $(`#tbl_allDocuments`).DataTable({
          "responsive": true,
          "columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 }
          ],
          "order": [[ 0, "desc" ]]
        });
      }
    });
  }

  thisOrganization.selectDocuments = function(thisCheckBox)
  {
    if($(thisCheckBox).is(':checked'))
    {
      _arrSelectedDocuments.push($(thisCheckBox).val());
    }
    else
    {
      let index = _arrSelectedDocuments.indexOf($(thisCheckBox).val());
      if (index > -1) 
      {
        _arrSelectedDocuments.splice(index, 1); 
      }
    }

    $('#btn_addSelectedDocuments').prop('disabled',(_arrSelectedDocuments.length > 0)? false : true);
  }

  thisOrganization.addSelectedDocuments = function()
  {
    let formData = new FormData();

    formData.set("organizationId", $('#txt_organizationId').val());
    formData.set("arrSelectedDocuments", _arrSelectedDocuments);

    $.ajax({
      /* OrganizationController->addSelectedOrganizationDocuments() */
      url : `${baseUrl}/marketing/add-selected-organization-documents`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_selectDocuments').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New document/s added successfully.',
          });
          ORGANIZATION.loadOrganizationDocuments($('#txt_organizationId').val());
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

  thisOrganization.addDocumentModal = function()
  {
    $('#div_fileName').hide();
    $('#div_fileUrl').hide();
    ORGANIZATION.loadUsers('#slc_assignedToDocument');
    $('#modal_addDocument').modal({backdrop:'static',keyboard: false});
  }

  thisOrganization.addOrganizationDocument = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.set("txt_organizationId", $('#txt_organizationId').val());

    $.ajax({
      /* OrganizationController->addOrganizationDocument() */
      url : `${baseUrl}/marketing/add-organization-document`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_addDocument').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New document added successfully.',
          });
          setTimeout(function(){
            ORGANIZATION.loadOrganizationDocuments($('#txt_organizationId').val());
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

  //Campaigns
  thisOrganization.loadOrganizationCampaigns = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationCampaigns() */
      url : `${baseUrl}/marketing/load-organization-campaigns`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        let count = 0;
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4"><a href="${baseUrl}/campaign-preview/${value['campaign_id']}">${value['campaign_name']}</a></td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">${value['campaign_status']}</td>
                      <td class="p-1">${value['campaign_type']}</td>
                      <td class="p-1">${value['expected_close_date']}</td>
                      <td class="p-1">$ ${value['expected_revenue']}</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="ORGANIZATION.unlinkOrganizationCampaign(${value['id']})" title="Unlink">
                          <i class="fa fa-unlink"></i>
                        </a>
                      </td>
                    </tr>`;
          count++;
        });

        $(`#tbl_campaigns`).DataTable().destroy();
        $(`#tbl_campaigns tbody`).html(tbody);
        $(`#tbl_campaigns`).DataTable({
          "responsive": true,
          "columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 },
            {
              "targets": [0],  
              "visible": false,
              "searchable": false
            }
          ],
          "order": [[ 0, "desc" ]]
        });

        $(`#tbl_campaigns_length`).html(`<button type="button" onclick="ORGANIZATION.selectCampaignModal(${organizationId})" class="btn btn-sm btn-default"><i class="fa fa-bullhorn mr-1"></i> Select Campaigns</button>`);
      
        if(count > 0)
        {
          $('#lbl_campaignCount').prop('hidden',false);
          $('#lbl_campaignCount').text(count);
        }
        else
        {
          $('#lbl_campaignCount').prop('hidden',true);
          $('#lbl_campaignCount').text(count);
        }
      }
    });
  }

  thisOrganization.loadUnlinkOrganizationCampaigns = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadUnlinkOrganizationCampaigns() */
      url : `${baseUrl}/marketing/load-unlink-organization-campaigns`,
      method : 'get',
      dataType: 'json',
      data : {organizationId:organizationId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1 pl-4"><input type="checkbox" onchange="ORGANIZATION.selectCampaigns(this)" value="${value['id']}"/></td>
                      <td class="p-1 pl-4">${value['campaign_name']}</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">${value['campaign_status']}</td>
                      <td class="p-1">${value['campaign_type']}</td>
                      <td class="p-1">${value['expected_close_date']}</td>
                      <td class="p-1">$ ${value['expected_revenue']}</td>
                    </tr>`;
        });

        $(`#tbl_allCampaigns`).DataTable().destroy();
        $(`#tbl_allCampaigns tbody`).html(tbody);
        $(`#tbl_allCampaigns`).DataTable({
          "responsive": true,
          "columnDefs": [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 10001, targets: 1 }
          ],
          "order": [[ 0, "desc" ]]
        });
      }
    });
  }

  thisOrganization.selectCampaignModal = function(organizationId)
  {
    $('#modal_selectCampaigns').modal({backdrop:'static',keyboard: false});
    $('#btn_addSelectedCampaigns').prop('disabled',true);
    _arrSelectedCampaigns = [];
    ORGANIZATION.loadUnlinkOrganizationCampaigns(organizationId);
  }

  thisOrganization.selectCampaigns = function(thisCheckBox)
  {
    if($(thisCheckBox).is(':checked'))
    {
      _arrSelectedCampaigns.push($(thisCheckBox).val());
    }
    else
    {
      let index = _arrSelectedCampaigns.indexOf($(thisCheckBox).val());
      if (index > -1) 
      {
        _arrSelectedCampaigns.splice(index, 1); 
      }
    }

    $('#btn_addSelectedCampaigns').prop('disabled',(_arrSelectedCampaigns.length > 0)? false : true);
    
  }

  thisOrganization.addSelectedCampaign = function()
  {
    let formData = new FormData();

    formData.set("organizationId", $('#txt_organizationId').val());
    formData.set("arrSelectedCampaigns", _arrSelectedCampaigns);

    $.ajax({
      /* OrganizationController->addSelectedOrganizationCampaigns() */
      url : `${baseUrl}/marketing/add-selected-organization-campaigns`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_selectCampaigns').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New campaign added successfully.',
          });
          ORGANIZATION.loadOrganizationCampaigns($('#txt_organizationId').val());
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

  thisOrganization.unlinkOrganizationCampaign = function(organizationCampaignId)
  {
    if(confirm('Please confirm!'))
    {
      let formData = new FormData();

      formData.set("organizationCampaignId", organizationCampaignId);

      $.ajax({
        /* OrganizationController->unlinkOrganizationCampaign() */
        url : `${baseUrl}/marketing/unlink-organization-campaign`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          console.log(result);
          if(result == 'Success')
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Campaign unlinked successfully.',
            });
            ORGANIZATION.loadOrganizationCampaigns($('#txt_organizationId').val());
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
  }



  //comments
  thisOrganization.loadOrganizationComments = function(organizationId)
  {
    $.ajax({
      /* OrganizationController->loadOrganizationComments() */
      url : `${baseUrl}/marketing/load-organization-comments`,
      method : 'get',
      dataType: 'json',
      data : {organizationId : organizationId},
      success : function(data)
      {
        console.log(data);

        let divComments = '';
        data.forEach(function(value, index){
          if(value['comment_id'] == null)
          {
            let imgSrc = (value['user_picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${value['user_picture']}`;
            divComments += `<div class="card-comment p-1">
                              <img class="img-circle img-sm" src="${imgSrc}" alt="User Image">
                              <div class="comment-text">
                                <span class="username">
                                ${value['created_by_name']}
                                <span class="text-muted float-right">${value['created_date']}</span>
                                </span>
                                <div class="p-2 mt-1 mb-1 bg-light" style="border-radius: 5px;">${value['comment']}</div>
                                <a href="#" class="mr-2">Like</a>
                                <a href="javascript:void(0)" onclick="ORGANIZATION.replyComment(this,${value['id']})" class="mr-2">Reply</a>
                                <span>${HELPER.dateTimePast(value['created_date'], value['date_now'])}</span>
                                <div class="div_replyToComment"></div>
                                ${ORGANIZATION.loadOrganizationCommentReplies(value['id'], data)}
                              </div>
                            </div>`;
          }
        });

        $('#div_loadComments').html(divComments);

        if(data.length > 0)
        {
          $('#lbl_commentCount').prop('hidden',false);
          $('#lbl_commentCount').text(data.length);
        }
        else
        {
          $('#lbl_commentCount').prop('hidden',true);
          $('#lbl_commentCount').text(data.length);
        }
      }
    });
  }

  thisOrganization.loadOrganizationCommentReplies = function(commentId, data)
  {
    let devReplyComments = '';
    data.forEach(function(value, index){
      if(commentId == value['comment_id'])
      {
        let imgSrc = (value['user_picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${value['user_picture']}`;
        devReplyComments += `<div class="ml-3 pt-1">
                              <div class="card-comment p-0">
                                <img class="img-circle img-sm" src="${imgSrc}" alt="User Image">
                                <div class="comment-text">
                                  <span class="username">
                                  ${value['created_by_name']}
                                  <span class="text-muted float-right">${value['created_date']}</span>
                                  </span>
                                  <div class="p-2 mt-1 mb-1 bg-light" style="border-radius: 5px;">${value['comment']}</div>
                                  <a href="#" class="mr-2">Like</a>
                                  <a href="javascript:void(0)" onclick="ORGANIZATION.replyComment(this,${value['id']})" class="mr-2">Reply</a>
                                  <span>${HELPER.dateTimePast(value['created_date'], value['date_now'])}</span>
                                  <div class="div_replyToComment"></div>
                                  ${ORGANIZATION.loadOrganizationCommentReplies(value['id'], data)}
                                </div>
                              </div>
                            </div>`;
      }
    });

    return devReplyComments;
                            
  }

  thisOrganization.addOrganizationComment = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.set("txt_organizationId", $('#txt_organizationId').val());

    $.ajax({
      /* OrganizationController->addOrganizationComment() */
      url : `${baseUrl}/marketing/add-organization-comment`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New comment posted successfully.',
          });
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
        $('#txt_comments').val('');
        ORGANIZATION.loadOrganizationComments($('#txt_organizationId').val());
      }
    });
  }

  thisOrganization.replyComment = function(elem,commentId)
  {
    let formComment = `<div class="card card-info" style="box-shadow: none;">
                        <form class="form-horizontal" id="form_replyToComment">
                          <input type="hidden" id="txt_replyCommentId" name="txt_replyCommentId" value="${commentId}">
                          <div class="card-body" style="padding: 0px;">
                            <textarea class="form-control mb-1" rows="3" id="txt_replyComments" name="txt_replyComments" placeholder="Type to compose" required></textarea>
                          </div>
                          <div class="card-footer" style="background-color: white; padding: 0px;">
                            <button type="button" onclick="ORGANIZATION.replyOrganizationComment();" class="btn btn-sm btn-primary float-right">Post Comment</button>
                          </div>
                        </form>
                      </div>`;
    $('.div_replyToComment').html('');       
    $(elem).closest('div').find('.div_replyToComment:eq(0)').html(formComment);  
    $('#txt_replyComments').focus();            
  }

  thisOrganization.replyOrganizationComment = function()
  {
    let formData = new FormData();

    formData.set("txt_organizationId", $('#txt_organizationId').val());
    formData.set("txt_replyCommentId", $('#txt_replyCommentId').val());
    formData.set("txt_replyComments", $('#txt_replyComments').val());

    $.ajax({
      /* OrganizationController->replyOrganizationComment() */
      url : `${baseUrl}/marketing/reply-organization-comment`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New comment posted successfully.',
          });
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: 'Error! <br>Database error!'
          });
        }
        ORGANIZATION.loadOrganizationComments($('#txt_organizationId').val());
      }
    });
  }

  return thisOrganization;

})();