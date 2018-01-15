<?php
require 'config.php';

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
<html>
<head>
<link rel="stylesheet" rev="stylesheet" href="style.css" type="text/css">
<title>Lab5</title>
<meta name="robots" content="noindex, nofollow">
<meta name="google-site-verification" content="XpGpZSCzs2HuMlW7PwniP9rXhva7fQSKjpPq6abuXLY" />
<style>
body {
    background-color: white;
}

table, th, td {
   border: 1px solid black;
}

table {
    width: 95%;
}

.wrapper {
	width: 330px;
	float: left;
}

.wrapper img {
	float: left;
	width: 320px;
	/* height: 100px; */
	margin: 5px 7px;
}

</style>
</head>
<body>
<p align="center">

<table>
<tr id="header_container">
	<td>
		<p>
			<b>This is Lab5</b> <?php echo (ENVIRONMENT=='TST'? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEST ENVIRONMENT' : '') ?>
		</p>
		<p>
			Your IP: <?php echo $_SERVER['REMOTE_ADDR']; ?><br />
			Local time: <?php echo date('d/m/Y H:i:s'); ?>
		</p>
	</td>
	<td width="30%">
		<p>
		<?php if($isloggedin): ?>
			You are logged in<br /><br />
			<a href="?action=logout">Logout</a>
		<?php else: ?>
			<?php echo $loginresult ?>
			<form name="login" action="index.php" method="post">
				Username: <input type="text" name="username" value="" /><br />
				Password: <input type="password" name="password" value="" /><br />
				<input type="submit" name="submit" value="Submit" />
			</form>	
		<?php endif ?>
		</p>
	</td>
</tr>
</table>

<br />

<?php if($isloggedin): ?>
	<?php if($local_cfg_is_set == 'no'): ?>
		Camera settings not defined. See files 'config.php' and 'config_local.php'.
	<?php else: ?>
		<table>
	
		<tr id="topnav_container">
			<td <?php echo ($action=='camlastpic'? 'id="topnavon"' : 'id="topnavoff"') ?> width="25%"><a href="?action=camlastpic">Camera Last Picture</a></td>
			<td <?php echo ($action=='campiclist'? 'id="topnavon"' : 'id="topnavoff"') ?> width="25%"><a href="?action=campiclist">Camera Pictures</a></td>
			<td <?php echo ($action=='camsetting'? 'id="topnavon"' : 'id="topnavoff"') ?> width="25%"><a href="?action=camsetting">Camera Settings</a></td>
			<td <?php echo ($action=='theftprot'? 'id="topnavon"' : 'id="topnavoff"') ?> width="25%"><a href="?action=theftprot">Theft Protection</a></td>
		</tr>
		<tr>
			<td colspan="4">
			<br />
		<?php
		switch ($action) {
			case 'camlastpic':
				//retrieve last picture from cam
				//if(ENVIRONMENT=='TST'){
				//	$lastimage = 'http://www.google.com/doodle4google/images/d4g_logo_global.jpg';
				//} else {
					$lastimage = CAM_LAST_PIC_URL;
				//}

				$chkautorefresh = 'off';
				IF (isset($_POST['chkautorefresh'])) {
					$chkautorefresh = $_POST['chkautorefresh'];
				}
				
				//echo '$chkautorefresh: ' . $chkautorefresh;

				echo '
					<script>
					function setAutoRefresh() {
						document.getElementById("camlastpic").submit();
					}
					setTimeout(function() {
						//alert(document.getElementById("chkautorefresh").checked)
						if(document.getElementById("chkautorefresh").checked) {
							document.getElementById("camlastpic").submit();
						}
					}, 3000);
					</script>
					<form name="camlastpic" id="camlastpic" action="index.php" method="post">
					<input type="hidden" name="action" id="action" value="camlastpic" />
					Auto refresh every 3 seconds <input type="checkbox" name="chkautorefresh" id="chkautorefresh" onclick="setAutoRefresh()" ' . ($chkautorefresh=='on'? 'checked' : '') . ' /> <br /><br />
					</form>
				';
				$imageData = base64_encode(file_get_contents($lastimage));
				echo '<img src="data:image/jpeg;base64,'.$imageData.'" width="640">';
				break;
			case 'campiclist':
				//retrieve last motion detection pictures
				$directory = PICFOLDER;
				$images = glob($directory . "*.jpg");
				//usort($images, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));
				usort($images, create_function('$b,$a', 'return filemtime($a) - filemtime($b);'));

				$picsperpage = 12;
				$goto = 'first';
				$curpage = 1;
				$totalpages = 0;
				$startpic = 0;

				IF (isset($_POST['picsperpage'])) {
					$picsperpage = $_POST['picsperpage'];
				}
				IF (isset($_POST['goto'])) {
					$goto = $_POST['goto'];
				}
				IF (isset($_POST['curpage'])) {
					$curpage = $_POST['curpage'];
				}
				$totalpages = round(count($images) / $picsperpage);

				switch($goto) {
					case 'first':
						$curpage = 1;
						break;
					case 'prev':
						IF ($curpage > 1) {
							$curpage--;
						}
						break;
					case 'next':
						IF ($curpage < $totalpages) {
							$curpage++;
						}
						break;
					case 'last':
						$curpage = $totalpages;
						break;
					default:
						$curpage = 1;
						break;
				}
				
				$startpic = (($curpage*$picsperpage)-$picsperpage)+1;
				
				/*
				echo 'picsperpage: ' . $picsperpage . '<br>';
				echo 'goto: ' . $goto . '<br>';
				echo 'totalpages: ' . $totalpages . '<br>';
				echo 'startpic: ' . $startpic . '<br>';
				*/
				
				//form opening
				echo '
					<script>
					function goToPage(destination) {
						//alert(destination);
						document.getElementById("goto").value = destination;
						//alert(document.getElementById("goto").value);
						document.getElementById("formcampiclist").submit();
					}
					</script>
					<form name="formcampiclist" id="formcampiclist" action="index.php" method="post">
					<input type="hidden" name="action" id="action" value="campiclist" />
					<input type="hidden" name="goto" id="goto" value="" />
					<input type="hidden" name="curpage" id="curpage" value="' . $curpage . '" />
					Images per page:&nbsp;
					<select name="picsperpage" onchange="goToPage(\'first\')">
						<option value="12"' . ($picsperpage==12? 'selected' : '') . '>12</option>
						<option value="24"' . ($picsperpage==24? 'selected' : '') . '>24</option>
						<option value="36"' . ($picsperpage==36? 'selected' : '') . '>36</option>
						<option value="48"' . ($picsperpage==48? 'selected' : '') . '>48</option>
						<option value="60"' . ($picsperpage==60? 'selected' : '') . '>60</option>
					</select>
				';
				//echo '<input type="submit" name="btnSubmit" value="  OK  " />';
				echo '&nbsp;&nbsp;';
				echo 'Page ' . $curpage . '/' . $totalpages;
				echo '&nbsp;&nbsp;';
				echo '<input type="button" name="gofirst" value="<<" onclick="goToPage(\'first\')"' . ($curpage==1? 'disabled' : '') . '/>';
				echo '<input type="button" name="goprev"  value="<-" onclick="goToPage(\'prev\')"' . ($curpage==1? 'disabled' : '') . ' />';
				echo '<input type="button" name="gonext"  value="->" onclick="goToPage(\'next\')"' . ($curpage==$totalpages? 'disabled' : '') . ' />';
				echo '<input type="button" name="golast"  value=">>" onclick="goToPage(\'last\')"' . ($curpage==$totalpages? 'disabled' : '') . ' />';
				echo '&nbsp;&nbsp;Total images ' . count($images);
				echo '&nbsp;&nbsp;';
				echo '</form>';
				//form closing

				//echo '<br />';

				$cnt = 1;
				foreach($images as $image) {
					
					$imageFileName = substr($image, strrpos($image, '/', -1)+1);
					$imageDateTime = date("d/m/Y H:i:s", filemtime($image));
					$imageData = base64_encode(file_get_contents($image));

					IF($cnt >= $startpic) {
						//show the image
						echo '<div class="wrapper">';
						echo '<img src="data:image/jpeg;base64,'.$imageData.'" width="320"><br />';
						echo sprintf('%04d', $cnt) . ') ' . $imageFileName . ' ' . $imageDateTime . '<br />';
						echo '</div>';
					}

					$cnt++;
					if ($cnt > ($picsperpage*$curpage)) {
						break;
					}
				}
				break;
			case 'camsetting':
				/*
				IF(ENVIRONMENT=='TST'){
					echo 'not available with the current environment';
				} else {
				*/

					$url = '';
					$camsettingcfg = '';
					IF (isset($_POST['camsettingcfg'])) {
						$camsettingcfg = $_POST['camsettingcfg'];
					}

					switch($camsettingcfg) {
						case 'setMotionOff':
							$url = CAM_URL . 'setSystemMotion?MotionDetectionEnable=0&ReplyErrorPage=motion.htm&ReplySuccessPage=motion.htm&ConfigSystemMotion=Save';
							break;
						case 'setMotionOn':
							$url = CAM_URL . 'setSystemMotion?MotionDetectionEnable=1&ReplyErrorPage=motion.htm&ReplySuccessPage=motion.htm&ConfigSystemMotion=Save';
							break;
						case 'setDateNightAuto':
							$url = CAM_URL . 'setDayNightMode?DayNightMode=0&ReplyErrorPage=errrnght.htm&ReplySuccessPage=night.htm&ConfigDayNightMode=Save';
							break;
						case 'setDateNightAlwaysDayMode':
							$url = CAM_URL . 'setDayNightMode?DayNightMode=2&ReplyErrorPage=errrnght.htm&ReplySuccessPage=night.htm&ConfigDayNightMode=Save';
							break;
						default:
							$url = '';
							break;
					}

					/*
					setSystemMotion				

					Disable:
					ConfigSystemMotion: Save
					MotionDetectionEnable: 0
					MotionDetectionScheduleDay: 62
					ReplyErrorPage: motion.htm
					ReplySuccessPage: motion.htm

					Enable:
					ConfigSystemMotion: Save
					MotionDetectionEnable: 1
					MotionDetectionScheduleDay: 62
					MotionDetectionScheduleMode: 0
					MotionDetectionSensitivity: 70
					ReplyErrorPage: motion.htm
					ReplySuccessPage: motion.htm
					
					setDayNightMode
					ConfigDayNightMode: Save
					DayNightMode: Auto=0 / AlwaysDayMode=2
					ReplyErrorPage: errrnght.htm
					ReplySuccessPage: night.htm
					*/

					IF ($url != '') {
						//apply defined settings
						//echo 'url: ' . $url;

						$ch = curl_init($url);
						$http_headers = array(
							'User-Agent: Junk', // Any User-Agent will do here
						);
						curl_setopt($ch, CURLOPT_HEADER, true);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						
						$response = curl_exec($ch);
						curl_close($ch);

						//echo '<div>response: ' . $response . '</div>';
					}
				
					require('simple_html_dom.php');

					echo 
						'<script>
						function applyCamSetting(cfg) {
							document.getElementById("camsettingcfg").value = cfg;
							document.getElementById("formcamsetting").submit();
						}
						</script>
						<form name="formcamsetting" id="formcamsetting" action="index.php" method="post">
						<input type="hidden" name="action" id="action" value="camsetting" />
						<input type="hidden" name="camsettingcfg" id="camsettingcfg" value="' . $camsettingcfg . '" />
						</form>';

					// motion detection start
					$url = CAM_URL . 'motion.htm';
		
					$ch = curl_init($url);
					$http_headers = array(
						'User-Agent: Junk', // Any User-Agent will do here
					);
					curl_setopt($ch, CURLOPT_HEADER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					
					$response = curl_exec($ch);
					curl_close($ch);

					//echo '<div>response: ' . $response . '</div>';

					// Create a DOM object
					$dom = new simple_html_dom();
					// Load HTML from a string
					$dom->load($response);
					
					//MotionDetectionEnable / default is false
					$motiondet = false;

					foreach($dom->find('input') as $element) {
						if ($element->type == 'radio' and $element->name == 'MotionDetectionEnable' and $element->value == '1' and $element->checked == true) {
							$motiondet = true;
						}
					}

					echo 'Motion detection is currently ' . ($motiondet? 'enabled' : 'disabled') . '. <a id="camset" href="#" onclick="applyCamSetting(\'' . ($motiondet? 'setMotionOff' : 'setMotionOn') .'\');return false;">Click here</a> to change it.<br/ >';
					// motion detection end
					
					// day/night mode start
					$url = CAM_URL . 'night.htm';
		
					$ch = curl_init($url);
					$http_headers = array(
						'User-Agent: Junk', // Any User-Agent will do here
					);
					curl_setopt($ch, CURLOPT_HEADER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					
					$response = curl_exec($ch);
					curl_close($ch);

					//echo '<div>response: ' . $response . '</div>';

					// Create a DOM object
					$dom = new simple_html_dom();
					// Load HTML from a string
					$dom->load($response);
					
					//Day/Night mode / default is auto
					$daynightauto = true;

					foreach($dom->find('input') as $element) {
						if ($element->type == 'radio' and $element->name == 'DayNightMode' and $element->value == '2' and $element->checked == true) {
							$daynightauto = false;
						}
					}
					
					echo '<br />';
					echo 'Day/Night Mode is is currently ' . ($daynightauto? 'Auto' : 'Always Day Mode') . '. <a id="camset" href="#" onclick="applyCamSetting(\'' . ($daynightauto? 'setDateNightAlwaysDayMode' : 'setDateNightAuto') .'\');return false;">Click here</a> to change it.<br/ >';
					// day/night mode end
				
					echo '<br /><br />in progress';

				//}
				break;
			case 'theftprot':
				echo 'to be done';
				break;
			default:
				echo 'select a function';
		}
		?>
			</td>
		</tr>
		</table>
	<?php endif ?>
<?php endif ?>
</p>

</body>
</html>