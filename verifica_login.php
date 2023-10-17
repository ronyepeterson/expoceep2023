<?php
session_start();
if(!$_SESSION['login']) {
	header('Location: loginexpoceep.php');
	exit();
}
?>