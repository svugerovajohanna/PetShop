<?php

require 'db.php';
require 'login_required.php';

require 'header.php';

$messages = [];

if(isset($_GET['changed'])){
    array_push($messages, 'Role uživatele byla změněna');
}


?>

<main class="container">
<?php if(count($messages)): ?>

<div class="alert alert-success">
        <?php foreach($messages as $message): ?>
        <p><?php echo $message; ?></p>
        <?php endforeach ?>
</div>
<?php endif ?>
    <h2>Můj profil</h2>
    <table class="table table-hover">
    <tr class="table-light">
      <th scope="row">Jméno</th>
      <td><?php echo @$currentUser[0]['first_name'] ?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">Příjmení</th>
      <td><?php echo @$currentUser[0]['last_name'] ?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">Telefonní číslo</th>
      <td><?php echo @$currentUser[0]['phone_number'] ?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">Email</th>
      <td><?php echo @$currentUser[0]['email'] ?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">Ulice</th>
      <td><?php echo @$currentUser[0]['street'] ?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">Čislo popisné</th>
      <td><?php echo @$currentUser[0]['house_number'] ?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">Město</th>
      <td><?php echo @$currentUser[0]['city'] ?></td>
    </tr>

    <tr class="table-light">
      <th scope="row">PSČ</th>
      <td><?php echo @$currentUser[0]['post_code'] ?></td>
    </tr>

    </table>

    <div>
        <a href="change_profile.php"><button type="button" class="btn btn-primary">Upravit údaje</button></a>
    </div>
</main>

<?php require 'footer.php'; ?>