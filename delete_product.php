<?php
	require 'db.php';
	require 'admin_required.php';
	
	
	
    $stmt = $productsDB->getPDO()->prepare("DELETE FROM products WHERE product_id=?");
    $stmt->execute(array($_GET['product']));
    
	header('Location: index.php');
	die();
	
	?>