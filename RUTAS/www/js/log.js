$(document).ready(function () {

});

function ingresar()
{

      		// location.href = 'home.html';
      		
	var usu = $('#txt_usuario').val();
	var pass = $('#txt_pass').val();
	if(usu=='' || pass=='')
	{
		alert('Ingrese las credenciales');
		return false;
	}
	var parametros = 
	{
		'usu':usu,
		'pass':pass,
	}
	 $.ajax({
      data:  {parametros:parametros},
      url:   url_link+'controlador/app.php?log=true',
      type:  'post',                   
      dataType: 'json',
      success:  function (response) { 
      	if(response!=-1)
      	{
      	  localStorage.setItem('ID_USUARIO', response[0].id_usuario);
          localStorage.setItem('PASSWORD', response[0].pass);
		  location.href = 'home.html';
      	}else
      	{
      		alert('Usuario o contraseña no encontrados');
      	}

      }
	 }).fail( function( jqXHR, textStatus, errorThrown ) {

    document.getElementById("lbl_mensaje").innerHTML = JSON.stringify(jqXHR);
    alert( jqXHR );
    alert( textStatus );
    alert( errorThrown);
});

}

function validar_sesion_activa()
{
 var usu = localStorage.getItem('ID_USUARIO');
  var pas = localStorage.getItem('PASSWORD');
  if(usu=='' && pas=='' || usu==null && pas==null)
  {
    location.href = '../www/view/login.html';
  }else
  {  	
    location.href = '../www/view/home.html';  	 
  }
}