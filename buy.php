<?php
	
	require 'db.php';
	require 'login_required.php';
	
	if(!isset($_SESSION['userID'])){
	    header('Location: login.php');
	    die();
	}
	
	if(!isset($_SESSION['cart'])){
	    $_SESSION['cart']=[];
	}
	
	$sql = "SELECT * FROM products WHERE product_id = :product_id";
	$statement = $productsDB->getPDO()->prepare($sql);
	$statement->execute(['product_id' => $_GET['product']]);
	$products = $statement->fetch();
	if (!$products){
	    die("Produkt nenalezen!");
	}
    $_SESSION['cart'][] = $products['product_id'];
	header('Location: cart.php');
	die();
	
	?>