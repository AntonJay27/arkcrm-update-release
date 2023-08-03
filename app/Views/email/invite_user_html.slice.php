<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<label>User ID: {{ $userId }}</label>
	<label>User Auth: {{ $userAuthCode }}</label>
	<br>
	<a href="<?php echo base_url(); ?>/sign-up/{{ $userId }}/{{ $userAuthCode }}">Sign Up</a>
</body>
</html>