<?php
session_start();
$username = $_SESSION['fbUserName'];

require '../database/Database.php';
?>

<script type="text/javascript">
$(function() {
	$(".delete_button").click(function() {
		var id = $(this).attr("id");
		var dataString = 'id='+ id ;
		var parent = $(this).parent();
		 
		$.ajax({
			type: "POST",
			url: "library/delete/delete.php",
			data: dataString,
			cache: false,
			beforeSend: function()
			{
				parent.animate({'backgroundColor':'#fb6c6c'},300).animate({ opacity: 0.35 }, "slow");
			},
			success: function()
			{
				parent.slideUp('slow', function() {$(this).remove();});
			}
		});
		 
		return false;
	});
});
</script>

<?php
if ($_GET['lastid']) {
	
	$lastId = $_GET['lastid'];
	
	$querySelect = "SELECT grumps.registered registered, grumps.id id,
						   grumps.fb_user_name fb_user_name,
						   grumps.status status, grumps.grump grump,
						   brands.title title 
					FROM grumps
					INNER JOIN brands
					ON grumps.brand_id = brands.id
			 		WHERE grumps.id < '$lastId'
			 		AND grumps.fb_user_name = '$username'
			  		ORDER BY id DESC
			  		LIMIT 0, 10";
	
	$bdd = new Database();
	
	$grumps = $bdd->selectAction($querySelect);

	foreach($grumps as $item) {
		
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
}