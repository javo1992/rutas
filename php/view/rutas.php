<?php include('header.php'); ?>
<!--  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/> -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="../css/leaflet-routing-machine.css" /> 

   <script type="text/javascript">
        $(document).ready(function () {
    // $('#sidebarToggleTop').click();
            estados();
        });
       

        function buscar_puntos()
        {
           $('#modal_espera').modal('show');
            elimina();
            var parametros = 
            {
              'estado':$('#ddl_estado').val(),
            }
             $.ajax({
              data:  {parametros:parametros},
              url:   '../controlador/rutasC.php?puntos=true',
              type:  'post',
              dataType: 'json',
              success:  function (response) { 
                var puntos =[];
                var mark =[] ;
                var nu = response.length;    
                response.forEach(function(data, index) {
                    // console.log(nu);
                    // return false;
                  if(index==0 || index== (nu-1) ){

                    if(index==0){
                     mark.push(L.marker([data.la, data.lo],{icon:inicio},{draggable: false}).bindPopup('<b>'+data.nombre+'</b>').openPopup());                   
                    }else{
                      mark.push(L.marker([data.la, data.lo],{icon:fin},{draggable: false}).bindPopup('<b>'+data.nombre+'</b>').openPopup());   
                    }
                  }else
                  {
                      if(data.estado==1)
                    {
                      mark.push(L.marker([data.la, data.lo],{icon: vacio},{draggable: false}).bindPopup('<b>'+data.nombre+'</b>').openPopup());
                    }else if(data.estado==2)
                    {
                       mark.push(L.marker([data.la, data.lo],{icon: medio},{draggable: false}).bindPopup('<b>'+data.nombre+'</b>').openPopup());
                     }else if(data.estado==3)
                     {
                       mark.push(L.marker([data.la, data.lo],{icon: lleno},{draggable: false}).bindPopup('<b>'+data.nombre+'</b>').openPopup());
                     }else{
                       mark.push(L.marker([data.la, data.lo],{draggable: false}).bindPopup('<b>'+data.nombre+'</b>').openPopup());
                     }
                  }

                  puntos.push(L.latLng(data.la, data.lo));

                    
                });

                pintar_puntos(puntos,mark);     

                $('#modal_espera').modal('hide');         
              }
            });
        }

        function pintar_puntos(puntos,popup)
        {
            ruta = L.Routing.control({
                waypoints:puntos,
                language: 'es', 
                // routeWhileDragging: true,
                draggableWaypoints: false,
            }).addTo(map);
          pop = L.layerGroup(popup).addTo(map);

        }

        function elimina()
        {
         if(ruta)
         {
            map.removeControl(ruta);
            map.removeControl(pop);
         }                        
        }
    </script>
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
        <div class="col-sm-3">
            <select class="form-control form-control-sm" id="ddl_estado" name="ddl_estado" onchange="buscar_puntos()">
                <option>Seleccione estado de contenedor</option>
            </select>
        </div>
    </div>
    <div class="row">
         <div class="col-lg-12">
            <!-- Basic Card Example -->
            <div class="card shadow mb-8">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contenedores</h6>
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
<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
<script src="../js/leaflet-routing-machine.js"></script>
<script src="../js/rutas.js"></script>

<!-- <script type="text/javascript">
    var mymap = L.map('map').setView([0.366382, -78.112900], 13);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);

    L.marker([0.366339, -78.113684]).addTo(mymap)
        .bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();

</script> -->
<?php include('footer.php'); ?>
           
