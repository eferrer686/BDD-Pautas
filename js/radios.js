$(document).ready(function() {
//Abrir modal de Nuevo Estado
  $(".nuevoEstado").click(function(){

    var modal = document.getElementById('modalEstado');
    var span = document.getElementsByClassName("closeEstado")[0];

    modal.style.display = "block";

    span.onclick = function() {
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
    }
  });
  // Abrir modal de Nueva Ciudad
  $(".nuevaCiudad").click(function(){

    var modal = document.getElementById('modalCiudad');
    var span = document.getElementsByClassName("closeCiudad")[0];

    modal.style.display = "block";

    span.onclick = function() {
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
    }
  });

  $(".trTableRadios").dblclick(function(){
    var idRadio = $(this).find(".idRadio").text();

    $(".idRadioText").val(idRadio);
    $(".formRadioInfo").submit();
  });


  $(".actualizarButton").click(function(){
    var table = document.getElementById("tableRadiosSQL");

    var sqlTable=[];

    for (var i = 1, row; row = table.rows[i]; i++) {
      var sqlRow=[];
      var idRadios = row.cells[0].innerHTML.replace('<br>', '');
      var estacion = row.cells[1].innerHTML.replace('<br>', '');

      var sel = row.cells[2].childNodes[0];
      var opt = sel.options[sel.selectedIndex];
      var estado = opt.value;

      var sel = row.cells[3].childNodes[0];
      var opt = sel.options[sel.selectedIndex];
      var ciudad =  opt.value;

      var frecuencia = row.cells[4].innerHTML.replace('<br>', '');
      var siglas = row.cells[5].innerHTML.replace('<br>', '');

      var sel = row.cells[6].childNodes[0];
      var opt = sel.options[sel.selectedIndex];
      var idProveedor = opt.value;



      sqlRow[0]= idRadios;
      sqlRow[1]= estacion;
      sqlRow[2]= estado;
      sqlRow[3]= ciudad;
      sqlRow[4]= frecuencia;
      sqlRow[5]= siglas;
      sqlRow[6]= idProveedor;

      sqlTable[i-1]=sqlRow;

    }
    // console.log(sqlTable);

    $(".tablaSQLRadios").val(JSON.stringify(sqlTable));
    $(".actualizarInput").submit();
  });

});

function estadosChange(value){
  $.ajax({
   type: "POST",
   url: '../html/radios.php',
   data: {estadoID: value.childNodes[0].value.toString()},
   async: true,
   success: function(response) {
    response = JSON.parse(response);

    var t ='';

    for(var i = 0; i<response.length;i++){
     t+="<option value='"+ response[i]['idciudad'] +"'>"
     + response[i]['ciudad'] +"</option>";
    }

    /* Remove all options from the select list */
    var select = $(value.parentNode).find('.ciudad').children().first();
    select.empty().append(t);


   }
  });
}
function nuevoEstadoCiudad(){
  console.log("Añadir");
}

function agregarEstado(){
  var estado = document.getElementsByClassName("nuevoEstadoInputText")[0].value;
  console.log(estado);

  $.ajax({
   type: "POST",
   url: '../html/radios.php',
   data: {estadoNuevo: estado},
   async: true,
   success: function(response) {
     location.reload();
   }
  });
}
function agregarCiudad(){
  var sel = document.getElementsByClassName("estadoDeNuevaCiudad")[0];
  var opt = sel.options[sel.selectedIndex];
  var idEstado = opt.value;

  var ciudad = document.getElementsByClassName("nuevaCiudadInputText")[0].value;

  $.ajax({
   type: "POST",
   url: '../html/radios.php',
   data: {idEstadoDeNuevaCiudad: idEstado,ciudadNueva: ciudad},
   async: true,
   success: function(response) {
     location.reload();
   }
  });
}
