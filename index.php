<?php
require 'include/config.php';

session_start();

$loginresult='';
$action='';
$isloggedin = false;

if(isset($_GET['action'])) {
	$action = $_GET['action'];
} elseif(isset($_POST['action'])) {
	$action = $_POST['action'];
}

if($action == 'logout') {
	$_SESSION['isloggedin'] = false;
	header('Location: ' . $_SERVER['PHP_SELF']);
}

if(isset($_POST['username'])) {
	//default behavior: not logged in
	$loginresult = 'Invalid Login';
	$_SESSION['isloggedin'] = false;

	if(isset($userinfo[$_POST['username']])) {
		if($userinfo[$_POST['username']] == $_POST['password']) {
			$_SESSION['isloggedin'] = true;
			$loginresult = '';
		}
	}

	//log the wrong input username and password
	if($_SESSION['isloggedin'] == false) {
		error_log($_SERVER['REMOTE_ADDR'] . " Username=" . $_POST['username'] . " Password=" . $_POST['password']);
	}
}

if(isset($_SESSION['isloggedin'])) {
	$isloggedin = $_SESSION['isloggedin'];
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="robots" content="noindex, nofollow">
	<meta name="google-site-verification" content="<?php echo $google_site_verification ?>" />

	<title>Lab5</title>

    <!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for login -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Custom styles for authenticated section -->
	<link href="css/starter-template.css" rel="stylesheet">

    </head>
<body>

<!-- Authenticated section -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
	<a class="navbar-brand" href="/"><img src="logo.png" alt="Lab5" width="120"></a>
	<?php if($isloggedin): ?>
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
				<li class="nav-item <?php echo ($action=='camlastpic'? 'active' : '') ?>">
					<a class="nav-link" href="?action=camlastpic">Current picture</a>
				</li>
				<li class="nav-item <?php echo ($action=='campiclist'? 'active' : '') ?>">
					<a class="nav-link" href="?action=campiclist">Last pictures</a>
				</li>
				<li class="nav-item <?php echo ($action=='camsetting'? 'active' : '') ?>">
					<a class="nav-link" href="?action=camsetting">Camera settings</a>
				</li>
				<li class="nav-item <?php echo ($action=='theftprot'? 'active' : '') ?>">
					<a class="nav-link disabled" href="#">Theft Protection</a>
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
			<a class="btn btn-outline-danger" href="?action=logout" role="button">Logout</a>
		</div>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="js/jquery-3.2.1.slim.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

	<?php endif //if($isloggedin) ?>
</nav>

<main role="main" class="container">
	<div class="starter-template">
		<?php if($isloggedin == false): ?>
			<!-- Login form -->
			<form class="form-signin" name="login" method="post">
				<!--
				<h2 class="form-signin-heading">Sign in</h2>
				-->
				<!-- <label for="username" class="sr-only">Email address</label> -->
				<input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
				<!-- <label for="password" class="sr-only">Password</label> -->
				<input type="password" name="password" class="form-control" placeholder="Password" required>
				<button class="btn btn-dark btn-lg btn-primary btn-block" type="submit">Login</button>
			</form>
		<?php else: ?>
			<!-- Content for authenticated section -->
			<?php switch ($action):
				case 'camlastpic': ?>
					<?php require 'include/camlastpic.php'; ?>
					<?php break; ?>
				<?php case 'campiclist': ?>
					<?php require 'include/campiclist.php'; ?>
					<?php break; ?>
				<?php case 'camsetting': ?>
					<?php require 'include/camsetting.php'; ?>
					<?php break; ?>
				<?php case 'theftprot': ?>
					to be done
					<?php break; ?>
				<?php default: ?>
					<h1>Welcome to <?php echo $sitename ?></h1>
					<p class="lead">Select an action in the above menu</p>
			<?php endswitch ?>
		<?php endif //if($isloggedin == false) ?>
	</div>
</main><!-- /.container -->

</body>
</html>