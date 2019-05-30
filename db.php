<?php

require_once __DIR__.'/database/UsersDB.php';
require_once __DIR__.'/database/CategoriesDB.php';
require_once __DIR__.'/database/ProductsDB.php';
require_once __DIR__.'/database/ItemsDB.php';
require_once __DIR__.'/database/OrdersDB.php';


$usersDB = new UsersDB('users');
$categoriesDB = new CategoriesDB('categories');
$productsDB = new ProductsDB('products');
$itemsDB = new ItemsDB('items');
$ordersDB = new OrdersDB('orders');


?>