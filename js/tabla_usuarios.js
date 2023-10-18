/**
 * 
 */

/**
 * 
 */

$(document).ready(function () {
    let tabla_usuarios
    let option
    let datasrc
    option = 1
    datasrc = JSON.stringify({'opcion':option})
    tabla_usuarios = $('#tabla_usuarios').DataTable({
        'ajax':{
            'url':'php/dataUsuarios.php',
            'method':'POST',
            'data': function (d) {
                return datasrc
            },
            'dataSrc': ''
        },
        'columns':[
            {'data':'id_us'},
            {'data':'Nombre'},
            {'data':'Apellidos'},
            {'data':'user'},
            {'data':'Num_empleado'},
            {'data':'Estado',
                render: function (data,type) {
                    if (type === 'display') {
                        let claseName = ''
                        let status = ''
                        switch (data) {
                            case 'Inactivo':
                                claseName = 'bg-danger'
                                status = 'Inactivo'
                            break
                            
                            case 'Activo':
                                claseName = 'bg-success'
                                status = 'Activo'
                            break
                            
                            default:
                                claseName = 'error'
                                status = 'error'
                            break
                        }
                        return "<span class='badge rounded-pill "+claseName+"'>"+status+"</span>"
                    }
                    return data
                }
            },
            {'defaultContent':"<div class='btn-group btn-group-sm' role='group'><button class='btn btn-warning btnEditar'><i class='fa-solid fa-pen-to-square'></i></button><button class='btn btn-danger btnBorrar'><i class='fa-solid fa-trash-can'></i></button></div>"}
        ]
    })

    $('#btn_open_modal').click(function (e) { 
        e.preventDefault()
        $('#modalUsuarios').modal('show')
        
    })


})