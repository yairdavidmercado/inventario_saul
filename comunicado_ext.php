
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
<link href="/gestion_documental/assets/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous">
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
        background: url('/gestion_documental/assets/img/loader.gif') 
                    50% 50% no-repeat rgb(249,249,249);
      }
    </style>
  </head>
  <body class="bg-light">
  <div class="loader"></div>
<main role="main" class="container py-5">
<div class="row">
  <div class="col-md-12 order-md-1">
  <div class="float-right"><img src="assets/img/logos.png" width="300px" alt="" srcset=""></div>
    <h4 class="mb-3">Radicar respuesta</h4>
    <form role="form" onsubmit="event.preventDefault(); return ShowRadicado();" class="needs-validation">
      <div class="row">
        <div class="col-md-3 mb-3">
          <label for="firstName">Número de radicado</label>
          <input type="text" placeholder="Presione ENTER para buscar" class="form-control" id="radicado" placeholder="" value="" required>
          <div class="invalid-feedback">
            Valid first name is required.
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <label for="lastName">Código de verificación</label>
          <input type="text" placeholder="Presione ENTER para buscar" class="form-control" id="cv" placeholder="" value="" required>
          <div class="invalid-feedback">
            Valid last name is required.
          </div>
        </div>
        <div class="col-md-3" style="margin-top: 31px;">
            <button class="btn btn-success" type="submit">Consultar</button>
        </div>
      </div>
    </form>
    <div class="table-responsive-sm">
    <form style="display:none" role="form" onsubmit="event.preventDefault(); return GuardarComunicado();" id="form_guardar" >
        <input id="id_comtext" name="id_comtext" type="text">
        <input id="soporte_adjunto" name="soporte_adjunto" type="file">
        <button type="submit" id="enviar_archivo" class="btn btn-success mr-2">Registrar petición</button>
    </form>
    <table id="example" style="font-size:11px" class="table table-striped table-bordered" >
        <thead >
            <tr>
                <th>&nbsp;</th>
                <th style="width:10px">Radicado</th>
                <th style="width:300px">Oficina</th>
                <th style="width:300px">Atn</th>
                <th style="width:300px">Asunto</th>
                <!-- <th style="width:10px">Dias de tramite</th> -->
                <th style="width:150px">Fecha</th>
                <th style="width:10px">Respuesta</th>
                <th style="width:10px">Descargar radicado</th>
                <th style="width:10px"><span id="text_respuesta"></span> respuesta</th>
            </tr>
        </thead>
        <tbody id="tbodytable">
            
        </tbody>
        <tfoot>
            <tr>
                <th>&nbsp;</th>
                <th style="width:10px">Radicado</th>
                <th style="width:300px">Oficina</th>
                <th style="width:300px">Atn</th>
                <th style="width:300px">Asunto</th>
                <!-- <th style="width:10px">Dias de tramite</th> -->
                <th style="width:150px">Fecha</th>
                <th style="width:10px">Respuesta</th>
                <th style="width:10px">Descargar radicado</th>
                <th style="width:10px"><span id="text_respuesta"></span> respuesta</th>
            </tr>
        </tfoot>
    </table>
  </div>
</div>
</main>
<script src="/gestion_documental/assets/js/jquery.slim.min.js" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="/gestion_documental/assets/js/jquery.slim.min.js"><\/script>')</script>
<script src="/gestion_documental/assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
$(function() {
    $('#soporte_adjunto').val("")
    $("#soporte_adjunto").change(function(){
        showFileSize()
    });
  $(".loader").css("display", "none")

  // $("#cv").keyup(function(e){ 
  //   var code = e.which; // recommended to use e.which, it's normalized across browsers
  //   if(code==13)e.preventDefault();
  //   if(code==32||code==13||code==188||code==186){
  //     ShowRadicado("2")
  //       //alert('Has presionado enter en el campo de cv')
  //   } // missing closing if brace
  // });
});

function GuardarComunicado() {
    if ($('#soporte_adjunto').val() == "") {
        alert('Por favor seleccione el archivo a enviar')
        return false
    }
    let form = $('#form_guardar')[0];
    let formData = new FormData(form)
    $.ajax({
    type : 'POST',
    enctype: 'multipart/form-data',
    data: formData,
    processData: false,
    contentType: false,
    url: 'php/guardar_solicitud.php',
    beforeSend: function() {
        $(".loader").css("display", "inline-block")
    },
    success: function(respuesta) {
      $(".loader").css("display", "none")
      let obj = JSON.parse(respuesta)
      if (obj.success) {
        alert('Su archivo fue enviado correctamente.')
        ShowRadicado()
      }else{
        alert(obj.message)
      }

    },
    error: function(e) {
      $(".loader").css("display", "none")
      console.log("No se ha podido obtener la información"+e);
    }
  });
    
  }

function ShowRadicado() {
    let values = { 
          cod: '1',
          radi: $('#radicado').val(),
          id: $('#cv').val()
    };
    $.ajax({
    type : 'POST',
    data: values,
    url: 'php/sel_comunicado_ext.php',
    beforeSend: function() {
        $(".loader").css("display", "inline-block")
    },
    success: function(respuesta) {
      $(".loader").css("display", "none")
       let obj = JSON.parse(respuesta)
       //$("#example").dataTable().fnDestroy();
       let fila = ''
       let btn_respuesta = '';
       $.each(obj[0], function( index, val ) {
         if (val.respuesta !== '0') {
            $('#text_respuesta').text('Descargar')
          btn_respuesta = '<a href="ftp://190.121.135.236/'+val.ruta_respuesta+'" class="btn btn-sm btn-danger" style="color:#fff"><i class="fa fa-file-pdf-o"></i></a>'
         }else{
            $('#text_respuesta').text('Adjuntar')
            btn_respuesta = '<div class="btn-group btn-group-sm">'+
                                '<button type="button" id="btn-adjuntar-soporte" onclick="select_upload()" class="btn btn-warning"><i class="fa fa-upload"></i></button>'+
                                '<button type="button" onclick="enviar_archivo('+val.id_radiext+')" class="btn btn-primary">Enviar</button>'+
                            '</div>';
         }
         fila += '<tr class="accordion-toggle">'+
                      '<td><button data-toggle="collapse" data-target="#demo1"  class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button></td>'+
                      '<td>'+val.id_radiext+'</td>'+
                      '<td>'+val.id_oficina+'</td>'+
                      '<td>'+val.atn+'</td>'+
                      '<td>'+val.asunto+'</td>'+
                      // '<td>'+val.dias_tramite+'</td>'+
                      '<td>'+val.fecha+' '+val.hora+'</td>'+
                      '<td>'+val.resp+'</td>'+
                      '<td><a href="ftp://190.121.135.236/'+val.ruta_envio+'" class="btn btn-sm btn-danger" style="color:#fff"><i class="fa fa-file-pdf-o"></i></a></td>'+
                      '<td>'+btn_respuesta+'</td>'+
                  '</tr>'+
                  '<tr>'+
                      '<td colspan="6" class="hiddenRow"><div id="demo1" class="accordian-body collapse">Demo2</div></td>'+
                  '</tr>'
      });
      $("#tbodytable").html(fila)
      //$('#example').DataTable();
        //$('#example').DataTable().ajax.reload();
    },
    error: function() {
      $(".loader").css("display", "")
      console.log("No se ha podido obtener la información");
    }
  });
    
  }

  function select_upload() {
      $('#soporte_adjunto').click()
  }

  function enviar_archivo(id) {
      $('#id_comtext').val(id)
      $('#enviar_archivo').click()
  }

  function showFileSize() {
    var input, file;

    // (Can't use `typeof FileReader === "function"` because apparently
    // it comes back as "object" on some browsers. So just see if it's there
    // at all.)
    if (!window.FileReader) {
        bodyAppend("p", "The file API isn't supported on this browser yet.");
        $("#btn-adjuntar-soporte").removeClass("btn-primary").addClass("btn-warning")
        return;
    }

    input = document.getElementById('soporte_adjunto');
    if (!input) {
        bodyAppend("p", "Um, couldn't find the soporte_adjunto element.");
        $("#btn-adjuntar-soporte").removeClass("btn-primary").addClass("btn-warning")
    }
    else if (!input.files) {
        bodyAppend("p", "This browser doesn't seem to support the `files` property of file inputs.");
        $("#btn-adjuntar-soporte").removeClass("btn-primary").addClass("btn-warning")
    }
    else if (!input.files[0]) {
        bodyAppend("p", "Por favor seleccione un archivo");
        $("#btn-adjuntar-soporte").removeClass("btn-primary").addClass("btn-warning")
    }else if (ValidateExtension()) {
        file = input.files[0];
        var FileSize = file.size / 1024 / 1024; // in MB
        if (FileSize > 5) {
            alert('El archivo seleccionado ha excedido los 5MB permitidos')
            $("#soporte_adjunto").val("")
            $(".text-validation-file").html("")
            $("#btn-adjuntar-soporte").removeClass("btn-primary").addClass("btn-warning")
            return false
        }else{
          $("#btn-adjuntar-soporte").removeClass("btn-warning").addClass("btn-primary")
          $(".text-validation-file").html("")
          //bodyAppend("p", "File " + file.name + " is " + file.size + " bytes in size");
        }
    }
}

function bodyAppend(tagName, innerHTML) {
    var elm;

    elm = document.createElement(tagName);
    elm.innerHTML = innerHTML;
    $("#soporte_adjunto").val("")
    $(".text-validation-file").html(elm);
}

function ValidateExtension() {
        var allowedFiles = [".doc", ".docx", ".pdf", ".png", ".jpg", ".jpeg", ".xlsx"];
        var fileUpload = document.getElementById("soporte_adjunto");
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
        if (!regex.test(fileUpload.value.toLowerCase())) {
            alert("Cargue archivos que tengan extensiones: " + allowedFiles.join(', ') + " solamente.")
            $("#soporte_adjunto").val("")
            $(".text-validation-file").html("")
            $("#btn-adjuntar-soporte").removeClass("btn-primary").addClass("btn-warning")
            return false;
        }
        return true;
    }
</script>
</body>
</html>
