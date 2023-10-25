/**
 * 
 */


/** 
 * 
 */
function Update_infousers(data) {
    var d = data.split('||');
    $('#idmodal').val(d[0]);//id
    $('#nombremodal').val(d[1]);//nombre
    $('#apellidosmodal').val(d[2]);//apellidos
    $('#usuariomodal').val(d[3]);//name_user
    $('#num_empleadomodal').val(d[4]);//numero_empleado
    $('#rolemodal').val(d[5]);//rolename
    if(d[6]==1){
        $('#estadomodal').val('Activo');
    }else {
    $('#estadomodal').val('Inactivo');
    }
    $('#ModalEditar').modal('show')
}
