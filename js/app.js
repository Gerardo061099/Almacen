import { messageAimate } from "./messages.js";
export async function obtener(categoriaText, gavilanesText, medidasText) {
  //obtenemos los valores ingresados por el usuario del documento registro_h.php
  //por su id incluyendo la imagen
  let nom = document.getElementById("nombre").value;
  let can = document.getElementById("cantidad").value;
  let canm = document.getElementById("cantidadm").value;
  let img = document.getElementById("subir_imagen").files[0]; //obtenemos un objeto
  let select = document.getElementById("medidas").value;
  let cate = document.getElementById("categoria").value;
  let gav = document.getElementById("gavilanes").value;
  if (
    nom == "" ||
    can == "" ||
    canm == "" ||
    select == "Choose..." ||
    cate == "Choose..." ||
    gav == "Choose..." ||
    img == ""
  ) {
    return messageAimate("Debes llenar todos los campos", "warning");
  }
  let datos = new FormData();
  datos.append("categoriaText", categoriaText);
  datos.append("gavilanesText", gavilanesText);
  datos.append("medidasText", medidasText);
  datos.append("nombre", nom);
  datos.append("cantidad", can);
  datos.append("cantidadm", canm);
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
    beforeSend: function () {
      $("load1").html(
        "<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>"
      );
    },
    success: function (mensaje) {
      switch (mensaje) {
        case "La herramienta ya existe":
          messageAimate("La herramienta ya existe", "warning");
          break;
        case "Insercion exitosa":
          messageAimate(
            "Puedes consultar la informacion en la lista de herramientas",
            "success"
          );
          break;
        case "Error al insertar la informacion":
          messageAimate(
            "Lo sentimos, ocurrio un problema al insertar la información",
            "error"
          );
          break;
        case "Error al subir la imagen al servidor":
          messageAimate(
            "La imagen capturada no se pudo subir al servidor",
            "error"
          );
          break;
        case "La imagen pesa demasiado":
          messageAimate("La imagen pesa demasiado, reduzca su peso", "info");
          break;
        case "La extencion del archivo no es permitida":
          messageAimate(
            "La extencion del archivo no es permitida, solo se permiten archivos .jpg, .jpeg, .png",
            "info"
          );
          break;
        default:
          messageAimate(
            "Ocurrio un error inesperado, intente de nuevo mas tarde",
            "error"
          );
          break;
      }
    },
  });
} //fin function obtener();

// funcion para actualizar campo cantidad de una herramienta
function update() {
  //e.preventDefault();
  var id_herramienta = document.getElementById("id_h").value;
  var cantidadnew = document.getElementById("cantidadnew").value;
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
      beforeSend: function () {
        $("#resultado").html("<div>cargando.... Espere un momento</div>");
      },
      success: function (mensaje) {
        //$('#resultado').html(mensaje);
        if (mensaje == "Actualizacion exitosa") {
          swal({
            title: "Actualizacion exitosa!!",
            text: "Se realizo un actualizacion de manera exitosa!!",
            icon: "success",
          });
        } else {
          swal({
            title: "Oh oh ",
            text: "Ocurrio un error",
            icon: "Debes ingresar los valores necesarios para realizar la actualizacion",
          });
        }
      },
    });
  } else {
    swal({
      title: "Datos Vacios",
      text: "Debes ingresar los valores necesarios para realizar la actualizacion",
      icon: "error",
    });
  }
} //fin function update();

async function getDataDeleteH(data) {
  var d = data.split("||");
  console.log(d[0], d[1], d[2], d[3], d[4], d[5], d[6], d[7], d[8]);
  $("#idmodal_d").val(d[0]); //id
  $("#nombremodal_d").val(d[1]); //nombre
  await getCategoria_d(d[2], d[3]);
  $("#stockminimo_d").val(d[7]); //stock
  await getGavilanes_d(d[4]);
  $("#stock_d").val(d[8]); //stock minimo
  await getMedidas_d(d[5], d[6]);
  $("#ModalEliminar").modal("show");
}

function deleteHerramienta(e) {
  e.preventDefault();
  var id_delete = parseInt($("#idmodal_d").val());
  var data;
  var x = confirm(`¿La siguiente herramientas se va a eliminar? ${id_delete}`);
  data = JSON.stringify({ id_delete: id_delete });
  if (x) {
    alert("Eliminando...");
    $.ajax({
      type: "POST",
      url: "php/eliminar.php",
      data: data,
      dataType: "JSON",
      success: function (response) {
        console.log(response);
        switch (response.response) {
          case "1":
            alert("La herramienta se borro de manera exitosa");
            window.location.href = "inventario.php";
            break;
          case "0":
            swal({
              title: "Error",
              text: "La herramienta no se pudo borrar",
              icon: "error",
            });
            break;
          default:
            swal({ title: "Error", text: response.response, icon: "info" });
            break;
        }
      },
    });
  }
  if (!x) {
    alert("Accion cancelada");
  }
}

function consultar(e) {
  var nombre_h = document.getElementById("herra_b").value;
  var medida_h = document.getElementById("medida_b").value;
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
      beforeSend: function () {
        $("#cargando").html("<div>Cargando...</div>");
      },
      success: function (mensaje) {
        if (mensaje == "Datos vacios") {
          swal({
            title: "Oh oh ",
            text: "Ocurrio un error",
            icon: "error",
          });
        } else {
          swal({
            title: "Consulta exitosa!!",
            text: "Deslice para abajo para ver los resultados de la busqueda!!",
            icon: "success",
          });
        }
      },
      error: function () {
        swal({
          title: "Oh oh ",
          text: "Algo salio mal",
          icon: "error",
        });
      },
    });
  } else {
    swal({
      title: "Campos vacios",
      text: "Debes seleccionar una opcion para realizar la busqueda!!",
      icon: "warning",
    });
    e.preventDefault();
  }
} //fin function consultar();

function subirsolicitud(e) {
  e.preventDefault();
  var nombre = document.getElementById("nombre").value;
  var apellidos = document.getElementById("ap").value;
  var n_empleado = document.getElementById("n_empleado").value;
  var datos = new FormData();
  datos.append("Nombre", nombre);
  datos.append("Apellidos", apellidos);
  datos.append("N_empleado", n_empleado);
  $.ajax({
    url: "add_solicitante.php",
    type: "POST",
    data: datos,
    processData: false,
    Cache: false,
    contentType: false,
    success: function (mensaje) {
      if (mensaje == "Insercion exitosa!!") {
        swal({
          title: "Insercion exitosa",
          text: "Los datos han sido insertados",
          icon: "success",
        });
        window.location.href = "add_solicitud.php";
      } else if (mensaje == "La insercion no se pudo ejecutar") {
        swal({
          title: "Oh oh",
          text: "Ocurrio un problema",
          icon: "warning",
        });
      }
    },
  });
}
function RegistrarSoli(e) {
  e.preventDefault();
  var herramienta = document.getElementById("id-herramienta").value;
  var cantidad = document.getElementById("cantidad").value;
  if (herramienta != "" && cantidad != "") {
    var data = new FormData();
    data.append("N_herramienta", herramienta);
    data.append("cantidad", cantidad);
    $.ajax({
      url: "fin_solicitud.php",
      type: "POST",
      data: data,
      processData: false,
      Cache: false,
      contentType: false,
      success: function (message) {
        if (message == "Registro realizado") {
          swal({
            title: "Registro Exitoso",
            text: "Se a registrado la solicitud de forma exitosa!!",
            icon: "success",
          });
          $("#btn-finalizar").attr("hidden", false);
        } else if (
          message ==
          "La cantidad solicitada es mayor a la cantidad en existencia"
        ) {
          swal({
            title: "Error",
            text: "La cantidad que solicitas es mayor al número de piezas almacenadas",
            icon: "warning",
          });
        } else {
          swal({
            title: "Error",
            text: "Ocurrio un error inesperado",
            icon: "warning",
          });
        }
      },
    });
  } else {
    swal({
      title: "Datos no ingresados",
      text: "La información recibida está incompleta",
      icon: "warning",
    });
  }
}

//********************************************** New code ******************************************/

export async function getDataFormUpdate(option) {
  const formData = new FormData();
  formData.append("option", option);
  let idHerramienta = parseInt($("#idmodal").val());
  formData.append("id", idHerramienta);
  let nombreH = $("#nombremodal").val();
  formData.append("nombreH", nombreH);
  let idMedidas = parseInt($("#medidasmodal").val());
  formData.append("idMedidas", idMedidas);
  let idGavilanes = parseInt($("#gavilanesmodal").val());
  formData.append("idGavilanes", idGavilanes);
  let idCategoria = parseInt($("#descripcionmodal").val());
  formData.append("idCategoria", idCategoria);
  let stock = parseInt($("#stock").val());
  formData.append("stock", stock);
  let stockMinimo = parseInt($("#stockminimo").val());
  formData.append("stockMinimo", stockMinimo);
  let idStatus = $("#status").val();
  formData.append("idStatus", idStatus);
  //? Validando si el input file tiene un archivo seleccionado
  //? si no tiene un archivo seleccionado se le asigna null
  $("#file_img").prop("files").length
    ? formData.append("fileImage", $("#file_img").prop("files")[0])
    : formData.append("fileImage", null);
  $.ajax({
    type: "POST",
    url: "php/herramientas.php",
    data: formData,
    dataType: "json",
    processData: false,
    contentType: false,
    success: function (res) {
      alert(res.status + " " + res.message);
    },
  });
}
