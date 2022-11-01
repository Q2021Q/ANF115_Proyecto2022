function busqueda(){
    var texto = document.getElementById("txtnom").value;
    var parametros = {
        "texto" : texto
    };
    $.ajax({
        data:parametros,
        url: "Ajax/valida.php",
        type: "POST",
        succes: function(response){
            $("#datos").html(response);
        }
    });
}