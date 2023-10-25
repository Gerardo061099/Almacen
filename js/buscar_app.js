/**
 * funciones para la version 2.0 de esta app
 */

/**
 * 
 */

$(document).ready(function () {
    function searchOptions() {
        var select_herramienta = document.getElementById('herra_b').value
        var medida_select = document.getElementById('medida_b')
        var data 
        data = JSON.stringify({"herramienta":select_herramienta})
        $.ajax({
            type: "POST",
            url: "php/getOptions.php",
            data: data,
            dataType: "json",
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    var option = document.createElement('option')
                    option.value = data[i].id
                    option.text = data[i].ancho
                    medida_select.add(option)
                }
            }
        })
    }
    $(document).on('change','#herra_b',function (e) {
        e.preventDefault()
        $('#medida_b').empty();
        searchOptions()
    })
})

