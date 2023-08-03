let baseUrl = $('#txt_baseUrl').val();

const MY_ACCOUNT = (function(){

  let thisMyAccount = {};

  var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisMyAccount.loadMyAccount = function()
  {
    $.ajax({
      /* MyAccountController->loadMyAccount() */
      url : `${baseUrl}/load-my-account`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        $('#lbl_userCompleteName').html(data['complete_name']);
        $('#lbl_userPosition').html(data['position']);
        $('#img_profilePicture').prop('src', (data['picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${data['picture']}`);
      }
    });
  }

  thisMyAccount.uploadMyAccountPicturePreview = function(imageFile)
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

  thisMyAccount.changeMyAccountPicture = function(thisForm)
  {
    let formData = new FormData(thisForm);

    formData.append("profilePicture", $('#file_profilePicture')[0].files[0]);

    $('#btn_savePicture').prop('disabled',true);

    $.ajax({
      /* MyAccountController->changeMyAccountPicture() */
      url : `${baseUrl}/change-my-account-picture`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      cache: false,
      data : formData,
      success : function(result)
      {
        console.log(result);
        if(result == 'Success')
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Profile Picture changed successfully.',
          });
          setTimeout(function(){
            window.location.replace(`${baseUrl}/my-account`);
          }, 1000);
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: `Error! <br>${result}`
          });
        }
      }
    });
  }

  thisMyAccount.loadMyAccountDetails = function()
  {
    $.ajax({
      /* MyAccountController->loadMyAccountDetails() */
      url : `${baseUrl}/load-my-account-details`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        console.log(data);
        $('#slc_salutation').val(data['salutation']);
        $('#txt_firstName').val(data['first_name']);
        $('#txt_lastName').val(data['last_name']);
        $('#txt_position').val(data['position']);
        $('#txt_email').val(data['user_email']);
        $('#txt_contactNumber').val(data['contact_number']);
      }
    });
  }

  thisMyAccount.editMyAccountDetials = function(thisForm)
  {
    if(confirm('Please Confirm!'))
    {
      let formData = new FormData(thisForm);

      $('#btn_saveChanges').prop('disabled',true);

      $.ajax({
        /* MyAccountController->editMyAccountDetails() */
        url : `${baseUrl}/edit-my-account-details`,
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
              title: 'Success! <br>Details updated successfully.',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/my-account`);
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

  thisMyAccount.editMyAccountPassword = function(thisForm)
  {
    if($('#txt_newPassword').val() != $('#txt_confirmPassword').val())
    {
      Toast.fire({
        icon: 'error',
        title: 'Error! <br>Password confirmation not match!',
      });

      $("#txt_newPassword").val('').focus();
      $("#txt_confirmPassword").val('');
    }
    else
    {
      let formData = new FormData(thisForm);

      $('#btn_saveChanges').prop('disabled',true);

      $.ajax({
        /* MyAccountController->editMyAccountPassword() */
        url : `${baseUrl}/edit-my-account-password`,
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
              title: 'Success! <br>Password changed successfully.',
            });
            setTimeout(function(){
              if(confirm('Click OK button to logout, CANCEL if you want to stay logged in!'))
              {
                window.location.replace(`${baseUrl}/user-logout`);
              }
              else
              {
                window.location.replace(`${baseUrl}/my-account`);
              }
            }, 1000);
          }
          else
          {
            Toast.fire({
              icon: 'error',
              title: `Error! <br> ${result}`
            });
            $("#txt_oldPassword").val('').focus();
          }
        }
      });
    }
  }


  

  return thisMyAccount;

})();