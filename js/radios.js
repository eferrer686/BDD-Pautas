$(document).ready(function() {

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
      var estado = row.cells[2].innerHTML.replace('<br>', '');
      var ciudad = row.cells[3].innerHTML.replace('<br>', '');
      var frecuencia = row.cells[4].innerHTML.replace('<br>', '');
      var siglas = row.cells[5].innerHTML.replace('<br>', '');

      var sel = row.cells[6].childNodes[0];
      var opt = sel.options[sel.selectedIndex];
      //
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
    console.log(sqlTable);

    $(".tablaSQLRadios").val(JSON.stringify(sqlTable));
    $(".actualizarInput").submit();
  });

});
