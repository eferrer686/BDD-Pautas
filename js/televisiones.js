$(document).ready(function() {

  $(".trTableTelevisiones").dblclick(function(){
    var idTelevision = $(this).find(".idTelevision").text();

    $(".idTelevisionText").val(idTelevision);
    $(".formTelevisionInfo").submit();
  });


  $(".actualizarButton").click(function(){
    var table = document.getElementById("tableTelevisionesSQL");

    var sqlTable=[];

    for (var i = 1, row; row = table.rows[i]; i++) {
      var sqlRow=[];
      var idTelevisiones = row.cells[0].innerHTML.replace('<br>', '');
      var nombre = row.cells[1].innerHTML.replace('<br>', '');
      var estacion = row.cells[2].innerHTML.replace('<br>', '');
      var estado = row.cells[3].innerHTML.replace('<br>', '');
      var ciudad = row.cells[4].innerHTML.replace('<br>', '');
      var siglas = row.cells[5].innerHTML.replace('<br>', '');

      var sel = row.cells[6].childNodes[0];
      var opt = sel.options[sel.selectedIndex];
      //
     var idProveedor = opt.value;



      sqlRow[0]= idTelevisiones;
      sqlRow[1]= nombre;
      sqlRow[2]= estacion;
      sqlRow[3]= estado;
      sqlRow[4]= ciudad;
      sqlRow[5]= siglas;
      sqlRow[6]= idProveedor;

      sqlTable[i-1]=sqlRow;

    }
    // console.log(sqlTable);

    $(".tablaSQLTelevisiones").val(JSON.stringify(sqlTable));
    $(".actualizarInput").submit();
  });

});
