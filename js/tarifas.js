$(document).ready(function() {

  $(".actualizarButton").click(function(){
    var table = document.getElementById("tableTarifasSQL");

    var sqlTable=[];

    for (var i = 1, row; row = table.rows[i]; i++) {
      var sqlRow=[];
      var idTarifas = row.cells[0].innerHTML.replace('<br>', '');
      var duracion = row.cells[1].innerHTML.replace('<br>', '');
      var tarifaGeneral = row.cells[2].innerHTML.replace('<br>', '');
      var tarifaEspecifica = row.cells[3].innerHTML.replace('<br>', '');
      var horaInicio = row.cells[4].childNodes[0].value;
      var horaFin = row.cells[5].childNodes[0].value;


      sqlRow[0]= idTarifas;
      sqlRow[1]= duracion;
      sqlRow[2]= tarifaGeneral;
      sqlRow[3]= tarifaEspecifica;
      sqlRow[4]= horaInicio;
      sqlRow[5]= horaFin;

      sqlTable[i-1]=sqlRow;

    }
    // console.log(sqlTable);

    $(".tablaSQLTarifas").val(JSON.stringify(sqlTable));
    $(".actualizarInput").submit();
  });

});
