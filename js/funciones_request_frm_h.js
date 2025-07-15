/**
 *
 */

/**
 *
 */

export async function getListgavilanes(select_gav) {
  let option;
  let data;
  option = 1; //consultamos la informacion de la tabla Gavilanes
  data = JSON.stringify({ option: option });
  $("#gavilanes").empty();
  $("#gavilanes").prepend("<option selected>Choose...</option>");
  $.ajax({
    type: "POST",
    url: "php/getListSelect_h.php",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response !== "") {
        for (let i = 0; i < response.length; i++) {
          let option = document.createElement("option");
          option.value = response[i].id_Gav;
          option.textContent = response[i].Num_gavilanes;
          select_gav.add(option);
        }
      }
    },
  });
}

export function getListMedidas(select_med) {
  let option = 2; //consultamos la informacion de la tabla Medidas
  let data = JSON.stringify({ option: option });
  $("#medidas").empty();
  $("#medidas").prepend("<option selected>Choose...</option>");
  $.ajax({
    type: "POST",
    url: "php/getListSelect_h.php",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response !== "") {
        for (let i = 0; i < response.length; i++) {
          let option = document.createElement("option");
          option.value = response[i].id_Medidas;
          option.textContent = `${response[i].Ancho}x${response[i].Largo}`;
          select_med.add(option);
        }
      }
    },
  });
}

export async function getListCategorias(select_categoria) {
  let option = 3; //consultamos la informacion de la tabla Categorias
  let data = JSON.stringify({ option: option });
  $("#categoria").empty();
  $("#categoria").prepend("<option selected>Choose...</option>");
  $.ajax({
    type: "POST",
    url: "php/getListSelect_h.php",
    data: data,
    dataType: "json",
    success: function (response) {
      if (response !== "") {
        for (let i = 0; i < response.length; i++) {
          let option = document.createElement("option");
          option.value = response[i].id_Categoria;
          option.textContent = `${response[i].Material} ${response[i].Descripcion}`;
          select_categoria.add(option);
        }
      }
    },
  });
}
