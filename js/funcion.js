/**
 *
 */
import { messageAimate } from "./messages.js";
/**
 *
 *
 */

export async function medidas() {
  var ancho = document.getElementById("ancho").value;
  var unidad_ancho = document.getElementById("unidad_ancho").value;
  var largo = document.getElementById("largo").value;
  var unidad_largo = document.getElementById("unidad_largo").value;
  let type_type = await separate(ancho);
  type_type == "Machuelo" || type_type == "Broca"
    ? (unidad_ancho = "")
    : (unidad_ancho = unidad_ancho);
  largo == "N/A" ? (unidad_largo = " ") : (unidad_largo = unidad_largo);
  if (largo === "" || ancho === "") {
    messageAimate("Falta Agregar datos ", "warning");
  } else {
    var data = new FormData();
    ancho = `${ancho}${unidad_ancho}`;
    largo = `${largo}${unidad_largo}`;
    data.append("Ancho", ancho);
    data.append("Largo", largo);
    $.ajax({
      url: "inserta_medidas.php",
      type: "POST",
      data: data,
      processData: false,
      Cache: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        switch (response.status) {
          case "ok":
            messageAimate("Los datos se agregaron correctamente", "success");
            break;
          case "error":
            messageAimate("Los datos se pudieron insertar", "error");
            break;
          case "info":
            messageAimate(
              `Ya existe un registro con estas medidas: ID de registro: ${response.datos.id}, Ancho: ${response.datos.Ancho}, Largo: ${response.datos.Largo}`,
              "info"
            );
            break;
          default:
            break;
        }
      },
    });
  }
}

export async function separate(ancho) {
  let cadenatexto = ancho;
  let substractletter = cadenatexto.split("")[0];
  let type_tool;
  switch (substractletter) {
    case "M":
      type_tool = "Machuelo";
      break;
    case "#":
      type_tool = "Broca";
      break;
    default:
      type_tool = null;
      break;
  }
  return type_tool;
}
