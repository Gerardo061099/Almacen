/**
 *
 */

/**
 *
 *
 */
//Esta funcion nos ayuda a eliminar elementos hijos del
//cuerpo de la tabla
export function removeChilds(i) {
  let a = document.getElementById(i);
  while (a.hasChildNodes()) {
    a.removeChild(a.firstChild);
  }
}
