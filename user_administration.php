<?php

require 'db.php';
require 'admin_required.php';


$messages = [];

if(isset($_GET['changed'])){
    array_push($messages, 'Role uživatele byla změněna');
}
$users = $usersDB->fetchAll();
?>

<?php require 'header.php'; ?>

<main class="container">
    <?php if(count($messages)): ?>

        <div class="alert alert-success">
                <?php foreach($messages as $message): ?>
                <p><?php echo $message; ?></p>
                <?php endforeach ?>
        </div>
    <?php endif ?>

    <h2>Správa uživatelů</h2>
    <table class="table table-hover">
        <thead>
            <tr class="table-primary">
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user): ?>
            <tr class="table-light">
                <td><?php echo @$user['email'];?></td>
                <td><?php echo @$user['role'];?></td>
                <td><a href="change_role.php?id=<?php echo @$user['id'];?>"><button type="button" class="btn btn-secondary">Upravit oprávnění</button></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


</main>


<?php require 'footer.php'; ?>