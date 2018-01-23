<?php require 'include/session.php' ?>
<?php
$loginresult = '';

if(isset($_POST['username'])) {
	//default behavior: not logged in
	$loginresult = 'InvalidLogin';
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

//normal session is present
$isloggedin = false;
if(isset($_SESSION['isloggedin'])) {
    $isloggedin = $_SESSION['isloggedin'];
}

//echo '$isloggedin: ' . $isloggedin . '<br />';

if($isloggedin == true) {
    header('Location: index.php');
    die;
}
?>
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
    <!-- Custom styles for login -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<!-- Login form -->
<form class="form-signin" name="login" method="post">
    <div class="alert bg-dark">
        <img src="logo.png" alt="Lab5" width="120">
    </div>
    <?php if($loginresult == 'InvalidLogin'): ?>
        <div class="alert alert-danger" role="alert">Invalid log in</div>
    <?php endif ?>
    <h2 class="form-signin-heading">Please log in</h2>
    <!-- <label for="username" class="sr-only">Email address</label> -->
    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
    <!-- <label for="password" class="sr-only">Password</label> -->
    <input type="password" name="password" class="form-control" placeholder="Password" required>
    <button class="btn btn-dark btn-lg btn-primary btn-block" type="submit">Log in</button>
</form>
</body>
</html>