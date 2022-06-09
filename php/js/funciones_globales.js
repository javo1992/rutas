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

function validador_correo(campo)
{
    var campo = $('#'+campo).val();   
    var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    //Se muestra un texto a modo de ejemplo, luego va a ser un icono
    if (emailRegex.test(campo)) {
      // alert("válido");
      return true;

    } else {
      Swal.fire('Email incorrecto','','info');
      console.log(campo);
      return false;
    }
}


function validar_ci_ruc(campo) {
        var cad = document.getElementById(campo).value.trim();
        var total = 0;
        var longitud = cad.length;
        var longcheck = longitud - 1;

        if (cad !== "" && longitud === 10){
          for(i = 0; i < longcheck; i++){
            if (i%2 === 0) {
              var aux = cad.charAt(i) * 2;
              if (aux > 9) aux -= 9;
              total += aux;
            } else {
              total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
            }
          }

          total = total % 10 ? 10 - total % 10 : 0;

          if (cad.charAt(longitud-1) == total) {
          }else{
          	Swal.fire('Cedula invalida','revise su numero '+cad,'info');
          	$('#'+campo).val('');
          }
        }
      }

