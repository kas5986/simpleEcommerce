<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	if (intval($_GET['subject']) == 0) {
		redirect_to("subject_index.php");
	}
	
	$id = mysql_prep($_GET['subject']);
	
	if ($subject = get_subject_by_id($id)) {
		
		$query = "DELETE FROM page_subjects WHERE id = {$id} LIMIT 1";
		$result = mysql_query($query, $connection);
		if (mysql_affected_rows() == 1) {
			redirect_to("subject_index.php?deleted=1");
		} else {
			// Deletion Failed
			echo "<p>Subject deletion failed.</p>";
			echo "<p>" . mysql_error() . "</p>";
			echo "<a href=\"content.php\">Return to Main Page</a>";
		}
	} else {
		// subject didn't exist in database
		redirect_to("subject_index.php");
	}
?>

<?php mysql_close($connection); ?>