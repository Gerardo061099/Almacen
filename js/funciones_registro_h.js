/**
 *
 */
import {
  getListgavilanes,
  getListMedidas,
  getListCategorias,
} from "./funciones_request_frm_h.js";
/**
 * Code by: Gerardo Jiménez Castillo
 */

$(document).ready(function () {
  let select_gavilanes = document.getElementById("gavilanes");
  let select_medidas = document.getElementById("medidas");
  let select_categoria = document.getElementById("categoria");
  $(window).on("load", async function () {
    await getListgavilanes(select_gavilanes);
    getListMedidas(select_medidas);
    await getListCategorias(select_categoria);
  });
});
