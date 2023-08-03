<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('page_title')</title>
	@include('template.includes.header')	
</head>
<body class="sidebar-mini layout-navbar-fixed layout-fixed sidebar-collapse text-sm">
	<div class="wrapper">
		@include('template.includes.navbar')

		@include('template.includes.sidebar')

		@yield('page_content')

		<input type="hidden" id="txt_baseUrl" value="<?php echo base_url(); ?>">

		@include('template.includes.footer')
	</div>
</body>
</html>