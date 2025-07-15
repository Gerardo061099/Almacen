/**
 *
 */

/**
 *
 *
 */

$(document).ready(function () {
  // ? aplicar en caso de que el background esa dark mode
  // ? y el tema de bootstrap sea dark (DataTable)
  let prefers = window.matchMedia("(prefers-color-scheme: dark)").matches
    ? "dark"
    : "light";
  let html = document.querySelector("html");

  html.classList.add(prefers);
  html.setAttribute("data-bs-theme", prefers);
  let option = 1;
  let sendOptionData = JSON.stringify({
    option: option,
  });
  let $tableAgotadas = $("#tableAgotadas").DataTable({
    ajax: {
      url: "php/agotadas.php",
      type: "POST",
      data: function (d) {
        return sendOptionData;
      },
      dataType: "json",
      dataSrc: "",
    },
    layout: {
      topStart: {
        buttons: ["print", "excel"],
      },
    },
    ordering: false,
    columns: [
      {
        data: "id",
      },
      { data: "nombre" },
      { data: "material" },
      { data: "descripcion" },
      { data: "gavilanes" },
      { data: "ancho" },
      { data: "largo" },
      { data: "stock" },
      { data: "stock_m" },
      {
        data: "stock_m",
        render: function (data, type, row) {
          let stockBuy = parseInt(row.stock_m) - parseInt(row.stock);
          return stockBuy;
        },
      },
    ],
  });
});
