<?php
	require 'db.php';
	require 'admin_required.php';
	
    $errors = [];
    
	$idToChange = $_GET['id'];
	if(!isset($idToChange)){
	    die('Chyba při změně role uživatele.');
    }
    

    $userToChange = $usersDB->fetchBy('id', $idToChange);
    
	if(!$userToChange){
	    $errors[] = 'Uživatel nenalezen';
	}else{
	    $userToChange = $userToChange[0];
	    $email = $userToChange['email'];
	    $oldPrivilege = $userToChange['role'];
	}
	
	if (!empty($_POST)) {
	    $newPrivilege = @$_POST['role'];
	    $usersDB->updateBy(['id'=>$idToChange],['role'=>$newPrivilege]);
	    header('Location: user_administration.php?changed');
	    die();
	}
	?>
	
    <?php require 'header.php'; ?>
    
	   <main class="container">
          <h2 class="text-center">Změna role uživatele</h2>
          
          <div class="row justify-content-center">
	      <form style="form-sign" method="POST">
	         <?php if(count($errors)): ?>
	            <div class="alert alert-danger">
	                  <?php foreach($errors as $error): ?>
	                  <p><?php echo $error; ?></p>
	                  <?php endforeach ?>
	            </div>
	         <?php endif ?>
	         <div class="form-label-group">
	            <label for="email">Email</label>
	            <input class="form-control" name="email" value="<?php echo @$email; ?>" disabled>
	         </div>
	         <div class="form-label-group">
	            <label>Role</label>
	            <select class="form-control" name="role">
	                <option value="cust" <?php echo ($oldPrivilege === "cust")? 'selected':'' ?>>Zákazník</option>
	                <option value="adm" <?php echo ($oldPrivilege === "adm")? 'selected':'' ?>>Aministrátor</option>
	            </select>
	         </div>
	         <br>
	         <button type="submit" class="btn btn-primary">Změnit</button>  
          </form>
          </div>
	   </main>
	<?php require 'footer.php'; ?>