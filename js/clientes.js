$(document).ready(function() {
  $(".trTableClientes").click(function(){
    var idCliente = $(this).find(".idCliente").text();
    
    $(".idClienteText").val(idCliente);
    $(".formClienteInfo").submit();
  });
});
