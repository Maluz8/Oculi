<?php
session_start();
function admin()
{
	if($_SESSION['valida'])
	{
		if($_POST['cambios']===null) // Sin parámetros para guardar, sólo usuario
		{
				
				$json = file_get_contents("usuarios.json");
				$usuarios = json_decode($json, true);
				
				$gruposUsuario = $usuarios['usuarios'][$_SESSION['usuario']]['grupos'];?> 
			
			<div class ="tutorial" id="tutorial"  style='display:none;'>
			<h3> Guía.</h3>
			<h4> Introducción </h4>
			<h4> Dar de alta una nueva pantalla </h4>
			En primer lugar si queremos mostrar noticias en alguna de nuestras pantallas debemos de registrarla en Oculus++,
			para ello en el apartado Pantallas podemos añadir una nueva. Donde se nos pedirá:</br>
			- IP de la Pantalla.</br>
			- Nombre: identificativo para el usuario.</br>
			- Grupo: aquí debemos seleccionar el nombre de la programación que se desee mostrar.</br>
			<img style="width: 100%;" src="http://localhost/oculus/temas/default/img/tutorial2.jpg">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.0.3/jquery-confirm.min.css">
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.0.3/jquery-confirm.min.js"></script>
			<script src="/oculus/funciones.js"></script>
			<h4> Grupos</h4>
			<p>
				Ejemplo: 	
			<img style="width: 100%;" src="http://localhost/oculus/temas/default/img/tutorial1.jpg"></p>
			<h4> Canales </h4>
			<p>Los canales son fuentes de noticias, 
			</p>
			<!--<img src="http://rubbercat.net/simpsons/homer/dancingjesus.gif">-->

			</div>
			
			<div class="scrollmenu">


						<a href="javascript:mostrartutorial();">Bienvenido</a>
						<a id= grupos href="javascript:mostrarGrupo();">Grupos</a>
						<a href="javascript:mostrarCanales(); ">Canales</a>
						<a href="javascript:mostrarPantallas();">Pantallas</a>
						<a href="javascript:mostrarUsuarios();" style='display:<?php if($_SESSION['usuario']!='admin')echo 'none';?>'>Usuarios</a>
			</div>
								
			<div class="bienvenido" id="bienvenido" style='display:block;'>
			<iframe src="https://docs.google.com/presentation/d/1DwTbGEgaIPJRLdT4nETLWp6YetJ2ilAbdaABykk2_ow/embed?start=true&loop=true&delayms=3000" frameborder="0" width="100%" height="820" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
			</div>
			<div class="formGrupos" id="formGrupos" style='display:none;'>
			 <h2 class="form-signin-heading">Grupo<button id="addGrupo" class="btn btn-lg btn-primary" style="float: right;margin: 7px;" >Añadir nuevo Grupo</button></h2>
			
			
				<?php
				$json = file_get_contents("config.json");
				$config = json_decode($json, true);
				$grupos = $config['opciones']['grupos'];

				
				$canales = $config['opciones']['canales'];
				// Descartar canales para los que no se tienen permisos
				foreach($canales as $canal)
				{
					if(($canal['owner']!=$_SESSION['usuario'])&&($canal['owner']!='*'))
						unset($canales[$key]);
				}
				
				echo '<datalist id="temas">';
				foreach(glob('./temas/*', GLOB_ONLYDIR) as $dir)
				{
  					echo('<option value="'.substr(strrchr($dir,'/'),1).'">');
				}
				echo '</datalist>';
				foreach($gruposUsuario as $grupo)
				{
					?>
					
					<form class="formGrupo" action="guardarGrupo.php"  >
						<h4 class="form-signin-heading"><?php echo($grupo);?></h4>
						<label for="iTitulo">Título a mostrar</label>
				        <input type="text" id="iTitulo" name="titulo" class="form-control" placeholder="Título a mostrar" value="<?php echo $grupos[$grupo]['titulo'];?>" required autofocus>
				        <label for="tActualizacion">Tiempo entre actualizaciones (minutos)</label>
				        <input list="temas" id="tema" name="tema" class="form-control" placeholder="Tema a usar" value="<?php echo $grupos[$grupo]['tema'];?>" required>
				        <label for="tActualizacion">Tiempo entre actualizaciones (minutos)</label>
				        <input type="number" id="tActualizacion" name="tActualizacion" class="form-control" placeholder="minutos" value="<?php echo $grupos[$grupo]['tActualizar'];?>" required>
				        <label for="tRotacion">Tiempo de cada noticia (segundos)</label>
				        <input type="number" id="tRotacion" name="tRotacion" class="form-control" placeholder="segundos" value="<?php echo $grupos[$grupo]['tRotacion'];?>" required>
				        <label for="listaCanales">Canales que se mostrarán. Usar la tecla Control para seleccionar varios canales.</label>
				        <select multiple class="form-control listaMulti" id="listaCanales" name="canales[]">
				        	<?php
				        	
				        	foreach($canales as $key => $canal)
				        	{
				        		$seleccionado = (in_array($key, $grupos[$grupo]['canales']))?' selected="true"':"";
				        		echo("<option$seleccionado>$key</option>");
				        		
							}
							
							?>
				        </select>
				        <button class="btn btn-lg btn-primary btn-block" type="submit" name="grupo" value="<?php echo($grupo);?>" >Guardar</button>
					</form>
	
					
					<?php
				}
				?>
			</div>
			<div class="formCanales" id="formCanales"  style='display:none;' >
				<h2 class="form-signin-heading">Canales</h2>
				<?php 
				// Descartar canales para los que no se tienen permisos
				foreach($canales as $key => $canal)
				{
					if(($canal['owner']!=$_SESSION['usuario']))
						unset($canales[$key]);
					else
					{
						?><form class="formCanal" action="guardarCanal.php">
							<h4 class="form-signin-heading"><?php echo($key);?></h4>
							<label for="descripcion">Descripción</label>
				        	<input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción del canal" value="<?php echo $canal['descripcion'];?>" required autofocus>
				        	<label for="fuente">Tipo de canal</label>
				        	<select class="form-control" id="listaTipos" name="fuente">
				        	<?php
				        	foreach(glob('./fuentes/*.php') as $archivo)
				        	{
				        		$fuente = basename($archivo, ".php");
				        		$seleccionado = ($fuente!=$canal['fuente'])?"":' selected="true"';
				        		echo("<option$seleccionado>$fuente</option>");
							}?>
				        	</select>
				        	<label for="url">URL fuente del canal</label>
				        	<input type="text" id="url" name="url" class="form-control" placeholder="URL fuente del canal" value="<?php echo $canal['url'];?>" required>
				        	<button class="btn btn-primary center-block" type="submit" name="canal" value="<?php echo($key);?>">Guardar</button>
			        	</form>
					<?php 
					}
				}?>
				<button id="addCanal" class="btn btn-lg btn-primary center-block" >Añadir nuevo canal</button>
			</div>
			<div class="formPantallas" id="formPantallas" style='display:none;'>
		<h2 class="form-signin-heading panel-heading">Pantallas</h2>

		<table id="pantallas" class="table panel-heading">
			<thead>
				<tr>
					<th>IP Pantalla</th>
					<th>Nombre</th>
					<th>Grupo</th>
					
				</tr>
			</thead>
			<tbody>
					<?php
					
			$pantallas = $config ['opciones'] ['pantallas'];
			$key = array_keys ( $pantallas );
			$i = 0;
			foreach ( $pantallas as $obj ) {
				foreach ($gruposUsuario as $grup){
					if ($obj['grupo'] == $grup){
					echo '<tr><td>' . $key [$i] . '</td>';
					echo '<td>' . $obj ['nombre'] . '</td>';
					echo '<td>' . $obj ['grupo'] ;
					echo "<button style='float:right;' title='Borrar registro' id='borrar".  $key[$i]. "' class='glyphicon glyphicon-trash'><i class='fa fa-trash' aria-hidden='true'></i></button> </td>";
				
					}
					
				}
				$i++;
			}
			
			?>
					</tbody>
		</table>
		<button id="addPantalla" class="btn btn-lg btn-primary center-block" >Añadir nueva Pantalla</button>
	</div>
			

			
			<script>
			$('#addCanal').click(function(){
				nombre = window.prompt("Nombre del nuevo canal: ", "<?php echo nombreUsuario();?>");
				$('#formCanales').append(`<form class="formCanal" action="guardarCanal.php">
							<h4 class="form-signin-heading">${nombre}</h4>
							<label for="descripcion">Descripción</label>
				        	<input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción del canal" required autofocus>
				        	<label for="fuente">Tipo de canal</label>
				        	<select class="form-control" id="listaTipos" name="fuente">
					        	<?php
					        	foreach(glob('./fuentes/*.php') as $archivo){
					        		echo('<option>'.basename($archivo, ".php").'</option>');}?>
						    </select>
						    <label for="url">URL fuente del canal</label>
				        	<input type="text" id="url" name="url" class="form-control" placeholder="URL fuente del canal" required>
				        	<button class="btn btn-primary center-block" type="submit" name="canal" value="${nombre}">Guardar</button></form>`);
			});
			$('#addPantalla').click(function(){
				nombre = window.prompt("IP de la Pantalla: ", " ");
				$('#formPantallas').append(`<form class="formPantallas" method="post" action="guardarPantalla.php">
							<h4 class="form-signin-heading">${nombre}</h4>
							<label for="Nombre">Nombre identificador </label>
				        	<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre identificador de la Pantalla" required autofocus>
				        	<label for="grupo">Grupo</label>
				        	<select class="form-control" id="grupo" name="grupo">
					        	<?php
					        	foreach($gruposUsuario as $gruposdisponibles){
					        		echo('<option>'.$gruposdisponibles.'</option>');}?>
						    </select>
						   
				        	<button class="btn btn-primary center-block" type="submit" name="ip" value="${nombre}">Guardar</button></form>`);
			});
		
			
			</script>
			<div class="formCanales" id="formCanales"  style='display:none;' >
				<h2 class="form-signin-heading">Canales</h2>
				<?php 
				// Descartar canales para los que no se tienen permisos
				foreach($canales as $key => $canal)
				{
					if(($canal['owner']!=$_SESSION['usuario']))
						unset($canales[$key]);
					else
					{
						?><form class="formCanal" action="guardarCanal.php">
							<h4 class="form-signin-heading"><?php echo($key);?></h4>
							<label for="descripcion">Descripción</label>
				        	<input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción del canal" value="<?php echo $canal['descripcion'];?>" >
				        	<label for="fuente">Tipo de canal</label>
				        	<select class="form-control" id="listaTipos" name="fuente">
				        	<?php
				        	foreach(glob('./fuentes/*.php') as $archivo)
				        	{
				        		$fuente = basename($archivo, ".php");
				        		$seleccionado = ($fuente!=$canal['fuente'])?' selected="true"':"";
				        		echo("<option$seleccionado>$fuente</option>");
							}?>
				        	</select>
				        	<label for="url">URL fuente del canal</label>
				        	<input type="text" id="url" name="url" class="form-control" placeholder="URL fuente del canal" value="<?php echo $canal['url'];?>" required>
				        	<button class="btn btn-primary center-block" type="submit" name="canal" value="<?php echo($key);?>">Guardar</button>
			        	</form>
					<?php 
					}
				}?>
				
			</div>
			
			<div class="gestionUsuarios" id="gestionUsuarios"  style='display:none;' >
				 <h2 class="form-signin-heading">Usuarios<button id="addUsuario" class="btn btn-lg btn-primary" style="float: right;margin: 7px;" >Añadir nuevo Usuario</button></h2>
			 	<?php 
				 if($_SESSION['usuario']!='admin')
				 	echo '<div> Usted no está autorizado a esta página.</div>';
				 else {
				 	echo '<div> Aquí van los users</div>';
				 	$key = array_keys ( $usuarios['usuarios'] );
				 	$i = 0;
				
				 	
				 	foreach ($usuarios['usuarios'] as $user){
				?>
				 			<form class="formUsuario" action="guardarUsuario.php" >
				            <h1><?php echo $key[$i]?></h1>
							<label for="usuario">Nombre Usuario</label>
				        	<input type="text" id="Usuario" name="usuario" class="form-control" placeholder="Nombre Usuario" value="<?php echo $key[$i];?>" required autofocus readonly="readonly">
				    		<label for="pass">Contraseña</label>
				        	<input type="text" id="pass" name="pass" class="form-control" placeholder="*****" value="<?php echo $user['password'];?>" required autofocus>
							<label for="listaCanales">Grupos asociados al Usuario.</label>
				        	<select multiple class="form-control listaMulti" id="listaGrupos" name="grupos[]">
				        	<?php
				        	foreach($grupos as $f => $grupo)
				        	{
				        		$selec = (in_array($f, $user['grupos']))?' selected="true"':"";		        	 
				        		echo("<option$selec>$f</option>");
				        	
				        	}
				        					        	    
				        					        	    ?>
			</select>
				          <button class="btn btn-lg btn-primary btn-block" type="submit" name="grupo" value="<?php echo($grupo);?>" >Guardar</button>
				</form>
		
				
				<?php $i++;}
				 }?>

	</div>
			
			
			
			<script type="text/javascript">
				
		
				$(document).on("click", ".glyphicon-trash", function(e) {
					var id = e.target.id;
					id = id.replace('borrar','');

					$.confirm({
					    title: '¿Quiere borrar la pantalla:' + id + '? ',
					    content: 'La pantalla que elemine no mostrará ningún contenido.',
					    buttons: {
					        Confirmar: function () {
								
					            $.post({url:'./guardarPantalla.php', data: {'ip': id, 'borrar':'1' }});
					            location.href="admin.php?posicion=4";

					        },
					        Cancelar: function () {
					        
					        }
					    }
					});
					
				});
				$('#addUsuario').click(function(){
					nombre = window.prompt("Nombre del nuevo Usuario: ", "<?php echo nombreUsuario();?>");
					$('#gestionUsuarios').append(`<form class="formUsuario" method="post" action="guardarUsuario.php">
								<h1 class="form-signin-heading">${nombre}</h1>
								<h1><?php echo $key[$i]?></h1>
								<label for="usuario">Nombre Usuario</label>
					        	<input type="text" id="Usuario" name="usuario" class="form-control" placeholder="Nombre Usuario" value=${nombre} required autofocus readonly="readonly">
					        	<label for="pass">Contraseña</label>
					        	<input type="text" id="pass" name="pass" class="form-control" placeholder="Introduzca Contraseña" value=" " required autofocus>
					        	<label for="listaCanales">Grupos asociados al Usuario.</label>
					        	<select multiple class="form-control listaMulti" id="listaGrupos" name="grupos[]">
					        	<?php
					        	foreach($grupos as $f => $grupo)
					        	{
					        	        	 
					        		echo("<option>$f</option>");
					        	
					        	}
					        					        	    
					        					        	    ?>
				</select>
					        	<button class="btn btn-primary center-block" type="submit" name="canal" value="${nombre}">Guardar</button></form>`);
				});

				$('#addGrupo').click(function(){
					nombre = window.prompt("Nombre del nuevo Grupo: ", " ");
					$('#formGrupos').append(`<form class="formGrupo" method="post" action="guardarGrupo.php">
								<h1 class="form-signin-heading">${nombre}</h1>
								<h1><?php echo $key[$i]?></h1>
								<label for="iTitulo">Título a mostrar</label>
					        <input type="text" id="iTitulo" name="titulo" class="form-control" placeholder="Título a mostrar" value="<?php echo $grupos[$grupo]['titulo'];?>" required autofocus>
					        <label for="tActualizacion">Tiempo entre actualizaciones (minutos)</label>
					        <input list="temas" id="tema" name="tema" class="form-control" placeholder="Tema a usar" value="<?php echo $grupos[$grupo]['tema'];?>" required>
					        <label for="tActualizacion">Tiempo entre actualizaciones (minutos)</label>
					        <input type="number" id="tActualizacion" name="tActualizacion" class="form-control" placeholder="minutos" value="<?php echo $grupos[$grupo]['tActualizar'];?>" required>
					        <label for="tRotacion">Tiempo de cada noticia (segundos)</label>
					        <input type="number" id="tRotacion" name="tRotacion" class="form-control" placeholder="segundos" value="<?php echo $grupos[$grupo]['tRotacion'];?>" required>
					        <label for="listaCanales">Canales que se mostrarán. Usar la tecla Control para seleccionar varios canales.</label>
					        <select multiple class="form-control listaMulti" id="listaCanales" name="canales[]">
					        	<?php
					        	
					        	foreach($canales as $key => $canal)
					        	{
					        		$seleccionado = (in_array($key, $grupos[$grupo]['canales']))?' selected="true"':"";
					        		echo("<option$seleccionado>$key</option>");
					        		
								}
								
								?>
					        </select>
							 <button class="btn btn-lg btn-primary btn-block" type="submit" name="grupo" value="${nombre}" >Guardar</button></form>`);
				});
				
			</script>
			
			<?php 
		}
		else
		{
			$_POST[''];
			
		}
	}
	else
	{
		echo '<div class="mensaje"><h2 class="label label-warning">Se debe iniciar sesión</h2></div>';
		header('Refresh: 2; URL = login.php');
	}
}
function nombreUsuario()
{
	return $_SESSION['usuario'];
}
function menu($textoSalir="Salir")
{
	if($_SESSION['valida'])
	{
		$ifadmin = '';
		//if($_SESSION['usuario']=='admin')
			//$ifadmin = '<a href="admin.php" class="salir">Grupos y canales</a><a href="pantallas.php" class="salir">Pantallas</a><a href="usuarios.php" class="salir">Usuarios</a><a href="conexiones.php" class="salir">Conexiones</a>';
		return '<div class="menuAdmin">'.$ifadmin.'<a href="logout.php" class="salir">'.$textoSalir.'</a></div>';
	}
	return '';
}


require(__DIR__."/temas/default/admin.php");
?>
					
					<?php if ($_GET["posicion"]==4){
					
					echo "<script>mostrarPantallas();</script>";	
					}?>