
const CONTACTS = (function(){

	let thisContacts = {};

	let baseUrl = $('#txt_baseUrl').val();

	let _arrSelectedDocuments = []; //global variable
	let _arrSelectedCampaigns = []; //global variable

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

  //test code for uploading pdf
  thisContacts.uploadPdf = function(thisForm)
  {
		let formData = new FormData(thisForm);
		$.ajax({
			/* ContactController->uploadPdf() */
		  url : `${baseUrl}/upload-pdf`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    
		  }
		});
  }

	thisContacts.loadContacts = function()
	{
		$.ajax({
			/* ContactController->loadContacts() */
		  url : `${baseUrl}/marketing/load-contacts`,
		  method : 'get',
		  dataType: 'json',
		  success : function(data)
		  {
		    console.log(data);
		    let tbody = '';
		    data.forEach(function(value,key){
		    	let organizationName = (_arrEmptyValues.includes(value['organization_id']))? '---' : `<a href="${baseUrl}/organization-preview/${value['organization_id']}">${value['organization_name']}</a>`;
		    	
		    	let selectContact = `<a href="javascript:void(0)" onclick="CONTACTS.selectContact('edit',${value['id']})" class="mr-2">
			                          <i class="fa fa-pen"></i>
			                        </a>`;
		    	let deleteContact = `<a href="javascript:void(0)" onclick="CONTACTS.removeContact(${value['id']})" class="text-red">
			                          <i class="fa fa-trash"></i>
			                        </a>`;
		    	tbody += `<tr>
		    							<td class="p-1">${value['id']}</td>
                      <td class="p-1 pl-4">${value['salutation']}</td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['id']}">${value['first_name']}</a></td>
                      <td class="p-1"><a href="${baseUrl}/contact-preview/${value['id']}">${value['last_name']}</a></td>
                      <td class="p-1">${(_arrEmptyValues.includes(value['position']))? '---' : value['position']}</td>
                      <td class="p-1">${organizationName}</td>
                      <td class="p-1"><a href="javascript:void(0)" onclick="CONTACTS.selectContactEmail(${value['id']},'${value['primary_email']}')">${value['primary_email']}</a></td>
                      <td class="p-1">${(_arrEmptyValues.includes(value['assigned_to']))? '---' : value['assigned_to']}</td>
                      <td class="p-1">
                        ${($('#txt_updateContact').val() == '1')? selectContact:''}
                        ${($('#txt_deleteContact').val() == '1')? deleteContact:''}
                      </td>
                    </tr>`;
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
		  }
		});
	}

	thisContacts.loadUsers = function(elemId, userId = '')
	{
	  $.ajax({
	    /* ContactController->loadUsers() */
	    url : `${baseUrl}/marketing/contacts/load-users`,
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

	thisContacts.loadOrganizations = function(elemId, organizationId = '')
	{
	  $.ajax({
	    /* OrganizationController->loadOrganizations() */
	    url : `${baseUrl}/marketing/load-organizations`,
	    method : 'get',
	    dataType: 'json',
	    success : function(data)
	    {
	      console.log(data);
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
	  });
	}

	thisContacts.uploadContactPicturePreview = function(imageFile)
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
	                       src="${baseUrl}/public/assets/img/user-placeholder.png"
	                       alt="User profile picture">`);

	    $('#lbl_fileName').html('');
	    $('#lbl_fileSize').html('');
	    $('#lbl_fileStatus').html('');

	    $('#div_imageDetails').hide();

	    alert('Please select image file.');
	  }
	}

	thisContacts.loadContactSubstitutions = function()
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

	thisContacts.loadOrganizationSubstitutions = function()
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

	thisContacts.addContact = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("chk_doNotCall", ($('#chk_doNotCall').is(':checked'))? 1 : 0);
		formData.append("profilePicture", $('#file_profilePicture')[0].files[0]);

		$.ajax({
			/* ContactController->addContact() */
		  url : `${baseUrl}/marketing/add-contact`,
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
            window.location.replace(`${baseUrl}/contacts`);
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

	thisContacts.selectContact = function(action, contactId)
	{
		$.ajax({
			/* ContactController->selectContact() */
		  url : `${baseUrl}/marketing/select-contact`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
	    	if(action == 'edit')
	    	{
	        $('#lbl_stateContact span').text('Edit Contact');
	        $('#lbl_stateContact i').removeClass('fa-plus');
	        $('#lbl_stateContact i').addClass('fa-pen');
	    		$('#modal_contact').modal({backdrop:'static',keyboard: false});
	    		$('#txt_contactId').val(contactId);

	    		$('#slc_salutation').val(data['salutation']);
	    		$('#txt_firstName').val(data['first_name']);
	    		$('#txt_lastName').val(data['last_name']);
	    		$('#txt_position').val(data['position']);
	    		CONTACTS.loadOrganizations('#slc_companyName', data['organization_id']);
	    		$('#txt_primaryEmail').val(data['primary_email']);
	    		$('#txt_secondaryEmail').val(data['secondary_email']);
	    		$('#txt_birthDate').val(data['date_of_birth']);
	    		$('#slc_introLetter').val(data['intro_letter']);
	    		$('#txt_officePhone').val(data['office_phone']);
	    		$('#txt_mobilePhone').val(data['mobile_phone']);
	    		$('#txt_homePhone').val(data['home_phone']);
	    		$('#txt_secondaryPhone').val(data['secondary_email']);
	    		$('#txt_fax').val(data['fax']);
	    		$('#chk_doNotCall').prop('checked',(data['do_not_call'] == 1)? true : false);
	    		$('#txt_linkedinUrl').val(data['linkedin_url']);
	    		$('#txt_twitterUrl').val(data['twitter_url']);
	    		$('#txt_facebookUrl').val(data['facebook_url']);
	    		$('#txt_instagramUrl').val(data['instagram_url']);
	    		$('#slc_leadSource').val(data['lead_source']);
	    		$('#txt_department').val(data['department']);
	    		// CONTACTS.loadUsers('#slc_reportsTo', data['reports_to']);
       		CONTACTS.loadUsers('#slc_assignedTo', data['assigned_to']);
	    		$('#slc_emailOptOut').val(data['email_opt_out']);

	    		$('#txt_mailingStreet').val(data['mailing_street']);
	    		$('#txt_mailingPOBox').val(data['mailing_po_box']);
	    		$('#txt_mailingCity').val(data['mailing_city']);
	    		$('#txt_mailingState').val(data['mailing_state']);
	    		$('#txt_mailingZip').val(data['mailing_zip']);
	    		$('#txt_mailingCountry').val(data['mailing_country']);
	    		$('#txt_otherStreet').val(data['other_street']);
	    		$('#txt_otherPOBox').val(data['other_po_box']);
	    		$('#txt_otherCity').val(data['other_city']);
	    		$('#txt_otherState').val(data['other_state']);
	    		$('#txt_otherZip').val(data['other_zip']);
	    		$('#txt_otherCountry').val(data['other_country']);

	    		$('#txt_description').val(data['description']);

	    		if(data['picture'] != null)
	    		{
	    			$('#img_profilePicture').prop('src',`${baseUrl}/public/assets/uploads/images/contacts/${data['picture']}`);
	    			$('#lbl_fileName').text(data['picture']);
	    		}	    		
	    	}
	    	else if(action == 'load')
	    	{
	    		if(data['picture'] != null)
	    		{
	    			$('#img_contactProfilePicture').prop('src',`${baseUrl}/public/assets/uploads/images/contacts/${data['picture']}`);
	    		}
	    		
	    		let contactName = `${data['first_name']} ${data['last_name']}`;
	    		$('#lnk_contact').text(contactName);
	    		$('#lnk_contact').attr('href',`${baseUrl}/contact-preview/${data['id']}`);

	    		let contactFullName = `${data['salutation']} ${data['first_name']} ${data['last_name']}`;
	    		$('#lbl_contactName').text(contactFullName);
   		
	    		let contactPosition = (_arrEmptyValues.includes(data['position']))? '---' : data['position'];
	    		$('#lbl_contactPosition').text(contactPosition);

	    		let contactEmail = (_arrEmptyValues.includes(data['primary_email']))? '---' : data['primary_email'];
	    		$('#lbl_contactEmail').text(contactEmail);
	    	}
		  }
		});
	}

	thisContacts.editContact = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("txt_contactId", $('#txt_contactId').val());
		formData.set("chk_doNotCall", ($('#chk_doNotCall').is(':checked'))? 1 : 0);

		formData.append("profilePicture", $('#file_profilePicture')[0].files[0]);

		$.ajax({
			/* ContactController->editContact() */
		  url : `${baseUrl}/marketing/edit-contact`,
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
		        title: 'Success! <br>Contact updated successfully.',
		      });
		      setTimeout(function(){
            window.location.replace(`${baseUrl}/contact-preview/${$('#txt_contactId').val()}`);
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

	thisContacts.removeContact = function(contactId)
	{
		if(confirm('Please Confirm'))
		{
			let formData = new FormData();

			formData.set("contactId", contactId);

			$.ajax({
				/* ContactController->removeContact() */
			  url : `${baseUrl}/marketing/remove-contact`,
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
			        title: 'Success! <br>Contact removed successfully.',
			      });
			      setTimeout(function(){
	            window.location.replace(`${baseUrl}/contacts`);
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

	thisContacts.checkCSVFile = function(thisInput)
	{
		var fileName = thisInput.files[0].name;

		let formData = new FormData();
		formData.set('contactList',thisInput.files[0],fileName);
		
		$('#lbl_loader').show();
		$('#div_checkResult').hide();
		$('#div_errorResult').hide();
		$('#btn_submitContactList').prop('disabled',true);
		$.ajax({
			// ContactController->checkContactFile
			url : `${baseUrl}/rolodex/check-contact-file`,
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
						
					$('#lnk_download').attr('href',`${baseUrl}/rolodex/contact-conflicts/${trafficFilterHolder}`);

					if(forInsert != 0)
					{
						$('#btn_submitContactList').prop('disabled',false);
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

	thisContacts.uploadContacts = function()
	{
		$('#lbl_uploadingProgress').show();
		if(confirm("Please confirm!"))
		{
			let rawData = __arrFileResult;
			$.ajax({
				// ContactController->uploadContacts
				url : `${baseUrl}/rolodex/upload-contacts`,
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

	//start of details

	//summary
	thisContacts.loadContactSummary = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactSummary() */
		  url : `${baseUrl}/marketing/load-contact-summary`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Summary
    		$('#lbl_firstName').text((_arrEmptyValues.includes(data['first_name']))? '---' : data['first_name']);
    		$('#lbl_lastName').text((_arrEmptyValues.includes(data['last_name']))? '---' : data['last_name']);
    		$('#lbl_position').text((_arrEmptyValues.includes(data['position']))? '---' : data['position']);
    		let organizationName = (_arrEmptyValues.includes(data['organization_name']))? '---' : `<a href="${baseUrl}/organization-preview/${data['organization_id']}" target="_blank">
    															${data['organization_name']}
    														</a>`;
    		$('#lbl_organizationName').html(organizationName);
    		$('#lbl_assignedTo').text((_arrEmptyValues.includes(data['assigned_to']))? '---' : data['assigned_to']);
    		$('#lbl_mailingCity').text((_arrEmptyValues.includes(data['mailing_city']))? '---' : data['mailing_city']);
    		$('#lbl_mailingCountry').text((_arrEmptyValues.includes(data['mailing_country']))? '---' : data['mailing_country']);
		  }
		});
	}

	thisContacts.loadContactDocumentSummary = function(contactId)
	{
		
	}

	thisContacts.loadContactActivitySummary = function(contactId)
	{

	}

	thisContacts.loadContactCommentSummary = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactComments() */
		  url : `${baseUrl}/marketing/load-contact-comments`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		  	console.log(data);

		  	let divCommentSummary = '';
		  	
		    data.forEach(function(value, index){
		    	if(value['comment_id'] == null)
		    	{
		    		let imgSrc = (value['user_picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${value['user_picture']}`;
	    			divCommentSummary += `<div class="card-comment p-1">
				    		                    <img class="img-circle img-sm img-bordered" src="${imgSrc}" alt="User Image">
				    		                    <div class="comment-text">
				    		                      <span class="username">
			                                ${value['created_by_name']}
			                                <span class="text-muted float-right">${value['created_date']}</span>
			                                </span>
			                                <div class="p-2 mt-1 mb-1 bg-light" style="border-radius: 5px;">${value['comment']}</div>
			                                <a href="#" class="mr-2">Like</a>
				    		                      <a href="javascript:void(0)" onclick="CONTACTS.replyCommentSummary(this,${value['id']})" class="mr-2">Reply</a>
				    		                      <span>${HELPER.dateTimePast(value['created_date'], value['date_now'])}</span>
				    		                      <div class="div_replyToComment"></div>
				    		                      ${CONTACTS.loadContactCommentReplySummary(value['id'], data)}
				    		                    </div>
				    		                  </div>`;
		    	}
		    });

		    $('#tbl_recentComments tbody tr td #div_loadCommentSummary').html(divCommentSummary);
		  }
		});
	}

	thisContacts.loadContactCommentReplySummary = function(commentId, data)
	{
		let	devReplyCommentSummary = '';
		data.forEach(function(value, index){
			if(commentId == value['comment_id'])
			{
				let imgSrc = (value['user_picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${value['user_picture']}`;
				devReplyCommentSummary += `<div class="ml-3 pt-1">
                              <div class="card-comment p-0">
                                <img class="img-circle img-sm img-bordered" src="${imgSrc}" alt="User Image">
                                <div class="comment-text">
                                  <span class="username">
                                  ${value['created_by_name']}
                                  <span class="text-muted float-right">${value['created_date']}</span>
                                  </span>
                                  <div class="p-2 mt-1 mb-1 bg-light" style="border-radius: 5px;">${value['comment']}</div>
                                  <a href="#" class="mr-2">Like</a>
                                  <a href="javascript:void(0)" onclick="CONTACTS.replyCommentSummary(this,${value['id']})" class="mr-2">Reply</a>
                                  <span>${HELPER.dateTimePast(value['created_date'], value['date_now'])}</span>
                                  <div class="div_replyToComment"></div>
                                  ${CONTACTS.loadContactCommentReplySummary(value['id'], data)}
                                </div>
                              </div>
                            </div>`;
			}
		});

		return devReplyCommentSummary;
	}

	thisContacts.addContactCommentSummary = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("txt_contactId", $('#txt_contactId').val());

		$.ajax({
			/* ContactController->addContactCommentSummary() */
		  url : `${baseUrl}/marketing/add-contact-comment-summary`,
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
		    CONTACTS.loadContactCommentSummary($('#txt_contactId').val());
		  }
		});
	}

	thisContacts.replyCommentSummary = function(elem,commentId)
	{
		let formComment = `<div class="card card-info" style="box-shadow: none;">
                        <form class="form-horizontal" id="form_replyToComment">
													<input type="hidden" id="txt_replyCommentId" name="txt_replyCommentId" value="${commentId}">
	                        <div class="card-body" style="padding: 0px;">
                            <textarea class="form-control mb-1" rows="3" id="txt_replyComments" name="txt_replyComments" placeholder="Type to compose" required></textarea>
                          </div>
                          <div class="card-footer" style="background-color: white; padding: 0px;">
                            <button type="button" onclick="CONTACTS.replyContactCommentSummary();" class="btn btn-sm btn-primary float-right">Post Comment</button>
                          </div>
                        </form>
                      </div>`;
    $('.div_replyToComment').html('');       
    $(elem).closest('div').find('.div_replyToComment:eq(0)').html(formComment);  
    $('#txt_replyComments').focus();            
	}

	thisContacts.replyContactCommentSummary = function()
	{
		let formData = new FormData();

		formData.set("txt_contactId", $('#txt_contactId').val());
		formData.set("txt_replyCommentId", $('#txt_replyCommentId').val());
		formData.set("txt_replyComments", $('#txt_replyComments').val());

		$.ajax({
			/* ContactController->replyContactComment() */
		  url : `${baseUrl}/marketing/reply-contact-comment`,
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
		    CONTACTS.loadContactCommentSummary($('#txt_contactId').val());
		  }
		});
	}

	//details
	thisContacts.loadContactDetails = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactDetails() */
		  url : `${baseUrl}/marketing/load-contact-details`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
    		let orgName = (_arrEmptyValues.includes(data['organization_id']))? '---' : `<a href="${baseUrl}/organization-preview/${data['organization_id']}">${data['organization_name']}</a>`;
    		
    		$('#div_details table:eq(0) tbody tr td:eq(1)').html(`${data['salutation']} ${data['first_name']}`);
    		$('#div_details table:eq(1) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['last_name']))? '---' : data['last_name']);
    		$('#div_details table:eq(2) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['position']))? '---' : data['position']);
    		$('#div_details table:eq(3) tbody tr td:eq(1)').html(orgName);
    		$('#div_details table:eq(4) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['primary_email']))? '---' : data['primary_email']);
    		$('#div_details table:eq(5) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['secondary_email']))? '---' : data['secondary_email']);
    		$('#div_details table:eq(6) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['date_of_birth']))? '---' : data['date_of_birth']);
    		$('#div_details table:eq(7) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['intro_letter']))? '---' : data['intro_letter']);
    		$('#div_details table:eq(8) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['office_phone']))? '---' : data['office_phone']);
    		$('#div_details table:eq(9) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['mobile_phone']))? '---' : data['mobile_phone']);
    		$('#div_details table:eq(10) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['home_phone']))? '---' : data['home_phone']);
    		$('#div_details table:eq(11) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['secondary_phone']))? '---' : data['secondary_phone']);
    		$('#div_details table:eq(12) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['fax']))? '---' : data['fax']);
    		$('#div_details table:eq(13) tbody tr td:eq(1)').html((data['do_not_call'] == 0)? 'No':'Yes');
    		$('#div_details table:eq(14) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['linkedin_url']))? '---' : data['linkedin_url']);
    		$('#div_details table:eq(15) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['twitter_url']))? '---' : data['twitter_url']);
    		$('#div_details table:eq(16) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['facebook_url']))? '---' : data['facebook_url']);
    		$('#div_details table:eq(17) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['instagram_url']))? '---' : data['instagram_url']);
    		$('#div_details table:eq(18) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['lead_source']))? '---' : data['lead_source']);
    		$('#div_details table:eq(19) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['department']))? '---' : data['department']);
    		$('#div_details table:eq(20) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['reports_to_name']))? '---' : data['reports_to_name']);
    		$('#div_details table:eq(21) tbody tr td:eq(1)').html((_arrEmptyValues.includes(data['assigned_to_name']))? '---' : data['assigned_to_name']);
    		$('#div_details table:eq(22) tbody tr td:eq(1)').html((data['email_opt_out'] == 0)? 'No':'Yes');

    		$('#div_details table:eq(23) tbody tr:eq(0) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_street']))? '---' : data['mailing_street']);
    		$('#div_details table:eq(23) tbody tr:eq(1) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_po_box']))? '---' : data['mailing_po_box']);
    		$('#div_details table:eq(23) tbody tr:eq(2) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_city']))? '---' : data['mailing_city']);
    		$('#div_details table:eq(23) tbody tr:eq(3) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_state']))? '---' : data['mailing_state']);
    		$('#div_details table:eq(23) tbody tr:eq(4) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_zip']))? '---' : data['mailing_zip']);
    		$('#div_details table:eq(23) tbody tr:eq(5) td:eq(1)').html((_arrEmptyValues.includes(data['mailing_country']))? '---' : data['mailing_country']);

    		$('#div_details table:eq(24) tbody tr:eq(0) td:eq(1)').html((_arrEmptyValues.includes(data['other_street']))? '---' : data['other_street']);
    		$('#div_details table:eq(24) tbody tr:eq(1) td:eq(1)').html((_arrEmptyValues.includes(data['other_po_box']))? '---' : data['other_po_box']);
    		$('#div_details table:eq(24) tbody tr:eq(2) td:eq(1)').html((_arrEmptyValues.includes(data['other_city']))? '---' : data['other_city']);
    		$('#div_details table:eq(24) tbody tr:eq(3) td:eq(1)').html((_arrEmptyValues.includes(data['other_state']))? '---' : data['other_state']);
    		$('#div_details table:eq(24) tbody tr:eq(4) td:eq(1)').html((_arrEmptyValues.includes(data['other_zip']))? '---' : data['other_zip']);
    		$('#div_details table:eq(24) tbody tr:eq(5) td:eq(1)').html((_arrEmptyValues.includes(data['other_country']))? '---' : data['other_country']);

    		$('#div_details table:eq(25) tbody tr td').html((_arrEmptyValues.includes(data['description']))? '---' : data['description']);
		  }
		});
	}

	//updates
	thisContacts.loadContactUpdates = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactUpdates() */
		  url : `${baseUrl}/marketing/load-contact-updates`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
    		console.log(data);

    		let div_contactUpdates = '';
				let createdDate = '';

				data.forEach(function(value,key){

					let actionDetails = ``;

					if(value['actions'].replace(/\s/g,'-') == 'Created-Contact')
					{
						var salutation  = `${value['action_details']['salutation']}`;
						var firstName   = `${value['action_details']['first_name']}`;
						var lastName    = `${value['action_details']['last_name']}`;
						actionDetails += `<span><b>Contact Name : </b> ${salutation} ${firstName} ${lastName}</span><br>`;
						actionDetails += `<span><b>Position : </b> ${value['action_details']['position']}</span><br>`;
						actionDetails += `<span><b>Primary Email : </b> ${value['action_details']['primary_email']}</span><br>`;
						
						// actionDetails += `<a href="javascript:void(0)"><i>More details ...</i></a>`;
					}

					if(value['actions'].replace(/\s/g,'-') == 'Quick-Create-Contact')
					{
						var salutation  = `${value['action_details']['salutation']}`;
						var firstName   = `${value['action_details']['first_name']}`;
						var lastName    = `${value['action_details']['last_name']}`;
						actionDetails += `<span><b>Contact Name : </b> ${salutation} ${firstName} ${lastName}</span><br>`;
						actionDetails += `<span><b>Primary Email : </b> ${value['action_details']['primary_email']}</span><br>`;
						
						// actionDetails += `<a href="javascript:void(0)"><i>More details ...</i></a>`;
					}

					if(value['actions'].replace(/\s/g,'-') == 'Updated-Contact')
					{
						var salutation  = `${value['action_details']['salutation']}`;
						var firstName   = `${value['action_details']['first_name']}`;
						var lastName    = `${value['action_details']['last_name']}`;
						actionDetails += `<span><b>Contact Name : </b> ${salutation} ${firstName} ${lastName}</span><br>`;
						actionDetails += `<span><b>Position : </b> ${value['action_details']['position']}</span><br>`;
						actionDetails += `<span><b>Primary Email : </b> ${value['action_details']['primary_email']}</span><br>`;
						
						// actionDetails += `<a href="javascript:void(0)"><i>More details ...</i></a>`;
					}

					if(value['actions'].replace(/\s/g,'-') == 'Linked-Contact-To-Organization')
					{
						actionDetails += `<span><b>Organization Name : </b> <a href="${baseUrl}/organization-preview/${value['action_details']['organization_id']}" target="_blank">${value['action_details']['organization_name']}</a></span><br>`;
					}

					if(value['actions'].replace(/\s/g,'-') == 'Unlinked-Contact-From-Organization')
					{
						actionDetails += `<span><b>Organization Name : </b> <a href="${baseUrl}/organization-preview/${value['action_details']['organization_id']}" target="_blank">${value['action_details']['organization_name']}</a></span><br>`;
					}

					if(value['actions'].replace(/\s/g,'-') == 'Sent-Email')
					{
						actionDetails += `<span><b>Subject : </b> ${value['action_details']['email_subject']}</span><br>`;
						actionDetails += `<span><b>Contect : </b></span> <div style="width:100%; background-color:#E4E4E4; padding:5px;">${value['action_details']['email_content']}</div>`;
						actionDetails += `<span><b>Status : </b> ${value['action_details']['email_status']}</span><br>`;
						actionDetails += `<span><b>Date & Time : </b> ${value['created_date']}</span><br>`;
					}

					if(value['actions'].replace(/\s/g,'-') == 'Linked-Contact-Document')
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

					if(value['actions'].replace(/\s/g,'-') == 'Unlinked-Contact-Document')
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

					if(value['actions'].replace(/\s/g,'-') == 'Linked-Contact-Campaign')
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

					if(value['actions'].replace(/\s/g,'-') == 'Unlinked-Contact-Campaign')
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
						div_contactUpdates += `<div class="time-label">
							                        <span class="bg-danger">
							                          ${value['date_created']}
							                        </span>
							                      </div>`;

						div_contactUpdates += `<div>
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
						// if(value['actions'] == 'Created Contact')
						// {
						// 	div_contactUpdates += `<div>
						// 		                        <i class="fas ${value['action_icon']} ${value['action_background']}"></i>
						// 		                        <div class="timeline-item">
						// 		                          <span class="time"><i class="far fa-clock"></i> ${HELPER.dateTimePast(value['created_date'],value['date_now'])}</span>
						// 		                          <h3 class="timeline-header"><a href="#">${value['created_by_name']}</a> ${value['actions']}</h3>
						// 		                        	<div class="timeline-body">
						// 		                        	  asdasd${value['action_details']}
						// 		                        	</div>
						// 		                        </div>
						// 		                      </div>`;
						// }
						// else
						// {
							
						// }
						div_contactUpdates += `<div>
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

				div_contactUpdates += `<div>
					                        <i class="far fa-clock bg-gray"></i>
					                      </div>`;

				$('#div_contactUpdates').html(div_contactUpdates);
    	}
		});
	}

	//Activities
	thisContacts.loadContactActivities = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactActivities() */
		  url : `${baseUrl}/marketing/load-contact-activities`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Activities
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
	                    <td class="p-1">Action</td>
	                  </tr>`;
	        count++;
		    });

		    $('#tbl_contactActivities').DataTable().destroy();
		    $('#tbl_contactActivities tbody').html(tbody);
		    $('#tbl_contactActivities').DataTable({
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

		    let buttons = `<button type="button" onclick="CONTACTS.addEventModal(${contactId})" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> Add Event</button>
		    								<button type="button" onclick="CONTACTS.addTaskModal(${contactId})" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> Add Task</button>`;

		    $(`#tbl_contactActivities_length`).html(buttons);

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

	thisContacts.addEventModal = function(contactId)
	{
		$('#modal_events').modal({backdrop:'static',keyboard: false});
	}

	thisContacts.addEvent = function(thisForm)
	{
		alert('In Progress!');
	}

	thisContacts.addTaskModal = function(contactId)
	{
		$('#modal_tasks').modal({backdrop:'static',keyboard: false});
	}

	thisContacts.addTask = function(thisForm)
	{
		alert('In Progress!');
	}

	//emails
	thisContacts.loadContactEmails = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactEmails() */
		  url : `${baseUrl}/marketing/load-contact-emails`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
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

		    $('#tbl_contactEmails').DataTable().destroy();
		    $('#tbl_contactEmails tbody').html(tbody);
		    $('#tbl_contactEmails').DataTable({
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
	thisContacts.loadContactDocuments = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactDocuments() */
		  url : `${baseUrl}/marketing/load-contact-documents`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		    console.log(data);
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
		    	let documentPreview = `<a href="${baseUrl}/document-preview/${value['document_id']}">${value['title']}</a>`;
		    	tbody += `<tr>
	                    <td class="p-1">${value['id']}</td>
	                    <td class="p-1 pl-4">${documentPreview}</td>
	                    <td class="p-1">${fileLink}</td>
	                    <td class="p-1">${value['created_date']}</td>
	                    <td class="p-1">${value['assigned_to_name']}</td>
	                    <td class="p-1">${(_arrEmptyValues.includes(value['download_count']))? 0 : value['download_count']}</td>
	                    <td class="p-1">
	                    	${downloadLink}
	                    	<a href="javascript:void(0)" onclick="CONTACTS.unlinkContactDocument(${value['id']})" title="Unlink">
	                    	  <i class="fa fa-unlink"></i>
	                    	</a>
	                    </td>
	                  </tr>`;
	        count++;
		    });

		    $('#tbl_contactDocuments').DataTable().destroy();
		    $('#tbl_contactDocuments tbody').html(tbody);
		    $('#tbl_contactDocuments').DataTable({
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

		    let buttons = `<button type="button" onclick="CONTACTS.selectDocumentModal(${contactId})" class="btn btn-sm btn-default"><i class="fa fa-file mr-1"></i> Select Documents</button>
		    								<button type="button" onclick="CONTACTS.addDocumentModal()" class="btn btn-sm btn-default"><i class="fa fa-plus mr-1"></i> New Document</button>`;

		    $(`#tbl_contactDocuments_length`).html(buttons);

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

	thisContacts.unlinkContactDocument = function(contactDocumentId)
	{
		if(confirm('Please confirm!'))
		{
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
			    console.log(result);
			    if(result == 'Success')
			    {
	          Toast.fire({
			        icon: 'success',
			        title: 'Success! <br>Document unlinked successfully.',
			      });
			      CONTACTS.loadContactDocuments($('#txt_contactId').val());
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

	thisContacts.selectDocumentModal = function(contactId)
	{
		$('#modal_selectDocuments').modal({backdrop:'static',keyboard: false});
		$('#btn_addSelectedDocuments').prop('disabled',true);
		_arrSelectedDocuments = [];
		CONTACTS.loadUnlinkContactDocuments(contactId);
	}

	thisContacts.loadUnlinkContactDocuments = function(contactId)
	{
		$.ajax({
			/* ContactController->loadUnlinkContactDocuments() */
		  url : `${baseUrl}/marketing/load-unlink-contact-documents`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId:contactId},
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
	                    <td class="p-1 pl-4"><input type="checkbox" onchange="CONTACTS.selectDocuments(this)" value="${value['id']}"/></td>
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

	thisContacts.selectDocuments = function(thisCheckBox)
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

	thisContacts.addSelectedDocuments = function()
	{
		let formData = new FormData();

		formData.set("contactId", $('#txt_contactId').val());
		formData.set("arrSelectedDocuments", _arrSelectedDocuments);

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
		    console.log(result);
		    $('#modal_selectDocuments').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>New document/s added successfully.',
		      });
		      CONTACTS.loadContactDocuments($('#txt_contactId').val());
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

	thisContacts.addDocumentModal = function()
	{
		$('#div_fileName').hide();
		$('#div_fileUrl').hide();
		CONTACTS.loadUsers('#slc_assignedToDocument');
		$('#modal_addDocument').modal({backdrop:'static',keyboard: false});
	}

	thisContacts.addContactDocument = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("txt_contactId", $('#txt_contactId').val());

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
			/* ContactController->addContactDocument() */
		  url : `${baseUrl}/marketing/add-contact-document`,
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
            CONTACTS.loadContactDocuments($('#txt_contactId').val());
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

	//campaigns
	thisContacts.loadContactCampaigns = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactCampaigns() */
		  url : `${baseUrl}/marketing/load-contact-campaigns`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
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
	                    	<a href="javascript:void(0)" onclick="CONTACTS.unlinkContactCampaign(${value['id']})" title="Unlink">
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

		    $(`#tbl_campaigns_length`).html(`<button type="button" onclick="CONTACTS.selectCampaignModal(${contactId})" class="btn btn-sm btn-default"><i class="fa fa-bullhorn mr-1"></i> Select Campaigns</button>`);
		  
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

	thisContacts.unlinkContactCampaign = function(contactCampaignId)
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
			      CONTACTS.loadContactCampaigns($('#txt_contactId').val());
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

	thisContacts.selectCampaignModal = function(contactId)
	{
		$('#modal_selectCampaigns').modal({backdrop:'static',keyboard: false});
		$('#btn_addSelectedCampaigns').prop('disabled',true);
		_arrSelectedCampaigns = [];
		CONTACTS.loadUnlinkContactCampaigns(contactId);
	}

	thisContacts.loadUnlinkContactCampaigns = function(contactId)
	{
		$.ajax({
			/* ContactController->loadUnlinkContactCampaigns() */
		  url : `${baseUrl}/marketing/load-unlink-contact-campaigns`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId:contactId},
		  success : function(data)
		  {
		    console.log(data);
    		// Emails
		    let tbody = '';
		    data.forEach(function(value,key){
		    	tbody += `<tr>
	                    <td class="p-1 pl-4"><input type="checkbox" onchange="CONTACTS.selectCampaigns(this)" value="${value['id']}"/></td>
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

	thisContacts.selectCampaigns = function(thisCheckBox)
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

	thisContacts.addSelectedCampaigns = function()
	{
		let formData = new FormData();

		formData.set("contactId", $('#txt_contactId').val());
		formData.set("arrSelectedCampaigns", _arrSelectedCampaigns);

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
		    $('#modal_selectCampaigns').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>New campaign/s added successfully.',
		      });
		      CONTACTS.loadContactCampaigns($('#txt_contactId').val());
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


	//comments
	thisContacts.loadContactComments = function(contactId)
	{
		$.ajax({
			/* ContactController->loadContactComments() */
		  url : `${baseUrl}/marketing/load-contact-comments`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId},
		  success : function(data)
		  {
		  	console.log(data);

		  	let divComments = '';
		    data.forEach(function(value, index){
		    	if(value['comment_id'] == null)
		    	{
		    		let imgSrc = (value['user_picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${value['user_picture']}`;
	    			divComments += `<div class="card-comment p-1">
	    		                    <img class="img-circle img-sm img-bordered" src="${imgSrc}" alt="User Image">
	    		                    <div class="comment-text">
	    		                      <span class="username">
                                ${value['created_by_name']}
                                <span class="text-muted float-right">${value['created_date']}</span>
                                </span>
                                <div class="p-2 mt-1 mb-1 bg-light" style="border-radius: 5px;">${value['comment']}</div>
                                <a href="#" class="mr-2">Like</a>
	    		                      <a href="javascript:void(0)" onclick="CONTACTS.replyComment(this,${value['id']})" class="mr-2">Reply</a>
	    		                      <span>${HELPER.dateTimePast(value['created_date'], value['date_now'])}</span>
	    		                      <div class="div_replyToComment"></div>
	    		                      ${CONTACTS.loadContactCommentReplies(value['id'], data)}
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

	thisContacts.loadContactCommentReplies = function(commentId, data)
	{
		let	devReplyComments = '';
		data.forEach(function(value, index){
			if(commentId == value['comment_id'])
			{
				let imgSrc = (value['user_picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${value['user_picture']}`;
	    	devReplyComments += `<div class="ml-3 pt-1">
                              <div class="card-comment p-0">
                                <img class="img-circle img-sm img-bordered" src="${imgSrc}" alt="User Image">
                                <div class="comment-text">
                                  <span class="username">
                                  ${value['created_by_name']}
                                  <span class="text-muted float-right">${value['created_date']}</span>
                                  </span>
                                  <div class="p-2 mt-1 mb-1 bg-light" style="border-radius: 5px;">${value['comment']}</div>
                                  <a href="#" class="mr-2">Like</a>
                                  <a href="javascript:void(0)" onclick="CONTACTS.replyComment(this,${value['id']})" class="mr-2">Reply</a>
                                  <span>${HELPER.dateTimePast(value['created_date'], value['date_now'])}</span>
                                  <div class="div_replyToComment"></div>
                                  ${CONTACTS.loadContactCommentReplies(value['id'], data)}
                                </div>
                              </div>
                            </div>`;
			}
		});

		return devReplyComments;                      
	}

	thisContacts.addContactComment = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("txt_contactId", $('#txt_contactId').val());

		$.ajax({
			/* ContactController->addContactComment() */
		  url : `${baseUrl}/marketing/add-contact-comment`,
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
		    CONTACTS.loadContactComments($('#txt_contactId').val());
		  }
		});
	}

	thisContacts.replyComment = function(elem,commentId)
	{
		let formComment = `<div class="card card-info" style="box-shadow: none;">
                        <form class="form-horizontal" id="form_replyToComment">
													<input type="hidden" id="txt_replyCommentId" name="txt_replyCommentId" value="${commentId}">
	                        <div class="card-body" style="padding: 0px;">
                            <textarea class="form-control mb-1" rows="3" id="txt_replyComments" name="txt_replyComments" placeholder="Type to compose" required></textarea>
                          </div>
                          <div class="card-footer" style="background-color: white; padding: 0px;">
                            <button type="button" onclick="CONTACTS.replyContactComment();" class="btn btn-sm btn-primary float-right">Post Comment</button>
                          </div>
                        </form>
                      </div>`;
    $('.div_replyToComment').html('');       
    $(elem).closest('div').find('.div_replyToComment:eq(0)').html(formComment);  
    $('#txt_replyComments').focus();            
	}

	thisContacts.replyContactComment = function()
	{
		let formData = new FormData();

		formData.set("txt_contactId", $('#txt_contactId').val());
		formData.set("txt_replyCommentId", $('#txt_replyCommentId').val());
		formData.set("txt_replyComments", $('#txt_replyComments').val());

		$.ajax({
			/* ContactController->replyContactComment() */
		  url : `${baseUrl}/marketing/reply-contact-comment`,
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
		    CONTACTS.loadContactComments($('#txt_contactId').val());
		  }
		});
	}


	//Sending Email
	thisContacts.selectEmailConfig = function(from, contactId=null, contactEmail=null)
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
        	CONTACTS.loadEmailTemplates();
        	if(from == 'contact-form')
        	{
        		$('#txt_to').val($('#lbl_contactEmail').text());
        	}
        	else
        	{
        		$('#txt_contactId').val(contactId);
        		$('#txt_to').val(contactEmail);
        	}
        	$('#txt_subject').val('');
        	$('#txt_content').summernote('destroy');
        	$('#txt_content').val('');
        	$('#txt_content').summernote(summernoteConfig);
        	CONTACTS.loadContactSubstitutions();
        	CONTACTS.loadOrganizationSubstitutions();
        	$('#modal_sendContactEmail').modal({backdrop:'static',keyboard: false});
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

	thisContacts.selectContactEmail = function(contactId, contactEmail)
	{
		CONTACTS.selectEmailConfig('contact-list', contactId, contactEmail);
	}

	thisContacts.loadEmailTemplates = function()
	{
		$.ajax({
		  /* EmailTemplateController->loadTemplates() */
		  url : `${baseUrl}/tools/load-templates/Contacts`,
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

	thisContacts.selectEmailTemplate = function(contactId,templateId)
	{
		$.ajax({
		  /* ContactController->selectEmailTemplate() */
		  url : `${baseUrl}/marketing/select-contact-email-template`,
		  method : 'get',
		  dataType: 'json',
		  data : {contactId : contactId, templateId : templateId},
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

	thisContacts.sendContactEmail = function(thisForm)
	{
		let formData = new FormData(thisForm);

		formData.set("txt_contactId", $('#txt_contactId').val());

		if($('#chk_unsubscribe').is(':checked'))
		{
			formData.set("chk_unsubscribe", 1);
		}

		$('#btn_sendContactEmail').html('<i class="fa fa-paper-plane mr-1"></i> Sending...');
		$('#btn_sendContactEmail').prop('disabled',true);

		$.ajax({
			/* ContactController->sendContactEmail() */
		  url : `${baseUrl}/marketing/send-contact-email`,
		  method : 'post',
		  dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		    console.log(result);
		    $('#modal_sendContactEmail').modal('hide');
		    if(result == 'Success')
		    {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>Message sent successfully.',
		      });

		      setTimeout(function(){
            window.location.replace(`${baseUrl}/contact-preview/${$('#txt_contactId').val()}`);
          }, 1000);
		    }
		    else
		    {
          Toast.fire({
		        icon: 'error',
		        title: 'Error! <br>Database error!'
		      });
		    }
		    $('#btn_sendContactEmail').html('<i class="fa fa-paper-plane mr-1"></i> Send Email');
		    $('#btn_sendContactEmail').prop('disabled',false);
		  }
		});
	}

	return thisContacts;

})();