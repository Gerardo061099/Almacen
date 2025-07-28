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
  let dataArray = [];
  let sendOptionData = JSON.stringify({
    option: option,
  });
  let tableAgotadas = $("#tableAgotadas").DataTable({
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
      { data: "id" },
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
      {
        defaultContent: `<button type="button" class="btn btn-sm btn-outline-light btnAddData">Priorizar</button>`,
      },
    ],
  });

  const tableArt = $("#tbArticlesPriorityHigh").DataTable({
    layout: {
      topStart: {
        buttons: [
          {
            extend: "pdfHtml5",
            donwload: "open",
          },
          "excel",
        ],
      },
    },
  });

  $("#tableAgotadas tbody").on("click", "tr", function () {
    let data = tableAgotadas.row(this).data();
    let buy = parseInt(data.stock_m) - parseInt(data.stock);
    let newRow = [
      data.id,
      data.nombre,
      data.material,
      data.descripcion,
      data.gavilanes,
      data.ancho,
      data.largo,
      data.stock,
      data.stock_m,
      buy,
      `<button type="button" class="btn btn-sm btn-outline-danger btnRemoveData">Eliminar</button>`,
    ];
    // data.id = `${data.id}`;
    // console.log(data);
    tableArt.row.add(newRow).draw();
  });

  $(document).on("click", ".btnRemoveData", function () {
    let row = tableArt.row($(this).parents("tr"));
    row.remove().draw();
  });
});
