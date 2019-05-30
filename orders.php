<?php

require 'db.php';
require 'login_required.php';

$user = $_SESSION['userID'];

$sql = 'SELECT * FROM orders WHERE user_id = ?'; //ORDER BY name

$statement = $ordersDB->getPDO()->prepare($sql);
$statement->bindValue(1, $user, PDO::PARAM_STR);
$statement->execute();

$orders = $statement->fetchAll();


require 'header.php';
?>

<main class="container">

    <h2>Moje objednávky</h2>
    <?php foreach($orders as $order): ?>
    <table class="table table-hover">

    <tr class="table-light">
      <th scope="row">Datum</th>
      <td><?php echo $order['order_date'] ?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">Poštovné</th>
      <td><?php echo $order['shipping']?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">Platba</th>
      <td><?php echo $order['payment']?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">Cena</th>
      <td><?php echo $order['total_price']?> Kč</td>
    </tr>
    </table>


    <?php endforeach ?>

</main>

<?php require 'footer.php'; ?>