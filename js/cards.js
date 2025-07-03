/**
 *
 */

/**
 *
 */

export async function createCard(
  id,
  nombre,
  descripcion,
  material,
  gavilanes,
  ancho,
  largo,
  stock,
  stockMinimo,
  rutaimg
) {
  const cardContainer = document.getElementById("card-container");
  const card = document.createElement("div");
  card.className = "col";
  card.innerHTML = `
    <div class="card">
        <img src="${rutaimg}" class="card-img-top" alt="sin vista de la imagen">
        <div class="card-body">
            <h5 class="card-title">#${id} ${nombre}</h5>
            <p class="card-text">${nombre} de ${material} ${descripcion}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">${ancho} de ancho x ${largo} de largo</li>
            <li class="list-group-item">Existencias: ${stock}</li>
            <li class="list-group-item">Stock minimo: ${stockMinimo}</li>
            <li class="list-group-item">${gavilanes} gavilan(es)</li>
        </ul>
        <div class="card-body">
            ${
              stock >= stockMinimo
                ? `<span class="badge bg-success">Suficiente</span>`
                : stock == 0
                ? `<span class="badge bg-danger">Agotado</span>`
                : `<span class="badge bg-warning">Bajo</span>`
            }
        </div>
    </div>`;
  cardContainer.appendChild(card);
}
