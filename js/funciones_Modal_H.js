/**
 *
 */
import { messageSWA } from "./messages.js";
import { base64 } from "./Tobase64.js";
/**
 *
 */

$(document).ready(function () {
  let previa = document.getElementById("previa");
  var id_registro;
  var nombre_h;
  var medidas_id;
  var categoria_id;
  var gavilanes_id;
  var stock;
  var stock_minimo;
  let imgtobase64;
  let type_img;
  let nameimg;
  let option;
  let img_size;
  $(document).on("change", "#file_img", async (e) => {
    let img = e.target.files[0];
    //todo: Utilizando operadores ternarios
    img != "",
      img != undefined
        ? ((img_size = (img.size / (1024 * 1024)).toFixed(2)),
          (nameimg = img.name),
          (imgtobase64 = await base64(img)),
          previa.setAttribute("src", imgtobase64),
          (option = 5),
          $("#option").val(option))
        : (previa.setAttribute("src", ""),
          (option = 4),
          $("#option").val(option));
  });

  $("#frm_update_h").submit(function (e) {
    if (img_size >= 3.0) {
      return alert("La imagen es demasiado pesada, no debe exceder de 3.00 Mb");
    }
    let data;
    id_registro = $("#idmodal").val();
    nombre_h = $("#nombremodal").val();
    medidas_id = $("#medidasmodal").val();
    categoria_id = $("#descripcionmodal").val();
    gavilanes_id = $("#gavilanesmodal").val();
    stock = $("#stock").val();
    stock_minimo = $("#stockminimo").val();
    option = $("#option").val();
    data = JSON.stringify({
      id_registro: id_registro,
      nombre_h: nombre_h,
      medidas_id: medidas_id,
      categoria_id: categoria_id,
      gavilanes_id: gavilanes_id,
      stock: stock,
      stock_min: stock_minimo,
      option: option,
      namefile: nameimg,
      img: imgtobase64,
    });
    console.log(data);
    $.ajax({
      type: "POST",
      url: "php/funcionesModalH.php",
      data: data,
      dataType: "json",
      success: function (response) {
        $("#ModalEditar").modal("hide");
        if (response.result == "1") {
          messageSWA(
            "La herramienta se actualizo de manera exitosa!!",
            "success"
          );
        }
        if (response.result == "0") {
          messageSWA("Error al intentar actualizar la informacion", "error");
        }
        window.setTimeout(function () {
          $(e)
            .fadeTo(500, 0)
            .slideUp(500, function () {
              e.preventDefault();
            });
        }, 5000);
      },
    });
  });

  $("#ModalEditar").on("hidden.bs.modal", (event) => {
    previa.setAttribute("src", "");
    $("#frm_update_h").trigger("reset");
  });
});
