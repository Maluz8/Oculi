<?php
function formulario_login()
{
	ob_start();
	?>
	<form method="post" class="form-signin" action="login.php">
        <h2 class="form-signin-heading">Iniciar sesión</h2>
        <label for="inputUsuario" class="sr-only">Usuario</label>
        <input id="inputUsuario" type="text" name="inputUsuario" class="form-control" placeholder="Nombre de usuario" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input id="inputPassword" type="password" name="inputPassword" class="form-control" placeholder="Contraseña" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
      </form>
	<?php
	return(ob_get_clean());
}
function login()
{
	if($_POST['inputUsuario']!==null) // Iniciar sesión 
	{
		session_start();
		$json = file_get_contents("usuarios.json");
		$usuarios = json_decode($json, true);
		$nUsuario = urldecode($_POST['inputUsuario']);
		$usuario = $usuarios['usuarios'][$nUsuario];
		if($usuario===null)
		{
			echo '<div class="mensaje"><h2 class="label label-danger">Usuario erróneo</h2></div>';
			header('Refresh: 2; URL = login.php');
		}
		else
		{
			$pass = urldecode($_POST['inputPassword']);
			if($usuario['password']!==$pass)
			{
				echo '<div class="mensaje"><h2 class="label label-danger">Usuario erróneo</h2></div>';
				header('Refresh: 2; URL = login.php');
			}
			else
			{
				$_SESSION['valida'] = true;
				$_SESSION['timeout'] = time()+strtotime('01:00:00');
				$_SESSION['usuario'] = $nUsuario;
				echo '<div class="mensaje"><h2 class="label label-success">Usuario correcto</h2></div>';
				header('Refresh: 1; URL = admin.php');
			}
		}
	}
	else	// Mostrar formulario
	{
		echo(formulario_login());
	}
}
require(__DIR__."/temas/default/login.php");
?>
