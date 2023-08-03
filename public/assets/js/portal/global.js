$(document).ready(function(){
	GLOBAL.loadMyAccount();
});

const GLOBAL = (function(){

  let thisGlobal = {};

  let baseUrl = $('#txt_baseUrl').val();

  thisGlobal.loadMyAccount = function()
  {
  	$.ajax({
  	  /* MyAccountController->loadMyAccount() */
  	  url : `${baseUrl}/load-my-account`,
  	  method : 'get',
  	  dataType: 'json',
  	  success : function(data)
  	  {
  	    console.log(data);
  	    $('#lbl_thisUserCompleteName1').html(data['complete_name']);
  	    $('#lbl_thisUserCompleteName2').html(data['complete_name']);
  	    $('#img_thisUserProfilePicture').prop('src', (data['picture'] == null)? `${baseUrl}/public/assets/img/user-placeholder.png` : `${baseUrl}/public/assets/uploads/images/users/${data['picture']}`);
  	  }
  	});
  }

  return thisGlobal;

})();