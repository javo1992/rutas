<?php include('header.php'); ?>
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <script type="text/javascript">
   	 $(document).ready(function () {
            buscar_puntos();
            setInterval(buscar_puntos, 3000);
        });
     var id;
    


     function simular_puntos()
     {

        var l = $('#on').val();
      if(l==0)
      {
        id = setInterval(simular,3000);
        $('#on').val(1);

      }else
      {
        clearInterval(id);
        $('#on').val(0);
      }
     }
     function simular()
     {
         $.ajax({
          // data:  {parametros,parametros},
          url:   '../controlador/rutasC.php?simular=true',
          type:  'post',
          dataType: 'json',
          success:  function (response) { 
            
          }
        });
     }
   	function buscar_puntos()
        {
          $('#lbl_espera').text('CARGANDO PUNTOS...');
          $("#img_espera").attr("src","../img/sistema/ubicacion.gif");
          $("#img_espera").css("width",'30%');

            var parametros = 
            {
              'estado':'',
            }
             $.ajax({
              data:  {parametros:parametros},
              url:   '../controlador/rutasC.php?puntos_all=true',
              type:  'post',
              dataType: 'json',
               beforeSend: function () {
                // $('#modal_espera').modal('show');
               },
              success:  function (response) { 
                var puntos =[];
                 var nu = response.length;    
                response.forEach(function(data, index) {
                 
                	    // return false;
                  if(index==0 || index== (nu-1) ){

                    if(index==0){
                     L.marker([data.la, data.lo],{icon:inicio}).addTo(mymap).bindPopup('<b>'+data.nombre+'</b>').openPopup();                   
                    }else{
                      L.marker([data.la, data.lo],{icon:fin}).addTo(mymap).bindPopup('<b>'+data.nombre+'</b>').openPopup();   
                    }
                  }else
                  {
                      if(data.estado==1)
                    {
                      L.marker([data.la, data.lo],{icon: vacio}).addTo(mymap).bindPopup('<b>'+data.nombre+'</b>').openPopup();
                    }else if(data.estado==2)
                    {
                       L.marker([data.la, data.lo],{icon: medio}).addTo(mymap).bindPopup('<b>'+data.nombre+'</b>').openPopup();
                     }else if(data.estado==3)
                     {
                       L.marker([data.la, data.lo],{icon: lleno}).addTo(mymap).bindPopup('<b>'+data.nombre+'</b>').openPopup();
                     }else{
                       L.marker([data.la, data.lo]).addTo(mymap).bindPopup('<b>'+data.nombre+'</b>').openPopup();
                     }
                  }



                });
                 $('#modal_espera').modal('hide');
                // console.log(puntos);
                // // elimina();
                // pintar_puntos(puntos)               
              }
            });
        }

   </script>
  
	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		#map {
			width: 100%;
			height: 450px;
		}
	</style>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <!-- <button onclick="eliminar_session()"> Cerrar</button> -->
    <div class="row">
         <div class="col-lg-12">
            <!-- Basic Card Example -->
            <div class="card shadow mb-8">
                <div class="card-header py-3">
                  <div class="row">
                    <div class="col-sm-6">                      
                        <h6 class="m-0 font-weight-bold text-primary">Contenedores</h6>
                    </div>
                    <div class="col-sm-6 text-right">
                      <button class="btn btn-sm btn-primary" onclick="simular_puntos();">Simular</button>
                      <input type="hidden" name="on" id="on" value="0">
                    </div>                    
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                        <div class="col-sm-12 text-center">
                            <label><input type="color" name="" value="#248d0a" disabled>CONTENEDOR VACIO</label>
                            <label><input type="color" name="" value="#ffb504" disabled>CONTENEDOR MEDIO</label>
                            <label><input type="color" name="" value="#db0023" disabled>CONTENEDOR LLENO</label>
                        </div>
                    </div>
                    <div id="map"></div>
                </div>
            </div>

        </div>                        
    </div>
</div>
<script type="text/javascript">
	var mymap = L.map('map').setView([0.366382, -78.112900], 17);

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(mymap);

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


</script>
<?php include('footer.php'); ?>
           