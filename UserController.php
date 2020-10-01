<?php  
	
	include_once "config.php";
	include_once "connectionController.php";

	Class UserController{

		function get() {

			$conn = connect();
			if (!$conn->connect_error) {
				
				$query = "select * from users";
				$prepared_query = $conn->prepare($query);
				$prepared_query->execute();

				$results = $prepared_query->get_result();
				$users = $results->fetch_all(MYSQLI_ASSOC);

				if ($users) {
					return $users;
				} else { return Array(); }

			} else { return Array(); }
		}
	}
?>