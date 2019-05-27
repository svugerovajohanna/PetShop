<?php

require 'login_required.php';
require 'db.php';

require 'header.php';


$sql = 'SELECT * FROM categories WHERE animal="cat"'; //$$ name = :name';
$statement = $categoriesDB->getPDO()->prepare($sql);
$statement->execute();

$categories = $statement->fetchAll();

?>
<main class="container">
<h2>Potřeby pro kočky</h2>

<!--- kategorie ---->
<div class="col-lg-3">
        <div class="list-group">
        <?php foreach($categories as $category): ?>
            <a href="./index.php" class="list-group-item d-flex justify-content-between align-items-center"><?php echo $category['name'];?></a>
        <?php endforeach ?>
        </div>
      </div>
</main>

<?php require 'footer.php';?>