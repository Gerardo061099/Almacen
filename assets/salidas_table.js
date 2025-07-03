/**
 *
 */

/**
 *
 *
 */

$(document).ready(async function () {
  let prefers = window.matchMedia("(prefers-color-scheme: dark)").matches
    ? "dark"
    : "light";
  let html = document.querySelector("html");

  html.classList.add(prefers);
  html.setAttribute("data-bs-theme", prefers);

  html.classList.add(prefers);
  html.setAttribute("data-bs-theme", prefers);
  let option = 1;
  let nombre = "";
  let apellidos = "";
  let n_emp = "";
  let id_herramienta;
  let stockS;
  let nombreH;
  let categoriaH;
  let materialH;
  let medidasH;
  let gavH;
  let dataRender;
  let rows = [];
  let listSolicitantes = [];
  let dataReq = JSON.stringify({
    option,
  });
  var myTable = $("#h").DataTable({
    ajax: {
      url: "php/tabla_salidas.php",
      method: "POST",
      data: function (d) {
        return dataReq;
      },
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
        orderable: false,
      },
      { data: "solicitante" },
      { data: "herramienta" },
      { data: "descripcion" },
      { data: "material" },
      { data: "gav" },
      { data: "ancho" },
      { data: "largo" },
      { data: "cantidad" },
      { data: "fecha" },
    ],
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
    order: [[0, "desc"]],
  });

  let showDataCard = async () => {
    option = 2;
    let nombreR = document.getElementById("nombre_empleado");
    let n_empleado = document.getElementById("num_e");
    let stock_req = document.getElementById("stocks_req");
    let n_req = document.getElementById("n_req");
    let dataSending = JSON.stringify({
      option,
    });
    await $.ajax({
      type: "POST",
      url: "php/tabla_salidas.php",
      data: dataSending,
      dataType: "json",
      success: function (data) {
        nombreR.innerText = `${data[0].solicitante}`;
        n_empleado.innerText = `${data[0].n_empleado}`;
        n_req.innerText = `${data[0].id_solicitud}`;
        stock_req.innerText = `${data[0].stock_solicitado}`;
      },
    });
  };
  await showDataCard();

  $(document).on("click", "#btnShowModal", function () {
    $("#frm-solicitante").trigger("reset");
    nombre = "";
    apellidos = "";
    n_emp = "";
    $("#modalSalidas").modal("show");
  });

  $(document).on("change", "#nombre", function (e) {
    nombre = e.target.value;
  });

  $(document).on("change", "#ap", function (e) {
    apellidos = e.target.value;
  });

  $(document).on("change", "#n_empleado", function (e) {
    n_emp = e.target.value;
  });

  $(document).on("click", "#btnGuardar", function (e) {
    if (nombre != "" && apellidos != "" && n_emp != "") {
      $("#frm-herramientas-outside").trigger("reset");
      $("#modalSalidas").modal("hide");
      $("#modalHerramienta").modal("show");
      // Limpiamos la tabla
      while (document.getElementById("tableBody").rows.length > 0) {
        document.getElementById("tableBody").deleteRow(0);
      }
    } else {
      alert("Por favor, completa todos los campos.");
    }
  });

  $(document).on("click", "#registrarSolicitud", function () {
    let materialH = [];
    let descripcionH = [];
    let bodyTableBody = document.getElementById("tableBody");
    id_herramienta = parseInt($("#id-herramienta").val());
    nombreH = $("#herramienta").val();
    categoriaH = $("#categorias").find("option:selected").text();
    // Separamos la categoria en dos partes
    // la primera parte es el material y la segunda parte es la descripcion
    if (categoriaH.split(" ")[0] === "CARBURO") {
      materialH = categoriaH.split(" ")[0];
      for (let i = 1; i < categoriaH.split(" ").length; i++) {
        descripcionH.push(categoriaH.split(" ")[i]);
      }
    } else {
      materialH = `${categoriaH.split(" ")[0]} ${categoriaH.split(" ")[1]} ${
        categoriaH.split(" ")[2]
      }`;
      for (let i = 3; i < categoriaH.split(" ").length; i++) {
        descripcionH.push(categoriaH.split(" ")[i]);
      }
    }
    medidasH = $("#medidas").find("option:selected").text();
    gavH = $("#gavilanes").find("option:selected").text();
    stockS = parseInt($("#cantidad").val());
    rows.push({
      nombreH,
      categoriaH,
      medidasH,
      gavH,
    });
    listSolicitantes.push({
      id_herramienta,
      stockS,
    });
    dataRender = JSON.stringify({
      id_herramienta,
      nombreH,
      categoriaH,
      medidasH,
      gavH,
      stockS,
    });
    let newRow = document.createElement("tr");
    newRow.innerHTML = `
      <td>${id_herramienta}</td>
      <td>${nombreH}</td>
      <td>${descripcionH.join(" ")}</td>
      <td>${materialH}</td>
      <td>${gavH}</td>
      <td>${medidasH}</td>
      <td>${stockS}</td>
      <td><button type="button" class="btn btn-danger btn-sm btnDelete">Eliminar</i></button></td>
    `;
    bodyTableBody.appendChild(newRow);
  });

  $(document).on("click", ".btnDelete", function () {
    let row = this.parentNode.parentNode;
    console.log(row);
    let table = document.getElementById("tableResumen");
    table.deleteRow(row.rowIndex);
    listSolicitantes.splice(row.rowIndex - 1, 1);
    rows.splice(row.rowIndex - 1, 1);
  });

  $(document).on("click", "#finalizar", function () {
    let data = JSON.stringify({
      listSolicitantes,
      nombre,
      apellidos,
      n_emp,
    });
    console.log(data);
    if (listSolicitantes.length === 0) {
      alert("No hay herramientas seleccionadas");
      return false;
    }
    $.ajax({
      url: "php/fin_solicitud.php",
      type: "POST",
      data: data,
      dataType: "json",
      success: function (res) {
        res.forEach(async (el) => {
          switch (el.status) {
            case "ok":
              alert(`${el.message}`);
              console.log(el.message);
              $("#btn-finalizar").attr("hidden", false);
              await showDataCard();
              break;
            case "error":
              alert(`${el.message}`);
              console.log(el.message);
              break;
            default:
              alert(`${el.message}`);
              console.log(el.message);
              break;
          }
        });
        myTable.ajax.reload();
      },
    });
  });
});
