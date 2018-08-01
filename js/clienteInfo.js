$(document).ready(function() {
  $(".trTablePautas").dblclick(function(){

    var table = $(this);

    var sqlTable=[];


    var sqlRow=[];
    var idPauta = table[0].cells[0].innerHTML.replace('<br>', '');
    var nombre = table[0].cells[1].innerHTML.replace('<br>', '');
    var sel = table[0].cells[2].childNodes[0];
    var opt = sel.options[sel.selectedIndex];
    var tipo = opt.value;

    sqlTable[0] = idPauta;
    sqlTable[1] = nombre;
    sqlTable[2] = tipo;


    // console.log(sqlTable);
    if (sqlTable[0]!=""){
      $(".idPautaText").val(JSON.stringify(sqlTable));
      $(".formPautaInfo").submit();
    }

  });

  $(".actualizarButton").click(function(){
    var table = document.getElementById("tablePautasSQL");
    var sqlTable=[];
    for (var i = 1, row; row = table.rows[i]; i++) {
      var sqlRow=[];
      var idPauta = row.cells[0].innerHTML.replace('<br>', '');
      var nombre = row.cells[1].innerHTML.replace('<br>', '');

      var sel = row.cells[2].childNodes[0];
      var opt = sel.options[sel.selectedIndex];
      var tipo = opt.value;

      var presupuesto = row.cells[3].innerHTML.replace('<br>', '').replace('$', '');


      sqlRow[0]= idPauta;
      sqlRow[1]= nombre;
      sqlRow[2]= tipo;
      sqlRow[3]= presupuesto;


      sqlTable[i-1]=sqlRow;

    }
    // console.log(sqlTable);
    $(".tablaSQLPautas").val(JSON.stringify(sqlTable));
    $(".actualizarInput").submit();
  });

  $(".deleteRenglon").click(function(){
    if(confirm("Estás seguro de eliminar todo este renglon, los cambios NO serán reversibles")){
      deleteRenglon(this);
    }
  });

});

function setNombre(){
  $.ajax({
   type: "POST",
   url: '../html/clienteInfo.php',
   data: {getNombre:1},
   async: true,
   success: function(response) {

     var title = $(document).find('.titleClienteInfo')[0];
     title.innerHTML = "Cliente: " + JSON.parse(response);
     title = $(document).find('.titleWindowClienteInfo')[0];
     title.innerHTML = "Cliente: " + JSON.parse(response);
   }
  });
}

function deleteRenglon(renglon){
  idRenglon =  renglon.parentNode.parentNode.childNodes[1].innerHTML;
  
  $.ajax({
   type: "POST",
   url: '../html/clienteInfo.php',
   data: {idRenglon: idRenglon},
   async: true,
   success: function(response) {
     location.reload();
   }
  });
}
