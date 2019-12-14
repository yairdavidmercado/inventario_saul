
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
    </style>
  </head>
  <body class="bg-light">

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
                <th style="width:200px">Nombre</th>
                <th>Remitente</th>
                <th>id remitente</th>
                <th style="width:300px">Servicio</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody id="tbodytable">
            
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
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
  $('#example').DataTable();
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
    success: function(respuesta) {
       let obj = JSON.parse(respuesta)
       let fila = ''
       $.each(obj[0], function( index, val ) {
         fila += '<tr>'+
                      '<td>'+val.id_radi+'</td>'+
                      '<td>'+val.nombre_usua+'</td>'+
                      '<td>'+val.nom_remitente+'</td>'+
                      '<td>'+val.id_remitente+'</td>'+
                      '<td>'+val.cod_servicio+'</td>'+
                      '<td>'+val.fecha_radi+'</td>'+
                  '</tr>'
      });
      $("#tbodytable").html(fila)
        //$('#example').DataTable().ajax.reload();
    },
    error: function() {
      console.log("No se ha podido obtener la información");
    }
  });
    
  }
</script>
</body>
</html>
