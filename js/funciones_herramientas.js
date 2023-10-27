/**
 * 
 */


/** 
 * 
 */
function editarHerramienta(data) {
    var d = data.split('||');
    $('#idmodal').val(d[0]);//id
    $('#nombremodal').val(d[1]);//nombre
    $('#materialmodal').val(d[2]);//material
    $('#descripcionmodal').val(d[3]);//descripcion
    $('#gavilanesmodal').val(d[4]);//gavilanes
    $('#anchomodal').val(d[5]);//ancho
    $('#largomodal').val(d[6]);//largo
    $('#stock').val(d[7]);//stock
    $('#stockminimo').val(d[8]);//stock minimo
    $('#ModalEditar').modal('show')
}


