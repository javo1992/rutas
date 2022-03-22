
$(document).ready(function () {

	disparar_noti();
	
});

function num_caracteres(campo,num)
{
	var val = $('#'+campo).val();
	var cant = val.length;
	console.log(cant+'-'+num);

	if(cant>num)
	{
		$('#'+campo).val(val.substr(0,num));
		return false;
	}

}



// function validar_session_activa() 
// {
// 	const id_empresa = localStorage.getItem('ID_EMPRESA');
// 	const empresa = localStorage.getItem('EMPRESA');
// 	const usuario = localStorage.getItem('USUARIO');
// 	const id_usuario = localStorage.getItem('ID_USUARIO');
	

// 	if(empresa==null || id_usuario==null)
// 	{
// 		window.location.href = 'view/login.html';
// 	}else
// 	{
// 		window.location.href = 'view/home.html';
// 	}
// }

// // function eliminar_session() 
// // {
// // 	// localStorage.clear();
// // 	localStorage.removeItem('ID_EMPRESA');
// // 	localStorage.removeItem('ID_USUARIO');
// // 	window.location.href = '../index.html';
// // }

// function leer()
// {
// 	    console.log(localStorage.getItem('INICIO'));
// 		console.log(localStorage.getItem('USUARIO'));
// 		console.log(localStorage.getItem('PASS'));
// }

function disparar_noti()
{
	// setInterval(notificaciones,10000);
	// notificaciones()
}

function notificaciones()
{
	var parametros = 
	{
		'empresa':localStorage.getItem('ID_EMPRESA'),
		'usuario':localStorage.getItem('ID_USUARIO'),
	}

    $.ajax({
        data:  {parametros:parametros},
        url:    url_link+'funciones.php?notificaciones=true',           
        type:  'post',
        dataType: 'json',
        success:  function (response) { 
            $('#pnl_aletas').html(response.noti); 
            $('#num_noti').text(response.num); 
        }
      });

}