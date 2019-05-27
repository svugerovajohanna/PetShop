<?php 

require 'db.php';

session_start();

$errors = [];


// kontrola, jestli byl formulář vyplněn

$submittedForm = !empty($_POST);
if ($submittedForm) {
    
    //trim osdstraní bílá místa okolo řetězce, htmlspecial chars převede speciální znaky na html znaky -> ochrana před XSS útokem
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $phoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $paswdConfirm = htmlspecialchars(trim($_POST['paswdConfirm']));
    $street = htmlspecialchars(trim($_POST['street']));
    $houseNumber = htmlspecialchars(trim($_POST['houseNumber']));
    $city= htmlspecialchars(trim($_POST['city']));
    $psc= htmlspecialchars(trim($_POST['psc']));
    

    // neprázdné jméno
    if (!$firstName) {
        $errors['firstName'] = 'Zadejte jméno!';
    }

    //neprázdné příjmení 
    if (!$lastName) {
        $errors['lastName'] = 'Zadejte příjmení!';
    }

    // validace emailu
    if(!$email){
        $errors['email'] = "Zadejte email!";
    }
    else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Zadejte email ve správném tvaru!';
        }
    }

    //kontrola telefonního čísla
    if(!$phoneNumber){
        $errors['phoneNumber'] = "Zadejte telefonní číslo!";
    }
    else{
        if(!preg_match('/^[0-9]{9}$/', $phoneNumber)) {
        $errors['phoneNumber'] = 'Zadejte telefonní číslo ve správném tvaru!';
        }
    }
    // heslo dlouhé alespoň 8 znaků
    if ( strlen($password) < 8 ) {
        $errors['password'] = 'Zadejte platné heslo!';
    }

    //shoda hesla a jeho opakování
    if ($password !== $paswdConfirm) {
        $errrors['pswdConfirm'] = "Zadaná hesla se neshodují!";
    }

    //neprázdná ulice
    if(!$street) {
        $errors['street'] = "Zadejte ulici!";
    }

    //neprázné popisné číslo, 1-5 čísel
    if(!$houseNumber) {
        $errors['houseNumber'] = "Zadjte číslo popisné!";
    }
    else {
        if(!preg_match('/^[0-9]{1,5}$/', $houseNumber)) {
            $errors['houseNumber'] = 'Zadejte číslo popisné ve správném tvaru!';
        }
    }

    //neprázdné PSC, pět čísel
    if(!$psc) {
        $errors['psc'] = "Zadejte PSČ!";
    }
    else {
        if(!preg_match('/^[0-9]{5}$/', $psc)) {
            $errors['psc'] = 'Zadejte PSČ ve správném tvaru!';
        }
    }

    //neprázdné měasto
    if(!$city) {
        $errors['city'] = "Vyplňtě město!";
    }


    if(!count($errors)){
        if($alreadyRegistred = $usersDB->fetchBy('email', $email)){ //existuje mail v databázi?
            $errors['email'] = "Tento email je už zaregistrován!";
        }
        else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $usersDB->create([
            'first_name'=>$firstName,
            'last_name'=>$lastName,
            'password'=>$hashedPassword,
            'phone_number'=>$phoneNumber,
            'email'=>$email,
            'street'=>$street,
            'house_number'=>$houseNumber,
            'city'=>$city,
            'post_code'=>$psc]);
            $user = $usersDB->fetchBy('email', $email);
            if(!$user){
                die('Při registraci nastala chyba');
            }
            $_SESSION['userID'] = $user[0]['id'];
            $_SESSION['email'] = $user[0]['email'];
        }

    }
    
    // if no errors: insert the new user to db
   
    // if no errors: send confirmation email
    //if (empty($errors)) {
       // sendEmail($email, 'Registration confirmation');
        //header('Location: login.php?ref=registration&email=' . $email);
        //die();
    //}
}
?>
<?php require __DIR__ . '/header.php'; ?>
<main class="container">
    <br>
    <h1 class="text-center">Registrace</h1>
    <p class="text-center"><small>Všechny uvedené údaje jsou povinné!</small></p>

    <div class="row justify-content-center">

    <form class="form-signup" method="POST">

        <?php if(count($errors)): ?>
            <div class="alert alert-danger">
                  <?php foreach($errors as $error): ?>
                  <p><?php echo $error; ?></p>
                  <?php endforeach ?>
            </div>

         <?php endif ?>
         
         <?php if ($submittedForm && !count($errors)): ?>
         <div class="alert alert-success">
         <p><?php echo "Registrace proběhla úspešně!"; ?></p>
            </div>
         <?php endif; ?>
         

        <div class="form-group">
            <label>Jméno</label>
            <input class="form-control" name="firstName" value="<?php echo @$firstName; ?>">
        </div>

        <div class="form-group">
            <label>Příjmení</label>
            <input class="form-control" name="lastName" value="<?php echo @$lastName; ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input class="form-control" name="email" value="<?php echo @$email; ?>">
            <small>Ve tvaru example@gmail.com</small>
        </div>

        <div class="form-group">
            <label>Telefonní číslo</label>
            <input class="form-control" name="phoneNumber" value="<?php echo @$phoneNumber; ?>">
            <small>Telefonní číslo zadávejte bez předvolby a bez mezer</small>
        </div>

        <div class="form-group">
            <label>Heslo</label>
            <input  type="password" class="form-control" name="password" value="<?php echo @$password; ?>">
            <small>Heslo musí obsahovat minimálně 8 znaků</small>
        </div>

        <div class="form-group">
            <label>Potvrďte heslo</label>
            <input type="password" class="form-control" name="paswdConfirm" value="<?php echo @$paswdConfirm; ?>">
            <small>Zadejte heslo znovu pro potvrzení správnosti</small>
        </div>

        <div class="form-group">
            <label>Ulice</label>
            <input class="form-control" name="street" value="<?php echo @$street; ?>">
        </div>

        <div class="form-group">
            <label>Číslo popisné</label>
            <input class="form-control" name="houseNumber" value="<?php echo @$houseNumber; ?>">
        </div>

        <div class="form-group">
            <label>Město</label>
            <input class="form-control" name="city" value="<?php echo @$city; ?>">
        </div>

        <div class="form-group">
            <label>PSČ</label>
            <input class="form-control" name="psc" value="<?php echo @$psc; ?>">
            <small>PSČ zadávejte bez mezer</small>
        </div>

        <button type="submit" class="btn btn-primary">Zaregistruj mě!</button>

    </form>

    </div>
</main>
<?php require __DIR__ . '/footer.php'; ?>