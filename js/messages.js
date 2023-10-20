/**
 *  Funciones para mostrar diferentes mensajes al usuario
 *  
 *  Para que estos mesajes se ejecuten correctamente incluya los CDN's como scripts en el documento 
 *  en el que requiere utilizar
 */

/**
 * 
 */
// Funcion que imprime un mensaje con Sweet Alert2 
export function messageSWA(message,type) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-start',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
      Toast.fire({
        icon: type,
        title: message
      })
}
