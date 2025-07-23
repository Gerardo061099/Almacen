/**
 *
 */
import {
  getCategoria,
  getMedidas,
  getGavilanes,
  getStatus,
  createList,
  getIsAvailable,
} from "./getCategoria.js";
import { getDataFormUpdate, obtener } from "./app.js";
import { createCard } from "./cards.js";
import { medidas } from "./funcion.js";
/**
 *
 */

$(document).ready(async function () {
  // ? aplicar en caso de que el background esa dark mode
  // ? y el tema de bootstrap sea dark (DataTable)
  let prefers = window.matchMedia("(prefers-color-scheme: dark)").matches
    ? "dark"
    : "light";
  let html = document.querySelector("html");
  html.classList.add(prefers);
  html.setAttribute("data-bs-theme", prefers);
  //* Variables Globales
  let option = 1;
  let idHerramienta;
  let nombreH;
  let idMedidas;
  let idCategoria;
  let idGavilanes;
  let stock;
  let stockMinimo;
  let idStatus;
  let fileImage;
  let data = { option };
  let tableHerramientas = await $("#herramientas").DataTable({
    ajax: {
      url: "php/herramientas.php",
      type: "POST",
      data: data,
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      {
        data: "id_herramienta",
        orderable: false,
      },
      { data: "Nombre" },
      { data: "material" },
      { data: "descripcion" },
      { data: "Num_gavilanes" },
      { data: "Ancho" },
      { data: "Largo" },
      { data: "cantidad_minima" },
      { data: "cantidad" },
      {
        data: "isAvailable",
        render: function (data) {
          if (data == 1)
            return `<span class="badge bg-success">Disponible</span>`;
        },
      },
      {
        data: "cantidad_minima",
        render: function (data, type, row) {
          if (row.cantidad == 0) {
            return `<span class="badge bg-danger">sin stock</span>`;
          } else if (row.cantidad < row.cantidad_minima) {
            return `<span class="badge bg-warning">insuficiente</span>`;
          } else {
            return `<span class="badge bg-success">suficiente</span>`;
          }
        },
      },
      { data: "fecha_hora" },
      {
        defaultContent: `
        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
          <button type="button" class="btn btn-warning btnEditar"><i class="bi bi-pencil-square"></i></button>
          <button type="button" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
        </div>`,
      },
    ],
    layout: {
      topStart: {
        buttons: [
          {
            extend: "pdfHtml5",
            download: "open",
            exportOptions: {
              columns: ":visible",
            },
          },
          "colvis",
        ],
      },
    },
    columnDefs: [
      {
        targets: -1,
        visible: false,
      },
    ],
  });

  $(document).on("click", "#createNewTool", async function () {
    let categoriaText = $("#categoria").find("option:selected").text();
    let gavilanesText = $("#gavilanes").find("option:selected").text();
    let medidaText = $("#medidas").find("option:selected").text();
    console.log(`Categoria seleccionada: ${categoriaText}`);
    console.log(`Medida seleccionada: ${medidaText}`);
    console.log(`Gavilanes seleccionados: ${gavilanesText}`);
    await obtener(categoriaText, gavilanesText, medidaText);
    tableHerramientas.ajax.reload(null, false);
    console.log("Se creo una nueva herramienta");
  });

  //Funcion medidas
  $(document).on("click", "#btn_add_medida", async function () {
    await medidas();
  });

  $(document).on("click", ".btnSendData", async function () {
    await getDataFormUpdate(option);
    tableHerramientas.ajax.reload(null, false);
  });

  $(document).on("click", ".btnEditar", async function () {
    $("#frm_update_h").trigger("reset");
    $("#previa").attr("src", "");
    option = 2;
    let row = tableHerramientas.row($(this).parents("tr")).data();
    $(".title-modal").text("Editando herramienta");
    $("#idmodal").val(row.id_herramienta);
    $("#nombremodal").val(row.Nombre);
    await getMedidas(row.Ancho, row.Largo);
    await getGavilanes(row.Num_gavilanes);
    await getCategoria(row.material, row.descripcion);
    await getStatus(row.cantidad, row.cantidad_minima);
    $("#stock").val(row.cantidad);
    await getIsAvailable(row.isAvailable);
    $("#stockminimo").val(row.cantidad_minima);
    $("#modal101").modal("show");
  });

  //* ********************************* Cards functions ************************************

  $(document).on("click", "#btn_buscar", function () {
    option = 6;
    let cardContainer = document.getElementById("card-container");
    let herramienta = $("#herra_b").val();
    let medida = $("#medida_b").val();
    let sendData = { option, herramienta, medida };
    $.ajax({
      type: "POST",
      url: "php/herramientas.php",
      data: sendData,
      dataType: "json",
      success: function (res) {
        window.location.href = "#main-container-Cards";
        // Clear existing cards
        cardContainer.innerHTML = "";
        res.forEach((e) => {
          createCard(
            e.id,
            e.Nombre,
            e.Descripcion,
            e.Material,
            e.Num_gavilanes,
            e.Ancho,
            e.Largo,
            e.Stock,
            e.Stock_minimo,
            e.rutaimg
          );
        });
      },
    });
  });

  $(document).on("change", "#checkAll", function (e) {
    let cardContainer = document.getElementById("card-container");
    if (e.target.checked) {
      option = 7;
      let sendData = { option };
      $("#herra_b").val("Choose...");
      $("#medida_b").val("Choose...");
      $("#herra_b").attr("disabled", true);
      $("#medida_b").attr("disabled", true);
      $("#btn_buscar").attr("disabled", true);
      $.ajax({
        type: "POST",
        url: "php/herramientas.php",
        data: sendData,
        dataType: "json",
        success: function (res) {
          window.location.href = "#main-container-Cards";
          // Clear existing cards
          cardContainer.innerHTML = "";
          res.forEach(async (e) => {
            await createCard(
              e.id,
              e.Nombre,
              e.Descripcion,
              e.Material,
              e.Num_gavilanes,
              e.Ancho,
              e.Largo,
              e.Stock,
              e.Stock_minimo,
              e.rutaimg
            );
          });
        },
      });
    } else {
      cardContainer.innerHTML = "";
      $("#herra_b").removeAttr("disabled");
      $("#medida_b").removeAttr("disabled");
      $("#btn_buscar").removeAttr("disabled");
    }
  });

  await $(document).load(
    "php/herramientas.php",
    { option: 8 },
    async function (res) {
      let response = JSON.parse(res);
      await $("#1").text(`${response[0].Avellanadores_Carburo}pzs`);
      await $("#2").text(`${response[1].Avellanadores_HSS}pzs`);
      await $("#3").text(`${response[2].Brocas_Carburo}pzs`);
      await $("#4").text(`${response[3].Brocas_HSS}pzs`);
      await $("#5").text(`${response[4].Buriles_Carburo}pzs`);
      await $("#6").text(`${response[5].Buriles_HSS}pzs`);
      await $("#7").text(`${response[6].Cortadores_Carburo}pzs`);
      await $("#8").text(`${response[7].Cortadores_HSS}pzs`);
      await $("#9").text(`${response[8].Machuelos_Carburo}pzs`);
      await $("#10").text(`${response[9].Machuelos_HSS}pzs`);
    }
  );

  await $(document).load("php/herramientas.php", { option: 9 }, function (res) {
    let response = JSON.parse(res);
    createList(
      "lista-Order-agotadas",
      response,
      "herramienta_agotada",
      "#linkA"
    );
  });

  await $(document).load(
    "php/herramientas.php",
    { option: 10 },
    function (res) {
      let response = JSON.parse(res);
      createList(
        "lista-Order-stockBajo",
        response,
        "herramienta_agotada",
        "#linkS"
      );
    }
  );
});
