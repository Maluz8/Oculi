<?php
session_start();
function admin()
{
	if($_SESSION['valida'])
	{
		if($_POST['cambios']===null) // Sin parámetros para guardar, sólo usuario
		{
			?>
			<div class="formGrupos">
				<h2 class="form-signin-heading">Grupos</h2>
				<?php
				$json = file_get_contents("usuarios.json");
				$usuarios = json_decode($json, true);
				$gruposUsuario = $usuarios['usuarios'][$_SESSION['usuario']]['grupos'];
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
					<form class="formGrupo">
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
				        <select multiple class="form-control listaMulti" id="listaCanales" name="canales">
				        	<?php
				        	foreach($canales as $key => $canal)
				        	{
				        		$seleccionado = (in_array($key, $grupos[$grupo]['canales']))?"":' selected="true"';
				        		echo("<option$seleccionado>$key</option>");
							}?>
				        </select>
				        <button class="btn btn-lg btn-primary btn-block" type="submit" name="grupo" value="<?php echo($grupo);?>">Guardar</button>
					</form>
					<?php
				}
				?>
			</div>
			<div class="formCanales" id="formCanales">
				<h2 class="form-signin-heading">Canales</h2>
				<?php 
				// Descartar canales para los que no se tienen permisos
				foreach($canales as $key => $canal)
				{
					if(($canal['owner']!=$_SESSION['usuario']))
						unset($canales[$key]);
					else
					{
						?><form class="formCanal">
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
				<button id="addCanal" class="btn btn-lg btn-primary center-block">Añadir nuevo canal</button>
			</div>
			<script>
			$('#addCanal').click(function(){
				nombre = window.prompt("Nombre del nuevo canal: ", "<?php echo nombreUsuario();?>");
				$('#formCanales').append(`<form class="formCanal">
							<h4 class="form-signin-heading">${nombre}</h4>
							<label for="descripcion">Descripción</label>
				        	<input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción del canal" required autofocus>
				        	<label for="fuente">Tipo de canal</label>
				        	<select class="form-control" id="listaTipos" name="fuente">
					        	<?php
					        	foreach(glob('./fuentes/*.php') as $archivo)
					        	{
					        		echo('<option>'.basename($archivo, ".php").'</option>');
								}?>
						    </select>
						    <label for="url">URL fuente del canal</label>
				        	<input type="text" id="url" name="url" class="form-control" placeholder="URL fuente del canal" required>
				        	<button class="btn btn-primary center-block" type="submit" name="canal" value="${name}">Guardar</button>
		        		</form>
			        	`);
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
		if($_SESSION['usuario']=='admin')
			$ifadmin = '<a href="admin.php" class="salir">Grupos y canales</a><a href="pantallas.php" class="salir">Pantallas</a><a href="usuarios.php" class="salir">Usuarios</a><a href="conexiones.php" class="salir">Conexiones</a>';
		return '<div class="menuAdmin">'.$ifadmin.'<a href="logout.php" class="salir">'.$textoSalir.'</a></div>';
	}
	return '';
}
require(__DIR__."/temas/default/admin.php");
?>
