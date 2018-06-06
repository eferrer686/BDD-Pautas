$(document).ready(function() {

  $(".trTableRadios").dblclick(function(){
    var idRadios = $(this).find(".idRadios").text();

    $(".idRadiosText").val(idRadios);
    $(".formRadiosInfo").submit();
  });


  $(".actualizarButton").click(function(){
    var table = document.getElementById("tableRadiosSQL");

    var sqlTable=[];
    for (var i = 1, row; row = table.rows[i]; i++) {
      var sqlRow=[];
      var idRadios = row.cells[0].innerHTML.replace('<br>', '');
      var estacion = row.cells[1].innerHTML.replace('<br>', '');
      var frecuencia = row.cells[2].innerHTML.replace('<br>', '');
      var siglas = row.cells[3].innerHTML.replace('<br>', '');

      var sel = row.cells[4].childNodes[0];
      var opt = sel.options[sel.selectedIndex];
      //
     var idProveedor = opt.value;



      sqlRow[0]= idRadios;
      sqlRow[1]= estacion;
      sqlRow[2]= frecuencia;
      sqlRow[3]= siglas;
      sqlRow[4]= idProveedor;

      sqlTable[i-1]=sqlRow;

    }
    console.log(sqlTable);

    $(".tablaSQLRadios").val(JSON.stringify(sqlTable));
    $(".actualizarInput").submit();
  });

});
