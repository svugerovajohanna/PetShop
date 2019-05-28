<?php
require 'db.php';
require 'admin_required.php';


$errors=[];

if (!empty($_POST)){
    $product_name = htmlspecialchars(trim($_POST['product_name']));
    $price = htmlspecialchars(trim($_POST['price']));
    $image= htmlspecialchars(trim($_POST['image']));
    $description = htmlspecialchars(trim($_POST['description']));
    $stock = htmlspecialchars(trim($_POST['stock']));
    $category = htmlspecialchars(trim($_POST['category']));

        if (!$product_name || !$price || !$image || !$description || !$stock ){
        $errors[] = 'Všechny údaje musí být vyplněné!';
    }
    if (strlen($description)>1000) {
        $errors[] = 'Příliš dlouhý popis!';
    }
    if (!preg_match('/^[0-9]{1,5}$/', $price) ) {
        $errors[] = 'Cena musí být celé číslo v maximálním řádu tísíců!';
    }
    if (!preg_match('/^[0-9]{1,5}$/', $stock) ) {
        $errors[] = 'Množství na skladě musí být celé číslo v maximálním řádu tísíců!';
    }

    if(!count($errors)){
        $productsDB->create(['product_name'=>$product_name, 'price'=>$price, 'image'=>$image, 'description'=>$description, 'stock'=>$stock, 'category'=>$category]);
        header('Location: index.php');
        die();
    }
}

$categories = $categoriesDB->fetchAll();

?>

<?php require 'header.php'; ?>

<main class="container">

    <h2 class="text-center">Přidat nový produkt</h2>
          
    <div class="row justify-content-center">

    <form class="form-signup" method="POST" action="new_product.php">
        <?php if(count($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach($errors as $error): ?>
                <p><?php echo $error; ?></p>
                <?php endforeach ?>
            </div>
            <?php endif ?>

        <div class="form-group">
            <label>Název</label>
            <input class="form-control" name="product_name" value="<?php echo @$product_name; ?>">
        </div>

        <div class="form-group">
            <label>Cena</label>
            <input class="form-control" name="price" value="<?php echo @$price; ?>">
        </div>

        <div class="form-group">
            <label>URL obrázku</label>
            <input class="form-control" name="image" value="<?php echo @$image; ?>">
        </div>

        <div class="form-group">
            <label>Popis</label>
            <input class="form-control" name="description" value="<?php echo @$description; ?>">
        </div>

        <div class="form-group">
            <label>Počet kusů na skladě:</label>
            <input class="form-control" name="stock" value="<?php echo @$stock; ?>">
        </div>

        <div class="form-group">
            <label>Kategorie</label>
            <select class="form-control" name="category">
                <?php foreach($categories as $category):?>
                    <option value="<?php echo $category['id'];?>"><?php echo $category['animal'] .": ". $category['name'];?></option>
                <?php endforeach;?>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Přidat</button>
    </form>

    </div>


</main>

<?php require 'footer.php'; ?>