function obtener(e) {
    console.log("Datos obtenidos: ");
    e.preventDefault();
    //obtenemos los valores ingresados por el usuario del documento registro_h.php
    //por su id incluyendo la imagen
    var nom = document.getElementById('nombre').value;
    var can = document.getElementById('cantidad').value;
    var precio = document.getElementById('precio').value;
    var total = document.getElementById('total').value;
    var img = document.getElementById('subir_imagen').files[0]; //obtenemos un objeto
    var select = document.getElementById('medidas').value;
    var cate = document.getElementById('categoria').value;
    var gav = document.getElementById('gavilanes').value;
    if (nom == "" || can == "" || precio == "" || total == "" || img == "" || select == "" || cate == "" || gav == "") {
        swal({
            title: "Campos Vacios",
            text: "Debes llenar todos los campos",
            icon: "warning",
        });
    } else {
        console.log("Nombre del producto: " + nom);
        console.log("Cantidad: " + can);
        console.log("Precio: " + precio);
        console.log("Total: " + total);
        console.log("Ruta de la imagen: " + img);
        console.log("Id de la medida es: " + select);
        console.log("Id de la categoria es: " + cate);
        console.log("Id de los gavilanes son: " + gav);
        var datos = new FormData();
        datos.append("nombre", nom);
        datos.append("cantidad", can);
        datos.append("precio", precio);
        datos.append("total", total);
        datos.append("img", img);
        datos.append("medidas", select);
        datos.append("categoria", cate);
        datos.append("gavilanes", gav);
        console.log("Subiendo datos");
        $.ajax({
            url: "add_h.php",
            type: "POST",
            data: datos,
            processData: false,
            Cache: false,
            contentType: false,
            before: function(mensaje) {

            },
            success: function(mensaje) {
                if (mensaje == "campos vacios") {
                    swal({
                        title: "Debes llenar todos los campos!!",
                        text: "Se inserto una nueva herramienta a la base de datos",
                        icon: "warning"
                    });
                } else {
                    swal({
                        title: "Insercion exitosa",
                        text: "Puedes consultar la informacion en la lista de herramientas",
                        icon: "success"
                    });
                }
            }
        });
    }
} //fin function obtener();

// funcion para actualizar campo cantidad de una herramienta
function update(e) {
    e.preventDefault();
    var id_herramienta = document.getElementById('id_h').value;
    var cantidadn = document.getElementById('cantidadn').value;
    console.log("# herramienta:" + id_herramienta);
    console.log("Cantidad: " + cantidadn);
    var files = new FormData();
    files.append("numero_h", id_herramienta);
    files.append("can", cantidadn);
    $.ajax({
        url: "update.php",
        type: "POST",
        data: files,
        processData: false,
        Cache: false,
        contentType: false,
        success: function(mensaje) {
            $('#resultado').html(mensaje);
            if (mensaje == "Actualizacion exitosa") {
                swal({
                    title: "Insercion exitosa",
                    icon: "success"
                });
            } else {
                swal({
                    title: "Oh oh ",
                    text: "Ocurrio un error",
                    icon: "error"
                });
            }
        }
    });
} //fin function update();

/*
function convertir(e) {
    e.preventDefault();
    var source = window.document.getElementsByTagName("body")[0];
    var specialElementHandlers = {
        '#hidden-element': function(element, renderer) {
            return true;
        }
    };
    var doc = new jsPDF({
        orientation: 'landscape'
    });
    doc.setFont("courier");
    doc.setFontType("normal");
    doc.setFontSize(24);
    doc.setTextColor(100);
    doc.fromHTML(elementHTML, 15, 15, {
        'width': 170,
        'elementHandlers': specialElementHandlers
    });

}*/