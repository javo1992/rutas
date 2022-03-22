<?php include('header.php'); ?>
<script type="text/javascript">
     $(document).ready(function () {
         setInterval(cargar_contenedores_llenos, 3000);    
        });

    function cargar_contenedores_llenos()
    {
         $.ajax({
          // data:  {parametros:parametros},
          url:   '../controlador/rutasC.php?llenos=true',
          type:  'post',
          dataType: 'json',
          success:  function (response) { 
            if(response!='')
            {
             $('#alerta_').css('display','initial');
             $('#lleno').html(response);
            }                
          }
        });
    }
</script>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12" id="alerta_" style="display: none;">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert! Existen contenedores llenos</h4>
                <h6>Los siguientes contenedores estan llenos</h6>
                <p id="lleno"></p>
                <a href="contenedores.php">click para Revisar</a>
              </div>            
        </div>
         <div class="col-lg-12">
            <img src="../img/sistema/home.png" style="width: 100%">
        </div>                        
    </div>
</div>
<?php include('footer.php'); ?>
           