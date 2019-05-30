<?php

require 'db.php';

session_start();


require_once __DIR__.'/facebook/vendor/autoload.php'; 

use Facebook\Facebook; 

// Facebook
$fb = new \Facebook\Facebook([
    'app_id' => '353829385257639',
	'app_secret' => '5823485577286f1900e22da50cbe773e',
    'default_graph_version' => 'v2.10'
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email'];
$loginUrl = $helper->getLoginUrl(
    'https://eso.vse.cz/~svuj00/PetShop/facebook/fb-login.php', $permissions
);

$errors=[];

$submittedForm = !empty($_POST);
if ($submittedForm) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if(!$email){
        $errors['email'] = "Zadejte email!";
    }
    if(!$password){
        $errors['password'] = "Zadejte heslo!";
    }
    else {
        $users = $usersDB->fetchBy('email', $email);
        $user=[];
        if($users){
            $user=$users[0];

            if(!password_verify($password, $user['password'])){
                    $errors['password'] = "Chybné heslo!";
             }else{
                $_SESSION['userID'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                header('Location: index.php');//index.php?login
                die();
             }

         }
         else{
            $errors['email'] = "Zadaný uživatel neexistuje!";
         }
    }
}

?>


<?php require __DIR__ . '/header.php'; ?>
<main class="container">
    <br>
    <h1 class="text-center">Přihlášení</h1>

    <div class="row justify-content-center">

    <form class="form-signup" method="POST">

        <?php if(count($errors)): ?>
            <div class="alert alert-danger">
                  <?php foreach($errors as $error): ?>
                  <p><?php echo $error; ?></p>
                  <?php endforeach ?>
            </div>
         <?php endif ?>

         <div class="form-group">
            <label>Email</label>
            <input class="form-control" name="email" value="<?php echo @$email; ?>">
            <small>Ve tvaru example@gmail.com</small>
        </div>

        <div class="form-group">
            <label>Heslo</label>
            <input type="password" class="form-control" name="password" value="<?php echo @$password; ?>">
        </div>

        <button type="submit" class="btn btn-primary">Přihlaš mě!</button>

        <div>
            <p>Ještě zde nemáte účet? <a href="registration.php"><b>Registrujte se!</b></a> Nebo se přihlašte přes <a class="font-weight-bold" href="<?php echo @$loginUrl;?>">Facebook</a></p>
        </div>
</form>

</div>
</main>
<?php require __DIR__ . '/footer.php'; ?>