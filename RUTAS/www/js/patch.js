
var url_link = 'http://corsinf.com:8087/pruebas/rutas/php/';
var url_img = url_link+'img/';
var url_img_u = url_link+'img/usuario/';
var url_img_c = url_link+'img/contenedores/';



// var servidor = 'https://www.jeanobando.online';
// var carpeta = 'php';
// var url_link = servidor+'/'+carpeta+'/';
// var url_img = url_link+'img/';
// var url_img_u = url_link+'img/usuario/';
// var url_img_c = url_link+'img/contenedores/';



function validar_sesion_activa()
{
  var usu = localStorage.getItem('ID_USUARIO');
  var pas = localStorage.getItem('PASSWORD');
  if(usu=='' && pas=='' || usu==null && pas==null)
  {
     location.href = 'login.html';
  }
}

function salir()
{
	 Swal.fire({
     title: 'Salir',
     text: "Esta usted seguro!",
     type: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Si!'
   }).then((result) => {
     if (result.value==true) {
     cerrar_sesion()
     }
   })
}

function cerrar_sesion()
{
  localStorage.removeItem('ID_USUARIO');
  localStorage.removeItem('PASSWORD');
  location.href = 'login.html';
}