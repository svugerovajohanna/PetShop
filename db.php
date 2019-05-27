<?php

require_once __DIR__.'/database/UsersDB.php';
require_once __DIR__.'/database/CategoriesDB.php';
require_once __DIR__.'/database/ProductsDB.php';



$usersDB = new UsersDB('users');
$categoriesDB = new CategoriesDB('categories');
$productsDB = new CategoriesDB('products');


?>