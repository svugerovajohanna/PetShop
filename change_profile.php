<?php

require 'db.php';
require 'login_required.php';

require 'header.php';

$errors = [];

$submittedForm = !empty($_POST);
if ($submittedForm) {
    
    //trim osdstraní bílá místa okolo řetězce, htmlspecial chars převede speciální znaky na html znaky -> ochrana před XSS útokem
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $phoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
    $email = htmlspecialchars(trim($_POST['email']));
    $actualPassword = htmlspecialchars(trim($_POST['actualPassword']));
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

    if($password){
            if(!password_verify($actualPassword, $user['password'])){
            $errors['actualPassword'] = "Chybně zadané aktuální heslo!";
        }

        //správné stávající heslo
        // heslo dlouhé alespoň 8 znaků
        if ( strlen($password) < 8 ) {
            $errors['password'] = 'Zadejte platné heslo!';
         }

         //shoda hesla a jeho opakování
         if ($password !== $paswdConfirm) {
            $errrors['pswdConfirm'] = "Zadaná hesla se neshodují!";
        }
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
        if($email != $currentUser[0]['email'] && $alreadyRegistred = $usersDB->fetchBy('email', $email)){ //existuje mail v databázi?
            $errors['email'] = "Tento email je už zaregistrován!";
        }
        else{

            

            $usersDB->updateBy(['id'=>$currentUser[0]['id']],[
            'first_name'=>$firstName,
            'last_name'=>$lastName,
            'phone_number'=>$phoneNumber,
            'email'=>$email,
            'street'=>$street,
            'house_number'=>$houseNumber,
            'city'=>$city,
            'post_code'=>$psc]);

            if($password){
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $usersDB->updateBy(['id'=>$currentUser[0]],[
                    'password'=>$hashedPassword]);
            }

            header('Location: user_profile?change.php');
            die();
        }
    }

}


?>

<main class="container">
<div class="row justify-content-center">
    <form class="form-signup" method="POST" >
    <?php if(count($errors)): ?>
            <div class="alert alert-danger">
                  <?php foreach($errors as $error): ?>
                  <p><?php echo $error; ?></p>
                  <?php endforeach ?>
            </div>
    <?php endif ?>

	<div class="form-group">
	     <label>Jméno</label>
	     <input class="form-control" name="firstName" value="<?php echo isset($firstName)?$firstName:@$currentUser[0]['first_name']; ?>">
	</div>
	<div class="form-group">
	    <label>Příjmení</label>
	    <input class="form-control" name="lastName" value="<?php echo isset($lastNname)?$surname:@$currentUser[0]['last_name']; ?>">
	</div>
	<div class="form-group">
	    <label>Telefonní číslo</label>
        <input class="form-control" name="phoneNumber" value="<?php echo isset($phoneNumber)?$phoneNumber:@$currentUser[0]['phone_number']; ?>">
        <small>Telefonní číslo zadávejte bez předvolby a bez mezer</small>
    </div>
    <div class="form-group">
	    <label>Email</label>
        <input class="form-control" name="email" value="<?php echo isset($email)?$email:@$currentUser[0]['email']; ?>">
        <small>Ve tvaru example@gmail.com</small>
    </div>
    <div class="form-group">
	    <label>Stávající heslo</label>
        <input type="password" class="form-control" name="actualPassword" value="<?php echo @$actualPassword; ?>">
    </div>
    <div class="form-group">
	    <label>Nové heslo</label>
        <input type="password" class="form-control" name="password" value="<?php echo @$password; ?>">
        <small>Heslo musí obsahovat alespoň 8 znaků.</small>
    </div>
    <div class="form-group">
	    <label>Potvrďte nové heslo</label>
        <input type="password" class="form-control" name="paswdConfirm" value="<?php echo @$paswdConfirm; ?>">
    </div>
    <div class="form-group">
	    <label>Ulice</label>
        <input class="form-control" name="street" value="<?php echo isset($street)?$street:@$currentUser[0]['street'] ?>">
    </div>
    <div class="form-group">
	    <label>Číslo popisné</label>
        <input class="form-control" name="houseNumber" value="<?php echo isset($houseNumber)?$houseNumber:@$currentUser[0]['house_number'] ?>">
    </div>
    <div class="form-group">
	    <label>Město</label>
        <input class="form-control" name="city" value="<?php echo isset($city)?$city:@$currentUser[0]['city'] ?>">
    </div>
    <div class="form-group">
	    <label>PSČ</label>
        <input class="form-control" name="psc" value="<?php echo isset($psc)?$psc:@$currentUser[0]['post_code'] ?>">
    </div>
    <div>
        <button type="submit" class="btn btn-secondary">Uložit údaje</button>
    </div>
</form>
</div>
</main>

<?php require 'footer.php'; ?>
