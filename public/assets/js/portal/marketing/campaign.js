let baseUrl = $('#txt_baseUrl').val();

const CAMPAIGN = (function(){

	let thisCampaign = {};

  let _arrSelectedContacts = [];
  let _arrSelectedOrganizations = [];

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisCampaign.loadCampaigns = function(loadTo)
  {
    $.ajax({
      /* CampaignController->loadCampaigns() */
      url : `${baseUrl}/marketing/load-campaigns`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        if(loadTo == 'table')
        {
          let tbody = '';
          data.forEach(function(value,key){
            let selectCampaign = `<a href="javascript:void(0)" onclick="CAMPAIGN.selectCampaign('edit',${value['id']})" class="mr-2">
                                        <i class="fa fa-pen"></i>
                                      </a>`;
            let deleteCampaign = `<a href="javascript:void(0)" onclick="CAMPAIGN.removeCampaign(${value['id']})" class="text-red">
                                        <i class="fa fa-trash"></i>
                                      </a>`;
            tbody += `<tr>
                        <td class="p-1 pl-4"><a href="${baseUrl}/campaign-preview/${value['id']}">${value['campaign_name']}</a></td>
                        <td class="p-1">${value['campaign_type']}</td>
                        <td class="p-1">${value['campaign_status']}</td>
                        <td class="p-1">$ ${value['expected_revenue']}</td>
                        <td class="p-1">${value['expected_close_date']}</td>
                        <td class="p-1">${value['assigned_to_name']}</td>
                        <td class="p-1">
                          ${($('#txt_updateCampaign').val() == '1')? selectCampaign:''}
                          ${($('#txt_deleteCampaign').val() == '1')? deleteCampaign:''}
                        </td>
                      </tr>`;
          });

          $('#tbl_campaigns').DataTable().destroy();
          $('#tbl_campaigns tbody').html(tbody);
          $('#tbl_campaigns').DataTable({
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
          let options = '<option value="">--Select campaign--</option>';
          data.forEach(function(value,key){
            options += `<option value="${value['id']}">${value['campaign_name']}</option>`;
          });
          $('#slc_memberOf').html(options);
        }
      }
    });
  }

  thisCampaign.loadUsers = function(elemId, userId = '')
  {
    $.ajax({
      /* CampaignController->loadUsers() */
      url : `${baseUrl}/marketing/campaigns/load-users`,
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

  thisCampaign.addCampaign = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $('#btn_saveCampaign').text('Please wait...');
    $('#btn_saveCampaign').prop('disabled',true);
    $.ajax({
      /* CampaignController->addCampaign() */
      url : `${baseUrl}/marketing/add-campaign`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        console.log(result);
        $('#modal_campaign').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New campaign added successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/campaigns`);
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

  thisCampaign.selectCampaign = function(action, campaignId)
  {
    $.ajax({
      /* CampaignController->selectCampaign() */
      url : `${baseUrl}/marketing/select-campaign`,
      method : 'get',
      dataType: 'json',
      data : {campaignId : campaignId},
      success : function(data)
      {
        console.log(data);
        if(action == 'edit')
        {
          $('#lbl_stateCampaign span').text('Edit Campaign');
          $('#lbl_stateCampaign i').removeClass('fa-plus');
          $('#lbl_stateCampaign i').addClass('fa-pen');
          $('#modal_campaign').modal({backdrop:'static',keyboard: false});
          $('#txt_campaignId').val(campaignId);

          $('#txt_campaignName').val(data['campaign_name']);
          CAMPAIGN.loadUsers('#slc_assignedTo', data['assigned_to']);
          $('#slc_campaignStatus').val(data['campaign_status']);
          $('#slc_campaignType').val(data['campaign_type']);
          $('#txt_product').val(data['product']);
          $('#txt_targetAudience').val(data['target_audience']);
          $('#txt_expectedCloseDate').val(data['expected_close_date']);
          $('#txt_sponsor').val(data['sponsor']);
          $('#txt_targetSize').val(data['target_size']);
          $('#txt_numSent').val(data['num_sent']);

          $('#txt_budgetCost').val(HELPER.numberWithCommas(data['budget_cost']));
          $('#txt_expectedResponse').val(data['expected_response']);
          $('#txt_expectedSalesCount').val(data['expected_sales_count']);
          $('#txt_expectedResponseCount').val(data['expected_response_count']);
          $('#txt_expectedROI').val(data['expected_roi']);
          $('#txt_actualCost').val(data['actual_cost']);
          $('#txt_expectedRevenue').val(data['expected_revenue']);
          $('#txt_actualSalesCount').val(HELPER.numberWithCommas(data['actual_sales_count']));
          $('#txt_actualResponseCount').val(data['actual_response_count']);
          $('#txt_actualROI').val(data['actual_roi']);

          $('#txt_description').val(data['campaign_description']);
        }
        else if(action == 'load')
        {
          let campaignName = `${data['campaign_name']}`;
          $('#lnk_campaign').text(campaignName);
          $('#lnk_campaign').attr('href',`${baseUrl}/campaign-preview/${data['id']}`);

          $('#lbl_campaignName').text(campaignName);

          let campaignStatus = (data['campaign_status'] != null)? data['campaign_status'] : '---';
          $('#lbl_campaignStatus').html(campaignStatus);

          let expectedCloseDate = (data['expected_close_date'] != null)? data['expected_close_date'] : '---';
          $('#lbl_expectedCloseDate').text(expectedCloseDate);
        }
      }
    });
        
  }

  thisCampaign.editCampaign = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.set("txt_campaignId", $('#txt_campaignId').val());

    $('#btn_saveCampaign').text('Please wait...');
    $('#btn_saveCampaign').prop('disabled',true);
    $.ajax({
      /* CampaignController->editCampaign() */
      url : `${baseUrl}/marketing/edit-campaign`,
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
            window.location.replace(`${baseUrl}/campaign-preview/${$('#txt_campaignId').val()}`);
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

  thisCampaign.removeCampaign = function(campaignId)
  {
    if(confirm('Please Confirm'))
    {
      let formData = new FormData();

      formData.set("campaignId", campaignId);

      $.ajax({
        /* CampaignController->removeCampaign() */
        url : `${baseUrl}/marketing/remove-campaign`,
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
              title: 'Success! <br>Campaign removed successfully.',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/campaigns`);
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

  //details
  thisCampaign.loadCampaignDetails = function(campaignId)
  {
    $.ajax({
      /* CampaignController->loadCampaignDetails() */
      url : `${baseUrl}/marketing/load-campaign-details`,
      method : 'get',
      dataType: 'json',
      data : {campaignId : campaignId},
      success : function(data)
      {
        console.log(data);
        // Details
        
        $('#div_details table:eq(0) tbody tr td:eq(1)').text((data['campaign_name'])? data['campaign_name'] : '---');
        $('#div_details table:eq(1) tbody tr td:eq(1)').text((data['assigned_to_name'])? data['assigned_to_name'] : '---');
        $('#div_details table:eq(2) tbody tr td:eq(1)').text((data['campaign_status'])? data['campaign_status'] : '---');
        $('#div_details table:eq(3) tbody tr td:eq(1)').text((data['campaign_type'])? data['campaign_type'] : '---');
        $('#div_details table:eq(4) tbody tr td:eq(1)').text((data['product'])? data['product'] : '---');
        $('#div_details table:eq(5) tbody tr td:eq(1)').text((data['target_audience'])? data['target_audience'] : '---');
        $('#div_details table:eq(6) tbody tr td:eq(1)').text((data['expected_close_date'])? data['expected_close_date'] : '---');
        $('#div_details table:eq(7) tbody tr td:eq(1)').text((data['sponsor'])? data['sponsor'] : '---');
        $('#div_details table:eq(8) tbody tr td:eq(1)').text((data['target_size'])? data['target_size'] : '---');
        $('#div_details table:eq(9) tbody tr td:eq(1)').text((data['created_date'])? data['created_date'] : '---');
        $('#div_details table:eq(10) tbody tr td:eq(1)').text((data['num_sent'])? data['num_sent'] : '---');
        $('#div_details table:eq(11) tbody tr td:eq(1)').text((data['updated_date'])? data['updated_date'] : '---');

        $('#div_details table:eq(12) tbody tr:eq(0) td:eq(1)').html((data['budget_cost'] != null)? data['budget_cost']:'---');
        $('#div_details table:eq(12) tbody tr:eq(1) td:eq(1)').html((data['expected_response'] != null)? data['expected_response']:'---');
        $('#div_details table:eq(12) tbody tr:eq(2) td:eq(1)').html((data['expected_sales_count'] != null)? data['expected_sales_count']:'---');
        $('#div_details table:eq(12) tbody tr:eq(3) td:eq(1)').html((data['expected_response_count'] != null)? data['expected_response_count']:'---');
        $('#div_details table:eq(12) tbody tr:eq(4) td:eq(1)').html((data['expected_roi'] != null)? data['expected_roi']:'---');
        
        $('#div_details table:eq(13) tbody tr:eq(0) td:eq(1)').html((data['actual_cost'] != null)? data['actual_cost']:'---');
        $('#div_details table:eq(13) tbody tr:eq(1) td:eq(1)').html((data['expected_revenue'] != null)? data['expected_revenue']:'---');
        $('#div_details table:eq(13) tbody tr:eq(2) td:eq(1)').html((data['actual_sales_count'] != null)? data['actual_sales_count']:'---');
        $('#div_details table:eq(13) tbody tr:eq(3) td:eq(1)').html((data['actual_response_count'] != null)? data['actual_response_count']:'---');
        $('#div_details table:eq(13) tbody tr:eq(4) td:eq(1)').html((data['actual_roi'] != null)? data['actual_roi']:'---');
        
        $('#div_details table:eq(14) tbody tr td').html((data['campaign_description'] != null)? data['campaign_description']:'---');
      }
    });
  }

  //updates
  thisCampaign.loadCampaignUpdates = function(campaignId)
  {
    $.ajax({
      /* CampaignController->loadCampaignUpdates() */
      url : `${baseUrl}/marketing/load-campaign-updates`,
      method : 'get',
      dataType: 'json',
      data : {campaignId : campaignId},
      success : function(data)
      {
        console.log(data);

        let div_campaignUpdates = '';
        let createdDate = '';

        data.forEach(function(value,key){

          let actionDetails = ``;

          if(value['actions'].replace(/\s/g,'-') == 'Created-Campaign')
          {
            actionDetails += `<span><b>Campaign Name : </b> ${value['action_details']['campaign_name']}</span><br>`;
            actionDetails += `<span><b>Campaign Status : </b> ${value['action_details']['campaign_status']}</span><br>`;
            actionDetails += `<span><b>Campaign Type : </b> ${value['action_details']['campaign_type']}</span><br>`;
            
            // actionDetails += `<a href="javascript:void(0)"><i>More details ...</i></a>`;
          }

          if(value['actions'].replace(/\s/g,'-') == 'Updated-Campaign')
          {
            actionDetails += `<span><b>Campaign Name : </b> ${value['action_details']['campaign_name']}</span><br>`;
            actionDetails += `<span><b>Campaign Status : </b> ${value['action_details']['campaign_status']}</span><br>`;
            actionDetails += `<span><b>Campaign Type : </b> ${value['action_details']['campaign_type']}</span><br>`;
            
            // actionDetails += `<a href="javascript:void(0)"><i>More details ...</i></a>`;
          }

          if(createdDate != value['date_created'])
          {
            div_campaignUpdates += `<div class="time-label">
                                      <span class="bg-danger">
                                        ${value['date_created']}
                                      </span>
                                    </div>`;

            div_campaignUpdates += `<div>
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
            if(value['actions'] == 'Created Contact')
            {
              div_campaignUpdates += `<div>
                                        <i class="fas ${value['action_icon']} ${value['action_background']}"></i>
                                        <div class="timeline-item">
                                          <span class="time"><i class="far fa-clock"></i> ${HELPER.dateTimePast(value['created_date'],value['date_now'])}</span>
                                          <h3 class="timeline-header"><a href="#">${value['created_by_name']}</a> ${value['actions']}</h3>
                                        </div>
                                      </div>`;
            }
            else
            {
              div_campaignUpdates += `<div>
                                        <i class="fas ${value['action_icon']} ${value['action_background']}"></i>
                                        <div class="timeline-item">
                                          <span class="time"><i class="far fa-clock"></i> ${HELPER.dateTimePast(value['created_date'],value['date_now'])}</span>
                                          <h3 class="timeline-header"><a href="#">${value['created_by_name']}</a> ${value['actions']}</h3>
                                          <div class="timeline-body">
                                            ${value['action_details']}
                                          </div>
                                          <div class="timeline-footer">
                                            <a href="#" class="btn btn-primary btn-sm">View Details</a>
                                          </div>
                                        </div>
                                      </div>`;
            }
          }
        });

        div_campaignUpdates += `<div>
                                  <i class="far fa-clock bg-gray"></i>
                                </div>`;

        $('#div_campaignUpdates').html(div_campaignUpdates);
      }
    });
  }

  //contacts
  thisCampaign.loadSelectedContactCampaigns = function(campaignId)
  {
    $.ajax({
      /* CampaignController->loadSelectedContactCampaigns() */
      url : `${baseUrl}/marketing/load-selected-contact-campaigns`,
      method : 'get',
      dataType: 'json',
      data : {campaignId : campaignId},
      success : function(data)
      {
        console.log(data);
        let count = 0;
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1">${value['contact_id']}</td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['contact_id']}">${value['first_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['contact_id']}">${value['last_name']}</a></td>
                      <td class="p-1">${(value['position'] == null)? '---' : value['position']}</td>
                      <td class="p-1">${(value['organization_name'] == null)? '---' : `<a href="${baseUrl}/organization-preview/${value['organization_id']}">${value['organization_name']}</a>`}</td>
                      <td class="p-1"><a href="javascript:void(0)" onclick="CONTACTS.selectContactEmail(${value['contact_id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="CAMPAIGN.unlinkContactCampaign(${value['id']})" title="Unlink">
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

        $(`#tbl_contacts_length`).html(`<button type="button" onclick="CAMPAIGN.selectContactModal(${campaignId})" class="btn btn-sm btn-default"><i class="fa fa-user mr-1"></i> Select Contact</button>`);
      
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

  thisCampaign.unlinkContactCampaign = function(contactCampaignId)
  {
    if(confirm('Please confirm!'))
    {
      let formData = new FormData();

      formData.set("contactCampaignId", contactCampaignId);

      $.ajax({
        /* ContactController->unlinkContactCampaign() */
        url : `${baseUrl}/marketing/unlink-contact-campaign`,
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
            CAMPAIGN.loadSelectedContactCampaigns($('#txt_campaignId').val());
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

  thisCampaign.selectContactModal = function(campaignId)
  {
    $('#modal_selectContact').modal({backdrop:'static',keyboard: false});
    $('#btn_addSelectedContacts').prop('disabled',true);
    _arrSelectedContacts = [];
    CAMPAIGN.loadUnlinkContacts(campaignId);
  }

  thisCampaign.loadUnlinkContacts = function(campaignId)
  {
    $.ajax({
      /* CampaignController->loadUnlinkContacts() */
      url : `${baseUrl}/marketing/load-unlink-contacts`,
      method : 'get',
      dataType: 'json',
      data : {campaignId:campaignId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1 pl-4"><input type="checkbox" onchange="CAMPAIGN.selectContacts(this)" value="${value['id']}"/></td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1">${value['first_name']}</td>
                      <td class="p-1">${value['last_name']}</td>
                      <td class="p-1">${value['position']}</td>
                      <td class="p-1">${value['organization_name']}</td>
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

  thisCampaign.selectContacts = function(thisCheckBox)
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

  thisCampaign.addSelectedContact = function()
  {
    let formData = new FormData();

    formData.set("campaignId", $('#txt_campaignId').val());
    formData.set("arrSelectedContacts", _arrSelectedContacts);

    $.ajax({
      /* ContactController->addSelectedContactCampaigns() */
      url : `${baseUrl}/marketing/add-selected-contact-campaigns`,
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
          CAMPAIGN.loadSelectedContactCampaigns($('#txt_campaignId').val());
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


  //Activities
  thisCampaign.loadCampaignActivities = function(campaignId)
  {
    $.ajax({
      /* CampaignController->loadCampaignActivities() */
      url : `${baseUrl}/marketing/load-campaign-activities`,
      method : 'get',
      dataType: 'json',
      data : {campaignId : campaignId},
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

        $('#tbl_campaignActivities').DataTable().destroy();
        $('#tbl_campaignActivities tbody').html(tbody);
        $('#tbl_campaignActivities').DataTable({
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

        let buttons = `<button type="button" onclick="CAMPAIGN.addEventModal(${campaignId})" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> Add Event</button>
                        <button type="button" onclick="CAMPAIGN.addTaskModal(${campaignId})" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> Add Task</button>`;

        $(`#tbl_campaignActivities_length`).html(buttons);

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

  thisCampaign.addEventModal = function(campaignId)
  {
    alert('In Progress!');
  }

  thisCampaign.addEvent = function(thisForm)
  {
    alert('In Progress!');
  }

  thisCampaign.addTaskModal = function(campaignId)
  {
    alert('In Progress!');
  }

  thisCampaign.addTask = function(thisForm)
  {
    alert('In Progress!');
  }
  

  //organizations
  thisCampaign.loadSelectedOrganizationCampaigns = function(campaignId)
  {
    $.ajax({
      /* CampaignController->loadSelectedOrganizationCampaigns() */
      url : `${baseUrl}/marketing/load-selected-organization-campaigns`,
      method : 'get',
      dataType: 'json',
      data : {campaignId : campaignId},
      success : function(data)
      {
        console.log(data);
        let count = 0;
        let tbody = '';
        data.forEach(function(value,key){
          let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}/campaign-preview/${value['id']}">${value['main_website']}</a>`;
          tbody += `<tr>
                      <td class="p-1">${value['organization_id']}</td>
                      <td class="p-1 pl-4"><a href="${baseUrl}/organization-preview/${value['id']}">${value['organization_name']}</a></td>
                      <td class="p-1"><a href="javascript:void(0)" onclick="CONTACTS.selectContactEmail(${value['id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                      <td class="p-1">${website}</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="CAMPAIGN.unlinkOrganizationCampaign(${value['id']})" title="Unlink">
                          <i class="fa fa-unlink"></i>
                        </a>
                      </td>
                    </tr>`;
          count++;          
        });

        $('#tbl_organizations').DataTable().destroy();
        $('#tbl_organizations tbody').html(tbody);
        $('#tbl_organizations').DataTable({
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

        $(`#tbl_organizations_length`).html(`<button type="button" onclick="CAMPAIGN.selectOrganizationModal(${campaignId})" class="btn btn-sm btn-default"><i class="fa fa-building mr-1"></i> Select Organization</button>`);
      
        if(count > 0)
        {
          $('#lbl_organizationCount').prop('hidden',false);
          $('#lbl_organizationCount').text(count);
        }
        else
        {
          $('#lbl_organizationCount').prop('hidden',true);
          $('#lbl_organizationCount').text(count);
        }
      }
    });
  }

  thisCampaign.unlinkOrganizationCampaign = function(organizationCampaignId)
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
            CAMPAIGN.loadSelectedOrganizationCampaigns($('#txt_campaignId').val());
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

  thisCampaign.selectOrganizationModal = function(campaignId)
  {
    $('#modal_selectOrganization').modal({backdrop:'static',keyboard: false});
    $('#btn_addSelectedOrganizations').prop('disabled',true);
    _arrSelectedOrganizations = [];
    CAMPAIGN.loadUnlinkOrganizations(campaignId);
  }

  thisCampaign.loadUnlinkOrganizations = function(campaignId)
  {
    $.ajax({
      /* CampaignController->loadUnlinkOrganizations() */
      url : `${baseUrl}/marketing/load-unlink-organizations`,
      method : 'get',
      dataType: 'json',
      data : {campaignId:campaignId},
      success : function(data)
      {
        console.log(data);
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}/contact-preview/${value['id']}">${value['main_website']}</a>`;
          tbody += `<tr>
                      <td class="p-1 pl-4"><input type="checkbox" onchange="CAMPAIGN.selectOrganizations(this)" value="${value['id']}"/></td>
                      <td class="p-1 pl-4">${value['organization_name']}</td>
                      <td class="p-1">${value['primary_email']}</td>
                      <td class="p-1">${website}</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                    </tr>`;
        });

        $(`#tbl_allOrganizations`).DataTable().destroy();
        $(`#tbl_allOrganizations tbody`).html(tbody);
        $(`#tbl_allOrganizations`).DataTable({
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

  thisCampaign.selectOrganizations = function(thisCheckBox)
  {
    if($(thisCheckBox).is(':checked'))
    {
      _arrSelectedOrganizations.push($(thisCheckBox).val());
    }
    else
    {
      let index = _arrSelectedOrganizations.indexOf($(thisCheckBox).val());
      if (index > -1) 
      {
        _arrSelectedOrganizations.splice(index, 1); 
      }
    }

    $('#btn_addSelectedOrganizations').prop('disabled',(_arrSelectedOrganizations.length > 0)? false : true);    
  }

  thisCampaign.addSelectedOrganization = function()
  {
    let formData = new FormData();

    formData.set("campaignId", $('#txt_campaignId').val());
    formData.set("arrSelectedOrganizations", _arrSelectedOrganizations);

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
        $('#modal_selectOrganization').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New organization added successfully.',
          });
          CAMPAIGN.loadSelectedOrganizationCampaigns($('#txt_campaignId').val());
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

  

  return thisCampaign;

})();