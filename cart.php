<?php

require 'db.php';
require 'login_required.php';

$errors=[];



$productsInCart = @$_SESSION['cart'];
if (is_array($productsInCart) && count($productsInCart)) {
    $question_marks = str_repeat('?,', count($productsInCart) - 1) . '?';
    //retezec s otazniky pro predani seznamu ids	
    // pocet otazniku = pocet prvku v poli ids
    // pokud mam treba v ids 1,2,3, vrati mi ?,?,?	
    
    $statement = $productsDB->getPDO()->prepare("SELECT * FROM products WHERE product_id IN ($question_marks) ORDER BY product_name");
    $statement->execute(array_values($productsInCart));
    $products = $statement->fetchAll();
    
    $statementSum = $productsDB->getPDO()->prepare("SELECT SUM(price) FROM products WHERE product_id IN ($question_marks)");
    $statementSum->execute(array_values($productsInCart));
    $sum = $statementSum->fetchColumn();
}
?>

<?php require 'header.php'; ?>
<main class="container">

    <h2>Nákupní košík</h2>

    

    <?php if(@$products): ?>
    <div class="col-9">
    <div class="row">
    <?php foreach($products as $product): ?>

    <div class="col-4 mb-4">
    <div class="card border-secondary mb-3 h-100" >
      <a href="#"><img class="card-img-top" src="<?php echo $product['image']; ?>" alt=""></a>
      <div class="card-body">
        <h4 class="card-title">
          <?php echo $product['product_name']; ?>
        </h4>
        <h5 class="card-text"><b><?php echo $product['price']; ?> Kč</b></h5>
      </div>
      
        <div class="card-footer text-center">
            <!-- množství -->
        </div> 
    </div>
  </div>
  <?php endforeach ?>

    </div>
</div>
<?php else: ?>
<p>Nákupní košík je prázdný.<p>
<?php endif; ?>
    <a href="index.php"><button type="button" class="btn btn-primary">Pokračovat v nákupu</button></a> //naposled?
   

</main>

<?php 
    require 'footer.php';
?>