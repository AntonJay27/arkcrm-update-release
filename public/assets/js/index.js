let baseUrl = $('#txt_baseUrl').val();

const INDEX = (function(){

	let thisIndex = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

	thisIndex.login = function(thisForm)
	{
		let formData = new FormData(thisForm);

    $('#btn_signIn').prop('disabled',true);
    $('#btn_signIn').text('Please wait...');

    $.ajax({
      // IndexController->login();
      url : `${baseUrl}/user-login`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {
        $('#txt_userEmail').val('');
        $('#txt_userPassword').val('');

        console.log(result);

        if(result == "Success")
        {
          Toast.fire({
		        icon: 'success',
		        title: 'Success! <br>Logging in, please wait...',
		      });

          setTimeout(function(){
            window.location.replace(`${baseUrl}/dashboard`);
          }, 1000);
        }
        else
        {
          Toast.fire({
		        icon: 'error',
		        title: 'Error! <br>Invalid login, try again!',
		      });
        }

        $('#btn_signIn').prop('disabled',false);
        $('#btn_signIn').text('Sign In');
      }
    });
	}

  thisIndex.forgotPassword = function(thisForm)
  {
    let formData = new FormData(thisForm);

    $('#btn_forgotPassword').prop('disabled',true);
    $('#btn_forgotPassword').text('Please wait...');

    $.ajax({
      // IndexController->forgotPassword();
      url : `${baseUrl}/user-forgot-password`,
      method : 'post',
      dataType: 'json',
      processData: false, // important
      contentType: false, // important
      data : formData,
      success : function(result)
      {

        console.log(result);
        $('#txt_userEmail').val('');

        if(result == "Success")
        {
          Toast.fire({
            icon: 'success',
            title: 'Success! <br>Change password link has been sent to your email!',
          });
        }
        else
        {
          Toast.fire({
            icon: 'error',
            title: result
          });
        }

        $('#btn_forgotPassword').prop('disabled',false);
        $('#btn_forgotPassword').text('Request new password');
      }
    });
  }

  thisIndex.changePassword = function(thisForm)
  {
    let formData = new FormData(thisForm);

    if($('#txt_newPassword').val() == $('#txt_confirmPassword').val())
    {
      $('#btn_changePassword').prop('disabled',true);
      $('#btn_changePassword').text('Please wait...');

      $.ajax({
        // IndexController->changePassword();
        url : `${baseUrl}/user-change-password`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          $('#txt_newPassword').val('');
          $('#txt_confirmPassword').val('');

          if(result == "Success")
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Change password link has been sent to your email!',
            });

            setTimeout(function(){
              window.location.replace(`${baseUrl}/login`);
            }, 1000);
          }
          else
          {
            Toast.fire({
              icon: 'error',
              title: result
            });
          }

          $('#btn_changePassword').prop('disabled',false);
          $('#btn_changePassword').text('Change password');
        }
      });
    }
    else
    {
      Toast.fire({
        icon: 'warning',
        title: 'Warning! <br>Password confirmation not match!'
      });
    }  
  }

  thisIndex.signUp = function(thisForm)
  {
    if($('#txt_userPassword').val() == $('#txt_confirmPassword').val())
    {
      let formData = new FormData(thisForm);

      $('#btn_signUp').prop('disabled',true);
      $('#btn_signUp').text('Please wait...');

      $.ajax({
        // IndexController->signUp();
        url : `${baseUrl}/user-sign-up`,
        method : 'post',
        dataType: 'json',
        processData: false, // important
        contentType: false, // important
        data : formData,
        success : function(result)
        {
          $('#txt_userEmail').val('');

          console.log(result);

          if(result == "Success")
          {
            Toast.fire({
              icon: 'success',
              title: 'Success! <br>Sign-up complete!',
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/login`);
            }, 1000);
          }
          else
          {
            Toast.fire({
              icon: 'warning',
              title: 'Warning! <br>Your account is active, try login.'
            });
            setTimeout(function(){
              window.location.replace(`${baseUrl}/login`);
            }, 3000);
          }
          $('#btn_signUp').prop('disabled',false);
          $('#btn_signUp').text('Register');
        }
      });
    }
    else
    {
      Toast.fire({
        icon: 'warning',
        title: 'Warning! <br>Password confirmation not match!'
      });
    }
    
  }

	return thisIndex;

})();