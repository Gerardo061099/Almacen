/**
 * 
 */
import { getListgavilanes,getListMedidas,getListCategorias } from './funciones_request_frm_h.js';
/**
 * Code by: Gerardo Jiménez Castillo
 */

$(document).ready(function () {
    var select_gavilanes = document.getElementById('gavilanes')
    var select_medidas = document.getElementById('medidas')
    var select_categoria = document.getElementById('categoria')
    $(window).on('load', async function () {
        await getListgavilanes(select_gavilanes)
        getListMedidas(select_medidas)
        await getListCategorias(select_categoria)
        console.log('Pagina cargada...')
    })
})
