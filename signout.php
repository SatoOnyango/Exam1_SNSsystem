<?php
session_start();

// セッションを空にする
$_SESSION = [];
session_destroy();

header("Location: signin.php");
exit();
