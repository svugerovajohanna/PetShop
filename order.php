<?php
require 'db.php';
require 'login_required.php';

date_default_timezone_set('Europe/Prague');

$productsInCart = @$_SESSION['cart'];
$payment = $_GET['pay'];
$shipping = $_GET['ship'];



$order_date = date("Y-m-d H:i:s");




$question_marks = str_repeat('?,', count($productsInCart) - 1) . '?';
    
$statement = $productsDB->getPDO()->prepare("SELECT * FROM products WHERE product_id IN ($question_marks) ORDER BY product_name");
$statement->execute(array_values($productsInCart));
$products = $statement->fetchAll();


//vytvořit objednávku
$customer = $currentUser[0]['id'];

$ordersDB->create(['user_id' => $customer,'order_date' => $order_date, 'shipping' => $shipping, 'payment' => $payment]);

$orderID = $ordersDB->getPDO()->lastInsertId();

//přidat produkty do obejdnávky
foreach($products as $product){
    $itemsDB->create(['order_code'=>$orderID, 'product'=>$product['product_id'], 'unit_price'=>$product['price']]);
}

$statement = $itemsDB->getPDO()->prepare('SELECT sum(unit_price) total_price FROM items WHERE order_code =:order_code');
$statement->execute([
    'order_code'=>$orderID
]);
$totalPrice = $statement->fetchColumn();

if(isset($totalPrice)){
    $ordersDB->updateBy(['order_code'=>$orderID], ['total_price'=>$totalPrice]);
    unset($_SESSION['cart']);
    
    header('Location: index.php');
    
    die();
}else{
    die('Chyba při výpočtu celkové ceny');
}
?>