var ruta;
var pop;



var map = L.map('map').setView([0.366382, -78.112900], 17);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

 var vacio = L.icon({
    iconUrl: '../img/vacio.png',
    iconSize:     [61, 55], // size of the icon
    iconAnchor:   [29, 55], // point of the icon which will correspond to marker's location
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});


var medio = L.icon({
    iconUrl: '../img/medio.png',
    iconSize:     [61, 55], // size of the icon
    iconAnchor:   [29, 55], // point of the icon which will correspond to marker's location
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});


var lleno = L.icon({
    iconUrl: '../img/lleno.png',
    iconSize:     [61, 55], // size of the icon
    iconAnchor:   [29, 55], // point of the icon which will correspond to marker's location
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});
var inicio = L.icon({
    iconUrl: '../img/inicio.png',
    iconSize:     [61, 55], // size of the icon
    iconAnchor:   [29, 55], // point of the icon which will correspond to marker's location
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});
var fin = L.icon({
    iconUrl: '../img/fin.png',
    iconSize:     [61, 55], // size of the icon
    iconAnchor:   [29, 55], // point of the icon which will correspond to marker's location
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});



function estados()
{
     $.ajax({
      // data:  {parametros:parametros},
      url:   '../controlador/rutasC.php?estados=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) { 
        $('#ddl_estado').html(response);                
      }
    });

}
