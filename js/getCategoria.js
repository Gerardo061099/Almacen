/**
 * 
 */

/**
 * 
 */


function getCategoria(material,descripcion) {
let option = 1
let data = JSON.stringify({'option':option})
let select= document.getElementById('descripcionmodal')
$('#descripcionmodal').empty()
$("#descripcionmodal").prepend('<option selected>Choose...</option>')
    $.ajax({
        type: "POST",
        url: "php/funcionesModalH.php",
        data: data,
        dataType: "json",
        success: function (data) {
            if (data !=='') {
                for (let i = 0; i < data.length; i++) {
                var option = document.createElement('option')
                option.value = data[i].id_Categoria
                option.textContent = `${data[i].Material} ${data[i].Descripcion}`
                if (data[i].Material == material && data[i].Descripcion == descripcion) {
                    option.selected = true
                }
                select.add(option)
                }
            }
        }
    })
}
function getMedidas(ancho,largo) {
let option = 2
let data = JSON.stringify({'option':option})
let selectmedidas= document.getElementById('medidasmodal')
$('#medidasmodal').empty()
$("#medidasmodal").prepend('<option selected>Choose...</option>')
    $.ajax({
        type: "POST",
        url: "php/funcionesModalH.php",
        data: data,
        dataType: "json",
        success: function (data) {
            if (data !== '') {
                for (let i = 0; i < data.length; i++) {
                    var option = document.createElement('option')
                    option.value = data[i].id_Medidas
                    option.textContent = `${data[i].Ancho} x ${data[i].Largo}`
                    if (data[i].Ancho == ancho && data[i].Largo == largo) {
                        option.selected = true
                    }
                    selectmedidas.add(option)
                }
            }
        }
    })
}

function getGavilanes(gavilanes) {
    let option = 3
    let data = JSON.stringify({'option':option})
    let selectgav = document.getElementById('gavilanesmodal')
    $('#gavilanesmodal').empty()
    $('#gavilanesmodal').prepend('<option selected>Choose...</option>')
    $.ajax({
        type: "POST",
        url: "php/funcionesModalH.php",
        data: data,
        dataType: "json",
        success: function (resp) {
            if (resp !== '') {
                for (let i = 0; i < resp.length; i++) {
                    var option = document.createElement('option')
                    option.value = resp[i].id_Gav
                    option.textContent = `${resp[i].Num_gavilanes}`
                    if (resp[i].Num_gavilanes == gavilanes) {
                        option.selected = true
                    }
                    selectgav.add(option)
                }
                
            }
        }
    });
}

function getCategoria_d(material,descripcion) {
    let option = 1
    let data = JSON.stringify({'option':option})
    let select= document.getElementById('descripcionmodal_d')
    $('#descripcionmodal_d').empty()
    $("#descripcionmodal_d").prepend('<option selected>Choose...</option>')
    $.ajax({
        type: "POST",
        url: "php/funcionesModalH.php",
        data: data,
        dataType: "json",
        success: function (data) {
            if (data !=='') {
                for (let i = 0; i < data.length; i++) {
                var option = document.createElement('option')
                option.value = data[i].id_Categoria
                option.textContent = `${data[i].Material} ${data[i].Descripcion}`
                if (data[i].Material == material && data[i].Descripcion == descripcion) {
                    option.selected = true
                }
                select.add(option)
                }
            }
        }
    })
}
    function getMedidas_d(ancho,largo) {
    let option = 2
    let data = JSON.stringify({'option':option})
    let selectmedidas= document.getElementById('medidasmodal_d')
    $('#medidasmodal_d').empty()
    $("#medidasmodal_d").prepend('<option selected>Choose...</option>')
        $.ajax({
            type: "POST",
            url: "php/funcionesModalH.php",
            data: data,
            dataType: "json",
            success: function (data) {
                if (data !== '') {
                    for (let i = 0; i < data.length; i++) {
                        var option = document.createElement('option')
                        option.value = data[i].id_Medidas
                        option.textContent = `${data[i].Ancho} x ${data[i].Largo}`
                        if (data[i].Ancho == ancho && data[i].Largo == largo) {
                            option.selected = true
                        }
                        selectmedidas.add(option)
                    }
                }
            }
        })
    }
    
    function getGavilanes_d(gavilanes) {
        let option = 3
        let data = JSON.stringify({'option':option})
        let selectgav = document.getElementById('gavilanesmodal_d')
        $('#gavilanesmodal_d').empty()
        $('#gavilanesmodal_d').prepend('<option selected>Choose...</option>')
        $.ajax({
            type: "POST",
            url: "php/funcionesModalH.php",
            data: data,
            dataType: "json",
            success: function (resp) {
                if (resp !== '') {
                    for (let i = 0; i < resp.length; i++) {
                        var option = document.createElement('option')
                        option.value = resp[i].id_Gav
                        option.textContent = `${resp[i].Num_gavilanes}`
                        if (resp[i].Num_gavilanes == gavilanes) {
                            option.selected = true
                        }
                        selectgav.add(option)
                    }
                    
                }
            }
        });
    }