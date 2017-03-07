<?php
class Youtube implements Fuente
{
	public static function generarCanal($url, $canal, $imagenDefecto, $limite=10)
	{
		ob_start(); // Guardar en un buffer toda la salida
		?>
		<script src="http://www.youtube.com/iframe_api"></script>
		<div class="item youtube" id ="youtube<?php echo $canal;?>">
			
			<div id="video<?php echo $canal;?>" class="vYoutube"></div>
		</div>
		<script>
			
			// Evitar que la diapositiva pase antes de que acabe el vídeo
			clearInterval(timer);
			// Restaurar estilos
			$('#video<?php echo $canal;?>').css('display', 'initial');
			$('#video<?php echo $canal;?>').css('opacity', '1');
			loadPlayer();
			
			function avanzar(){
				rotar();
				timer = setInterval(rotar, tRotacion);
				$('#video<?php echo $canal;?>').css('opacity', '0');
				setTimeout(function() {
					$('#video<?php echo $canal;?>').css('display', 'none');
				}, 300);
			}

			function loadPlayer() { 
				if (typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined') {
					var tag = document.createElement('script');
					tag.src = "https://www.youtube.com/iframe_api";
					var firstScriptTag = document.getElementsByTagName('script')[0];
					firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	
					window.onYouTubePlayerAPIReady = function() {
						onYouTubePlayer();
					};
	
				} else {
					onYouTubePlayer();
				}
			}

			var player;

			function onYouTubePlayer() {
				player = new YT.Player('video<?php echo $canal;?>', {
					height: '100%',
					width: '100%',
					videoId: '<?php echo $url;?>',
					playerVars: {autoplay: 1, controls:0, showinfo: 0, rel: 0, showsearch: 0, iv_load_policy: 3 },
					events: {
						'onStateChange': onPlayerStateChange,
						'onError': catchError
					}
				});
			}

			var done = false;
			function onPlayerStateChange(event) {
				if (event.data == YT.PlayerState.ENDED) {
					avanzar();
				}
			}
			function catchError(event){
				console.error("No se pudo reproducir el vídeo: código "+event.data);
				avanzar();
			}
		</script>
		<?php 
		return(ob_get_clean()); // Devolver el resultado del buffer
	}
}
?>