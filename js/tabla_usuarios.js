/**
 *
 */
import { messageSWA } from "./messages.js";
import { modeDarkTable } from "./modeDarkTable.js";
/**
 *
 */

$(document).ready(function () {
  modeDarkTable();
  let tabla_usuarios;
  let nombre;
  let apellidos;
  let email;
  let pass;
  let num_e;
  let estado;
  let option;
  let fila;
  let registro_id;
  let datasrc;
  option = 1;
  datasrc = JSON.stringify({ opcion: option });
  tabla_usuarios = $("#tabla_usuarios").DataTable({
    ajax: {
      url: "php/dataUsuarios.php",
      method: "POST",
      data: function (d) {
        return datasrc;
      },
      dataSrc: "",
    },
    columns: [
      { data: "id_us" },
      { data: "Nombre" },
      { data: "Apellidos" },
      { data: "user" },
      { data: "Num_empleado" },
      {
        data: "Estado",
        render: function (data, type) {
          if (type === "display") {
            let claseName = "";
            let status = "";
            switch (data) {
              case "Inactivo":
                claseName = "bg-warning";
                status = "Inactivo";
                break;

              case "Activo":
                claseName = "bg-success";
                status = "Activo";
                break;

              default:
                claseName = "error";
                status = "error";
                break;
            }
            return (
              "<span class='badge rounded-pill " +
              claseName +
              "'>" +
              status +
              "</span>"
            );
          }
          return data;
        },
      },
      {
        defaultContent:
          "<div class='btn-group btn-group-sm' role='group'><button class='btn btn-warning btnEditar'><i class='fa-solid fa-pen-to-square'></i></button><button class='btn btn-danger btnBorrar'><i class='fa-solid fa-trash-can'></i></button></div>",
      },
    ],
    searching: false,
    paging: false,
  });

  /**
   * funciones para Mostrar, Agregar, Actualizar y Eliminar Usuarios.
   */

  $("#btn_open_modal").click(function (e) {
    e.preventDefault();
    option = 2;
    registro_id = null;
    $("#modal_title").text("Agregar nuevo usuario.");
    $("#frm_add_user").trigger("reset");
    $("#modalUsuarios").modal("show");
  });

  $("#frm_add_user").submit(function (e) {
    e.preventDefault();
    let datos;
    nombre = $.trim($("#nombre_u").val());
    apellidos = $.trim($("#apellidos_u").val());
    email = $.trim($("#email_u").val());
    pass = $.trim($("#pass_u").val());
    num_e = $.trim($("#num_e").val());
    estado = $.trim($("#estado_u").val());
    datos = JSON.stringify({
      registro_id: registro_id,
      nombre: nombre,
      apellidos: apellidos,
      email: email,
      pass: pass,
      num_e: num_e,
      estado: estado,
      opcion: option,
    });
    if (
      nombre != "" &&
      apellidos != "" &&
      email != "" &&
      num_e != "" &&
      estado != "Choose..."
    ) {
      $.ajax({
        type: "POST",
        url: "php/dataUsuarios.php",
        data: datos,
        dataType: "json",
        success: function (a) {
          console.log(a);
          if (a.result == "1")
            messageSWA("El usuario se agrego correctamente!!", "success");
          if (a.result == "")
            messageSWA("Ocurrio un error inesperado", "error");
          tabla_usuarios.ajax.reload(null, false);
        },
      });
    } else {
      messageSWA("Datos incompletos", "info");
    }
    $("#modalUsuarios").modal("hide");
  });

  $(document).on("click", ".btnEditar", function () {
    $("#modal_title").text("Editando...");
    $("#frm_add_user").trigger("reset");
    option = 3;
    fila = $(this).closest("tr");
    registro_id = fila.find("td:eq(0)").text();
    let nombre_us = fila.find("td:eq(1)").text();
    let apellidos_us = fila.find("td:eq(2)").text();
    let usuario = fila.find("td:eq(3)").text();
    let num_us = fila.find("td:eq(4)").text();
    let estado_us = fila.find("td:eq(5)").text();
    $("#nombre_u").val(nombre_us);
    $("#apellidos_u").val(apellidos_us);
    $("#email_u").val(usuario);
    $("#num_e").val(num_us);
    $("#estado_u").val(estado_us);
    $("#modalUsuarios").modal("show");
  });

  $(document).on("change", "#gridCheck", function () {
    var password1 = document.getElementById("pass_u");
    var check = document.getElementById("gridCheck");
    // Si el checkbox de mostrar contraseña está activada
    if (check.checked === true) {
      password1.type = "text";
    }
    // Si no está activada
    else {
      password1.type = "password";
    }
  });

  $(document).on("click", ".btnBorrar", function () {
    option = 4;
    fila = $(this);
    let delete_row = parseInt($(this).closest("tr").find("td:eq(0)").text());
    let data = JSON.stringify({ opcion: option, delete_id: delete_row });
    let response = confirm(
      `Seguro que quieres eliminar el siguiente registro: ${delete_row}`
    );
    if (response) {
      $.ajax({
        type: "POST",
        url: "php/dataUsuarios.php",
        data: data,
        dataType: "json",
        success: function (resp) {
          if (resp.result == "1")
            messageSWA("El registro se elimino", "success");
          if (resp.result == "")
            messageSWA(
              "Ocurrio un error al intentar eliminar el registro",
              "error"
            );
          tabla_usuarios.ajax.reload(null, false);
        },
      });
    } else {
      messageSWA("Accion cancelada", "info");
    }
  });
});
