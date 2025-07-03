/**
 *
 */
import { messageSWA } from "../js/messages.js";
import { removeChilds } from "../assets/removeAllChilds.js";
import { modeDarkTable } from "../js/modeDarkTable.js";
/**
 *
 */

$(document).ready(async function () {
  modeDarkTable();
  var n_factura;
  var articulo;
  var cantidad;
  var v_unitario;
  var importe;
  var fecha;
  var data_array = [];
  var rows;
  let id_herramienta;
  let name_herramienta;
  let option = 1;
  let herramienta;
  let categoria;
  let medidas;
  let gav;
  let datosD = JSON.stringify({ option: option });
  let tableDataFact = await $("#data_factura").DataTable({
    ajax: {
      url: "php/facturas.php",
      method: "POST",
      data: function (d) {
        return datosD;
      },
      dataSrc: "",
      complete: function (data) {
        actualizarDiv();
      },
    },
    responsive: true,
    columnDefs: [{ responsivePriority: 1, targets: 5 }],
    columns: [
      { data: "id" },
      { data: "articulo" },
      { data: "existencia" },
      { data: "cantidad" },
      {
        data: "valor_u",
        render: function (data, type, row) {
          return `<p class="text-warning">$${parseFloat(data).toFixed(2)}</p>`;
        },
      },
      {
        data: "importe",
        render: function (data, type, row) {
          return `<p class="text-success">$${parseFloat(data).toFixed(2)}</p>`;
        },
      },
    ],
    ordering: false,
    footerCallback: function (row, data, start, end, display) {
      let api = this.api();

      // Remove the formatting to get integer data for summation
      let intVal = function (i) {
        return typeof i === "string"
          ? i.replace(/[\$,]/g, "") * 1
          : typeof i === "number"
          ? i
          : 0;
      };

      // Total over all pages
      let total = api
        .column(5)
        .data()
        .reduce((a, b) => intVal(a) + intVal(b), 0);

      // Total over this page
      let pageTotal = api
        .column(5, { page: "current" })
        .data()
        .reduce((a, b) => intVal(a) + intVal(b), 0);

      // Update footer
      api.column(5).footer().innerHTML = `Total: $${pageTotal.toFixed(
        2
      )} ($${total.toFixed(2)} MXN)`;
    },
  });
  // accediendo a la data de la tabla
  function actualizarDiv() {
    var datos = tableDataFact.data();
    // Obtener un dato específico (ejemplo: primer registro)
    if (datos.length > 0) {
      var primerRegistro = datos[0];
      let fechaFormatted = moment(primerRegistro.fecha).format("MMM Do YYYY");
      $("#Numfact").html(`${primerRegistro.n_factura}`);
      $("#fechaFactura").html(`${fechaFormatted}`);
    }
  }
  $(document).on("click", "#editar", function () {
    alert("Funcion en desarrollo");
  });

  $(document).on("click", "#eliminar", function () {
    alert("Funcion en desarrollo");
  });

  $(document).on("click", "#btn_agregar", function () {
    n_factura = document.getElementById("n_factura").value;
    cantidad = document.getElementById("cantidad").value;
    herramienta = document.getElementById("herramienta").value;
    categoria = $("#categorias").find("option:selected").text();
    medidas = $("#medidas").find("option:selected").text();
    gav = $("#gavilanes").find("option:selected").text();
    v_unitario = parseFloat(document.getElementById("v_unitario").value);
    importe = parseFloat(document.getElementById("importe").value);
    fecha = document.getElementById("fecha").value;
    id_herramienta = document.getElementById("id-herramienta").value;
    let tr = document.createElement("tr");
    if (
      n_factura == "" ||
      articulo == "" ||
      cantidad == "" ||
      v_unitario == "" ||
      importe == "" ||
      fecha == "" ||
      id_herramienta == ""
    ) {
      return messageSWA("Faltan algunos datos por ingresar", "error");
    } else {
      tr.innerHTML = `
        <td>${cantidad}</td>
        <td>${id_herramienta}</td>
        <td>${herramienta} de ${categoria} de ${gav} gavilanes de ${medidas}</td>
        <td class="text-warning">$${v_unitario.toFixed(2)}</td>
        <td class="text-success">$${importe.toFixed(2)}</td>
        <td><button class="btn btn-danger btn-sm btn_eliminar" type="button">Eliminar</button></td>`;
    }
    document.getElementById("body_tb_factura").appendChild(tr);
  });

  $(document).on("click", ".btn_eliminar", function () {
    $(this).closest("tr").remove();
  });

  $(document).on("click", "#btn_insert", function (e) {
    data_array = [];
    e.preventDefault();
    option = 2;
    fecha = document.getElementById("fecha").value;
    n_factura = parseInt(document.getElementById("n_factura").value);
    id_herramienta = document.getElementById("id-herramienta").value;
    cantidad = document.getElementById("cantidad").value;
    v_unitario = document.getElementById("v_unitario").value;
    importe = document.getElementById("importe").value;
    rows = document.getElementById("body_tb_factura").rows;
    if (rows.length <= 0) {
      return messageSWA("No has realizado ningun registro aún", "info");
    }
    for (let i = 0; i < rows.length; i++) {
      data_array.push([
        rows[i].cells[0].innerHTML,
        rows[i].cells[1].innerHTML,
        rows[i].cells[3].innerHTML,
        rows[i].cells[4].innerHTML,
      ]);
    }
    const data = JSON.stringify({
      option: option,
      n_factura: n_factura,
      data_array: data_array,
      fecha: fecha,
    });
    $.post(
      "php/facturas.php",
      data,
      (data) => {
        switch (data.status) {
          case "Registro completo":
            tableDataFact.ajax.reload(null, false);
            $("#frm-facturas").trigger("reset");
            messageSWA("Factura añadida", "success");
            removeChilds("body_tb_factura");
            break;
          case "Error":
            messageSWA("No se pudo añadir la factura", "error");
            break;
          default:
            messageSWA(
              "Ha sucedido un error inesperado, reportalo con el programador",
              "error"
            );
            break;
        }
      },
      "json"
    );
  });
});
