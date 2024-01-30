/**
 * 
 */

/**
 * 
 */
$(document).ready(function () {
    var herramienta_slct = document.getElementById('herramienta')
    var categoria_slct = document.getElementById('categorias')
    var medidas_slct = document.getElementById('medidas')
    var medidas_hidden = document.getElementById('medida')
    var gavilanes_slct = document.getElementById('gavilanes')
    var gavilanes_hidden = document.getElementById('gavilan')
    var select_herramienta = document.getElementById('id-herramienta')
    var herramienta
    var categoriaId
    var medidasid
    var gavilanesid
    var option
    $(document).on('change','#herramienta', function (e) {
        e.preventDefault()
        select_herramienta.value = ''
        select_herramienta.text = ''
        $('#categorias').empty()
        $("#categorias").prepend("<option selected>Choose...</option>")
        option = 1
        herramienta = herramienta_slct.value
        let data = JSON.stringify({'option':option,'herramienta':herramienta})
        $.ajax({
            type: 'POST',
            url: 'php/solicitud_procesos.php',
            data: data,
            dataType: 'json',
            success: function (resp) {
                if (resp != '') {
                    var categoria_hidden = document.getElementById('categoria')
                    for (let i = 0; i < resp.length; i++) {
                        var opcion = document.createElement('option')
                        opcion.value = resp[i].id_categoria
                        opcion.text = resp[i].material + ' ' + resp[i].descripcion
                        categoria_slct.add(opcion)
                    }
                    categoria_hidden.hidden = false
                    medidas_hidden.hidden = true
                    gavilanes_hidden.hidden = true
                }
                else {
                    alert(`${resp['status']}`)
                }
            }
        })
    })

    $(document).on('change','#categorias', function (e) {
        e.preventDefault()
        select_herramienta.value = ''
        select_herramienta.text = ''
        $('#medidas').empty()
        $('#medidas').append("<option selected>Choose...</option>")
        option = 2
        herramienta = herramienta_slct.value
        categoriaId = categoria_slct.value
        let data = JSON.stringify({'option':option,'herramienta':herramienta,'categoriaid':categoriaId})
        $.ajax({
            type: 'POST',
            url: 'php/solicitud_procesos.php',
            data: data,
            dataType: 'json',
            success: function (resp) {
                if (resp != '') {
                    for (let i = 0; i < resp.length; i++) {
                        var opcion = document.createElement('option')
                        opcion.value = resp[i].id_medidas
                        opcion.text = resp[i].ancho + ' ' + resp[i].largo
                        medidas_slct.add(opcion)
                    }
                    medidas_hidden.hidden = false
                    gavilanes_hidden.hidden = true
                } else {
                    alert(`${resp['status']}`)
                }
            }
        })
    })

    $(document).on('change','#medidas', function (e) {
        e.preventDefault()
        select_herramienta.value = ''
        select_herramienta.text = ''
        $('#gavilanes').empty()
        $('#gavilanes').append("<option selected>Choose...</option>")
        option = 3
        herramienta = herramienta_slct.value
        categoriaId = categoria_slct.value
        medidasid = medidas_slct.value
        let data  = JSON.stringify({'option':option,'herramienta':herramienta,'categoriaid':categoriaId,'medidasid':medidasid})
        $.ajax({
            type: 'POST',
            url: 'php/solicitud_procesos.php',
            data: data,
            dataType: 'json',
            success: function (resp) {
                if (resp != '') {
                    for (let i = 0; i < resp.length; i++) {
                        var opcion = document.createElement('option')
                        opcion.value = resp[i].id_gavilanes
                        opcion.text = resp[i].num_gavilanes
                        gavilanes_slct.add(opcion)
                    }
                    gavilanes_hidden.hidden = false
                } else {
                    alert(`${resp['status']}`)
                }
            }
        })
    })

    $(document).on('change','#gavilanes', function (e) {
        e.preventDefault()
        option = 4
        herramienta = herramienta_slct.value
        categoriaId = categoria_slct.value
        medidasid = medidas_slct.value
        gavilanesid = gavilanes_slct.value
        if (gavilanesid != 'Choose...') {
            let data  = JSON.stringify({'option':option,'herramienta':herramienta,'categoriaid':categoriaId,'medidasid':medidasid,'gavilanesid':gavilanesid})
            $.post('php/solicitud_procesos.php', data, (resp) => {
                    select_herramienta.value = resp.id_herramienta
                },"json"
            )
        }
        if (gavilanesid == 'Choose...') {
            select_herramienta.value = ''
        }
    })
})