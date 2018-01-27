<?php require 'include/session.php' ?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="favicon.ico">
	<meta name="robots" content="noindex, nofollow">
	<meta name="google-site-verification" content="<?php echo $google_site_verification ?>" />
	<title>Lab5</title>
    <!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for the starter template -->
    <link href="css/starter-template.css" rel="stylesheet">
    </head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
	<a class="navbar-brand" href="index.php"><img src="logo.png" alt="Lab5" width="120"></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		<ul class="navbar-nav mr-auto">
			<!--
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			-->
			<li class="nav-item">
				<a class="nav-link" href="#" onclick="loadSection('camlastpic')">Current picture</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#" onclick="loadSection('campiclist')">Last pictures</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#" onclick="loadSection('camsetting')">Camera settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#" onclick="loadSection('theftprot')">Theft Protection</a>
			</li>
			<!--
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
				<div class="dropdown-menu" aria-labelledby="dropdown01">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</li>
			-->
		</ul>
		<a class="btn btn-outline-danger" href="?action=logout" role="button">Log out</a>
	</div>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery-3.2.1.slim.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/lab5.js"></script>
</nav>

<main role="main" class="container">
	<div class="starter-template" id="starter-template">
		<h1>Welcome to <?php echo $sitename ?></h1>
		<p class="lead">Select an action in the above menu</p>
	</div>
</main><!-- /.container -->

</body>
</html>