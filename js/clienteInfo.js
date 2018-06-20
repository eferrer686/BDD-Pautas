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
    $(".idPautaText").val(JSON.stringify(sqlTable));
    $(".formPautaInfo").submit();

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

      var presupuesto = row.cells[3].innerHTML.replace('<br>', '');


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

});
