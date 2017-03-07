var n = 0;
var maxNodo = 0;
var nodos = [];
var timer;
if(!tActualizar)
	tActualizar = 900000;
if(!tRotacion)
	tRotacion = 5000;
function actualizar (primeraVez=false){
	$.ajax( {
		url: URL,
		type: 'GET',
		processData: false,
		contentType: false
	}).done(function( data ) {
		if(data=='') {
			$('#pie>#web').css('border-left', 'dotted 3px black');
		} else if(data=='0'){
			$('#pie>#web').css('border-left', 'dotted 3px black');
		} else {
			localStorage.setItem("noticias", data);
			$('#noticia').html(data);
			nodos = $('#noticia').children('.item');
			maxNodo = nodos.length-1;
			$(nodos).css('max-height','0');
			$(nodos).css('opacity','0');
			$(nodos[n]).css('max-height','');
			$(nodos[n]).css('opacity','1');
			$('#pie>#web').css('border-left', 'none');
		}
	}).fail(function(x, status, error) {
			if(primeraVez)
			{
				cargarStorage();
			}
			$('#pie>#web').css('border-left', 'dotted 3px black');
		});
}
function rotar (){
	$(nodos[n]).css('opacity','0');
	$(nodos[n]).css('height','0');
	if(n==maxNodo)
	{
		n=0;
		$(nodos).css('height','');
		cargarStorage();
	}
	else
	{
		n++;
	}
	$(nodos[n]).css('max-height','');
	$(nodos[n]).css('opacity','1');
}
function reloj() {
	reloj = new Date();
	cero = (reloj.getMinutes()<10)?'0':'';
	$('#reloj').html('<h2>'+reloj.getHours()+':'+cero+reloj.getMinutes()+'</h2>');
}
function cargarStorage(){
	data = localStorage.getItem("noticias");
	$('#noticia').html('');
	$('#noticia').html(data);
	nodos = $('#noticia').children('.item');
	maxNodo = nodos.length-1;
	$(nodos).css('max-height','0');
	$(nodos).css('opacity','0');
	$(nodos[n]).css('max-height','');
	$(nodos[n]).css('opacity','1');
}
$(function(){
	actualizar();
	reloj();
});

setInterval(actualizar, tActualizar);
timer = setInterval(rotar, tRotacion);
setInterval(reloj, 1000);