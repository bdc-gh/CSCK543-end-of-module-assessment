<?php
session_start();
unset($_SESSION['user_id']);

header('Location: /CSCK543-end-of-module-assessment/views/auth/login.php');
exit;
