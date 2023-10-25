function medidas(e) {
    e.preventDefault();
    var ancho = document.getElementById('ancho').value;
    var largo = document.getElementById('largo').value;
    if (largo === "" || ancho === "") {
        swal({
            title: "Error",
            text: "Falta Agregar datos ",
            icon: "warning",
        });
    } else {
        console.log('Ancho: ' + ancho);
        console.log('Largo: ' + largo);
        var data = new FormData();
        data.append("Ancho", ancho);
        data.append("Largo", largo);
        $.ajax({
            url: "inserta_medidas.php",
            type: "POST",
            data: data,
            processData: false,
            Cache: false,
            contentType: false,
            success: function(mensaje) {
                if (mensaje == "Insercion exitosa") {
                    swal({
                        title: "Insercion exitosa",
                        text: "Los datos se agregaron correctamente",
                        icon: "success"
                    })
                } else {
                    swal({
                        title: "Error",
                        text: "Los datos se pudieron insertar",
                        icon: "warning"
                    });
                }
            }
        })
    }
}
$(document).ready(function () {
    function searchOptions() {
        var select_herramienta = document.getElementById('herra_b').value
        var medida_select = document.getElementById('medida_b')
        var data 
        data = JSON.stringify({'herramienta':select_herramienta})
        $.ajax({
            async: false,
            type: "POST",
            url: "php/getOptions.php",
            data: data,
            dataType: "json",
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    console.log(element)
                    
                }
            }
        })
    }
    $(document).on('change','#herra_b',function (e) {
        e.preventDefault()
        searchOptions()
    })
})



