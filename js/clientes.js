$(document).ready(function() {
  $(".trTableClientes").dblclick(function(){
    var idCliente = $(this).find(".idCliente").text();

    $(".idClienteText").val(idCliente);
    $(".formClienteInfo").submit();
  });

  // $('#editable').editableTableWidget();
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
