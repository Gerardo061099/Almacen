/**
 * 
 */
import { messageSWA } from './messages.js'
/**
 * 
 */

$(document).ready(function () {
    var id_registro
    var nombre_h
    var medidas_id
    var categoria_id
    var gavilanes_id
    var stock
    var stock_minimo
    var option
    
    $('#frm_update_h').submit(function (e) { 
        let data 
        option = 4
        id_registro = $('#idmodal').val()
        nombre_h = $('#nombremodal').val()
        medidas_id = $('#medidasmodal').val()
        categoria_id = $('#descripcionmodal').val()
        gavilanes_id = $('#gavilanesmodal').val()
        stock = $('#stock').val()
        stock_minimo = $('#stockminimo').val()
        data = JSON.stringify({'id_registro':id_registro,'nombre_h':nombre_h,'medidas_id':medidas_id,'categoria_id':categoria_id,'gavilanes_id':gavilanes_id,'stock':stock,'stock_min':stock_minimo,'option':option})
        $.ajax({
            type: "POST",
            url: "php/funcionesModalH.php",
            data: data,
            dataType: "json",
            success: function (response) {
                $('#ModalEditar').modal('hide')
                if (response.result == '1') messageSWA('La herramienta se actualizo de manera exitosa!!','success')
                if (response.result == '0') messageSWA('Error al intentar actualizar la informacion','error')
                window.setTimeout(function() {
                    $(e).fadeTo(500, 0).slideUp(500, function(){
                        e.preventDefault()
                    })
                }, 5000)
            }
        })
    })
})