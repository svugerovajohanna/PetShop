<?php
	require __DIR__.'/../db.php';
    require_once __DIR__.'/vendor/autoload.php';
    
    use Facebook\Facebook; 
	
	$fb = new \Facebook\Facebook([
	    'app_id' => '353829385257639',
	    'app_secret' => '5823485577286f1900e22da50cbe773e',
	    'default_graph_version' => 'v2.10'
	]);
	
	$helper = $fb->getRedirectLoginHelper();
	
	if (isset($_GET['state'])) {
	    $helper->getPersistentDataHandler()->set('state', $_GET['state']); 
	}
	
	try {
	    $accessToken = $helper->getAccessToken();
	} catch(\Facebook\Exceptions\FacebookResponseException $e) {
	    echo 'Graph returned an error: ' . $e->getMessage();
	    exit;
	} catch(\Facebook\Exceptions\FacebookSDKException $e) {
	    echo 'Facebook SDK returned an error: ' . $e->getMessage();
	    exit;
	}
	
	session_start();
	
	$fb = new \Facebook\Facebook([
	    'app_id' => '353829385257639',
	    'app_secret' => '5823485577286f1900e22da50cbe773e',
	    'default_graph_version' => 'v2.10',
	    'default_access_token' => $accessToken
	]);
	try {
	    $me = $fb->get('/me')->getGraphUser();
	    $picture = $fb->get('/me/picture?redirect=false&height=200')->getGraphUser();
	    $user = $fb->get('/me?fields=email,name', $accessToken)->getGraphUser();
	} catch(\Facebook\Exceptions\FacebookResponseException $e) {
	    echo 'Graph returned an error: ' . $e->getMessage();
	    exit;
	} catch(\Facebook\Exceptions\FacebookSDKException $e) {
	    echo 'Facebook SDK returned an error: ' . $e->getMessage();
	    exit;
	}
	
	
	$name = explode(' ', $user['name']);
	$lastName = end($name);
	$firstName = implode(' ', array_slice($name, 0, -1));
	$email = $user['email'];
	$users = $usersDB->fetch('email', $email);
	
	if(!$users){
	    $usersDB->create(['first_name' => $firstName, 
	                'last_name' => $LastName,
	                'email' => $email,
	                'phone_number' => NULL,
	                'password' => NULL]);
	    $users = $usersDB->fetch('email', $email);
	}
    $_SESSION['fb'] = $accessToken;
    
	header('Location: ../index.php?');
	die();
	?>
	