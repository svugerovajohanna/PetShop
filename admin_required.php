<?php
    require 'login_required.php';
    
	if($currentUser[0]!= "adm"){
	    die('Nedostatečná práva');
	}
?>