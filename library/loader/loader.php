<?php
session_start();
$fbUserName = $_SESSION['fbUserName'];

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
	
	$id = explode('sp', $_GET['lastid']);
	
	$lastId = $id[0];
	
	$brandId = $id[1];
	
	$querySelect = "SELECT * FROM grumps
			 		WHERE id < '$lastId'
			 		AND brand_id = '$brandId'
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
		
		echo '<div class="span8 wrapper8" id="'.$item['id'].'">';
		if ($item['fb_user_name'] == $fbUserName) {
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
}