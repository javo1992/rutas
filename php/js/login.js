$(document).ready(function () {

});
function login()
{
	var usu = $('#txt_usuario').val();
	var pass = $('#txt_password').val();
  var rem = $('#customCheck').prop('checked');
  // console.log(rem);
  // return false;
  if(rem==true)
  {
    localStorage.setItem('RECORDAR','1');
  }else
  {
    localStorage.setItem('RECORDAR','0');
  }  
   	var parametros = 
   	{
   	  'usu':usu,
   	  'pass':pass,
   	}
     $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/funcionesSistema.php?login=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) { 
        if(response.res==true)
        {          
        	window.location.href = "../view/home.php";
        }else
        {
        	Swal.fire('','Usuario o contraseña incorrecto','info');
        }
      }
    });
}

function registrarse()
{
  var datos = $("#form_registro").serialize();
  if($('#txt_lon').val()=='' && $('#txt_lon').val()=='')
  {
    navigator.geolocation.watchPosition(onSuccess, onError, { timeout: 5000 });
  }
   if($('#txt_email').val()=='' || $('#txt_pass').val() =='' || $('#txt_fecha_na').val()=='' || $('#txt_usuario').val()=='')
  {
    Swal.fire('','Llene todo los campos','info');
    return false;
  }
     $.ajax({
      data:  datos,
      url:   url_s+'registrarse=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) { 
        if(response==1)
        {
          Swal.fire('','Usuario creado','success');
          window.location.href = "../pages/inicio.html";
        }else
        {
          Swal.fire('','No se pudo registrar intente mas tarde','error');
        }
      }
    });

}

function recuperar_pass()
{
  if($('#txt_email').val()=='')
  {

    Swal.fire('','Ingrese un email valido','error');
     return false;
  }
  var parametros = 
  {
    'usu':$('#txt_email').val(),
  }
     $.ajax({
      data:  {parametros,parametros},
      url:   url_s+'recuperar=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) { 
        if(response==1)
        {
          Swal.fire('','Su clave termporal se a enviado a su correo','success');
          // window.location.href = "../pages/login.html";
        }else if(response==-2)
        {
          Swal.fire('','No se pudo enviar email','error');
        }
        else
        {
          Swal.fire('','Email no encontrado','error');
        }
      }
    });


}

function recordar()
{  
  const REC = localStorage.getItem('RECORDAR');
  if(REC==1)
  {
    var ruc = localStorage.getItem('RUC_EMPRESA');
    var usu = localStorage.getItem('USUARIO');
    var pas = localStorage.getItem('PASS');
    $('#txt_empresa').val(ruc);
    $('#txt_usuario').val(usu);
    $('#txt_password').val(pas);   
    $('#customCheck').prop('checked',true);
  }

}


function crear_sesion(usuario,empresa,pass)
{
  // var directorio = "file:///storage/emulated/0";
  var texto = [];
  texto.push(usuario+'\n');
  texto.push(pass+'\n');
  texto.push(empresa);

  var blob = new Blob(texto,{type: "text/plain;charset=utf-8"});
  saveAs(blob, "session.txt","C:\\Apps\\");
}

// window.resolveLocalFileSystemURL(directorio, function(dir) {
// 	dir.getFile(nombreArchivo, {create:true}, function(fileEntry) {
// 		// el archivo ha sido creado satisfactoriamente.
// 		// Usa fileEntry para leer el contenido o borrar el archivo
// 	});
// });