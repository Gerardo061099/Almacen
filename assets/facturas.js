/**
 *
 */
import { messageSWA } from "../js/messages.js";
/**
 *
 */

$(document).ready(function () {
  var n_factura;
  var articulo;
  var cantidad;
  var v_unitario;
  var importe;
  var fecha;
  var data_array = [];
  var rows;
  var option;
  $(document).on("click", "#btn_agregar", function () {
    n_factura = document.getElementById("n_factura").value;
    articulo = document.getElementById("articulo").value;
    cantidad = document.getElementById("cantidad").value;
    v_unitario = document.getElementById("v_unitario").value;
    importe = document.getElementById("importe").value;
    fecha = document.getElementById("fecha").value;
    document
      .getElementById("body_tb_factura")
      .insertRow(
        -1
      ).innerHTML = `<td>${cantidad}</td><td>${articulo}</td><td>$${v_unitario}</td><td>$${importe}</td>`;
  });

  $(document).on("click", "#btn_eliminar", function () {
    const table = document.getElementById("body_tb_factura");
    const rowCount = table.rows.length;
    if (rowCount < 1) {
      alert("No quedan registros para eliminar");
    } else {
      table.deleteRow(rowCount - 1);
    }
  });

  $(document).on("click", "#btn_insert", function (e) {
    e.preventDefault();
    option = 2;
    fecha = document.getElementById("fecha").value;
    n_factura = parseInt(document.getElementById("n_factura").value);
    rows = document.getElementById("body_tb_factura").rows;
    for (let i = 0; i < rows.length; i++) {
      data_array.push([
        rows[i].cells[0].innerHTML,
        rows[i].cells[1].innerHTML,
        rows[i].cells[2].innerHTML,
        rows[i].cells[3].innerHTML,
      ]);
    }
    console.log(`N° de Factura: ${n_factura}`);
    console.log(data_array);
    console.log(`Fecha de Factura: ${fecha}`);
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
            messageSWA("Factura añadida", "success");
            break;
          case "Error":
            messageSWA("No se pudo añadir la factura", "error");
            break;
          default:
            break;
        }
      },
      "json"
    );
  });
});
