/**
 *
 */

/**
 *
 */

export async function modeDarkTable() {
  let prefers = window.matchMedia("(prefers-color-scheme: dark)").matches
    ? "dark"
    : "light";
  let html = document.querySelector("html");

  html.classList.add(prefers);
  html.setAttribute("data-bs-theme", prefers);
}

// ? creamos y agregamos las opciones al select de años
export async function createSelectYear() {
  const limitYear = "2024";
  let yearsArray = [];
  let nowYear = new Date().getFullYear();
  for (let i = nowYear; i >= limitYear; i--) {
    yearsArray.push(i);
    createOptionsYears(i);
  }
}
//* funcion dependiente de createSelectYear
export function createOptionsYears(dateYear) {
  const select = document.getElementById("yearSelectFilter");
  let option = document.createElement("option");
  option.value = dateYear;
  option.textContent = dateYear;
  select.appendChild(option);
}
//?--------- creamos y agregamos las opciones al select de facturas
export async function getFacturastoSelect(yearFil = Date().getFullYear()) {
  let yearFilter = yearFil;
  let option = 3;
  $.ajax({
    type: "POST",
    url: "php/facturas.php",
    data: JSON.stringify({ option, yearFilter }),
    dataType: "json",
    success: function (res) {
      res.map((e) => createOptions(e));
    },
  });
}
//* funcion dependiente de getFacturastoSelect
export function createOptions(res) {
  let select = document.getElementById("facturasOption");
  let option = document.createElement("option");
  option.value = res.id;
  option.textContent = `${res.n_factura}`;
  select.appendChild(option);
}
