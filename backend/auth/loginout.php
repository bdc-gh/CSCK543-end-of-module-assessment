<?php
session_start();
// Removing the user ID ends the logged-in state used by protected pages.
unset($_SESSION['user_id']);

header('Location: ../../views/auth/login.php');
exit;
