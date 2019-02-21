<?php
require 'Session.php';
$session = new Session;

if ($_SESSION['role_id'] == 1) {
    header('Location: users_list.php');
}

if ($_SESSION['role_id'] == 2) {
    header('Location: profile.php');
}
