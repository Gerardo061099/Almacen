/**
 * 
 */

/**
 * 
 */

$(document).ready(function () {
    var user = document.getElementById('usuario').textContent;
    var btn_reporte = document.getElementById('btn-reportes-out')
    if (user == '@admin06' || user == 'clasico1mx@hotmail.com') {
        btn_reporte.style.visibility = 'visible';
    } else {
        btn_reporte.style.visibility = 'hidden';
    }
});