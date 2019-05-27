<?php

require 'db.php';

session_start();

if(!isset($_SESSION["userID"])){
	header('Location: login.php');
	die();
}

if(isset($_SESSION['userID'])){
    $currentUser = $usersDB->fetchBy('id', $_SESSION['userID']);
    if (!$currentUser) {
        session_destroy();
        header('Location: index.php');
        die();
    }

}
else {
    $currentUser = $usersDB->fetchBy('email', $users['email']);
    if (!$currentUser) {
        session_destroy();
        header('Location: index.php');
        die();
    }

    $currentUser = $usersDB->fetchBy('userID', $users['id']);
    if (!$actualUser) {
        session_destroy();
        header('Location: index.php');
        die();

        $_SESSION['userID'] = $actualUser[0]['userID'];
        $_SESSION['email'] = $actualUser[0]['email'];
    }
    
}


?>