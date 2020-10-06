<?php  
	
	include_once "config.php";
	include_once "connectionController.php";

	if (isset($_POST) && isset($_POST['action'])) {
		
		$userController = new UserController();

		switch ($_POST['action']) {
			case 'store':
				
				$name = strip_tags($_POST['name']);
				$email = strip_tags($_POST['email']);
				$password = strip_tags($_POST['password']);

				$userController->store($name,$email,$password);

				break;
		}
	}

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

		public function store($name, $email, $password) {

			$conn = connect();

			if(!$conn->connect_error) {

				if($name!="" && $email!="" && $password!="") {

					$query = "insert into users (name,email,password) values (?,?,?)";
					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('sss',$name,$email,$password);

					if ($prepared_query->execute()) {

						$_SESSION['status'] = "success";
						$_SESSION['status'] = "Usuario registrado";
						header('Location: ' . $_SERVER['HTTP_REFERER']);
					} else {
						$_SESSION['status'] = "error";
						$_SESSION['status'] = "Usuario no registrado";
					}
				} else {

					$_SESSION['status'] = "error";
					$_SESSION['status'] = "Verifique la información ingresada";
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}

			} else {

				$_SESSION['status'] = "error";
				$_SESSION['status'] = "Error de conexión";
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}
	}
?>