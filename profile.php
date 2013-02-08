<?php include 'public/inc/header.phtml'; ?>
<?php include 'public/inc/navbar.phtml'; ?>

<?php if ($user) { ?>
<div class="container">
	<div class="row" id="fadeIn1">
		<div class="span4 wrapper">
			<h3>
			<img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
			<?php echo $user_profile['name']; ?>
			</h3>
		</div>	
		
		<div class="span7 wrapper2">
			<h4>Mes Grumps</h4>
		</div>
		
		<?php 
		
			$username = $user_profile['username'];
			$_SESSION['fbUserName'] = $username;
		
			$bdd = new Database();
		
			$querySelect = "SELECT grumps.registered registered, grumps.id id,
								   grumps.fb_user_name fb_user_name,
								   grumps.status status, grumps.grump grump,
								   brands.title title 
							FROM grumps
							INNER JOIN brands
							ON grumps.brand_id = brands.id
							WHERE fb_user_name = '$username'
							ORDER BY id DESC
							LIMIT 0, 10";
					
			$grumps = $bdd->selectAction($querySelect);

			foreach($grumps as $item){
				
				$date = date('Y-m-d H:i:s'); 
				$dateFr = explode(' ', $item['registered']);
				$dateExplode = implode('/', array_reverse(explode('-', $dateFr['0'])));
				$hours = $dateFr['1'];
				$grumpDate = $dateExplode . ' à ' . $hours;
				
				$brandPage = str_replace(' ', '+', $item['title']);
				
				echo '<div class="span7 wrapper3" id="'.$item['id'].'">';
				if ($item['fb_user_name'] == $username) {
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
						' . $item['fb_user_name'] . '</a> pour <a href="brands.php?search='.$brandPage.'&search-btn=search">'.$item['title'].'</a>
						 </b>';
				echo '<p>' . $item['grump'] . '</p>';
				echo '<p class="grump-option">
						<span class="grump-date">Le '.$grumpDate.'</span>
					  </p>';
				echo '</div>';
        		echo '</div>';
    		}
    				
        	echo '<div class="span7 loaderstop" id="loaderstop">
        			<img src="public/img/ajax-loader.gif" alt="loader" />
        		  </div>';
		?>
	</div>
</div>

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