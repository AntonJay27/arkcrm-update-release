<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<label>UserID: {{ $userId }}</label>
	<label>Username: {{ $userName }}</label>
	<label>Password Auth: {{ $passwordAuthCode }}</label>
	<br>
	<a href="<?php echo base_url(); ?>/change-password/{{ $userId }}/{{ $userAuthCode }}/{{ $passwordAuthCode }}">Change Password</a>
</body>
</html>