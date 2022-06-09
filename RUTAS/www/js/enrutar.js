
var watchID = navigator.geolocation.watchPosition(onSuccess, onError);

function onSuccess(position) {
    // var element = document.getElementById('geolocation');
    // element.innerHTML = 'Latitude: '  +      + '<br />' +
    //                     'Longitude: ' +     + '<br />' +
    //                     '<hr />'      + element.innerHTML;
    document.getElementById('txt_lat').value = position.coords.latitude;
    document.getElementById('txt_lon').value = position.coords.longitude;
   
}

// onError Callback receives a PositionError object
//

function buscar_posicion()
{
     navigator.geolocation.watchPosition(onSuccess, onError);
     map.on('locationfound', onLocationFound);
}
function onError(error) {
    // alert('code: '    + error.code    + '\n' +
    //       'message: ' + error.message + '\n');
}

function rutas()
{
	 location.href = 'rutas.html';
}

function contenedor()
{
	location.href = 'contenedor.html';
}
function home()
{
	location.href = 'home.html';
}
function perfil()
{
	location.href = 'perfil.html';
}

  function getParameterByName(name) 
  {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }
