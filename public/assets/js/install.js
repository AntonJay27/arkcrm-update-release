
const INSTALL = (function(){

	let thisInstall = {};

	let baseUrl = $('#txt_baseUrl').val();

	var Toast = Swal.mixin({
		toast: true,
		position: 'top',
		showConfirmButton: false,
		timer: 3000
	});

	let _arrSystemConfiguration = [];

	thisInstall.submitStepTwo = function()
	{
		$.ajax({
		  /* Home->installationStepTwo() */
			url : `${baseUrl}/install/InstallationController.php?action=submitStepTwo`,
			method : 'get',
			dataType: 'json',
			success : function(data)
			{
				let tbody = ``;
				let btnDisable = false;

				data.forEach(function(value,key){
					tbody += `<tr>
					<td>${value[0]}</td>
					<td>${value[1]}</td>
					<td>${(value[2] == 'No')? `<span style="font-weight:bold; color:red;">${value[2]}</span>` : `<span style="font-weight:bold;">${value[2]}</span>`}</td>
					</tr>`; 

					if(value[2] == 'No')
					{
						btnDisable = true;
					} 
				});

				$('#tbl_phpConfig tbody').html(tbody);

				$('#btn_stepThreeNext').prop('disabled',btnDisable);
			}
		});
	}


	thisInstall.stepThreeBack = function()
	{
		$.ajax({
		  /* Home->installationStepTwo() */
			url : `${baseUrl}/install/InstallationController.php?action=stepThreeBack`,
			method : 'get',
			dataType: 'json',
			success : function(data)
			{
				console.log(data);
			}
		});
	}


	thisInstall.submitStepFour  = function(thisForm)
	{
		if($('#txt_password').val() == $('#txt_retypePassword').val())
		{
			$('#lbl_warningMsg').prop('hidden',true);

			let formData = new FormData(thisForm);

			_arrSystemConfiguration = {
				'database_type' 			: $('#txt_databaseType').val(),
				'host_name' 				: $('#txt_hostName').val(),
				'host_user_name' 			: $('#txt_hostUserName').val(),
				'host_user_password'		: $('#txt_hostUserPassword').val(),
				'database_name' 			: $('#txt_databaseName').val(),
				'create_database' 		: ($('#chk_createDatabase').is(':checked'))? 1 : 0,
				'first_name' 				: $('#txt_firstName').val(),
				'last_name' 				: $('#txt_lastName').val(),
				'email' 						: $('#txt_email').val(),
				'username' 					: $('#txt_username').val(),
				'password' 					: $('#txt_password').val()
			};

			formData.set('chk_createDatabase',($('#chk_createDatabase').is(':checked'))? 1 : 0);
			formData.set('txt_baseUrl',baseUrl);

			$('#btn_stepFourNext').html('<i>Please Wait...</i>');
			$('#btn_stepFourNext').prop('disabled',true);

			$.ajax({
			  /* Home->installationStepFour() */
				url : `${baseUrl}/install/installation-step-four`,
				method : 'post',
				dataType: 'json',
			  processData: false, // important
			  contentType: false, // important
			  data : formData,
			  success : function(result)
			  {
			  	$('#btn_stepFourNext').html('&emsp;Next&emsp;');
			  	$('#btn_stepFourNext').prop('disabled',false);

			  	if(result[0] == "Error")
			  	{
			  		$('#div_msgResult').html(`<div class="alert alert-danger" role="alert">${result[1]}</div>`);
			  		$('#btn_stepFiveNext').prop('disabled',true);
			  	}
			  	else
			  	{
			  		$('#div_msgResult').html("");
			  		$('#btn_stepFiveNext').prop('disabled',false);
			  	}

			  	$('#lbl_databaseType').html(_arrSystemConfiguration['database_type']);
			  	$('#lbl_databaseName').html(_arrSystemConfiguration['database_name']);

			  	$('#lbl_url').html(`<a href="javascript:void(0)">${baseUrl.replace("install","")}</a>`);

			  	$('#lbl_userName').html(_arrSystemConfiguration['username']);
			  	$('#lbl_completeName').html(_arrSystemConfiguration['first_name'] + ' ' + _arrSystemConfiguration['last_name']);
			  	$('#lbl_email').html(_arrSystemConfiguration['email']);

			  	$('#div_stepOne').prop('hidden',true);
			  	$('#div_stepTwo').prop('hidden',true);
			  	$('#div_stepThree').prop('hidden',true);
			  	$('#div_stepFour').prop('hidden',true);
			  	$('#div_stepFive').prop('hidden',false);
			  	$('#div_stepSix').prop('hidden',true);
			  	$('#div_stepSeven').prop('hidden',true);
			  }
			});					
		}
		else
		{
			$('#lbl_warningMsg').prop('hidden',false);
			$('#txt_password').val('').focus();
			$('#txt_retypePassword').val('');
		}	
	}


	thisInstall.submitStepFive = function()
	{
		let formData = new FormData();

		formData.set('txt_firstName',_arrSystemConfiguration['first_name']);
		formData.set('txt_lastName',_arrSystemConfiguration['last_name']);
		formData.set('txt_email',_arrSystemConfiguration['email']);
		formData.set('txt_username',_arrSystemConfiguration['username']);
		formData.set('txt_password',_arrSystemConfiguration['password']);

		$('#btn_stepFiveNext').html('<i>Please Wait...</i>');
		$('#btn_stepFiveNext').prop('disabled',true);

		$.ajax({
		  /* Home->installationStepFive() */
			url : `${baseUrl}/install/installation-step-five`,
			method : 'post',
			dataType: 'json',
		  processData: false, // important
		  contentType: false, // important
		  data : formData,
		  success : function(result)
		  {
		  	$('#btn_stepFiveNext').html('&emsp;Next&emsp;');
		  	$('#btn_stepFiveNext').prop('disabled',false);

		  	if(result[0] == "Error")
		  	{
		  		$('#div_msgResult').html(`<div class="alert alert-danger" role="alert">${result[1]}</div>`);
		  		$('#btn_stepFiveNext').prop('disabled',true);
		  	}
		  	else
		  	{
		  		$('#div_stepOne').prop('hidden',true);
		  		$('#div_stepTwo').prop('hidden',true);
		  		$('#div_stepThree').prop('hidden',true);
		  		$('#div_stepFour').prop('hidden',true);
		  		$('#div_stepFive').prop('hidden',true);
		  		$('#div_stepSix').prop('hidden',false);
		  		$('#div_stepSeven').prop('hidden',true);

		  		setTimeout(function(){
		  			let arrTasks = [
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Calendars Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Campaigns Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Contacts Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Documents Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Emails Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Events Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Migrations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Organizations Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Tasks Table</i>',
		  				'<i>Creating Database Tables: Users Table</i>',
		  				'<i>Creating Database Tables: Users Table</i>',
		  				'<i>Creating Database Tables: Users Table</i>',
		  				'<i>Creating Database Tables: Users Table</i>',
		  				'<i>Creating Database Tables: Users Table</i>',
		  				'<i>Creating Database Tables: Users Table</i>',
		  				'<i>Seeding : Users Table</i>',
		  				'<i>Seeding : Users Table</i>',
		  				'<i>Seeding : Users Table</i>',
		  				'<i>Please do not reload the page, It will take 5-6 minutes, please wait...</i>'
		  				];

let width = 0;
let id = setInterval(function frame() {
	if (width >= 100) 
	{
		clearInterval(id);
		$('#lbl_pleaseWait').html('Finalizing...');
		setTimeout(function(){
			$('#div_stepOne').prop('hidden',true);
			$('#div_stepTwo').prop('hidden',true);
			$('#div_stepThree').prop('hidden',true);
			$('#div_stepFour').prop('hidden',true);
			$('#div_stepFive').prop('hidden',true);
		}, 8000);   
		// INSTALL.loadStepSix();  
  		$('#div_stepSix').prop('hidden',true);
  		$('#div_stepSeven').prop('hidden',false);     	  
	} 
	else 
	{
		width++;
		$('#lbl_pleaseWait').html('Loading...');
		$('#div_progressBar').css('width',width + '%'); 
		$('#lbl_percent').html(`${width}% Complete`);
		$('#lbl_task').html(arrTasks[width]);
	}
}, 100);
}, 10000);
}
}
});		
}

// thisInstall.loadStepSix = function()
// {
// 	$.ajax({
// 		  /* InstallationController->installationStepSix() */
// 		url : `${baseUrl}/install/installation-step-six`,
// 		method : 'post',
// 		dataType: 'json',
// 		  processData: false, // important
// 		  contentType: false, // important
// 		  success : function(result)
// 		  {
// 		  	if(result[0] == "Success")
// 		  	{
// 		  		$('#lbl_task').html('<i>GIT Initialization</i>');
// 		  		INSTALL.gitAddInit();
// 		  	}
// 		  	else
// 		  	{
// 		  		Toast.fire({
// 		  			icon: 'error',
// 		  			title: `Error! <br>${result[1]}`,
// 		  		});
// 		  	}
// 		  }
// 		});
// }

// thisInstall.gitAddInit = function()
// {
// 	$.ajax({
// 		  /* InstallationController->gitAddInit() */
// 		url : `${baseUrl}/install/git-add-init`,
// 		method : 'post',
// 		dataType: 'json',
// 		  processData: false, // important
// 		  contentType: false, // important
// 		  success : function(result)
// 		  {
// 		  	if(result[0] == "Success")
// 		  	{
// 		  		INSTALL.gitCommitInit();
// 		  	}
// 		  	else
// 		  	{
// 		  		Toast.fire({
// 		  			icon: 'error',
// 		  			title: `Error! <br>${result[1]}`,
// 		  		});
// 		  	}
// 		  }
// 		});
// }

// thisInstall.gitCommitInit = function()
// {
// 	$.ajax({
// 		  /* InstallationController->gitCommitInit() */
// 		url : `${baseUrl}/install/git-commit-init`,
// 		method : 'post',
// 		dataType: 'json',
// 		  processData: false, // important
// 		  contentType: false, // important
// 		  success : function(result)
// 		  {
// 		  	if(result[0] == "Success")
// 		  	{
// 		  		$('#lbl_task').html('<i>GIT Initialization Completed!</i>');
// 		  		INSTALL.gitAdd();
// 		  	}
// 		  	else
// 		  	{
// 		  		Toast.fire({
// 		  			icon: 'error',
// 		  			title: `Error! <br>${result[1]}`,
// 		  		});
// 		  	}
// 		  }
// 		});
// }

// thisInstall.gitAdd = function()
// {
// 	$.ajax({
// 		  /* InstallationController->gitAdd() */
// 		url : `${baseUrl}/install/git-add`,
// 		method : 'post',
// 		dataType: 'json',
// 		  processData: false, // important
// 		  contentType: false, // important
// 		  success : function(result)
// 		  {
// 		  	if(result[0] == "Success")
// 		  	{
// 		  		$('#lbl_task').html('<i>Update gitignore file.</i>');
// 		  		INSTALL.gitCommit();
// 		  	}
// 		  	else
// 		  	{
// 		  		Toast.fire({
// 		  			icon: 'error',
// 		  			title: `Error! <br>${result[1]}`,
// 		  		});
// 		  	}
// 		  }
// 		});
// }

// thisInstall.gitCommit = function()
// {
// 	$.ajax({
// 		  /* InstallationController->gitCommit() */
// 		url : `${baseUrl}/install/git-commit`,
// 		method : 'post',
// 		dataType: 'json',
// 		  processData: false, // important
// 		  contentType: false, // important
// 		  success : function(result)
// 		  {
// 		  	if(result[0] == "Success")
// 		  	{
// 		  		$('#lbl_task').html('<i>Save gitignore file.</i>');
// 		  		INSTALL.gitRemote();
// 		  	}
// 		  	else
// 		  	{
// 		  		Toast.fire({
// 		  			icon: 'error',
// 		  			title: `Error! <br>${result[1]}`,
// 		  		});
// 		  	}
// 		  }
// 		});
// }

// thisInstall.gitRemote = function()
// {
// 	$.ajax({
// 		  /* InstallationController->gitRemote() */
// 		url : `${baseUrl}/install/git-remote`,
// 		method : 'post',
// 		dataType: 'json',
// 		  processData: false, // important
// 		  contentType: false, // important
// 		  success : function(result)
// 		  {
// 		  	if(result[0] == "Success")
// 		  	{
// 		  		$('#lbl_task').html('<i>Create Remote Repository</i>');
// 		  		$('#div_stepSix').prop('hidden',true);
// 		  		$('#div_stepSeven').prop('hidden',false);
// 		  	}
// 		  	else
// 		  	{
// 		  		Toast.fire({
// 		  			icon: 'error',
// 		  			title: `Error! <br>${result[1]}`,
// 		  		});
// 		  	}
// 		  }
// 		});
// }

thisInstall.complete = function()
{
	window.location.replace(baseUrl);
}

return thisInstall;

})();
