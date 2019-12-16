
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Offcanvas template · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/offcanvas/">

    <!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .loader{
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('/inventario_saul/assets/img/loader.gif') 
                    50% 50% no-repeat rgb(249,249,249);
      }
    </style>
  </head>
  <body class="bg-light">
  <div class="loader"></div>
<main role="main" class="container py-5">
<div class="row">
  <div class="col-md-12 order-md-1">
    <h4 class="mb-3">Radicados</h4>
    <form class="needs-validation" novalidate>
      <div class="row">
        <div class="col-md-3 mb-3">
          <label for="firstName">Número de radicado</label>
          <input type="text" placeholder="Presione ENTER para buscar" class="form-control" id="radicado" placeholder="" value="" required>
          <div class="invalid-feedback">
            Valid first name is required.
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <label for="lastName">Identificación</label>
          <input type="text" placeholder="Presione ENTER para buscar" class="form-control" id="identificacion" placeholder="" value="" required>
          <div class="invalid-feedback">
            Valid last name is required.
          </div>
        </div>
      </div>
    </form>
    <div class="table-responsive-sm" >
    <table id="example" class="table table-striped table-bordered" >
        <thead >
            <tr>
                <th style="width:10px">Radicado</th>
                <th style="width:300px">Razón</th>
                <th style="width:300px">Asunto</th>
                <th style="width:10px">Dias de tramite</th>
                <th style="width:10px">Fecha</th>
                <th style="width:10px">Estado</th>
                <th style="width:10px">Respuesta</th>
            </tr>
        </thead>
        <tbody id="tbodytable">
            
        </tbody>
        <tfoot>
            <tr>
                <th>Radicado</th>
                <th>Razón</th>
                <th>Asunto</th>
                <th>Dias de tramite</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Respuesta</th>
            </tr>
        </tfoot>
    </table>
    </div>
    
  </div>
</div>
</main>
<script src="assets/js/jquery.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="assets/js/jquery.slim.min.js"><\/script>')</script>
<script src="assets/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
$(function() {
  $(".loader").css("display", "none")
  //$('#example').DataTable();
  $("#radicado").keyup(function(e){ 
    var code = e.which; // recommended to use e.which, it's normalized across browsers
    if(code==13)e.preventDefault();
    if(code==32||code==13||code==188||code==186){
      ShowRadicado("1")
      //$('#example').DataTable().ajax.reload();
      //alert('Has presionado enter en el campo de número de radicado')
    } // missing closing if brace
  });

  $("#identificacion").keyup(function(e){ 
    var code = e.which; // recommended to use e.which, it's normalized across browsers
    if(code==13)e.preventDefault();
    if(code==32||code==13||code==188||code==186){
      ShowRadicado("2")
        //alert('Has presionado enter en el campo de identificacion')
    } // missing closing if brace
  });
});

function ShowRadicado(tipo) {
  var values = []
    if (tipo == "1") {
      values = { 
          cod: tipo,
          id: $('#radicado').val()
      }; 
    }else if(tipo == "2"){
      values = { 
          cod: tipo,
          id: $('#identificacion').val()
      }; 
    }
    $.ajax({
    type : 'POST',
    data: values,
    url: 'php/sel_radicado.php',
    beforeSend: function() {
        $(".loader").css("display", "inline-block")
    },
    success: function(respuesta) {
      $(".loader").css("display", "none")
       let obj = JSON.parse(respuesta)
       $("#example").dataTable().fnDestroy();
       let fila = ''
       $.each(obj[0], function( index, val ) {
         fila += '<tr>'+
                      '<td>'+val.conse+'</td>'+
                      '<td>'+val.razon+'</td>'+
                      '<td>'+val.asunto+'</td>'+
                      '<td>'+val.dias_tramite+'</td>'+
                      '<td>'+val.fecha+'</td>'+
                      '<td>'+val.leido+'</td>'+
                      '<td>'+val.respuesta+'</td>'+
                  '</tr>'
      });
      $("#tbodytable").html(fila)
      $('#example').DataTable();
        //$('#example').DataTable().ajax.reload();
    },
    error: function() {
      $(".loader").css("display", "")
      console.log("No se ha podido obtener la información");
    }
  });
    
  }
</script>
</body>
</html>
