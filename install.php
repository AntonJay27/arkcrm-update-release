<?php

$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.env'))
{
    $uri = (isset($_SERVER['HTTPS']))? 'https://' : 'http://' . $_SERVER['SERVER_NAME'] . '/' . $uriSegments[1] . '/login';
    header('Location:'.$uri);
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Installation Wizard</title>
	<!-- Icon -->
	<link rel="icon" href="public/assets/img/arkonorllc-logo-edited.png">
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="public/assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="public/assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Sweet alert -->
	<link rel="stylesheet" href="public/assets/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<!-- Toaster -->
	<link rel="stylesheet" href="public/assets/AdminLTE/plugins/toastr/toastr.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="public/assets/AdminLTE/dist/css/adminlte.min.css">

	<style type="text/css">

		@media only screen and (min-width: 992px) {
		  #myVideo {
	        width: 100%;
	        height: auto;
	    }
		}

		@media only screen and (max-width: 768px) {
		  #myVideo {
	        width:auto;
	        height: 100%;
	    }
		}

		#div_videoContainer
		{
			position: absolute;
	    width: 100%;
	    top: 0;
	    height: 100%;
	    pointer-events: none;
	    z-index: 0;
	    overflow: hidden;
	    left: 0;
	    background: rgba(0, 0, 0, 0.9);
		}

		#myVideo {
		  position: fixed;
		}

		/* Add some content at the bottom of the video/page */
		.content {
		  position: absolute;
		  top: 0;
		  left: 0;
		  overflow: hidden;
		  width: 100%;
		}

		/* width */
		::-webkit-scrollbar {
		  width: 5px;
		}

		/* Track */
		::-webkit-scrollbar-track {
		  background: #f1f1f1; 
		}
		 
		/* Handle */
		::-webkit-scrollbar-thumb {
		  background: #888; 
		}

		/* Handle on hover */
		::-webkit-scrollbar-thumb:hover {
		  background: #555; 
		}

		#form_systemConfiguration input {
			font-weight: bold;
			color : black;
		}
	</style>

</head>
<body style="background: rgba(0, 0, 0, 0.9);">

	<div id="div_videoContainer">
		<video autoplay muted loop id="myVideo">
		  <source src="public/assets/img/arkonor-video.mp4" type="video/mp4">
		</video>
	</div>

	<div class="content">
	  <div class="container">

	  	<center>
	  		<img src="public/assets/img/arkcrmlogo.png" height="100%" class="img img-round">
	  	</center>

	  	<div class="card card-outline card-primary" style="background: rgba(0, 0, 0, 0.9);">
		  	<div class="card-body">
		  		<div class="mb-5">
			  		<h2 class="card-title text-white">Installation Wizard</h2>
				  	<button type="button" class="btn btn-tool float-right" title="Help">
				  		<i class="fas fa-question"></i>
				  	</button>
		  		</div>	  		
		  		
		  		<div class="mb-2" id="div_stepOne">
		  			<div class="row mb-3">
		  				<div class="col-sm-4">
		  					<center>
		  						<img src="public/assets/img/crm-icon.png" width="80%" class="img img-round">
		  					</center>		  					
		  				</div>
		  				<div class="col-sm-8">
		  					<div class="d-none d-lg-block" style="margin-top: 105px;">
		  						<h2 class="text-white">Welcome to Arkonor CRM Setup Wizard</h2>
		  						<h6 class="text-muted">This wizard will guide you through the installation of Arkonor CRM</h6>	
		  					</div>
		  					<div class="d-inline d-lg-none">
		  						<center>
		  							<h2 class="text-white">Welcome to Arkonor CRM Setup Wizard</h2>
		  							<h6 class="text-muted">This wizard will guide you through the installation of Arkonor CRM</h6>	
		  						</center>
		  					</div>			
		  				</div>
		  			</div>
		  			<button class="btn btn-sm btn-primary float-right" id="btn_stepOneInstall">&emsp;Install&emsp;</button>
		  		</div>

		  		<div class="mb-2" id="div_stepTwo" hidden>
		  			<center>
		  				<h3 class="text-white">Public License & Privacy Policy</h3>
		  			</center>
		  			<div class="mb-3 p-2" style="max-height: 45vh; overflow-x: auto; border: 1px solid grey;">
		  				<p class="text-muted">
		  					Where does it come from?
		  					Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

		  					The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.

		  					Where does it come from?
		  					Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

		  					The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
		  				</p>
		  			</div>		  			
		  			<button class="btn btn-sm btn-primary float-right" id="btn_stepTwoIAgree">&emsp;I Agree&emsp;</button>
		  		</div>

		  		<div class="mb-2" id="div_stepThree" hidden>
		  			<center>
		  				<h3 class="text-white">Server Requirements</h3>
		  			</center>
		  			<table class="table table-sm table-bordered mt-2 mb-1 text-muted" id="tbl_phpConfig">
		  				<thead>
		  					<tr>
		  						<th width="30%">PHP Configuration</th>
		  						<th>Required Value</th>
		  						<th>Present Value</th>
		  					</tr>
		  				</thead>
		  				<tbody>
		  					
		  				</tbody>
		  			</table>

		  			<table class="table table-sm table-bordered text-muted">
		  				<tbody>
		  					<tr>
		  						<td width="30%">Database Requirements</td>
		  						<td>MySQL (5.1+) via the MySQLi driver</td>
		  					</tr>
		  				</tbody>
		  			</table>

		  			<div class="float-right">
		  				<button class="btn btn-sm btn-default" id="btn_stepThreeBack">&emsp;Back&emsp;</button>
		  				<button class="btn btn-sm btn-primary" id="btn_stepThreeNext">&emsp;Next&emsp;</button>
		  			</div>		  			
		  		</div>

		  		<div class="mb-2" id="div_stepFour" hidden>
		  			<center>
		  				<h3 class="text-white">System Configuration</h3>
		  			</center>
		  			<form id="form_systemConfiguration">
		  				<h6 class="text-warning" id="lbl_warningMsg" hidden>Oops, password confirmation not match!</h6>
		  				<div class="row">
		  					<div class="col-sm-12 col-lg-6">
		  						<table class="table table-sm table-bordered text-muted">
		  							<thead>
		  								<tr>
		  									<th colspan="2"><center>Database Configuration</center></th>
		  								</tr>
		  							</thead>
		  							<tbody>
		  								<tr>
		  									<th width="50%">Database Type</th>
		  									<td>
		  										<input type="text" class="form-control form-control-sm" id="txt_databaseType" name="txt_databaseType" value="MYSQL" readonly>
		  									</td>
		  								</tr>
		  								<tr>
		  									<th width="50%">Host Name <span class="text-red">*</span></th>
		  									<td>
		  										<input type="text" class="form-control form-control-sm" id="txt_hostName" name="txt_hostName" required>
		  									</td>
		  								</tr>
		  								<tr>
		  									<th width="50%">User Name <span class="text-red">*</span></th>
		  									<td>
		  										<input type="text" class="form-control form-control-sm" id="txt_hostUserName" name="txt_hostUserName" required>
		  									</td>
		  								</tr>
		  								<tr>
		  									<th width="50%">Password</th>
		  									<td>
		  										<input type="password" class="form-control form-control-sm" id="txt_hostUserPassword" name="txt_hostUserPassword">
		  									</td>
		  								</tr>
		  								<tr>
		  									<th width="50%">Database Name <span class="text-red">*</span></th>
		  									<td>
		  										<input type="text" class="form-control form-control-sm" id="txt_databaseName" name="txt_databaseName" required>
		  									</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  						<div class="custom-control custom-checkbox mb-3">
			  						<input class="custom-control-input" type="checkbox" id="chk_createDatabase" name="chk_createDatabase">
			  						<label for="chk_createDatabase" class="custom-control-label text-white">Create New Database</label>
		  						</div>
		  					</div>
		  					<div class="col-sm-12 col-lg-6">
		  						<table class="table table-sm table-bordered text-muted">
		  							<thead>
		  								<tr>
		  									<th colspan="2"><center>Admin User Information</center></th>
		  								</tr>
		  							</thead>
		  							<tbody>
		  								<tr>
		  									<th width="50%">First Name</th>
		  									<td>
		  										<input type="text" class="form-control form-control-sm" id="txt_firstName" name="txt_firstName">
		  									</td>
		  								</tr>
		  								<tr>
		  									<th width="50%">Last Name <span class="text-red">*</span></th>
		  									<td>
		  										<input type="text" class="form-control form-control-sm" id="txt_lastName" name="txt_lastName" required>
		  									</td>
		  								</tr>
		  								<tr>
		  									<th width="50%">Email <span class="text-red">*</span></th>
		  									<td>
		  										<input type="email" class="form-control form-control-sm" id="txt_email" name="txt_email" required>
		  									</td>
		  								</tr>
		  								<tr>
		  									<th width="50%">User Name <span class="text-red">*</span></th>
		  									<td>
		  										<input type="text" class="form-control form-control-sm" id="txt_username" name="txt_username" required>
		  									</td>
		  								</tr>
		  								<tr>
		  									<th width="50%">Password <span class="text-red">*</span></th>
		  									<td>
		  										<input type="password" class="form-control form-control-sm" id="txt_password" name="txt_password" required>
		  									</td>
		  								</tr>
		  								<tr>
		  									<th width="50%">Retype Password <span class="text-red">*</span></th>
		  									<td>
		  										<input type="password" class="form-control form-control-sm" id="txt_retypePassword" name="txt_retypePassword" required>
		  									</td>
		  								</tr>
		  							</tbody>
		  						</table>
		  					</div>
		  				</div>
		  				<div class="float-right">
		  					<button type="button" class="btn btn-sm btn-default" id="btn_stepFourBack">&emsp;Back&emsp;</button>
		  					<button type="submit" class="btn btn-sm btn-primary" id="btn_stepFourNext">&emsp;Next&emsp;</button>
		  				</div>
		  			</form>
		  		</div>

		  		<div class="mb-2" id="div_stepFive" hidden>
		  			<h6 class="text-warning">IMPORTANT: Please don't reload the page, it will interrupt your installation process!</h6>
		  			<div class="mb-3" style="max-height: 50vh; overflow-x: auto;">
		  				<div id="div_msgResult">
			  				<div class="alert alert-danger" role="alert">
			  				  <b>Unable to connect to database Server. Invalid mySQL Connection Parameters specified This may be due to the following reasons:</b><br>
									-specified database user, password, hostname, database type, or port is invalid.<br>
									-specified user does not have access to connect to the database server from the host.
			  				</div>
		  				</div>
		  				<table class="table table-sm table-bordered mb-1" width="100%">
		  					<thead>
		  						<tr class="bg-dark">
		  							<th colspan="2">Database Information</th>
		  						</tr>
		  					</thead>
		  					<tbody>
		  						<tr class="text-white">
		  							<td width="50%">Database Type <span class="text-red">*</span></td>
		  							<td><span style="font-weight:bold;" id="lbl_databaseType"></span></td>
		  						</tr>
		  						<tr class="text-white">
		  							<td width="50%">Database Name <span class="text-red">*</span></td>
		  							<td><span style="font-weight:bold;" id="lbl_databaseName"></span></td>
		  						</tr>
		  					</tbody>
		  				</table>
		  				<table class="table table-sm table-bordered mb-1" width="100%">
		  					<thead>
		  						<tr class="bg-dark">
		  							<th colspan="2">System Information</th>
		  						</tr>
		  					</thead>
		  					<tbody>
		  						<tr class="text-white">
		  							<td width="50%">URL <span class="text-red">*</span></td>
		  							<td><span style="font-weight:bold;" id="lbl_url"></span></td>
		  						</tr>
		  					</tbody>
		  				</table>
		  				<table class="table table-sm table-bordered mb-0" width="100%">
		  					<thead>
		  						<tr class="bg-dark">
		  							<th colspan="2">Admin User Information</th>
		  						</tr>
		  					</thead>
		  					<tbody>
		  						<tr class="text-white">
		  							<td width="50%">User Name <span class="text-red">*</span></td>
		  							<td><span style="font-weight:bold;" id="lbl_userName"></span></td>
		  						</tr>
		  						<tr class="text-white">
		  							<td width="50%">Complete Name</td>
		  							<td><span style="font-weight:bold;" id="lbl_completeName"></span></td>
		  						</tr>
		  						<tr class="text-white">
		  							<td width="50%">Email <span class="text-red">*</span></td>
		  							<td><span style="font-weight:bold;" id="lbl_email"></span></td>
		  						</tr>
		  					</tbody>
		  				</table>
		  			</div>
		  			<div class="float-right">
		  				<button type="button" class="btn btn-sm btn-default" id="btn_stepFiveBack">&emsp;Back&emsp;</button>
		  				<button type="button" class="btn btn-sm btn-primary" id="btn_stepFiveNext">&emsp;Next&emsp;</button>
		  			</div>
		  		</div>

		  		<div id="div_stepSix" hidden>
		  			<center>
		  				<h3 class="text-white">Installation in progress</h3>
		  				<h5 class="text-muted" id="lbl_pleaseWait">please wait...</h5>
		  			</center>
		  			<br>
		  			<div class="progress">
			  			<div class="progress-bar bg-primary progress-bar-striped" id="div_progressBar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%; animation: progress-bar-stripes 1s linear infinite;">
			  			</div>
		  			</div>
		  			<center>	
				  		<span class="text-sm text-muted" id="lbl_percent">0% Complete</span><br>
				  		<span class="text-xs text-muted" id="lbl_task"><i>...</i></span>
		  			</center>	
		  			<br><br>	  			
		  		</div>

		  		<div id="div_stepSeven" hidden>
		  			<center>
		  				<h3 class="text-white">Welcome to Arkonor CRM</h3>
		  				<h5 class="text-muted">Hurray, your installation setup was completely successful!</h5>
		  				<br>
		  				<button type="button" onclick="INSTALL.complete();" class="btn btn-outline-primary btn-lg">Click to Start</button>
		  				<br><br><br>
		  			</center>			
		  		</div>
		  		
		  	</div>
	  	</div>

	  	<center>
	  		<small>
	  			<span style="word-spacing: 5px; color: #f1f1f1;">
	  				Powered by Arkonor LLC CRM 1.0.0 &#169; <?php echo date('2022') ?>
	  				<div class="d-inline d-lg-none"><br></div>
	  				<a href="https://arkonorllc.com" target="_blank">arkonorllc.com</a> | 
	  				<a href="javascript:void(0)">Read License</a> | 
	  				<a href="javascript:void(0)">Privacy Policy</a>
	  			</span>
	  		</small>
	  	</center>

	  	<div class="mb-3"></div>

	  </div>
	</div>

	<?php $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>
	<?php $security = (isset($_SERVER['HTTPS']))? 'https://' : 'http://'; ?>
  
	<input type="hidden" id="txt_baseUrl" value="<?php echo $security . $_SERVER['SERVER_NAME']  . '/' . $uriSegments[1]; ?>">
  

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="public/assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Sweet Alert -->
	<script src="public/assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- Toaster -->
	<script src="public/assets/AdminLTE/plugins/toastr/toastr.min.js"></script>
	<!-- AdminLTE App -->
	<script src="public/assets/AdminLTE/dist/js/adminlte.min.js"></script>
	<!-- custom script -->
	<script src="public/assets/js/install.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){

			// $('#div_stepOne').prop('hidden',true);
			$('#div_stepTwo').prop('hidden',true);
			$('#div_stepThree').prop('hidden',true);
			$('#div_stepFour').prop('hidden',true);
			$('#div_stepFive').prop('hidden',true);
			$('#div_stepSix').prop('hidden',true);
			$('#div_stepSeven').prop('hidden',true);


			$('#btn_stepOneInstall').on('click',function(){
				$('#div_stepOne').prop('hidden',true);
				$('#div_stepTwo').prop('hidden',false);
				$('#div_stepThree').prop('hidden',true);
				$('#div_stepFour').prop('hidden',true);
				$('#div_stepFive').prop('hidden',true);
				$('#div_stepSix').prop('hidden',true);
				$('#div_stepSeven').prop('hidden',true);
			});

			$('#btn_stepTwoIAgree').on('click',function(){
				$('#div_stepOne').prop('hidden',true);
				$('#div_stepTwo').prop('hidden',true);
				$('#div_stepThree').prop('hidden',false);
				$('#div_stepFour').prop('hidden',true);
				$('#div_stepFive').prop('hidden',true);
				$('#div_stepSix').prop('hidden',true);
				$('#div_stepSeven').prop('hidden',true);
				INSTALL.submitStepTwo();
			});


			$('#btn_stepThreeBack').on('click',function(){
				$('#div_stepOne').prop('hidden',true);
				$('#div_stepTwo').prop('hidden',false);
				$('#div_stepThree').prop('hidden',true);
				$('#div_stepFour').prop('hidden',true);
				$('#div_stepFive').prop('hidden',true);
				$('#div_stepSix').prop('hidden',true);
				$('#div_stepSeven').prop('hidden',true);
				INSTALL.stepThreeBack();
			});
			$('#btn_stepThreeNext').on('click',function(){
				$('#div_stepOne').prop('hidden',true);
				$('#div_stepTwo').prop('hidden',true);
				$('#div_stepThree').prop('hidden',true);
				$('#div_stepFour').prop('hidden',false);
				$('#div_stepFive').prop('hidden',true);
				$('#div_stepSix').prop('hidden',true);
				$('#div_stepSeven').prop('hidden',true);
			});


			$('#btn_stepFourBack').on('click',function(){
				$('#div_stepOne').prop('hidden',true);
				$('#div_stepTwo').prop('hidden',true);
				$('#div_stepThree').prop('hidden',false);
				$('#div_stepFour').prop('hidden',true);
				$('#div_stepFive').prop('hidden',true);
				$('#div_stepSix').prop('hidden',true);
				$('#div_stepSeven').prop('hidden',true);
			});
			$('#form_systemConfiguration').on('submit',function(e){
				e.preventDefault();
				INSTALL.submitStepFour(this);			
			});


			$('#btn_stepFiveBack').on('click',function(){
				$('#div_stepOne').prop('hidden',true);
				$('#div_stepTwo').prop('hidden',true);
				$('#div_stepThree').prop('hidden',true);
				$('#div_stepFour').prop('hidden',false);
				$('#div_stepFive').prop('hidden',true);
				$('#div_stepSix').prop('hidden',true);
				$('#div_stepSeven').prop('hidden',true);
			});
			$('#btn_stepFiveNext').on('click',function(){
				INSTALL.submitStepFive();
			});

		});
		
	</script>
</body>
</html>