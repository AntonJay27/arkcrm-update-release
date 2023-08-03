<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	{{ $subjectTitle }}
	
	{{ $emailContent }}

	@if($unsubscribeLink != "")
	<a href="<?php echo base_url(); ?>/{{ $unsubscribeLink }}">Unsubscribe</a>
	@endif
</body>
</html>