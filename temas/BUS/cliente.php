<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>Biblioteca Universidad de Sevilla - Noticias - <?php echo $titulo;?></title>
	<style><?php require __DIR__ . '/css/cliente.css';?></style>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css"></link>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script>
		var URL = "http://<?php echo(dirname($_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'])."?id={$_GET['id']}");?>";
		var tActualizar = <?php echo($tActualizar*60000)?>;
		var tRotacion = <?php echo($tRotacion*1000)?>;
		<?php require __DIR__.'/js/cliente.js';?>
	</script>
</head>
<body>
	<div class="cabecera">
		<div id="reloj"></div>
		<div id="titulo"><h2><?php echo $titulo;?></h2></div><img src="temas/BUS/bus.png">
	</div>
	<div id="noticia"></div>
	<div id="pie">
		<div>Biblioteca Universidad de Sevilla</div><div id="web">http://bib.us.es</div>
	</div>
</body>
</html>