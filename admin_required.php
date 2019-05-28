<?php
    require 'login_required.php';
    
	if($currentUser[0]['role'] != "adm"){
	    die('Nedostatečná práva');
	}
?>