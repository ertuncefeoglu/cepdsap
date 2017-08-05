<!DOCTYPE html>
<html ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>cepdsap - AngularJS login and security</title>
    <link href="app/css/bootstrap.min.css" rel="stylesheet">
    <link href="app/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="app/css/app.css" rel="stylesheet" />

</head>
<body class="container">
	<div id="fullscreen_bg" class="fullscreen_bg"/>

		<ng-view></ng-view>

		<script src="app/lib/angular/angular.min.js"></script>
		<script src="app/lib/angular/angular-route.min.js"></script>
		<script src="app/lib/angular/angular-resource.min.js"></script>
		<script src="app/lib/angular/angular-sanitize.min.js"></script>
		<script src="app/js/app.js"></script>
		<script src="app/js/controllers.js"></script>
		<script src="app/js/directives.js"></script>
		<script src="app/js/filters.js"></script>
		<script src="app/js/services.js"></script>
		<script>
		    angular.module("myApp").constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>'); 
		</script>
	</div>	
</body>
</html>