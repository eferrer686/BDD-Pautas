$(document).ready(function() {
  $(".trTableProveedores").dblclick(function(){
    var idProveedor = $(this).find(".idProveedor").text();

    $(".idProveedorText").val(idProveedor);
    $(".formProveedorInfo").submit();
  });
  $(".comision").keypress(function(e){
    var keycode = e.which;
          /* 48-57: 0 -9
             8:backspace */
    if((keycode >= 48 && keycode <= 57) || keycode == 8 || keycode == 46 )
       return true;
    return false;
  });

  $(".actualizarButton").click(function(){
    var table = document.getElementById("tableProveedoresSQL");
    var sqlTable=[];
    for (var i = 1, row; row = table.rows[i]; i++) {
      var sqlRow=[];
      var idProveedor = row.cells[0].innerHTML.replace('<br>', '');
      var nombre = row.cells[1].innerHTML.replace('<br>', '');
      var telefono = row.cells[2].innerHTML.replace('<br>', '');
      var direccion = row.cells[3].innerHTML.replace('<br>', '');
      var comision = row.cells[4].innerHTML.replace('<br>', '');


      sqlRow[0]= idProveedor;
      sqlRow[1]= nombre;
      sqlRow[2]= telefono;
      sqlRow[3]= direccion;
      sqlRow[4]= comision;

      sqlTable[i-1]=sqlRow;

    }
    // console.log(sqlTable);

    $(".tablaSQLProveedores").val(JSON.stringify(sqlTable));
    $(".actualizarInput").submit();
  });

});
