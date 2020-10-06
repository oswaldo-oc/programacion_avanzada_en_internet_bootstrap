<?php  
	include "UserController.php";
	$UserController = new UserController();

	$users = $UserController->get();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Bootstrap</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="#">Lord of the Rings</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			  	<ul class="navbar-nav mr-auto">
			  	<li class="nav-item active">
			     	<a class="nav-link" href="#">Inicio<span class="sr-only">(current)</span></a>
			  	</li>
			  	<li class="nav-item">
			     	<a class="nav-link" href="#">Link</a>
			  	</li>
			    </ul>
			    <form class="form-inline my-2 my-lg-0">
			      	<input class="form-control mr-sm-2" type="search" placeholder="Escribe aquí..." aria-label="Search">
			     	<button class="btn btn-primary my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> Buscar</button>
			 	</form>
			</div>
		</nav>

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active" aria-current="page">Inicio</li>
		  	</ol>
		</nav>

		<?php if (isset($_SESSION['status']) && $_SESSION['status']=="success"):?>

		<div class="alert alert-success alert-dismissible fade show" role="alert">
		  <strong>Éxito!</strong> <?= $_SESSION['message'] ?>.
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>

		<?php unset($_SESSION['status']); endif ?>

		<?php if (isset($_SESSION['status']) && $_SESSION['status']=="error"):?>

		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		  <strong>Error!</strong> <?= $_SESSION['message'] ?>.
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>

		<?php unset($_SESSION['status']); endif ?>

		<div class="card mb-4">
		  <div class="card-header">
		    Lista de usuarios registrados
		    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#staticBackdrop">
		    	<i class="fas fa-user-plus"></i> Añadir usuario
		    </button>
		  </div>
		  <div class="card-body">
		  	<table class="table table-stripped">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Nombre</th>
			      <th scope="col">Correo electrónico</th>
			      <th scope="col">Estado</th>
			      <th scope="col">Acciones</th>
			    </tr>
			  </thead>
			  <tbody>

			  	<?php if(isset($users) && count($users)>0): ?>
			  	<?php foreach ($users as $user): ?>

			    <tr>
			      <th scope="row"> <?= $user['id'] ?> </th>
			      <td> <?= $user['name'] ?> </td>
			      <td> <?= $user['email'] ?> </td>
			      <td> 
			      	<?php if($user['status']==1): ?>
			      	<span class="badge badge-success">Activo</span> 
			      	<?php else: ?>
			      		<span class="badge badge-danger">Inactivo</span>
			      	<?php endif ?>
			      </td>
			      <td>
						<button type="button" class="btn btn-warning">
							<i class="fas fa-edit"></i> Editar
						</button>
						<button type="button" onclick="remove(1)" class="btn btn-danger">
							<i class="fa fa-trash"></i> Eliminar
						</button>
					</td>
			    </tr>

				<?php endforeach ?>
				<?php endif ?>

			  </tbody>
			</table>
		  </div>
		</div>
	</div>

	<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="staticBackdropLabel">Agregar usuario</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      	  <div class="modal-body">
	        	  <form method="POST" action="UserController.php" onsubmit="return validateRegister()">
	        	  	<div class="form-group">
						<label for="name">Nombre completo</label>
        	  			<div class="input-group mb-3">
        	  					<div class="input-group-prepend">
        	  						<span class="input-group-text"><i class="fas fa-user"></i></span>		
        	  					</div>
						    	<input type="text" name="name" class="form-control" id="name" aria-describedby="name" required="" placeholder="Samwise Gamgee">
        	  			</div>
        	  			<small id="email" class="form-text text-muted">Ingresar sólo letras.</small>
					  </div>
					  <div class="form-group">
					    <label for="email">Correo electrónico</label>
					    <div class="input-group mb-3">
        	  					<div class="input-group-prepend">
        	  						<span class="input-group-text"><i class="fas fa-envelope"></i></span>		
        	  					</div>
						    	<input type="email" name="email" class="form-control" id="email" aria-describedby="email" required="" placeholder="example@domain.com">
        	  			</div>
					    
					  </div>
					  <div class="form-group">
					    <label for="exampleInputPassword1">Contraseña</label>
					    <div class="input-group mb-3">
        	  					<div class="input-group-prepend">
        	  						<span class="input-group-text"><i class="fas fa-lock"></i></span>		
        	  					</div>
						    	<input type="password" name="password" class="form-control" id="password1" required="" placeholder="passwordExample123">
        	  			</div>
					    
					  </div>
					  <div class="form-group">
					    <label for="exampleInputPassword1">Confirmar contraseña</label>
					    <div class="input-group mb-3">
        	  					<div class="input-group-prepend">
        	  						<span class="input-group-text"><i class="fas fa-check-double"></i></span>		
        	  					</div>
						    	<input type="password" class="form-control" id="password2" required="" placeholder="passwordExample123">
        	  			</div>
					    
					  </div>
					  <div class="modal-footer">
		          		<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
		          		<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
		          		<input type="hidden" name="action" value="store">
		      		  </div>
					</form>
		      </div>


	    </div>
	  </div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript">
		function validateRegister() {
			console.log(1)
			if($("#password1").val() == $("#password2").val()) {
				return true;
			}else {
				$("#password1").addClass("is-invalid")
				$("#password2").addClass("is-invalid")

				swal("", "Las contraseñas no coinciden", "error")
				return false;
			}
		}

		function remove(id){
			swal({
				title: "",
				text: "¿Desea eliminar el usuario?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
				buttons: ["Cancelar", "Eliminar"],
			})
			.then( (willDelete) => {
				if ( willDelete ){
					swal("Usuario eliminado con exito!", {
						icon: "success",
					});
				}
			});
		}
	</script>
</body>
</html>