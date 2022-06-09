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
		$('#sidebarToggleTop').click();
	   	puntos_mapa();
	   	lista_contenedores();
      revisar_puntos_inicio();
	   });
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
                    <h6 class="m-0 font-weight-bold">Registro de nuevo contenedor</h6>
                </div>
                <div class="card-body">
                   <div class="row">
                   		<div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-5">
                            <b>Nombre Cont.</b>
                        <input type="text" name="txt_nombre" id="txt_nombre" class="form-control form-control-sm" placeholder="Nombre del contenedor">
                        <input type="hidden" name="txt_id" id="txt_id">                            
                          </div>
                          <div class="col-sm-3">
                            <b>Codigo Cont.</b>
                        <input type="text" name="txt_cod" id="txt_cod" class="form-control form-control-sm" placeholder="Codigo">                       
                          </div>
                          <div class="col-sm-4">
                            <label class="custom-control custom-checkbox"><input type="checkbox" name="rbl" value="ini" id="rbl_ini"> Punto Inicio</label>
                            <label class="custom-control custom-checkbox"><input type="checkbox" name="rbl" value="fin" id="rbl_fin"> Punto Final</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                            <b>Alto(m)</b>
                            <input type="" name="" class="form-control form-control-sm" id="txt_alto" name="txt_alto">
                          </div>
                           <div class="col-sm-4">
                            <b>largo(m)</b>
                            <input type="" name="" class="form-control form-control-sm" id="txt_largo" name="txt_largo">
                          </div>
                           <div class="col-sm-4">
                            <b>Ancho(m)</b>
                            <input type="" name="" class="form-control form-control-sm" id="lbl_ancho" name="lbl_ancho">
                          </div>
                        </div>
                          <div class="row">
                          <div class="col-sm-12">
                            <b>Descripcion</b>
                            <textarea class="form-control-sm form-control" style="resize: none;" id="txt_des" name="txt_des"></textarea>
                          </div>                          
                        </div>
                   			
                   		   <div class="row">
                   		   	 <div class="col-sm-5">
                   		   	 	longtiud
                   		   	 	<input type="text" name="txt_lon" id="txt_lon" class="form-control form-control-sm" readonly="">
                   		   	 </div>
                   		   	 <div class="col-sm-5">
                   		   	 	latitud
                   				<input type="text" name="txt_lat" id="txt_lat" class="form-control form-control-sm" readonly="">                   		   	 	
                   		   	 </div>
                   		   	 <div class="col-sm-2 text-center">  
                   		   	 <br>                 		   	 	
                   		   	   <button class="btn btn-sm btn-primary" onclick="guardar()">Guardar</button>
                   		   	 </div>
                   		   </div>
                         <div class="row">
                            <div class="col-sm-12">
                       
                        <b>Ubicacion</b>
                        <div id="map"></div>
                     </div>
                         </div>

                   		</div>
                   		<div class="col-sm-6">
                        <b>Contenedores registrados</b>
                          <div class="row">                             
                            <div class="col-sm-12">
                              <input type="text" class="form-control form-control-sm" name="txt_query" id="txt_query" onkeyup="lista_contenedores()" placeholder="Buscar contenedor">
                              <input type="hidden" name="lin_tbl" id="lin_tbl" value="0">
                              <div class="table-responsive" style="overflow-y: scroll; height: 50%">
                                <table class="table table-bordered dataTable">
                                  <thead>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>latitud</th>
                                    <th>longitud</th>
                                    <th>largo</th>
                                    <th>ancho</th>
                                    <th>alto</th>
                                    <th>descripcion</th>
                                    <th></th>
                                  </thead>
                                  <tbody id="tbl_contenedor">
                                    
                                  </tbody>
                                </table>
                                
                              </div>
                            </div>
                          </div>         
                   		</div>
                   </div>
                   
                </div>
            </div>

        </div>                        
    </div>
</div>
<script type="text/javascript">
	var mymap = L.map('map').setView([0.366382, -78.112900], 17);

 var vacio = L.icon({
    iconUrl: '../img/default.png',
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


	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(mymap);
	   var lista = [];

		var punto = L.marker([0.3645633893498964, -78.11236328470248],{
        draggable: true
      }).addTo(mymap).bindPopup("<b>Mi ubicacion</b>").openPopup();
    

    // var punto = L.marker([0.3645633893498964, -78.11236328470248],{
    //     draggable: true
    //   }).addTo(mymap).bindPopup("<b>Mi ubicacion</b>").openPopup();
	  

    $('#txt_lon').val(-78.11236328470248);
		$('#txt_lat').val(0.3645633893498964);
	
	
	punto.on('dragend', function(e) {
		$('#txt_lon').val(e.target._latlng.lng);
		$('#txt_lat').val(e.target._latlng.lat);
    });

    function puntos_mapa(){
    	$.ajax({
          // data:  {parametros:parametros},
          url:   '../controlador/nuevo_contenedorC.php?puntos_mapa=true',
          type:  'post',
          dataType: 'json',
          success:  function (response) {    
             var nu = response.length;    
             response.forEach(function(data, index) {             	
                  if(index==0 || index== (nu-1) )
                  {
                    if(index==0){
                     lista[data.id] = L.marker([data.la, data.lo],{icon:inicio}).addTo(mymap).bindPopup('<b>'+data.nombre+'</b>').openPopup();                   
                    }else{
                      lista[data.id] = L.marker([data.la, data.lo],{icon:fin}).addTo(mymap).bindPopup('<b>'+data.nombre+'</b>').openPopup();   
                    }
                  }else
                  {
                   
                       lista[data.id] = L.marker([data.la, data.lo],{icon:vacio}).addTo(mymap).bindPopup('<b>'+data.nombre+'</b><br /><b>Estado: </b>'+data.nombre_estado).openPopup();
                  }







                });
              } 
           });

    }

     function lista_contenedores(){
     	var parametros = {
     		'query':$('#txt_query').val(),
     	}
    	$.ajax({
          data:  {parametros:parametros},
          url:   '../controlador/nuevo_contenedorC.php?lista_contenedores=true',
          type:  'post',
          dataType: 'json',
          success:  function (response) { 
             if(response.length!=0){
               $('#lin_tbl').val(1);
             }
            $('#tbl_contenedor').html(response);
            }               
           });

    }

    function guardar()
    {

    	var nom = $('#txt_nombre').val();
    	var lon = $('#txt_lon').val();
		  var lat = $('#txt_lat').val();
		  var id = $('#txt_id').val();
      var ini = $('#rbl_ini').prop('checked');
      var fin = $('#rbl_fin').prop('checked');
      var li = $('#lin_tbl').val();
      var cod = $('#txt_cod').val();
       var al = $('#txt_alto').val();
       var la = $('#txt_largo').val();
       var an = $('#lbl_ancho').val();
       var des = $('#txt_des').val();

      if(lat==0.3645633893498964 && lon== -78.11236328470248)
      {
        Swal.fire('Mueva el marker','','error');
        return false;
      }

      if(li==0){

        $('#rbl_ini').attr('checked',true);
      }

      var ini = $('#rbl_ini').prop('checked');

    	if(nom=='')
    	{
    		Swal.fire('coloque un nombre valido','','info');
    		return false;
    	}
    	var parametros = {
    		'lat':lat,
    		'lon':lon,
    		'nom':nom,
    		'id':id,
        'ini':ini,
        'fin':fin,
        'cod':cod,
        'al':al,
        'la':la,
        'an':an, 
        'des':des,
    	}
	 $.ajax({
          data:  {parametros:parametros},
          url:   '../controlador/nuevo_contenedorC.php?nuevo=true',
          type:  'post',
          dataType: 'json',
          success:  function (response) { 
            if(response==1 && id=='')
            {
            	Swal.fire('Contenedor registrado','','success');
            }else if(response==1 && id!='')
            {
            	Swal.fire('Contenedor editado','','success');
            }        
            location.reload();
          }
        });

    }

    function editar(id)
    {
    	 $.ajax({
          data:  {id:id},
          url:   '../controlador/nuevo_contenedorC.php?editar=true',
          type:  'post',
          dataType: 'json',
          success:  function (response) { 
          	console.log(response);
          	$('#txt_nombre').val(response[0].nombre);
    		    $('#txt_lon').val(response[0].lo);
			      $('#txt_lat').val(response[0].la);
		        $('#txt_id').val(response[0].id);  
            $('#rbl_ini').attr('disabled',false);
            $('#rbl_fin').attr('disabled',false); 
            $('#txt_cod').val(response[0].codigo);  

            $('#txt_alto').val(response[0].alto);  
            $('#txt_largo').val(response[0].largo);  
            $('#lbl_ancho').val(response[0].ancho);  
            $('#txt_des').val(response[0].des);     

            if(response[0].inicio==1 && response[0].fin==1)
            {
              $('#rbl_ini').prop('checked',true);
              $('#rbl_fin').prop('checked',true);  

            }else if(response[0].inicio==0 && response[0].fin==1)
            {
              $('#rbl_fin').prop('checked',true);  

            }else if(response[0].inicio==1 && response[0].fin==0)
            {
              $('#rbl_ini').prop('checked',true);  

            }

          }
        });

    }

    function delete_contenedor(id)
    {
    	Swal.fire({
		  title: 'Esta seguro de eliminar?',
		  text: "Esta apunto de eliminar un contenedor!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {
		     eliminar(id);
		  }
		})
    }

    function eliminar(id)
    {
    	 $.ajax({
          data:  {id:id},
          url:   '../controlador/nuevo_contenedorC.php?eliminar=true',
          type:  'post',
          dataType: 'json',
          success:  function (response) { 
          	if(response==1)
          	{
          		Swal.fire('Contenedor eliminado','','success');
          		 lista.forEach(function(data,index){
          		 	mymap.removeControl(lista[index]);
          		 });          		
            location.reload();
          	}                    
          }
        });

    }

    function revisar_puntos_inicio()
    {
      $.ajax({
          // data:  {id:id},
          url:   '../controlador/nuevo_contenedorC.php?revisar=true',
          type:  'post',
          dataType: 'json',
          success:  function (response) { 
            console.log(response.inicio);
            if(response.inicio==true)
            {
              $('#rbl_ini').attr('disabled',true);
            }
            if(response.fin==true)
            {
              $('#rbl_fin').attr('disabled',true);              
            }                
          }
        });

    }


</script>
<?php include('footer.php'); ?>
           