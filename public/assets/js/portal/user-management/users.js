let baseUrl = $('#txt_baseUrl').val();

const USERS = (function(){

	let thisUsers = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisUsers.loadUsers = function()
  {
		$.ajax({
			/* UserController->loadUsers() */
		  url : `${baseUrl}/user-management/load-users`,
		  method : 'get',
		  dataType: 'json',
		  success : function(data)
		  {
		    console.log(data);
		    let tbody = '';
		    data.forEach(function(value,key){
          let userStatus = '';
          if(value['user_password'] == null)
          {
            userStatus = (value['user_status'] == 1)? '<span class="text-green text-bold">Active</span>' : '<span class="text-warning text-bold">Pending</span>';
          }
          else
          {
            userStatus = (value['user_status'] == 1)? '<span class="text-green text-bold">Active</span>' : '<span class="text-red text-bold">Inactive</span>';
          }

          let actions = '';
          if(value['created_by'] == null)
          {
            actions = `<a href="javascript:void(0)" onclick="USERS.selectUser(${value['user_id']})" class="mr-2">
                          <i class="fa fa-pen"></i>
                        </a>`;
          }
          else
          {
            actions = `<a href="javascript:void(0)" onclick="USERS.selectUser(${value['user_id']})" class="mr-2">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="USERS.removeUser(${value['user_id']})" class="text-red">
                          <i class="fa fa-trash"></i>
                        </a>`;
          }
		    	tbody += `<tr>
                      <td class="p-1 pl-4">${value['first_name']}</td>
                      <td class="p-1">${value['last_name']}</td>
                      <td class="p-1">${value['user_name']}</td>
                      <td class="p-1">${value['user_email']}</td>
                      <td class="p-1">${value['role_name']}</td>
                      <td class="p-1 text-center">${userStatus}</td>
                      <td class="p-1 text-center">
                        ${actions}
                      </td>
                    </tr>`;
		    });

		    $('#tbl_users').DataTable().destroy();
		    $('#tbl_users tbody').html(tbody);
		    $('#tbl_users').DataTable({
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

  thisUsers.selectEmailConfig = function()
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
          $('#txt_userId').val('');
          $('#txt_userName').val('');
          $('#txt_primaryEmail').val('');
          $('#txt_firstName').val('');
          $('#txt_lastName').val('');
          $('#slc_roles').val('');
          USERS.loadRoles();
          $('#modal_users').modal('show');
        }
        else
        {
          if(confirm(`Unable to Create User, Please check your Email Configuration Setup on SETTINGS->Email Configuration. Thank you! \n\nDo you want me to redirect you to Email Configuration module? \nClick OK to proceed.`))
          { 
            window.location.replace(`${baseUrl}/settings`);
          }
        }
      }
    });
  }

  thisUsers.loadRoles = function(roleId = "")
  {
  	$.ajax({
      /* RoleController->loadRoles() */
      url : `${baseUrl}/user-management/load-roles`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
      	let roleOptions = '<option value="">---</option>';
      	data.forEach(function(value,key){
      		if(roleId == value['id'])
      		{
      			roleOptions += `<option value="${value['id']}" selected>${value['role_name']}</option>`;
      		}
      		else
      		{
      			roleOptions += `<option value="${value['id']}">${value['role_name']}</option>`;
      		}      		
      	});
      	$('#slc_roles').html(roleOptions);
      }
    });
  }

  thisUsers.addUser = function(thisForm)
  {
  	let formData = new FormData(thisForm);

    formData.set('chk_admin',($('#chk_admin').is(':checked'))? 1:0);

  	$('#btn_submitUser').text('Please wait...');
  	$('#btn_submitUser').prop('disabled',true);

  	$.ajax({
  		/* UserController->addUser() */
  	  url : `${baseUrl}/user-management/add-user`,
  	  method : 'post',
  	  dataType: 'json',
  	  processData: false, // important
  	  contentType: false, // important
  	  data : formData,
  	  success : function(result)
  	  {
  	    if(result == "Success")
        {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>New user created successfully!',
		      });
          $('#modal_users').modal('hide');

          setTimeout(function(){
            window.location.replace(`${baseUrl}/users`);
          }, 1000);
        }
        else
        {
          Toast.fire({
		        icon: 'error',
		        title: result,
		      });
        }
  	    $('#btn_submitUser').text('Save User');
  	    $('#btn_submitUser').prop('disabled',false);
  	  }
  	});
  }

  thisUsers.selectUser = function(userId)
  {
  	$.ajax({
  	  /* UserController->selectUser() */
  	  url : `${baseUrl}/user-management/select-user`,
  	  method : 'get',
  	  dataType: 'json',
  	  data : {userId : userId},
  	  success : function(data)
  	  {
  	  	console.log(data);
  	  	$('#lbl_titleHeader').html('<i class="fa fa-pen mr-1"></i> Update User');
  	  	$('#modal_users').modal('show');
  	  	$('#txt_userId').val(data['user_id']);
  	  	$('#txt_userName').val(data['user_name']);
  	  	$('#txt_primaryEmail').val(data['user_email']);
  	  	$('#txt_firstName').val(data['first_name']);
  	  	$('#txt_lastName').val(data['last_name']);
  	  	USERS.loadRoles(data['role_id']);
        $('#chk_admin').prop('checked',(data['admin'] == '1')? true : false);
  	  }
  	});
  }

  thisUsers.editUser = function(thisForm)
  {
  	let formData = new FormData(thisForm);

    formData.set('chk_admin',($('#chk_admin').is(':checked'))? 1:0);

  	$('#btn_submitUser').text('Please wait...');
  	$('#btn_submitUser').prop('disabled',true);

  	$.ajax({
  		/* UserController->editUser() */
  	  url : `${baseUrl}/user-management/edit-user`,
  	  method : 'post',
  	  dataType: 'json',
  	  processData: false, // important
  	  contentType: false, // important
  	  data : formData,
  	  success : function(result)
  	  {
  	    if(result == "Success")
        {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>User updated successfully!',
		      });
          $('#modal_users').modal('hide');
          setTimeout(function(){
            window.location.replace(`${baseUrl}/users`);
          }, 1000);
        }
        else
        {
          Toast.fire({
		        icon: 'error',
		        title: result,
		      });
        }
  	    $('#btn_submitUser').text('Save User');
  	    $('#btn_submitUser').prop('disabled',false);
  	  }
  	});
  }

  thisUsers.removeUser = function(userId)
  {
  	if(confirm('Please Confirm!'))
    {
      let formData = new FormData();

      formData.set('userId',userId);

      $.ajax({
        /* UserController->removeUser() */
        url : `${baseUrl}/user-management/remove-user`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          if(result == "Success")
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>User has been deleted successfully!',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/users`);
            }, 1000);
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

	return thisUsers;

})();