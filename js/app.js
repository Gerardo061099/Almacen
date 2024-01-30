function obtener(e) {
    e.preventDefault()
    //obtenemos los valores ingresados por el usuario del documento registro_h.php
    //por su id incluyendo la imagen
    var nom = document.getElementById('nombre').value
    var can = document.getElementById('cantidad').value
    var canm = document.getElementById('cantidadm').value
    var img = document.getElementById('subir_imagen').files[0] //obtenemos un objeto
    var select = document.getElementById('medidas').value
    var cate = document.getElementById('categoria').value
    var gav = document.getElementById('gavilanes').value
        var datos = new FormData()
        datos.append('nombre', nom)
        datos.append('cantidad', can)
        datos.append('cantidadm', canm)
        datos.append('img', img)
        datos.append('medidas', select)
        datos.append('categoria', cate)
        datos.append('gavilanes', gav)
        console.log('Subiendo datos')
        console.log(datos)
        $.ajax({
            url: "add_h.php",
            type: "POST",
            data: datos,
            processData: false,
            Cache: false,
            contentType: false,
            success: function(mensaje) {
                switch (mensaje) {
                    case "campos vacios":
                        swal({
                            title: "Campos Vacios",
                            text: "Debes llenar todos los campos",
                            icon: "warning",
                        })
                        break
                    case "Insercion exitosa":
                        swal({
                            title: "Insercion exitosa",
                            text: "Puedes consultar la informacion en la lista de herramientas",
                            icon: "success"
                        })
                        break
                    case "Error al insertar la informacion":
                        swal({
                            title: "Error de insercion",
                            text: "Lo sentimos, ocurrio un problema al insertar la información",
                            icon: "error"
                        })
                        break
                    case "Error al subir la imagen al servidor":
                        swal({
                            title: "Error con la imagen",
                            text: "La imagen capturada no se pudo subir al servidor",
                            icon: "error"
                        })
                        break
                    case "La extencion del archivo no es permitida":
                        swal({
                            title: "Error con la imagen",
                            text: "La extencion del archivo no es permitida",
                            icon: "error"
                        })
                        break
                    default:
                        swal({
                            title: "Error de insercion",
                            text: "Lo sentimos, ocurrio un problema al insertar la información",
                            icon: "error"
                        })
                        break
                }
            }
        })
    
} //fin function obtener();

// funcion para actualizar campo cantidad de una herramienta
function update() {
    //e.preventDefault();
    var id_herramienta = document.getElementById('id_h').value;
    var cantidadnew = document.getElementById('cantidadnew').value;
    if (id_herramienta != "Choose..." && cantidadnew != "") {
        var files = new FormData();
        files.append("numero_h", id_herramienta);
        files.append("can", cantidadnew);
        $.ajax({
            url: "update.php",
            type: "POST",
            data: files,
            processData: false,
            Cache: false,
            contentType: false,
            beforeSend: function() {
                $('#resultado').html('<div>cargando.... Espere un momento</div>');
            },
            success: function(mensaje) {
                //$('#resultado').html(mensaje);
                if (mensaje == "Actualizacion exitosa") {
                    swal({
                        title: "Actualizacion exitosa!!",
                        text: "Se realizo un actualizacion de manera exitosa!!",
                        icon: "success"
                    })
                } else {
                    swal({
                        title: "Oh oh ",
                        text: "Ocurrio un error",
                        icon: "Debes ingresar los valores necesarios para realizar la actualizacion"
                    })
                }
            }
        })
    } else {
        swal({
            title: "Datos Vacios",
            text: "Debes ingresar los valores necesarios para realizar la actualizacion",
            icon: "error"
        })
    }

} //fin function update();

async function getDataDeleteH(data) {
    var d = data.split('||')
    console.log(d[0],d[1],d[2],d[3],d[4],d[5],d[6],d[7],d[8])
    $('#idmodal_d').val(d[0])//id
    $('#nombremodal_d').val(d[1])//nombre
    await getCategoria_d(d[2],d[3])
    $('#stockminimo_d').val(d[7])//stock
    await getGavilanes_d(d[4])
    $('#stock_d').val(d[8])//stock minimo
    await getMedidas_d(d[5],d[6])
    $('#ModalEliminar').modal('show')
}

function deleteHerramienta(e) {
    var id_delete = $('#idmodal_d').val()
    var data
    var x = confirm(`¿La siguiente herramientas se va a eliminar?`)
    data = JSON.stringify({'id_delete':id_delete})
    if (x) {
        alert('Eliminando...')
        $.ajax({
            type: "POST",
            url: "php/eliminar.php",
            data: data,
            dataType: "json",
            success: function (response) {
                switch (response) {
                    case '1':
                        swal({
                            title: "Herramienta eliminada",
                            text: "La herramienta se borro de manera exitosa",
                            icon: "success"
                        })
                        break
                    case '0':
                        swal({
                            title: "Error",
                            text: "La herramienta no se pudo borrar",
                            icon: "success"
                        })
                        break
                    default:
                        swal({
                            title: "Error",
                            text: "La herramienta no se pudo borrar",
                            icon: "success"
                        })
                        break
                }
            }
        })
    }
    if (!x) {
        alert('Accion cancelada')
    }
}

function consultar(e) {
    var nombre_h = document.getElementById('herra_b').value;
    var medida_h = document.getElementById('medida_b').value;
    if (nombre_h != "Choose..." && medida_h != "Choose...") {
        var datos = new FormData();
        datos.append("herramientajs", nombre_h);
        datos.append("medidajs", medida_h);
        $.ajax({
            type: "POST",
            url: "inventario.php",
            data: datos,
            processData: false,
            Cache: false,
            contentType: false,
            beforeSend: function() {
                $('#cargando').html('<div>Cargando...</div>');
            },
            success: function(mensaje) {
                if (mensaje == "Datos vacios") {
                    swal({
                        title: "Oh oh ",
                        text: "Ocurrio un error",
                        icon: "error"
                    })
                } else {
                    swal({
                        title: "Consulta exitosa!!",
                        text: "Deslice para abajo para ver los resultados de la busqueda!!",
                        icon: "success"
                    })
                }
            },
            error: function() {
                swal({
                    title: "Oh oh ",
                    text: "Algo salio mal",
                    icon: "error"
                })
            }
        })
    } else {
        swal({
            title: "Campos vacios",
            text: "Debes seleccionar una opcion para realizar la busqueda!!",
            icon: "warning"
        })
        e.preventDefault()
    }
} //fin function consultar();

function convertir() {
    console.log("Function convertir");
    var $screenshot = document.body;
    html2pdf()
        .set({
            margin: 0.2,
            marginTop: 0.4,
            filename: "Reportes.pdf",
            image: {
                type: "jpg",
                quality: 0.50,
            },
            html2canvas: {
                scale: 3,
                letterRendering: true
            },
            jsPDF: {
                unit: "in",
                format: "a3",
                orientation: "portrait" //portrait o landscape
            }
        })
        .from($screenshot)
        .save()
        .catch(error => console.log(error))
        .finally()
        .then(() => {
            swal({
                title: "Conversion exitosa!!",
                text: "Se a generado el PDF",
                icon: "success"
            })
        })
}

function subirsolicitud(e) {
    e.preventDefault()
    var nombre = document.getElementById("nombre").value
    var apellidos = document.getElementById("ap").value
    var n_empleado = document.getElementById("n_empleado").value
    var genero = document.getElementById("genero").value
    var datos = new FormData()
    datos.append("Nombre", nombre)
    datos.append("Apellidos", apellidos)
    datos.append("N_empleado", n_empleado)
    datos.append("Genero", genero)
    $.ajax({
        url: "add_solicitante.php",
        type: "POST",
        data: datos,
        processData: false,
        Cache: false,
        contentType: false,
        success: function(mensaje) {
            if (mensaje == "Insercion exitosa!!") {
                swal({
                    title: "Insercion exitosa",
                    text: "Los datos han sido insertados",
                    icon: "success"
                })
                window.location.href = "add_solicitud.php";
            } else if (mensaje == "La insercion no se pudo ejecutar") {
                swal({
                    title: "Oh oh",
                    text: "Ocurrio un problema",
                    icon: "warning"
                })
            }
        }
    })
}
function RegistrarSoli(e) {
    e.preventDefault()
    var herramienta = document.getElementById("id-herramienta").value
    var maquina = document.getElementById("maquina").value
    var cantidad = document.getElementById("cantidad").value
    if (herramienta != "" && maquina != "Choose..." && cantidad != "") {
        var data = new FormData()
        data.append("N_herramienta", herramienta)
        data.append("N_maquina", maquina)
        data.append("cantidad", cantidad)
        $.ajax({
            url: "fin_solicitud.php",
            type: "POST",
            data: data,
            processData: false,
            Cache: false,
            contentType: false,
            success: function(message) {
                if (message == "Registro realizado") {
                    swal({
                        title: "Registro Exitoso",
                        text: "Se a registrado la solicitud de forma exitosa!!",
                        icon: "success"
                    })
                    $('#btn-finalizar').attr('hidden', false)
                } else if (message == "La cantidad solicitada es mayor a la cantidad en existencia") {
                    swal({
                        title: "Error",
                        text: "La cantidad que solicitas es mayor al número de piezas almacenadas",
                        icon: "warning"
                    })
                } else {
                    swal({
                        title: "Error",
                        text: "Ocurrio un error inesperado",
                        icon: "warning"
                    })
                }
            }
        })
    } else {
        swal({
            title: "Datos no ingresados",
            text: "La información recibida está incompleta",
            icon: "warning"
        })
    }
}