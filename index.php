<?php

require 'login_required.php';
require 'db.php';

require 'header.php';





//výběr kategorií pro kočku
$sql = 'SELECT * FROM categories WHERE animal="cat"'; //ORDER BY name
$statement = $categoriesDB->getPDO()->prepare($sql);
$statement->execute();

$categories = $statement->fetchAll();


//uložení ID categorii koček 
$categoryIDs=[];
foreach($categories as $category){
    $categoryID = $category['id'];
    $categoryIDs[] = $categoryID; 
}



// offset pro strankovani
if (isset($_GET['offset'])) {
	$offset = (int)$_GET['offset'];
} else {
	$offset = 0;
}


//rozdělení do categorii - pokud dostanu v getu
if(@$_GET['category']) {
    $currentCategory = $_GET['category'];
    $count = $productsDB->getPDO()->prepare("SELECT COUNT(product_id) FROM products WHERE category = :categorySelected");
    $count->execute(['categorySelected'=>$currentCategory]);
    $count = $count->fetchColumn();


    $statement = $productsDB->getPDO()->prepare("SELECT * FROM products WHERE category = ? ORDER BY product_name ASC LIMIT 6 OFFSET ?");
    $statement->bindValue(1, $currentCategory, PDO::PARAM_STR);
    $statement->bindValue(2, $offset, PDO::PARAM_INT);
    $statement->execute();
}
else{ //všechny produkty, index
    $idsForQuery= implode(',', $categoryIDs);

    $count = $productsDB->getPDO()->query("SELECT COUNT(product_id) FROM products WHERE category IN ($idsForQuery)");
    $count = $count->fetchColumn();

    $statement = $productsDB->getPDO()->prepare("SELECT * FROM products WHERE category IN ($idsForQuery) ORDER BY product_name ASC LIMIT 6 OFFSET ?");

    $statement->bindValue(1, $offset, PDO::PARAM_INT);
    $statement->execute();
    
    $statement->execute();


}
$products = $statement->fetchAll();


$currentUser = $usersDB->fetchBy('id', $_SESSION['userID']);
	if($currentUser){
	  $role = $currentUser[0]['role'];
	}

?>
<main class="container">
<h2>Potřeby pro kočky</h2>


<div class="row">

<!--- kategorie ---->
<div class="col-lg-3">
        <div class="list-group">
        <?php foreach($categories as $category): ?>
            <a href="./index.php?category=<?php echo $category['id'];?>"class="list-group-item d-flex justify-content-between align-items-center"><?php echo $category['name'];?></a>
        <?php endforeach ?>
        <a href="./index.php"class="list-group-item d-flex justify-content-between align-items-center">Všechny produkty</a>
        </div>
</div>


<!-- produkty -->

<div class="col-9">
    <div class="row">
    <?php foreach($products as $product): ?>

<div class="col-4 mb-4">
    <div class="card border-secondary mb-3 h-100" >
      <a href="#"><img class="card-img-top" src="<?php echo $product['image']; ?>" alt=""></a>
      <div class="card-body">
        <h4 class="card-header">
          <?php echo $product['product_name']; ?>
        </h4>
        <h5 class="card-title"><?php echo $product['price']; ?> Kč</h5>
        <p class="card-text small"><?php echo $product['description']; ?></p>
      </div>
      
      <div class="card-footer text-center">
           

            <?php if($role == "adm"): ?>
                <p class="small">Na skladě: <?php echo $product['stock']?><p>
                <a href="./edit_product.php?product=<?php echo $product['product_id'] ?>"><button type="button" class="btn btn-primary">Upravit</button></a>
                <a href="./delete_product.php?product=<?php echo $product['product_id'] ?>"><button type="button" class="btn btn-primary">Smazat</button></a>
            <? else: ?>

            <?php if($role == "cust"): ?>
                <?php if($product['stock']>0):?>
                    <a href="./buy.php?product=<?php echo $product['product_id'] ?>"><button type="button" class="btn btn-secondary">Přidat do košíku</button></a>
                <?php endif;?>
                <?php if($product['stock']==0):?>
                    <p>Produkt není k dispozici.</p>
                 <?php endif;?>
            
            <?php endif; ?>
                
            <?php endif; ?>
            

        </div> 
    </div>
  </div>
  <?php endforeach ?>

    </div>
</div>

<div class="row">
    <ul class="pagination">	
        
			<?php for($i=1; $i<=ceil($count/6); $i++) { ?>
                <li class="page-item">
				<a class="page-link <? $offset/6+1 == $i ? "active" : ""  ?>" href="index.php?offset=<?= ($i-1)*6 ?>"><?= $i ?></a>
                </li>
            <?php } ?>
        
    </ul>
</div>



</main>

<?php require 'footer.php';?>