<?php

require 'db.php';
require 'login_required.php';

$id = $_GET['id'];

foreach ($_SESSION['cart'] as $key => $value){
    if ($value == $id) {
				unset($_SESSION['cart'][$key]);
    }
}
header('Location: cart.php');
?>

?>