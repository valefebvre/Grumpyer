<?php include 'public/inc/header.phtml'; ?>
<?php include 'public/inc/navbar.phtml'; ?>

<?php if ($user_profile['id'] == '100004333361936') { ?>

<div class="container">
	<div class="row" id="fadeIn1">
		<div class="span7 wrapper5">
			<h4>Ajouter une marque</h4>
		</div>
		<div class="span7 wrapper6">
			<form action="" method="post" enctype="multipart/form-data">
				<label><b>Ajouter une image (160x160)</b></label>
				<input type="file" name="image"/>
				
				<label><b>Ajouter un titre</b></label>
				<input type="text" name="title" value="<?php echo $_POST['title'] ?>"/>
				
				<label><b>Site web</b></label>
				<input type="text" name="website" value="<?php echo $_POST['website'] ?>"/>
				
				<label><b>Ajouter une description</b></label>
				<textarea rows="4" name="description"><?php echo $_POST['description'] ?></textarea>
				
				<label></label>
				<button type="submit" class="btn" name="btn">Ajouter</button>
			</form>
			<?php 
				if (isset($_POST['btn'])) {
					if (!empty($_FILES['image']['tmp_name']) && !empty($_POST['title']) 
						&& !empty($_POST['description']) && !empty($_POST['website'])) {
							
						// POST & FILES
						$title = htmlspecialchars(addslashes($_POST['title']));
						$description = htmlspecialchars(addslashes($_POST['description']));
						$website = htmlspecialchars($_POST['website']);
						$registered = date('Y-m-d H:i:s');
						
						$explode = explode('.', $_FILES['image']['name']);
						$extend = $explode['1'];
						$image = $title.'.'.$extend;
						
						// Requête
						$query = "INSERT INTO brands(image, title, website, description, registered) 
								  VALUES('$image', '$title', '$website', '$description', '$registered')";
							
						$db = new Database();
						$result = $db->alterationAction($query);
						
						if ($result['rows_affected'] == 0) {
							echo '<div class="alert alert-error">
									<b>Cette marque éxiste déjà !</b>
								  </div>';
						} else {
							// Upload photo
							$route = 'public/img/brands/';
							move_uploaded_file(
								$_FILES['image']['tmp_name'], 
								$route.$image
							);
							
							echo '<div class="alert alert-success">
									<b>La marque a été ajoutée avec succès !</b>
								  </div>';						
						}
						
					} else {
						echo '<div class="alert alert-error">
								<b>Merci de remplir tous les champs !</b>
							  </div>';
					}
				}
			?>
		</div>	
	</div>
</div>



<?php 
} else {  
	echo '<div class="container">
			<div class="row" id="fadeIn1">
				<div class="alert alert-error">
					<b>Désolé mais tu dois être administrateur pour accéder à cette page !</b>
		  		</div>
		  	</div>
		  </div>';
}
?>

<?php include 'public/inc/footer.phtml'; ?>

