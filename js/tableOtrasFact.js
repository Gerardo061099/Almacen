/**
 *
 */
import {
  getFacturastoSelect,
  modeDarkTable,
  createSelectYear,
} from "./modeDarkTable.js";
/**
 *
 */

$(document).ready(async function () {
  //? modo oscuro aplicado a la tabla
  await modeDarkTable();
  //? creamos y agregamos las opciones al select de años
  await createSelectYear();
  //? creamos y agregamos las opciones al select de facturas
  await getFacturastoSelect(document.getElementById("yearSelectFilter").value);
  // ? consultamos las facturas cuando indicamos un año diferente al actual
  $(document).on("change", "#yearSelectFilter", function (e) {
    $("#facturasOption").html("htmlString");
    getFacturastoSelect(e.target.value);
  });
  let tableFacts = $("#tablaOtrasFacturas").DataTable({
    columnDefs: [
      {
        responsivePriority: 1,
        targets: 4,
      },
    ],
    ordering: false,
    responsive: true,
    layout: {
      topStart: {
        buttons: [
          {
            extend: "pdfHtml5",
            download: "open",
          },
        ],
      },
    },
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
        .column(4)
        .data()
        .reduce((a, b) => intVal(a) + intVal(b), 0);
      // Total over this page
      let pageTotal = api
        .column(4, { page: "current" })
        .data()
        .reduce((a, b) => intVal(a) + intVal(b), 0);
      // Update footer
      api.column(4).footer().innerHTML = `Total: $${pageTotal.toFixed(
        2
      )} ($${total.toFixed(2)} MXN)`;
    },
  });
  $(document).on("click", "#btn_filter", function () {
    let option = 4; //? opcion para consultar las facturas
    let yearSelected = $("#yearSelectFilter").val();
    let facturaSelected = $("#facturasOption").find("option:selected").text();
    let datosSend = JSON.stringify({
      option,
      yearFilter: yearSelected,
      n_factura: facturaSelected,
    });
    $.ajax({
      type: "POST",
      url: "php/facturas.php",
      data: datosSend,
      success: function (response) {
        response = JSON.parse(response);
        response.map((e) => {
          e.map((item, j, e) => {
            if (j > 2 && j < 5) {
              item = `$${parseFloat(item).toFixed(2)}`;
              e.splice(j, 1, item);
            }
          });
        });
        tableFacts.clear().rows.add(response).draw();
        tableFacts.ajax.reload(null, false); //? reload the table without resetting the pagination
      },
    });

    // let data = [
    //   [1, "Articulo 1", 2, 100, 200],
    //   [2, "Articulo 2", 1, 150, 150],
    //   [3, "Articulo 3", 3, 200, 600],
    // ];
    // tableFacts.clear().rows.add(data).draw();
  });
});
