<?php 

// Instanciation de l'API Facebook
require 'facebook.php';
 
$facebook = new Facebook(array(
  'appId'  => 'XXXXXXXXXXXXXXX',
  'secret' => 'XXXXXXXXXXXXXXX',
  'cookie' => true
));

// Récupération de l'utilisateur
$user = $facebook->getUser();

if ($user) {
  try {
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Bouton de connexion ou déconnexion
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

// Paramètres de l'utilisateur
$params = array(
	'redirect_uri' => 'http://www.grumpyer.com',
    'scope' => 'email,user_about_me,publish_actions',);

$loginUrl = $facebook->getLoginUrl($params);

// Publication sur le wall
if (isset($_POST['grumper'])) {
	if (!empty($_POST['comment']) && !empty($_POST['share'])) {
		
		$brandName = str_replace('+', ' ', $_GET['search']);
		
		try {
			$message = 'J\'ai Grumpé ' . $brandName . ' : ' . $_POST['comment'];
			
      		$statusUpdate = $facebook->api(
      			'/me/feed', 
      			'post', 
      			array(
      				'title' => 'Grumpyer',
      				'message' => $message, 
      				'link' => 'http://www.grumpyer.com'
      			)
      		);
		} catch (FacebookApiException $e) {}		
	}
}
