<?php

require 'db.php';
require 'admin_required.php';

$statement = $productsDB->getPDO()->prepare("SELECT * FROM products WHERE product_id=?");
$statement->execute(array($_GET['product']));


$products = $statement->fetch();


$categories = $categoriesDB->fetchAll();

$errors=[];


if (!$products){
	die("Produkt nenenalezen!");
}

$submittedForm = !empty($_POST);
if ($submittedForm) {

  

    $statement = $productsDB->getPDO()->prepare("SELECT last_updated_at FROM products WHERE product_id = ?");
	$statement->execute(array($_POST['product_id']));
    $current_last_updated_at = $statement->fetchColumn();
    
    if (!($_POST['product_name']) || !($_POST['price']) || !($_POST['image']) || !($_POST['description']) || !($_POST['stock'])) {
        $errors[] = 'Všechny údaje musí být vyplněné!';
    }
    if (strlen($_POST['description'])>1000) {
        $errors[] = 'Příliš dlouhý popis!';
    }
    if (!preg_match('/^[0-9]{0,5}$/', $_POST['price']) ) {
        $errors[] = 'Cena musí být celé číslo v maximálním řádu tísíců!';
    }
    if (!preg_match('/^[0-9]{0,5}$/', $_POST['stock']) ) {
        $errors[] = 'Množství na skladě musí být celé číslo v maximálním řádu tísíců!';
    }

			
	//cas posledni editace v db a zacatek editace nejsou stejne, zaznam se zmenil v pozadi, nedelame update
	// promennou last_updated_at predavame ve formulari jako hidden pole
	if ($_POST['last_updated_at'] != $current_last_updated_at) {
		
        die ("Zboží bylo mezitím změněno!");
    }
    else{

    $statement = $productsDB->getPDO()->prepare("UPDATE products SET product_name=?, price=?, image=?, description=?, category=?, stock=?, last_updated_at=now() WHERE product_id=?");
	$statement->execute(array($_POST['product_name'], (float)$_POST['price'], $_POST['image'], $_POST['description'], $_POST['category'], $_POST['stock'], $_POST['product_id']));
	
    header('Location: index.php');
    }
}



?>

<?php require 'header.php';?>

<main class="container">
    
<h2 class="text-center">Editace produktu</h2>
    <div class="row justify-content-center">
    
<form class="form-signup" action="" method="POST">
<?php if(count($errors)): ?>
            <div class="alert alert-danger">
                  <?php foreach($errors as $error): ?>
                  <p><?php echo $error; ?></p>
                  <?php endforeach ?>
            </div>

         <?php endif ?>
	    
        
    <div class="form-group">
	     <label>Název</label>
	     <input type="text" class="form-control" name="product_name" value="<?php echo $products['product_name']; ?>">
    </div>

    <div class="form-group">
	     <label>Cena</label>
	     <input type="text" class="form-control" name="price" value="<?php echo $products['price']; ?>">
    </div>
    
    <div class="form-group">
	     <label>URL obrázku</label>
	     <textarea class="form-control" name="image"><?php echo $products['image']; ?></textarea>
    </div>

    <div class="form-group">
	     <label>Popis</label>
	     <textarea type="text" class="form-control" name="description"><?php echo $products['description']; ?></textarea>
    </div>

    <div class="form-group">
            <label>Kategorie</label>
            <select class="form-control" name="category">
                <?php foreach($categories as $category):?>
                    <option value="<?php echo $category['id'];?>" <?php
                            if(@$products['category'] === $category['id']){
                                echo 'selected';
                            }
                    ?>><?php echo $category['animal'] .": ". $category['name'];?></option>
                <?php endforeach;?>
            </select>
        </div>

        <div class="form-group">
	     <label>Stav zásob</label>
	     <input type="text" class="form-control" name="stock" value="<?php echo $products['stock']; ?>">
        </div>
    
				
		<br/>
		
		<input type="hidden" name="product_id" value="<?= $products['product_id'] ?>">
		
        <input type="hidden" name="last_updated_at" value="<?= $products['last_updated_at'] ?>">

		
        <button type="submit" class="btn btn-primary">Ulož změny</button>
       
		
    </form>
</div>

    </main>


<?php require 'footer.php';?>