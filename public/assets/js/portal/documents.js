let baseUrl = $('#txt_baseUrl').val();

const DOCUMENTS = (function(){

	let thisDocuments = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  let _arrSelectedContacts = [];
  let _arrSelectedOrganizations = [];

  let _arrEmptyValues = [null,""];

  thisDocuments.loadDocuments = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DocumentController->loadDocuments() */
      url : `${baseUrl}/load-documents`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        // Documents
        let tbody = '';
        let count = 0;
        data.forEach(function(value,key){
          let fileLink = '';
          let downloadLink = '';

          if(value['file_url'] != null)
          {
            fileLink = `<a href="${value['file_url']}" target="_blank" title="${value['file_url']}">${value['file_url'].substring(0, 20)}...</a>`;
            downloadLink = `<a href="${value['file_url']}" class="mr-2" target="_blank" title="Open Link">
                              <i class="fa fa-external-link"></i>
                            </a>`;
          }
          else
          {
            fileLink = `<a href="${baseUrl}/public/assets/uploads/documents/${value['file_name']}" target="_blank">${value['file_name'].substring(0, 20)}...</a>`;
            downloadLink = `<a href="javascript:void(0)" onclick="DOCUMENTS.downloadDocument(${value['id']},'${value['file_name']}')" class="mr-2" title="Download" disabled>
                              <i class="fa fa-download"></i>
                            </a>`;
          }
          let documentPreview = `<a href="${baseUrl}/document-preview/${value['id']}">${value['title']}</a>`;

          let selectDocument = `<a href="javascript:void(0)" onclick="DOCUMENTS.selectDocument('edit',${value['id']})" class="mr-2" title="Edit">
                                      <i class="fa fa-pen"></i>
                                    </a>`;
          let deleteDocument = `<a href="javascript:void(0)" onclick="DOCUMENTS.removeDocument(${value['id']})" class="text-red" title="Delete">
                                      <i class="fa fa-trash"></i>
                                    </a>`;
          tbody += `<tr>
                      <td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4">${documentPreview}</td>
                      <td class="p-1">${fileLink}</td>
                      <td class="p-1">${value['created_date']}</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">${(value['download_count'] != null)? parseInt(value['download_count']) : 0}</td>
                      <td class="p-1">
                        ${($('#txt_updateDocument').val() == '1')? selectDocument:''}
                        ${downloadLink}
                        ${($('#txt_deleteDocument').val() == '1')? deleteDocument:''}
                      </td>
                    </tr>`;
          count++;
        });

        $('#tbl_documents').DataTable().destroy();
        $('#tbl_documents tbody').html(tbody);
        $('#tbl_documents').DataTable({
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
      }
    });
  }

  thisDocuments.removeDocument = function(documentId)
  {
    if(confirm('Please Confirm'))
    {
      $('body').waitMe(_waitMeLoaderConfig);
      let formData = new FormData();
      formData.set("documentId", documentId);
      $.ajax({
        /* DocumentController->removeDocument() */
        url : `${baseUrl}/remove-document`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          $('body').waitMe('hide');
          if(result[0] == 'Success')
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Document removed successfully.',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/documents`);
            }, 1000);
          }
          else
          {
            Toast.fire({
              icon: 'error',
              title: `Error! <br>${result[0]}`
            });
          }
        }
      });
    }
  }

  thisDocuments.addDocumentModal = function()
  {
    $('#lbl_fileNameNote').html('');
    $('#div_fileName').hide();
    $('#div_fileUrl').hide();
    DOCUMENTS.loadUsers('#slc_assignedToDocument');
    $('#txt_documentState').val('add');
    $('#modal_document').modal('show');
  }

  thisDocuments.loadUsers = function(elemId, userId = '')
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* UserController->loadUsers() */
      url : `${baseUrl}/documents/load-users`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
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

  thisDocuments.addDocument = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    if($('#slc_uploadtype').val() == 1)
    {
      let files = document.getElementById('file_fileName').files;
      let fileLen = files.length;
      for (var index = 0; index < fileLen; index++) 
      {
         formData.append("file_fileName[]", files[index]);
      }
    }
    $.ajax({
      /* DocumentController->addDocument() */
      url : `${baseUrl}/add-document`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#modal_document').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New document added successfully.',
          });

          setTimeout(function(){
            window.location.replace(`${baseUrl}/documents`);
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

  thisDocuments.selectDocument = function(action, documentId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    // CONTACTS.loadUsers(['#slc_reportsTo','#slc_assignedTo']);
    $.ajax({
      /* DocumentController->selectDocument() */
      url : `${baseUrl}/select-document`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        $('body').waitMe('hide');
        if(action == 'edit')
        {
          $('#lbl_stateDocument span').text('Edit Document');
          $('#lbl_stateDocument i').removeClass('fa-plus');
          $('#lbl_stateDocument i').addClass('fa-pen');
          $('#modal_document').modal('show');
          $('#txt_documentId').val(documentId);

          $('#txt_title').val(data['title']);
          DOCUMENTS.loadUsers('#slc_assignedToDocument', data['assigned_to']);
          $('#slc_uploadtype').val((_arrEmptyValues.includes(data['type']))? '' : data['type']);

          if(data['type'] == 1)
          {
            $('#div_fileName').show();
            $('#lbl_fileNameNote').html('<i>Note: This will override the old file!</i>');
            $('#div_fileUrl').hide();
          }
          else
          {
            $('#div_fileName').hide();
            $('#lbl_fileNameNote').html('');
            $('#div_fileUrl').show();
          }
          $('#txt_fileUrl').val(data['file_url']);
          $('#txt_notes').val(data['notes']);
        }
        else if(action == 'load')
        {
          let documentTitle = data['title'];
          $('#lnk_document').text(documentTitle);
          $('#lnk_document').attr('href',`${baseUrl}/document-preview/${data['id']}`);

          $('#lbl_documentTitle').text(documentTitle);

          let documentUploadLast = data['uploadLast'];
          $('#lbl_documentUploadedLast').text(documentUploadLast);

          let documentDownload = '';
          if(data['type'] == 1)
          {
            documentDownload = `<i class="fa fa-download mr-1" title="Download"></i>
                                <span>
                                  <a href="javascript:void(0)" onclick="DOCUMENTS.downloadDocument(${data['id']},'${data['file_name']}');">Download</a>
                                </span>`;
          }
          else
          {
            documentDownload = `<i class="fa fa-link mr-1" title="Open link in new tab"></i>
                                <span>
                                  <a href="${data['file_url']}" target="_blank">Open link</a>
                                </span>`;
          }
          $('#lbl_documentDownload').html(documentDownload);
        }
      }
    });
  }

  thisDocuments.editDocument = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    formData.set("txt_documentId", $('#txt_documentId').val());
    if($('#slc_uploadtype').val() == 1)
    {
      let files = document.getElementById('file_fileName').files;
      let fileLen = files.length;
      for (var index = 0; index < fileLen; index++) 
      {
         formData.append("file_fileName[]", files[index]);
      }
    }
    $.ajax({
      /* DocumentController->editDocument() */
      url : `${baseUrl}/edit-document`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#modal_document').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Document updated successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/document-preview/${$('#txt_documentId').val()}`);
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

  thisDocuments.downloadDocument = function(documentId, documentFileName)
  {
    if(confirm('Please Confirm!'))
    {
      $('body').waitMe(_waitMeLoaderConfig);
      $.ajax({
        /* DocumentController->downloadDocument() */
        url : `${baseUrl}/download-document`,
        method : 'get',
        dataType: 'json',
        data : {documentId : documentId},
        success : function(data)
        {
          $('body').waitMe('hide');
          let documentFile = `${baseUrl}/public/assets/uploads/documents/${documentFileName}`;
          var a = document.createElement('A');
          a.href = documentFile;
          a.download = documentFile.substr(documentFile.lastIndexOf('/') + 1);
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);

          setTimeout(function(){
            window.location.replace(`${baseUrl}/document-preview/${documentId}`);
          }, 1000);
        }
      });
    }
  }







  //details
  thisDocuments.loadDocumentDetails = function(documentId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DocumentController->selectDocument() */
      url : `${baseUrl}/select-document`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        $('body').waitMe('hide');
        $('#div_details table:eq(0) tbody tr td:eq(1)').text(data['title']);
        $('#div_details table:eq(1) tbody tr td:eq(1)').text(data['assigned_to_name']);
        $('#div_details table:eq(2) tbody tr td:eq(1)').text('/public/assets/uploads/documents/');
        // $('#div_details table:eq(3) tbody tr td:eq(1)').text(data['assigned_to_name']);
        $('#div_details table:eq(4) tbody tr td:eq(1)').text(data['created_date']);
        $('#div_details table:eq(5) tbody tr td:eq(1)').text((data['updated_date'] == null)? '---' : data['updated_date']);
        $('#div_details table:eq(6) tbody tr td:eq(0)').html((data['notes'] == "")? '---' : data['notes']);
        $('#div_details table:eq(7) tbody tr td:eq(1)').html((data['file_name'] == null)? '---' : data['file_name']);
        $('#div_details table:eq(8) tbody tr td:eq(1)').html((data['file_size'] == null)? '---' : data['file_size']);
        $('#div_details table:eq(9) tbody tr td:eq(1)').html((data['file_type'] == null)? '---' : data['file_type']);
        $('#div_details table:eq(10) tbody tr td:eq(1)').html((data['download_count'] == null)? '---' : parseInt(data['download_count']));
      }
    });
  }





  //updates
  thisDocuments.loadDocumentUpdates = function(documentId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DocumentController->loadDocumentUpdates() */
      url : `${baseUrl}/load-document-updates`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        $('body').waitMe('hide');

        let div_documentUpdates = '';
        let createdDate = '';

        data.forEach(function(value,key){

          if(createdDate != value['date_created'])
          {
            div_documentUpdates += `<div class="time-label">
                                      <span class="bg-danger">
                                        ${value['date_created']}
                                      </span>
                                    </div>`;

            div_documentUpdates += `<div>
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

            createdDate = value['date_created'];
          }
          else
          {
            if(value['actions'] == 'Created Contact')
            {
              div_documentUpdates += `<div>
                                        <i class="fas ${value['action_icon']} ${value['action_background']}"></i>
                                        <div class="timeline-item">
                                          <span class="time"><i class="far fa-clock"></i> ${HELPER.dateTimePast(value['created_date'],value['date_now'])}</span>
                                          <h3 class="timeline-header"><a href="#">${value['created_by_name']}</a> ${value['actions']}</h3>
                                        </div>
                                      </div>`;
            }
            else
            {
              div_documentUpdates += `<div>
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

        div_documentUpdates += `<div>
                                  <i class="far fa-clock bg-gray"></i>
                                </div>`;

        $('#div_documentUpdates').html(div_documentUpdates);
      }
    });
  }





  //contacts
  thisDocuments.loadSelectedContactDocuments = function(documentId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DocumentController->loadSelectedContactDocuments() */
      url : `${baseUrl}/load-selected-contact-documents`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        $('body').waitMe('hide');
        let count = 0;
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1">${value['contact_id']}</td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['contact_id']}">${value['first_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['contact_id']}">${value['last_name']}</a></td>
                      <td class="p-1">${value['position']}</td>
                      <td class="p-1"><a href="${baseUrl}/organization-preview/${value['organization_id']}">${value['organization_name']}</a></td>
                      <td class="p-1"><a href="javascript:void(0)" onclick="CONTACTS.selectContactEmail(${value['contact_id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="alert('Coming Soon')" class="mr-2" title="Edit">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="DOCUMENTS.unlinkContactDocument(${value['id']})" title="Unlink">
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

        $(`#tbl_contacts_length`).html(`<button type="button" onclick="DOCUMENTS.selectContactModal(${documentId})" class="btn btn-sm btn-default"><i class="fa fa-user mr-1"></i> Select Contact</button>`);
      
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

  thisDocuments.unlinkContactDocument = function(contactDocumentId)
  {
    if(confirm('Please confirm!'))
    {
      $('body').waitMe(_waitMeLoaderConfig);
      let formData = new FormData();
      formData.set("contactDocumentId", contactDocumentId);
      $.ajax({
        /* ContactController->unlinkContactDocument() */
        url : `${baseUrl}/marketing/unlink-contact-document`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          $('body').waitMe('hide');
          if(result == 'Success')
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Document unlinked successfully.',
            });
            DOCUMENTS.loadSelectedContactDocuments($('#txt_documentId').val());
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

  thisDocuments.selectContactModal = function(documentId)
  {
    $('#modal_selectContact').modal('show');
    $('#btn_addSelectedContacts').prop('disabled',true);
    _arrSelectedContacts = [];
    DOCUMENTS.loadUnlinkContacts(documentId);
  }

  thisDocuments.loadUnlinkContacts = function(documentId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DocumentController->loadUnlinkContacts() */
      url : `${baseUrl}/load-unlink-contacts`,
      method : 'get',
      dataType: 'json',
      data : {documentId:documentId},
      success : function(data)
      {
        $('body').waitMe('hide');
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          tbody += `<tr>
                      <td class="p-1 pl-4"><input type="checkbox" onchange="DOCUMENTS.selectContacts(this)" value="${value['id']}"/></td>
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

  thisDocuments.selectContacts = function(thisCheckBox)
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

  thisDocuments.addSelectedContact = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData();
    formData.set("documentId", $('#txt_documentId').val());
    formData.set("arrSelectedContacts", _arrSelectedContacts);
    $.ajax({
      /* ContactController->addSelectedContactDocuments() */
      url : `${baseUrl}/marketing/add-selected-contact-documents`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#modal_selectContact').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New contact added successfully.',
          });
          DOCUMENTS.loadSelectedContactDocuments($('#txt_documentId').val());
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

  










  //organization
  thisDocuments.loadSelectedOrganizationDocuments = function(documentId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DocumentController->loadSelectedOrganizationDocuments() */
      url : `${baseUrl}/load-selected-organization-documents`,
      method : 'get',
      dataType: 'json',
      data : {documentId : documentId},
      success : function(data)
      {
        $('body').waitMe('hide');
        let count = 0;
        let tbody = '';
        data.forEach(function(value,key){
          let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}/contact-preview/${value['id']}">${value['main_website']}</a>`;
          tbody += `<tr>
                      <td class="p-1">${value['organization_id']}</td>
                      <td class="p-1 pl-4"><a href="${baseUrl}/organization-preview/${value['organization_id']}">${value['organization_name']}</a></td>
                      <td class="p-1"><a href="javascript:void(0)" >${value['primary_email']}</a></td>
                      <td class="p-1">${website}</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">N/A</td>
                      <td class="p-1">${value['assigned_to_name']}</td>
                      <td class="p-1">
                        <a href="javascript:void(0)" onclick="alert('Coming Soon')" class="mr-2" title="Edit">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="DOCUMENTS.unlinkOrganizationDocument(${value['id']})" title="Unlink">
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

        $(`#tbl_organizations_length`).html(`<button type="button" onclick="DOCUMENTS.selectOrganizationModal(${documentId})" class="btn btn-sm btn-default"><i class="fa fa-building mr-1"></i> Select Organization</button>`);
      
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

  thisDocuments.unlinkOrganizationDocument = function(organizationDocumentId)
  {
    if(confirm('Please confirm!'))
    {
      $('body').waitMe(_waitMeLoaderConfig);
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
          $('body').waitMe('hide');
          if(result == 'Success')
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Campaign unlinked successfully.',
            });
            DOCUMENTS.loadSelectedOrganizationDocuments($('#txt_documentId').val());
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

  thisDocuments.selectOrganizationModal = function(documentId)
  {
    $('#modal_selectOrganization').modal('show');
    $('#btn_addSelectedOrganizations').prop('disabled',true);
    _arrSelectedOrganizations = [];
    DOCUMENTS.loadUnlinkOrganizations(documentId);
  }

  thisDocuments.loadUnlinkOrganizations = function(documentId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DocumentController->loadUnlinkOrganizations() */
      url : `${baseUrl}/load-unlink-organizations`,
      method : 'get',
      dataType: 'json',
      data : {documentId:documentId},
      success : function(data)
      {
        $('body').waitMe('hide');
        // Emails
        let tbody = '';
        data.forEach(function(value,key){
          let website = (value['main_website'] == null)? '---' : `<a href="${baseUrl}/contact-preview/${value['id']}">${value['main_website']}</a>`;
          tbody += `<tr>
                      <td class="p-1 pl-4"><input type="checkbox" onchange="DOCUMENTS.selectOrganizations(this)" value="${value['id']}"/></td>
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

  thisDocuments.selectOrganizations = function(thisCheckBox)
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

  thisDocuments.addSelectedOrganization = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData();
    formData.set("documentId", $('#txt_documentId').val());
    formData.set("arrSelectedOrganizations", _arrSelectedOrganizations);
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
        $('body').waitMe('hide');
        $('#modal_selectOrganization').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New organization added successfully.',
          });
          DOCUMENTS.loadSelectedOrganizationDocuments($('#txt_documentId').val());
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

  

  return thisDocuments;

})();