<?php include 'public/inc/header.phtml'; ?>
<?php include 'public/inc/navbar.phtml'; ?>
<?php  $bdd = new Database(); ?>

<div class="container">
	<div class="row" id="fadeIn1">
	
		<div class="span6 center video">
			<iframe src="http://www.youtube.com/embed/fLoVSsQVAew?rel=0" 
					frameborder="0" 
					allowfullscreen></iframe>
		</div>
		
		<?php if (!$user) { ?>
		<div class="span6 center intro">
		<?php } else { ?>
		<div class="span6 center">
		<?php } ?>
		
			<!-- Introduction -->
			<h2>Bienvenue sur Grumpyer</h2>
			<p>
				Partage tes mauvaises expériences consommateurs !
				Tu as payé un produit ou un service et tu n'es pas satisfait ? 
				Tu veux ajouter un mauvais point à une marque dans l'espoir d'être entendu 
				et partager ton mécontentement sur les réseaux 
				sociaux ? Tu peux le faire ici sans perdre
				de temps.
			</p>
				
			<!-- Facebook -->	
			<?php if (!$user) { ?>
				<div class="inset">
					<a class="fb login_button" href="<?php echo $loginUrl; ?>">
						<div class="logo_wrapper">
							<span>Se connecter avec Facebook</span>
						</div>
						<img src="public/img/facebook.png" id="fb"></img>
					</a>
				</div>
			
					
			<?php } else { ?>
			
			<div class="alert intro-connect">
				<h3>Salut <?php echo $user_profile['first_name'] ?> !</h3>
				<b>
				   <p>
				      Grumpyer c'est simple ! Si tu souhaites poster un Grump, 
					  il te suffit de cliquer sur <a href="brands.php">Marques</a>, 
					  de choisir la marque que tu souhaites et de publier un 
					  bon ou un mauvais Grump.
				   </p>
						
				   <p>
				      Tu peux aussi consulter tes informations en cliquant sur 
					  <a href="profile.php">Mon profil</a>.
				   </p>
						
				   <p>
				      N'oublie pas de proposer des marques et 
				      <a href="#" onclick="FacebookInviteFriends();">
				      d'inviter tes amis</a>
					  pour faire grandir Grumpyer.
				   </p>
						
				   <p>Bon Grump !</p>
				</b> 
			</div>		
						
			<?php } ?>
			
		</div>
		
		<div class="span12">
			<div class="slideshow">  
			    <ul>  
			    <?php 
			    $query = "SELECT * FROM brands";
			    
			    $slide = $bdd->selectAction($query);
			    
			    foreach($slide as $item){
			    	echo '<li><img src="public/img/brands/'.$item['title'].'"/></li>';
			    }
			    ?>
			    </ul>  
			</div>			
		</div>
		
	</div>
</div>

<?php include 'public/inc/footer.phtml'; ?>