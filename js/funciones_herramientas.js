/**
 *
 */

/**
 *  Code by: Gerardo Jiménez Castillo
 */
async function editarHerramienta(data) {
  var option = 4;
  $("#option").val(option);
  var d = data.split("||");
  $("#idmodal").val(d[0]); //id
  $("#nombremodal").val(d[1]); //nombre
  await getCategoria(d[2], d[3]);
  $("#stockminimo").val(d[7]); //stock
  await getGavilanes(d[4]);
  $("#stock").val(d[8]); //stock minimo
  await getMedidas(d[5], d[6]);
  $("#ModalEditar").modal("show");
}
