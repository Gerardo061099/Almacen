/**
 *
 */

/**
 *
 */

export async function getCategoria(material, descripcion) {
  let option = 1;
  let data = JSON.stringify({ option: option });
  let select = document.getElementById("descripcionmodal");
  $("#descripcionmodal").empty();
  $("#descripcionmodal").prepend("<option selected>Choose...</option>");
  $.ajax({
    type: "POST",
    url: "php/funcionesModalH.php",
    data: data,
    dataType: "json",
    success: function (data) {
      if (data !== "") {
        for (let i = 0; i < data.length; i++) {
          var option = document.createElement("option");
          option.value = data[i].id_Categoria;
          option.textContent = `${data[i].Material} ${data[i].Descripcion}`;
          if (
            data[i].Material == material &&
            data[i].Descripcion == descripcion
          ) {
            option.selected = true;
          }
          select.add(option);
        }
      }
    },
  });
}
export async function getMedidas(ancho, largo) {
  let option = 2;
  let data = JSON.stringify({ option: option });
  let selectmedidas = document.getElementById("medidasmodal");
  $("#medidasmodal").empty();
  $("#medidasmodal").prepend("<option selected>Choose...</option>");
  $.ajax({
    type: "POST",
    url: "php/funcionesModalH.php",
    data: data,
    dataType: "json",
    success: function (data) {
      if (data !== "") {
        for (let i = 0; i < data.length; i++) {
          var option = document.createElement("option");
          option.value = data[i].id_Medidas;
          option.textContent = `${data[i].Ancho} x ${data[i].Largo}`;
          if (data[i].Ancho == ancho && data[i].Largo == largo) {
            option.selected = true;
          }
          selectmedidas.add(option);
        }
      }
    },
  });
}
export async function getStatus(stock, stock_minimo) {
  $("#status").removeClass("text-danger text-success text-warning");
  if (stock == 0) {
    $("#status").val("Sin stock");
    $("#status").addClass("text-danger");
  } else if (stock >= stock_minimo) {
    $("#status").val("Suficiente");
    $("#status").addClass("text-success");
  } else {
    $("#status").val("Insuficiente");
    $("#status").addClass("text-warning");
  }
}
export async function getIsAvailable(isAvailable) {
  const selectAvailable = $("#isavailable");
  switch (isAvailable) {
    case "1":
      selectAvailable.val("available");
      break;
    default:
      return alert("Sin estatus de la disponibilidad");
      break;
  }
}

export async function getGavilanes(gavilanes) {
  let option = 3;
  let data = JSON.stringify({ option: option });
  let selectgav = document.getElementById("gavilanesmodal");
  $("#gavilanesmodal").empty();
  $("#gavilanesmodal").prepend("<option selected>Choose...</option>");
  $.ajax({
    type: "POST",
    url: "php/funcionesModalH.php",
    data: data,
    dataType: "json",
    success: function (resp) {
      if (resp !== "") {
        for (let i = 0; i < resp.length; i++) {
          var option = document.createElement("option");
          option.value = resp[i].id_Gav;
          option.textContent = `${resp[i].Num_gavilanes}`;
          if (resp[i].Num_gavilanes == gavilanes) {
            option.selected = true;
          }
          selectgav.add(option);
        }
      }
    },
  });
}

export function getCategoria_d(material, descripcion) {
  let option = 1;
  let data = JSON.stringify({ option: option });
  let select = document.getElementById("descripcionmodal_d");
  $("#descripcionmodal_d").empty();
  $("#descripcionmodal_d").prepend("<option selected>Choose...</option>");
  $.ajax({
    type: "POST",
    url: "php/funcionesModalH.php",
    data: data,
    dataType: "json",
    success: function (data) {
      if (data !== "") {
        for (let i = 0; i < data.length; i++) {
          var option = document.createElement("option");
          option.value = data[i].id_Categoria;
          option.textContent = `${data[i].Material} ${data[i].Descripcion}`;
          if (
            data[i].Material == material &&
            data[i].Descripcion == descripcion
          ) {
            option.selected = true;
          }
          select.add(option);
        }
      }
    },
  });
}
export function getMedidas_d(ancho, largo) {
  let option = 2;
  let data = JSON.stringify({ option: option });
  let selectmedidas = document.getElementById("medidasmodal_d");
  $("#medidasmodal_d").empty();
  $("#medidasmodal_d").prepend("<option selected>Choose...</option>");
  $.ajax({
    type: "POST",
    url: "php/funcionesModalH.php",
    data: data,
    dataType: "json",
    success: function (data) {
      if (data !== "") {
        for (let i = 0; i < data.length; i++) {
          var option = document.createElement("option");
          option.value = data[i].id_Medidas;
          option.textContent = `${data[i].Ancho} x ${data[i].Largo}`;
          if (data[i].Ancho == ancho && data[i].Largo == largo) {
            option.selected = true;
          }
          selectmedidas.add(option);
        }
      }
    },
  });
}

export function getGavilanes_d(gavilanes) {
  let option = 3;
  let data = JSON.stringify({ option: option });
  let selectgav = document.getElementById("gavilanesmodal_d");
  $("#gavilanesmodal_d").empty();
  $("#gavilanesmodal_d").prepend("<option selected>Choose...</option>");
  $.ajax({
    type: "POST",
    url: "php/funcionesModalH.php",
    data: data,
    dataType: "json",
    success: function (resp) {
      if (resp !== "") {
        for (let i = 0; i < resp.length; i++) {
          var option = document.createElement("option");
          option.value = resp[i].id_Gav;
          option.textContent = `${resp[i].Num_gavilanes}`;
          if (resp[i].Num_gavilanes == gavilanes) {
            option.selected = true;
          }
          selectgav.add(option);
        }
      }
    },
  });
}

export function createList(idContainer, jsonData, link, idBtn) {
  let container = document.getElementById(idContainer);
  jsonData.forEach((item, i) => {
    if (i < 10) {
      let listItem = document.createElement("li");
      listItem.textContent = `${i + 1}.- ${item.Nombre} de ${item.material}...`;
      container.appendChild(listItem);
    } else {
      $(idBtn).html(
        `<a href="${link}.php" class="btn btn-dark btn-sm" tabindex="-1" role="button" aria-disabled="true">Ver detalles.</a>`
      );
    }
  });
}
