$(document).ready(function() {

  $(".actualizarButton").click(function(){
    var table = document.getElementById("tableTelevisionesSQL");

    var sqlTable=[];

    for (var i = 1, row; row = table.rows[i]; i++) {
      var sqlRow=[];
      var idTelevisiones = row.cells[0].innerHTML.replace('<br>', '');
      var programa = row.cells[1].innerHTML.replace('<br>', '');
      var duracion = row.cells[2].innerHTML.replace('<br>', '');
      var tarifaGeneral = row.cells[3].innerHTML.replace('<br>', '');
      var tarifaEspecifica = row.cells[4].innerHTML.replace('<br>', '');
      var descuento = row.cells[5].innerHTML.replace('<br>', '');
      var horaInicio = row.cells[6].childNodes[0].value;
      var horaFin = row.cells[7].childNodes[0].value;


      sqlRow[0]= idTelevisiones;
      sqlRow[1]= programa;
      sqlRow[2]= duracion;
      sqlRow[3]= tarifaGeneral;
      sqlRow[4]= tarifaEspecifica;
      sqlRow[5]= descuento;
      sqlRow[6]= horaInicio;
      sqlRow[7]= horaFin;

      sqlTable[i-1]=sqlRow;

    }
    console.log(sqlTable);

    $(".tablaSQLTelevisiones").val(JSON.stringify(sqlTable));
    $(".actualizarInput").submit();
  });

});
