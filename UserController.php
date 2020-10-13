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

			case 'update':
				
				$id = strip_tags($_POST['id']);
				$name = strip_tags($_POST['name']);
				$email = strip_tags($_POST['email']);
				$password = strip_tags($_POST['password']);

				$userController->update($id,$name,$email,$password);
			break;

			case 'remove':
			
				$id = strip_tags($_POST['user_id']);

				echo json_encode($userController->remove($id));
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
						$_SESSION['message'] = "El usuario se ha registrado correctamente";
						header('Location: ' . $_SERVER['HTTP_REFERER']);
					} else {
						$_SESSION['status'] = "error";
						$_SESSION['message'] = "El usuario no se ha registrado";
						header('Location: ' . $_SERVER['HTTP_REFERER']);
					}
				} else {

					$_SESSION['status'] = "error";
					$_SESSION['message'] = "Verifique la información ingresada";
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}

			} else {

				$_SESSION['status'] = "error";
				$_SESSION['message'] = "Error de conexión";
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}

		public function update($id, $name, $email, $password) {

			$conn = connect();

			if(!$conn->connect_error) {

				if($id!="" && $name!="" && $email!="" && $password!="") {

					$query = "update users set name = ?, email = ?, password = ? where id = ?";
					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('sssi',$name,$email,$password,$id);

					if ($prepared_query->execute()) {

						$_SESSION['status'] = "success";
						$_SESSION['message'] = "El usuario se ha actualizado correctamente";
						header('Location: ' . $_SERVER['HTTP_REFERER']);
					} else {
						$_SESSION['status'] = "error";
						$_SESSION['message'] = "El usuario no se ha actualizado";
						header('Location: ' . $_SERVER['HTTP_REFERER']);
					}
				} else {

					$_SESSION['status'] = "error";
					$_SESSION['message'] = "Verifique la información ingresada";
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}

			} else {

				$_SESSION['status'] = "error";
				$_SESSION['message'] = "Error de conexión";
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}

		public function remove($id) {

			$conn = connect();

			if(!$conn->connect_error) {

				if($id!="") {

					$query = "delete from users where id = ?";
					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('i',$id);

					if ($prepared_query->execute()) {

						$respuesta = array(
							'status' => "success",
							'message' => "El usuario se ha eliminado correctamente"
						);
						return $respuesta;
					} else {

						$respuesta = array(
							'status' => "error",
							'message' => "El usuario no se ha eliminado"
						);
						return $respuesta;
					}
				} else {

					$respuesta = array(
						'status' => "error",
						'message' => "Verifique la información ingresada"
					);
					return $respuesta;
				}
			} else {

				$respuesta = array(
					'status' => "error",
					'message' => "Error de conexión"
				);
				return $respuesta;
			}
		}
	}
?>