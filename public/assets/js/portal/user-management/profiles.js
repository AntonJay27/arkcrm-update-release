
const PROFILES = (function(){

	let thisProfiles = {};

  let baseUrl = $('#txt_baseUrl').val();

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisProfiles.loadProfiles = function()
  {
    $.ajax({
      /* ProfileController->loadProfiles() */
      url : `${baseUrl}/user-management/load-profiles`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        let tbody = '';

        data.forEach(function(value, index){
          tbody += `<tr>
                      <td>
                        <a href="javascript:void(0)" onclick="PROFILES.duplicateProfile(${value['id']})" class="mr-2">
                          <i class="fa fa-copy"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="PROFILES.selectProfile(${value['id']})" class="mr-2">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="PROFILES.removeProfile(${value['id']})" class="text-red">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                      <td>${value['profile_name']}</td>
                      <td>${value['description']}</td>
                    </tr>`;
        });

        if(tbody == '')
        {
          tbody = `<tr>
                    <td colspan="3"><center>-- No Profile --</center></td>
                  </tr>`;
        }

        $('#tbl_profiles tbody').html(tbody);
      }
    });
  }

  thisProfiles.changeFieldStatus = function(thisField)
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

  thisProfiles.addProfile = function(thisForm)
  {
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

    formData.set("arrModulesAndFields", JSON.stringify(arrModulesAndFields));

    $.ajax({
      /* ProfileController->addProfile() */
      url : `${baseUrl}/user-management/add-profile`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('#modal_profiles').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>New Profile added successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/profiles`);
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

  thisProfiles.duplicateProfile = function(profileId)
  {
    $.ajax({
      /* ProfileController->selectProfile() */
      url : `${baseUrl}/user-management/select-profile`,
      method : 'get',
      dataType: 'json',
      data : {profileId : profileId},
      success : function(data)
      {
        $('#txt_profileId').val('');
        $('#txt_profileName').val(data['profile_name']);
        $('#txt_description').val(data['description']);

        $('#lbl_modalTitle').html('<i class="fa fa-copy"></i> Duplicate Profile');
        $('#modal_profiles').modal('show');
      }
    });
  }

  thisProfiles.selectProfile = function(profileId)
  {
    $.ajax({
      /* ProfileController->selectProfile() */
      url : `${baseUrl}/user-management/select-profile`,
      method : 'get',
      dataType: 'json',
      data : {profileId : profileId},
      success : function(data)
      {
        console.log(data);

        $('#txt_profileId').val(data['id']);
        $('#txt_profileName').val(data['profile_name']);
        $('#txt_description').val(data['description']);

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
            PROFILES.changeFieldStatus(this);
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

        $('#lbl_modalTitle').html('<i class="fa fa-pen"></i> Edit Profile');
        $('#modal_profiles').modal('show');
      }
    });
  }

  thisProfiles.editProfile = function(thisForm)
  {
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

    formData.set("arrModulesAndFields", JSON.stringify(arrModulesAndFields));

    $.ajax({
      /* ProfileController->editProfile() */
      url : `${baseUrl}/user-management/edit-profile`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('#modal_profiles').modal('hide');
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Profile updated successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/profiles`);
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

  thisProfiles.removeProfile = function(profileId)
  {
    if(confirm('Please Confirm'))
    {
      let formData = new FormData();

      formData.set("profileId", profileId);

      $.ajax({
        /* ProfileController->removeProfile() */
        url : `${baseUrl}/user-management/remove-profile`,
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
              title: 'Success! <br>Profile removed successfully.',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/profiles`);
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

  return thisProfiles;

})();