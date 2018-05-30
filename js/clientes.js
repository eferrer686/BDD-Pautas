$(document).ready(function() {
    $(".trTableClientes").click(function(){
       var idCliente = $(this).find(".idCliente").text();
        $("#trFormHiddenCliente").val(idCliente);
        $("#trFormHiddenClientes").submit();
     });
});
