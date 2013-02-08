<?php include 'public/inc/header.phtml'; ?>
<?php include 'public/inc/navbar.phtml'; ?>

<?php if ($user) { ?>
<div class="container">
	<div class="row" id="fadeIn1">
	
		<div class="invite-friends">
			<div class="alert">
				<b>
				<a href="#" onclick="FacebookInviteFriends();">
				Si tu aimes Grumpyer invite tes amis à te rejoindre en 
				cliquant ici !
				</a>
				</b>
			</div>
		</div>
			
		<div class="span3">
			<div class="alert alert-info">
				<b>Recherche une marque !</b>
			</div>
		    <form class="form-search" method="get" action="">
			    <div class="input-append">
				    <input type="text" class="span2 search-query" 
				    	   id="search" name="search" 
				    	   placeholder="Recherche ici">
				    <button type="submit" class="btn" name="search-btn" value="search">Rechercher</button>
			    </div>
		    </form>
			
			<div id="propose-brand"></div>
			<div class="alert alert-info search-info">
				<b>Propose une marque !</b>
			</div>
		    <form class="form-search" method="post" action="">
			    <div class="input-append">
				    <input type="text" class="span2 search-query" 
				    	   id="search" name="propose" 
				    	   placeholder="Propose ici">
				    <button type="submit" class="btn" name="propose-btn" id="propose-btn">
				    	Proposer
				    </button>
			    </div>
		    </form>
		    
		    <?php 
		    
		    $bdd = new Database();
		    
		    $_SESSION['fbUserName'] = $user_profile['username'];
		    
		    if (isset($_POST['propose-btn'])) {
		    	if (!empty($_POST['propose'])) {
		    		
		    		$propose = htmlspecialchars(addslashes($_POST['propose']));
		    		
		    		$queryPropose = "INSERT INTO propose_brands(name)
		    						 VALUES('$propose')";
		    		
		    		$insertPropose = $bdd->alterationAction($queryPropose);
		    		
					echo '<div class="alert alert-success" id="fadeOut">
							<b>La marque a été proposée, elle sera bientôt ajoutée !</b>
			  			  </div>';	
		    	} else {
		    		echo '<div class="alert alert-error" id="fadeOut">
							<b>Merci d\'indiquer une marque !</b>
			  			  </div>';	
		    	}
		    }
		    
		    ?>

    	</div>
    	
    	<div class="span8 wrapper7">
    	
    	<?php 
			if (isset($_GET['search-btn'])) {
				
				$brandName = htmlspecialchars($_GET['search']);
				$getBrandName = str_replace(' ', '+', $brandName);
				
				$query = "SELECT * FROM brands
						  WHERE title = '$brandName'
						  LIMIT 1";
				
				$result = $bdd->selectAction($query);
				
				if ($result == true) {
					
					// Brand ID
					$brandId = $result[0]['id'];
					
					// Marque
					echo '<div class="brand">';
					echo '<img src="http://grumpyer.com/public/img/brands/'.$result[0]['image'].'" />';
					echo '<h2><a href="http://'.$result[0]['website'].'" target="_blank">'.$result[0]['title'].'</a></h2>';
					echo '<em>'.$result[0]['description'].'</em>';
					echo '</div>';
					
					// Compteur
					echo '<div class="counter" id="counter">';
					
					$queryGoodCounter = "SELECT COUNT(grumps.id) AS compteur
										 FROM grumps
										 INNER JOIN brands ON brands.id = grumps.brand_id
										 WHERE grumps.brand_id = '$brandId'
										 AND grumps.status = 'Good'";
					
					$counterGood = $bdd->selectAction($queryGoodCounter);
					
					$goodGrump = $counterGood[0]['compteur'];
					
					$queryBadCounter = "SELECT COUNT(grumps.id) AS compteur
										FROM grumps
										INNER JOIN brands ON brands.id = grumps.brand_id
									 	WHERE grumps.brand_id = '$brandId'
									 	AND grumps.status = 'Bad'";
					
					$counterBad = $bdd->selectAction($queryBadCounter);
					
					$badGrump = $counterBad[0]['compteur'];
					
					$counter = $goodGrump - $badGrump;
					$counter = sprintf("%08d", $counter);
					$counter = implode(' ', str_split($counter, 1));
					$counter = explode(' ', $counter);
					
					echo '<span class="count">' . $counter[0] . '</span>';
					echo '<span class="count">' . $counter[1] . '</span>';
					echo '<span class="count">' . $counter[2] . '</span>';
					echo '<span class="count">' . $counter[3] . '</span>';
					echo '<span class="count">' . $counter[4] . '</span>';
					echo '<span class="count">' . $counter[5] . '</span>';
					echo '<span class="count">' . $counter[6] . '</span>';
					echo '<span class="count">' . $counter[7] . '</span>';
					
					echo '</div>';
					
					// Form
					echo '<div class="form" id="form-grump">';
					echo '<form method="post" action="brands.php?search='.$getBrandName.'&search-btn=search">';
					echo '<div class="bad-good">
						  <input type="radio" name="status" id="good" value="Good" checked>
						  <span class="good">Good Grump</span>
						  <input type="radio" name="status" id="bad" value="Bad">
						  <span class="bad">Bad Grump</span>
						  <span class="partager">
						  <input type="checkbox" name="share" checked="checked"> 
						  Partager
						  </span>';
					echo '</div>';
					echo '<div class="area">';
					echo '<textarea rows="2" cols="50" placeholder="Exprime-toi" name="comment"></textarea>';
					echo '</div>';
					echo '<div class="area-btn">';
					echo '<button class="btn btn-primary" type="submit" name="grumper">Grumper '.$brandName.'</button>';
					echo '</div>';
					echo '</form>';
					
					if (isset($_POST['grumper'])) {
						if (!empty($_POST['comment'])) {
							
							// POST
							$status = $_POST['status'];
							$comment = htmlspecialchars(addslashes($_POST['comment']));
							
							// Date
							$registered = date('Y-m-d H:i:s');
							
							// ID Facebook
							$userNameFb = $user_profile['username'];
							
							// Requête
							$queryInsert = "INSERT INTO grumps(brand_id, fb_user_name, status, grump, registered)
											VALUES('$brandId', '$userNameFb', '$status', '$comment', '$registered');";
							
							$bdd->alterationAction($queryInsert);
							
							echo '<div class="alert alert-success grump-success" id="fadeOut">
									<b>Grump envoyé !</b>
								  </div>';
						} else {
							echo '<div class="alert alert-error grump-error">
									<b>Tu dois laisser un commentaire !</b>
					  			  </div>';							
						}
					}
					echo '</div>';
					echo '</div>';
					
					// Posts
					$querySelect = "SELECT * FROM grumps
									WHERE brand_id = '$brandId'
									ORDER BY id DESC
									LIMIT 0, 10";
					
					$grumps = $bdd->selectAction($querySelect);

					foreach($grumps as $item){
						
						$date = date('Y-m-d H:i:s'); 
						$dateFr = explode(' ', $item['registered']);
						$dateExplode = implode('/', array_reverse(explode('-', $dateFr['0'])));
						$hours = $dateFr['1'];
						$grumpDate = $dateExplode . ' à ' . $hours;
						
						echo '<div class="span8 wrapper8" id="'.$item['id'].'sp'.$brandId.'">';
						if ($item['fb_user_name'] == $user_profile['username']) {
							echo '<a href="#" id="'.$item['id'].'" class="delete_button">x</a>';
						}
						echo '<div class="profile_picture">
							  <img src="https://graph.facebook.com/'.$item['fb_user_name'].'/picture">
							  </div>';
						echo '<div class="profile_grumps">';
						if ($item['status'] == 'Good') {
							echo '<b>
									<span class="good-grump">' . $item['status'];
						} else {
							echo '<b>
									<span class="bad-grump">' . $item['status'];
						}
						
						echo ' Grump</span> de <a href="http://facebook.com/' . $item['fb_user_name'] . '" target="_blank">
								' . $item['fb_user_name'] . '</a>
							  </b>';
						echo '<p>' . $item['grump'] . '</p>';
						echo '<p class="grump-option">
								<span class="grump-date">Le '.$grumpDate.'</span>
							  </p>';
						
						echo '</div>';
        				echo '</div>';
        				
    				}
    				
        			echo '<div class="span8 loader" id="loader">
        					<img src="public/img/ajax-loader.gif" alt="loader" />
        				  </div>';
					
				} else {
					echo '<div class="alert alert-error">
							<b>Désolé, cette marque n\'éxiste pas encore, mais tu peux 
							la proposer, nous essayons de répondre a tes propositions
							d\'ajouts de marques aussi rapidement que possible afin
							que tu puisses les Grumper !</b>
			  			  </div>';	
				}
			}
    	?>
    </div>
</div>
<?php 

	// Enregistrement de l'utilisateur
	$queryUser = "SELECT * FROM users
				  WHERE facebook_id = " . $user_profile['id'];

	$userExist = $bdd->selectAction($queryUser);
		
	if ($userExist == false) {
			
		$idFb = $user_profile['id'];
		$name = $user_profile['name'];
		$firstName = $user_profile['first_name'];
		$lastName = $user_profile['last_name'];
		$link = $user_profile['link'];
		$username = $user_profile['username'];
		$gender = $user_profile['gender'];
		$email = $user_profile['email'];
		$timezone = $user_profile['timezone'];
		$locale = $user_profile['locale'];
		$verified = $user_profile['verified'];
		$updatedTime = $user_profile['updated_time'];
			
		$insertUser = "INSERT INTO users(facebook_id, name, first_name,
										 last_name, link, username, gender,
										 email, timezone, locale, verified,
										 updated_time)
					   VALUES('$idFb', '$name', '$firstName', '$lastName',
					   		  '$link', '$username', '$gender', '$email',
					   		  '$timezone', '$locale', '$verified', '$updatedTime')";
		
		$insertUserInBdd = $bdd->alterationAction($insertUser);
	}
?>
<?php 
} else {  
	echo '<div class="container">
			<div class="row" id="fadeIn1">
				<div class="alert alert-error">
					<b>Tu dois être connecté si tu veux accéder à l\'application !</b>
		  		</div>
		  	</div>
		  </div>';
}
?>

<?php include 'public/inc/footer.phtml'; ?>