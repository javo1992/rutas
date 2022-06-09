<?php include('header.php'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		listar();
	   });

	function listar()
	{
	  var parametros = {
			'query':$('#txt_query').val(),
		}
     $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/tipoC.php?listar_tipo=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) { 
        $('#tbl_tipos').html(response);                
      }
    });

	}
	
	function guardar()
	{
		var n = $('#txt_nombre').val();
		var id = $('#txt_id').val();
		
		if(n=='')
		{
			Swal.fire('Llene todo los campos','','info');
			return false;
		}

     $.ajax({
	      data:  $('#form-tipo').serialize(),
	      url:   '../controlador/tipoC.php?guardar=true',
	      type:  'post',
	      dataType: 'json',
	      success:  function (response) { 
	      	if(id=='' && response==1)
	      	{ Swal.fire('tipo Guardado','','success')

	      	}else if(id!='' && response==1)
	      	{ Swal.fire('tipo Editado','','success')

	      	}else
	      	{ Swal.fire('No se pudo guardar','','error')

	      	}
	      	listar();
	      	limpiar();

	      }
	    });

	}

	function editar(id)
	{
		var parametros = {
			'id':id,
		}
      $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/tipoC.php?editar=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) { 
        $('#txt_id').val(response[0].id);
        $('#txt_nombre').val(response[0].nombre);
        $('#txt_ci').val(response[0].ci_ruc);
        $('#txt_nick').val(response[0].nick);
        $('#txt_pass').val(response[0].pass);
        $('#ddl_tipo').val(response[0].id_tipo);
        $('#txt_dir').val(response[0].direccion);        
      }
      });

    }

    function eliminar(id)
	{
		var parametros = {
			'id':id,
		}
      $.ajax({
      data:  {parametros:parametros},
      url:   '../controlador/tipoC.php?eliminar=true',
      type:  'post',
      dataType: 'json',
      success:  function (response) {
	      	listar();   
      }
      });

    }

	 function limpiar()
      {
      	$('#txt_id').val('');
        $('#txt_nombre').val('');
        $('#txt_ci').val('');
        $('#txt_nick').val('');
        $('#txt_pass').val('');
        $('#ddl_tipo').val('');
        $('#txt_dir').val('');   
      }

  function eliminar_registro(id)
    {
    	Swal.fire({
		  title: 'Esta seguro de eliminar?',
		  text: "Esta apunto de eliminar un registro!",
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
</script>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tipo de usuario</h1>
    <!-- <button onclick="eliminar_session()"> Cerrar</button> -->
    <div class="row">
         <div class="col-lg-12">
            <!-- Basic Card Example -->
            <div class="card shadow mb-8">
                <div class="card-header py-3">
                    <!-- <h6 class="m-0 font-weight-bold text-primary">Basic Card Example</h6> -->
                </div>
                <div class="card-body">
                	<div class="row">
                		<div class="col-sm-4">
                		<form id="form-tipo">
                			<div class="row">
                				<div class="col-sm-12">
                					<input type="hidden" name="txt_id" id="txt_id">
                					<b>Tipo de usuario</b>
                					<input type="text" class="form-control form-control-sm" placeholder="Nombre" name="txt_nombre" id="txt_nombre">               					
                				</div>
                				
                			</div>
                			<div class="modal-footer">
                				<button class="btn btn-sm btn-primary" type="button" onclick="guardar()">Guardar</button>
                			</div>                			
                			 </form>
                		</div>
                		<div class="col-sm-8">
                			<input type="text" class="form-control form-control-sm" name="txt_query" id="txt_query" onkeyup="listar()" placeholder="Buscar tipo">
                			<div class="table-responsive" style="height: 400px">                				
                				<table class="table table-bordered dataTable">
                					<thead>
                						<th>Tipo de usuario</th>
                						<th></th>
                					</thead>
                					<tbody id="tbl_tipos">
                						
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
<?php include('footer.php'); ?>
           