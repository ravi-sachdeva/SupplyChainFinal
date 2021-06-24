<?php 

	$conn = mysqli_connect("localhost","root","","ourproject");

	if($conn)
	{

	}
	else
	{?>
		<script >alert("Database not connected")</script>
	<?php

	}


 ?>