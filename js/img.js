/**
 *
 */

/**
 *
 */

$(document).ready(function () {
  $(document).on("change", "#subir_imagen", function (e) {
    e.preventDefault();
    let sectionImg = document.getElementById("section-img");
    sectionImg.innerHTML = "";
    let imgStick = document.createElement("img");
    imgStick.style.width = "192px";
    imgStick.style.height = "108px";
    let nombre_img = document.getElementById("nombre_img");
    let tamaño_img = document.getElementById("tamaño_img");
    let img = e.target;
    if (img.files.length > 0) {
      let file = img.files[0];
      let name = file.name;
      let sizekb = (file.size / 1024).toFixed(2);
      let sizemb = (file.size / (1024 * 1024)).toFixed(2);
      let intsize = parseFloat(sizemb);
      let srcURL = URL.createObjectURL(file);
      imgStick.src = srcURL;
      nombre_img.textContent = `Nombre: ${name}`;
      tamaño_img.textContent = `Tamaño: ${sizekb} KB / ${sizemb} MB`;
      sectionImg.append(imgStick);
      if (intsize > 3.0) {
        $("#link_diss_img").attr("hidden", false);
        $("#createNewTool").attr("disabled", true);
      }
      if (intsize < 3.0) {
        $("#link_diss_img").attr("hidden", true);
        $("#createNewTool").attr("disabled", false);
      }
    } else {
      $("#link_diss_img").attr("hidden", true);
      sectionImg.innerHTML = "";
      nombre_img.textContent = "";
      tamaño_img.textContent = "";
    }
  });
});
