let baseUrl = $('#txt_baseUrl').val();

const ROLES = (function(){

	let thisRoles = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisRoles.loadRoles = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* RoleController->loadRoles() */
      url : `${baseUrl}/user-management/load-roles`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        let divRoles = '';
        data.forEach(function(value, index){
          if(value['reports_to'] == null)
          {
            divRoles += `<li>
                          <a href="javascript:void(0)" onclick="ROLES.selectRole(${value['id']})" class="label">${value['role_name']}</a> 
                          <div class="actions">
                            <a href="javascript:void(0)" onclick="ROLES.addRoleModal(${value['id']})"><i class="fa fa-plus ml-1"></i></a>
                            <a href="javascript:void(0)" onclick="ROLES.removeRole(${value['id']});"><i class="fa fa-trash ml-1"></i></a>
                          </div>
                            ${ROLES.loadSubRoles(value['id'], value['sub_role'], data)}
                        </li>`;
          }
        });
        $('#ul_roles').html(divRoles);
        $('#ul_roles').treed({openedClass:'fa fa-minus-square', closedClass:'fa fa-plus-square'});
      }
    });
  }

  thisRoles.loadSubRoles = function(roleId, subRole, data)
  {
    let devSubRoles = '';
    if(subRole == 1)
    {
      devSubRoles += `<ul>`;
    }
    data.forEach(function(value, index){
      if(roleId == value['reports_to'])
      {
        if(subRole == 1)
        {
          devSubRoles += `<li>
                            <a href="javascript:void(0)" onclick="ROLES.selectRole(${value['id']})" class="label">${value['role_name']}</a>
                            <div class="actions">
                              <a href="javascript:void(0)" onclick="ROLES.addRoleModal(${value['id']})"><i class="fa fa-plus ml-1"></i></a>
                              <a href="javascript:void(0)" onclick="ROLES.removeRole(${value['id']});"><i class="fa fa-trash ml-1"></i></a>
                            </div>
                              ${ROLES.loadSubRoles(value['id'], value['sub_role'], data)}
                          </li>`;
                          // alert(subRole);
        }
        else
        {
          devSubRoles += `<li>
                            <a href="javascript:void(0)" onclick="ROLES.selectRole(${value['id']})" class="label">${value['role_name']}</a>
                            <div class="actions">
                              <a href="javascript:void(0)" onclick="ROLES.addRoleModal(${value['id']});"><i class="fa fa-plus ml-1"></i></a>
                              <a href="javascript:void(0)" onclick="ROLES.removeRole(${value['id']});"><i class="fa fa-trash ml-1"></i></a>
                            </div>
                          </li>`;
                          // alert(subRole);
        }
      }
    });

    if(subRole == 1)
    {
      devSubRoles += `</ul>`;
    }

    return devSubRoles;
  }

  thisRoles.loadReportsTo = function(roleId = null)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* RoleController->loadRoles() */
      url : `${baseUrl}/user-management/load-roles`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        let slcReportsTo = '<option value="" selected>---</option>';
        data.forEach(function(value, index){
          if(roleId == value['id'])
          {
            slcReportsTo += `<option value="${value['id']}" selected>${value['role_name']}</option>`;
          }
          else
          {
            slcReportsTo += `<option value="${value['id']}">${value['role_name']}</option>`;
          }          
        });

        $('#slc_reportsTo').html(slcReportsTo);
      }
    });
  }

  thisRoles.loadProfiles = function(selectOptions, selectedData = [])
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* ProfileController->loadProfiles() */
      url : `${baseUrl}/user-management/load-profiles`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        if(selectOptions == 'single-select')
        {
          let slcProfile = '<option value="" selected>Choose Profile</option>';

          data.forEach(function(value, index){
            slcProfile += `<option value="${value['id']}">${value['profile_name']}</option>`;          
          });

          $('#slc_profile').html(slcProfile);
        }
        else
        {
          let slcProfiles = '';
          data.forEach(function(value, index){
            if(selectedData.includes(value['id']))
            {
              slcProfiles += `<option value="${value['id']}" selected>${value['profile_name']}</option>`; 
            }
            else
            {
              slcProfiles += `<option value="${value['id']}">${value['profile_name']}</option>`; 
            }                     
          });

          $('#slc_profiles').html(slcProfiles);
          $('#slc_profiles').select2();
        }
      }
    });
  }

  thisRoles.copyProfile = function(thisInput)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let profileId = $(thisInput).val();
    $.ajax({
      /* ProfileController->selectProfile() */
      url : `${baseUrl}/user-management/select-profile`,
      method : 'get',
      dataType: 'json',
      data : {profileId : profileId},
      success : function(data)
      {
        $('body').waitMe('hide');
        let count = 0;
        let moduleStatusChecked = 0;
        let moduleStatus = false;
        $('#tbl_profilePrivileges tbody tr.module').each(function(){          
          if(data['modules_and_fields'][count][0][0] == 1)
          {
            moduleStatus = true;
            moduleStatusChecked++;
          }
          else 
          {
            moduleStatus = false;
          }

          $(this).find('td:eq(0) input[type="checkbox"]').prop('checked',moduleStatus);

          $(this).find('td:eq(1) input[type="checkbox"]').prop('checked',(data['modules_and_fields'][count][1][0])? true : false);
          $(this).find('td:eq(2) input[type="checkbox"]').prop('checked',(data['modules_and_fields'][count][1][1])? true : false);
          $(this).find('td:eq(3) input[type="checkbox"]').prop('checked',(data['modules_and_fields'][count][1][2])? true : false);
          $(this).find('td:eq(4) input[type="checkbox"]').prop('checked',(data['modules_and_fields'][count][1][3])? true : false);

          if(data['modules_and_fields'][count][1].includes(1))
          {
            $(this).find('td:eq(5) button.btn_modules').prop('disabled',false);
          }
          else
          {
            $(this).find('td:eq(5) button.btn_modules').prop('disabled',true);
          }


          let fieldCount = 0;
          $(this).next().find('input.fields').each(function(){
            $(this).val(data['modules_and_fields'][count][2][fieldCount]);
            ROLES.changeFieldStatus(this);
            fieldCount++;
          });

          count++;
        });

        moduleStatus = (moduleStatusChecked == count)? true : false;
        $('#tbl_profilePrivileges thead tr th:eq(0)').find('input[type="checkbox"]').prop('checked',moduleStatus);

        let checkboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').length;
        let checkedboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input:checked[type="checkbox"]').length;
        $('#chk_view').prop('checked',(checkboxesView == checkedboxesView)? true : false);

        let checkboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input[type="checkbox"]').length;
        let checkedboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input:checked[type="checkbox"]').length;
        $('#chk_create').prop('checked',(checkboxesCreate == checkedboxesCreate)? true : false);

        let checkboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input[type="checkbox"]').length;
        let checkedboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input:checked[type="checkbox"]').length;
        $('#chk_edit').prop('checked',(checkboxesEdit == checkedboxesEdit)? true : false);

        let checkboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input[type="checkbox"]').length;
        let checkedboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input:checked[type="checkbox"]').length;
        $('#chk_delete').prop('checked',(checkboxesDelete == checkedboxesDelete)? true : false);
      }
    });
  }

  thisRoles.addRoleModal = function(roleId)
  {
    $('#lbl_modalTitle').html('<i class="fa fa-plus"></i> Create New Role');
    $('#modal_roles').modal('show');

    $('#txt_roleId').val('');

    $('#tr_privilegesFromExistingProfiles').hide();
    $('#tr_privilegesDirectlyToRole').show();
    $('#div_privileges').show();

    ROLES.loadReportsTo(roleId);

    $('#slc_profiles').prop('required',false);
    ROLES.loadProfiles('single-select');
  }

  thisRoles.changeFieldStatus = function(thisField)
  {
    $(thisField).removeClass('range-zero');
    $(thisField).removeClass('range-one');
    $(thisField).removeClass('range-two');

    if($(thisField).val() == 0)
    {
      $(thisField).addClass('range-zero');
    }
    else if($(thisField).val() == 1)
    {
      $(thisField).addClass('range-one');
    }
    else
    {
      $(thisField).addClass('range-two');
    }
  }

  thisRoles.addRole = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let arrModulesAndFields = [];
    $('#tbl_profilePrivileges tbody tr.module').each(function(){
      
      let moduleStatus = ($(this).find('td:eq(0) input[type="checkbox"]').is(':checked'))? 1 : 0;

      let viewStatus = ($(this).find('td:eq(1) input[type="checkbox"]').is(':checked'))? 1 : 0;
      let createStatus = ($(this).find('td:eq(2) input[type="checkbox"]').is(':checked'))? 1 : 0;
      let editStatus = ($(this).find('td:eq(3) input[type="checkbox"]').is(':checked'))? 1 : 0;
      let deleteStatus = ($(this).find('td:eq(4) input[type="checkbox"]').is(':checked'))? 1 : 0;

      let fields = [];
      $(this).next().find('input.fields').each(function(){
        fields.push($(this).val());
      });

      rowData = [
        [moduleStatus],
        [viewStatus,createStatus,editStatus,deleteStatus],
        fields
      ];

      arrModulesAndFields.push(rowData);
      
    });

    let formData = new FormData(thisForm);

    let canAssignRecordsTo = $("input[type='radio'][name='rdb_canAssignRecordsTo']:checked").val();
    let privileges = $("input[type='radio'][name='rdb_privileges']:checked").val();

    formData.set("arrModulesAndFields", JSON.stringify(arrModulesAndFields));
    formData.set("canAssignRecordsTo", canAssignRecordsTo);
    formData.set("privileges", privileges);
    formData.set("profiles", JSON.stringify($('#slc_profiles').val()));

    $.ajax({
      /* RoleController->addRole() */
      url : `${baseUrl}/user-management/add-role`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#modal_roles').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New Role added successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/roles`);
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

  thisRoles.selectRole = function(roleId)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* RoleController->selectRole() */
      url : `${baseUrl}/user-management/select-role`,
      method : 'get',
      dataType: 'json',
      data : {roleId : roleId},
      success : function(data)
      {
        $('body').waitMe('hide');

        $('#txt_roleId').val(data['id']);
        $('#txt_subRole').val(data['sub_role']);

        $('#txt_roleName').val(data['role_name']);
        ROLES.loadReportsTo(data['reports_to']);

        if(data['can_assign_records_to'] == 'all-users')
        {
          $('#rdb_1').prop('checked',true);
        }
        else if(data['can_assign_records_to'] == 'users-having-same-role-or-subordinate-role')
        {
          $('#rdb_2').prop('checked',true);
        }
        else
        {
          $('#rdb_3').prop('checked',true);
        }

        if(data['privileges'] == 'assign-privileges-directly-to-role')
        {
          $('#rdb_4').prop('checked',true);
          $('#tr_privilegesFromExistingProfiles').hide();
          $('#tr_privilegesDirectlyToRole').show();
          $('#div_privileges').show();

          $('#slc_profiles').prop('required',false);
          ROLES.loadProfiles('single-select');
        }
        else
        {
          $('#rdb_5').prop('checked',true);
          $('#tr_privilegesFromExistingProfiles').show();
          $('#tr_privilegesDirectlyToRole').hide();
          $('#div_privileges').hide();

          $('#slc_profiles').prop('required',true);
          ROLES.loadProfiles('multiple-select',data['profiles']);
        }

        if(data['modules_and_fields'] != null)
        {
          let count = 0;
          let moduleStatusChecked = 0;
          let moduleStatus = false;
          $('#tbl_profilePrivileges tbody tr.module').each(function(){          
            if(data['modules_and_fields'][count][0][0] == 1)
            {
              moduleStatus = true;
              moduleStatusChecked++;
            }
            else 
            {
              moduleStatus = false;
            }

            $(this).find('td:eq(0) input[type="checkbox"]').prop('checked',moduleStatus);

            $(this).find('td:eq(1) input[type="checkbox"]').prop('checked',(data['modules_and_fields'][count][1][0])? true : false);
            $(this).find('td:eq(2) input[type="checkbox"]').prop('checked',(data['modules_and_fields'][count][1][1])? true : false);
            $(this).find('td:eq(3) input[type="checkbox"]').prop('checked',(data['modules_and_fields'][count][1][2])? true : false);
            $(this).find('td:eq(4) input[type="checkbox"]').prop('checked',(data['modules_and_fields'][count][1][3])? true : false);

            if(data['modules_and_fields'][count][1].includes(1))
            {
              $(this).find('td:eq(5) button.btn_modules').prop('disabled',false);
            }
            else
            {
              $(this).find('td:eq(5) button.btn_modules').prop('disabled',true);
            }

            let fieldCount = 0;
            $(this).next().find('input.fields').each(function(){
              $(this).val(data['modules_and_fields'][count][2][fieldCount]);
              ROLES.changeFieldStatus(this);
              fieldCount++;
            });

            count++;
          });

          moduleStatus = (moduleStatusChecked == count)? true : false;
          $('#tbl_profilePrivileges thead tr th:eq(0)').find('input[type="checkbox"]').prop('checked',moduleStatus);
        }

        let checkboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input[type="checkbox"]').length;
        let checkedboxesView = $('#tbl_profilePrivileges tbody tr').find('td:eq(1) input:checked[type="checkbox"]').length;
        $('#chk_view').prop('checked',(checkboxesView == checkedboxesView)? true : false);

        let checkboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input[type="checkbox"]').length;
        let checkedboxesCreate = $('#tbl_profilePrivileges tbody tr').find('td:eq(2) input:checked[type="checkbox"]').length;
        $('#chk_create').prop('checked',(checkboxesCreate == checkedboxesCreate)? true : false);

        let checkboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input[type="checkbox"]').length;
        let checkedboxesEdit = $('#tbl_profilePrivileges tbody tr').find('td:eq(3) input:checked[type="checkbox"]').length;
        $('#chk_edit').prop('checked',(checkboxesEdit == checkedboxesEdit)? true : false);

        let checkboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input[type="checkbox"]').length;
        let checkedboxesDelete = $('#tbl_profilePrivileges tbody tr').find('td:eq(4) input:checked[type="checkbox"]').length;
        $('#chk_delete').prop('checked',(checkboxesDelete == checkedboxesDelete)? true : false);

        $('#lbl_modalTitle').html('<i class="fa fa-pen"></i> Edit Role');
        $('#modal_roles').modal('show');

      }
    });
  }

  thisRoles.editRole = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let arrModulesAndFields = [];
    $('#tbl_profilePrivileges tbody tr.module').each(function(){
      
      let moduleStatus = ($(this).find('td:eq(0) input[type="checkbox"]').is(':checked'))? 1 : 0;

      let viewStatus = ($(this).find('td:eq(1) input[type="checkbox"]').is(':checked'))? 1 : 0;
      let createStatus = ($(this).find('td:eq(2) input[type="checkbox"]').is(':checked'))? 1 : 0;
      let editStatus = ($(this).find('td:eq(3) input[type="checkbox"]').is(':checked'))? 1 : 0;
      let deleteStatus = ($(this).find('td:eq(4) input[type="checkbox"]').is(':checked'))? 1 : 0;

      let fields = [];
      $(this).next().find('input.fields').each(function(){
        fields.push($(this).val());
      });

      rowData = [
        [moduleStatus],
        [viewStatus,createStatus,editStatus,deleteStatus],
        fields
      ];

      arrModulesAndFields.push(rowData);
      
    });

    let formData = new FormData(thisForm);

    let canAssignRecordsTo = $("input[type='radio'][name='rdb_canAssignRecordsTo']:checked").val();
    let privileges = $("input[type='radio'][name='rdb_privileges']:checked").val();

    formData.set("arrModulesAndFields", JSON.stringify(arrModulesAndFields));
    formData.set("canAssignRecordsTo", canAssignRecordsTo);
    formData.set("privileges", privileges);
    formData.set("profiles", JSON.stringify($('#slc_profiles').val()));

    $.ajax({
      /* RoleController->editRole() */
      url : `${baseUrl}/user-management/edit-role`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('body').waitMe('hide');
        $('#modal_roles').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Role updated successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/roles`);
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

  thisRoles.removeRole = function(roleId)
  {
    let formData = new FormData();
    formData.set('roleId',roleId);
    if(confirm('Please Confirm!'))
    {
      $('body').waitMe(_waitMeLoaderConfig);
      $.ajax({
        /* RoleController->removeRole() */
        url : `${baseUrl}/user-management/remove-role`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          $('body').waitMe('hide');
          $('#modal_roles').modal('hide');
          if(result[0] == 'Success')
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Role removed successfully.',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/roles`);
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

  thisRoles.loadOrganizationName = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* RoleController->loadOrganizationName() */
      url : `${baseUrl}/user-management/load-organization-name`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        if(data['organization_name'] == '__ORGANIZATION_NAME__')
        {
          $('#lbl_organizationName').text('Organization');
        }
        else
        {
          $('#lbl_organizationName').text(data['organization_name']);
        }
      }
    });
  }

  thisRoles.selectOrganizationName = function()
  {
    $('#modal_organizationName').modal({static:'backdrop'});
  }

  thisRoles.editOrganizationName = function(thisForm)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    let formData = new FormData(thisForm);
    $.ajax({
      /* RoleController->editOrganizationName() */
      url : `${baseUrl}/user-management/edit-organization-name`,
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
            title: 'Success! <br>Organization Name updated successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/roles`);
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

  return thisRoles;

})();