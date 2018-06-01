$(document).ready(function() {
  $(".trTableClientes").dblclick(function(){
    var idCliente = $(this).find(".idCliente").text();

    $(".idClienteText").val(idCliente);
    $(".formClienteInfo").submit();
  });

  $(".actualizarButton").click(function(){
    var table = document.getElementById("tableClientesSQL");
    var sqlTable=[];
    for (var i = 1, row; row = table.rows[i]; i++) {
      var sqlRow=[];
      var idCliente = row.cells[0].innerHTML.replace('<br>', '');
      var nombre = row.cells[1].innerHTML.replace('<br>', '');
      var contacto = row.cells[2].innerHTML.replace('<br>', '');
      var mail = row.cells[3].innerHTML.replace('<br>', '');
      var telefono = row.cells[4].innerHTML.replace('<br>', '');
      var rfc = row.cells[5].innerHTML.replace('<br>', '');
      var direccion = row.cells[6].innerHTML.replace('<br>', '');


      sqlRow[0]= idCliente;
      sqlRow[1]= nombre;
      sqlRow[2]= contacto;
      sqlRow[3]= mail;
      sqlRow[4]= telefono;
      sqlRow[5]= rfc;
      sqlRow[6]= direccion;

      sqlTable[i-1]=sqlRow;

    }
    console.log(sqlTable);
    $(".tablaSQLClientes").val(JSON.stringify(sqlTable));
    $(".actualizarInput").submit();
  });

});


  // Future Mobile Implementation
  // var tapped=false
  // $("#mini-cart .dropdown-toggle").on("touchstart",function(e){
  //     if(!tapped){ //if tap is not set, set up single tap
  //       tapped=setTimeout(function(){
  //           tapped=null
  //           //insert things you want to do when single tapped
  //
  //       },300);   //wait 300ms then run single click code
  //     } else {    //tapped within 300ms of last tap. double tap
  //       clearTimeout(tapped); //stop single tap callback
  //       tapped=null
  //       //insert things you want to do when double tapped
  //       var idCliente = $(this).find(".idCliente").text();
  //
  //       $(".idClienteText").val(idCliente);
  //       $(".formClienteInfo").submit();
  //
  //     }
  //     e.preventDefault()
  // });
