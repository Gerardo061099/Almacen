/**
 * 
 */

/**
 * 
 */

$(document).ready(function () {
    
    $(document).on('change','#subir_imagen', function (e) {
        e.preventDefault()
        var etiquetaIMG = document.getElementById('etiquetaIMG')
        var nombre_img = document.getElementById('nombre_img')
        var tamaño_img = document.getElementById('tamaño_img')
        var img = e.target
        if (img.files.length > 0) {
            let file = img.files[0]
            let name = file.name
            let sizekb = (file.size / 1024).toFixed(2)
            let sizemb = (file.size / (1024*1024)).toFixed(2)
            let intsize = parseFloat(sizemb)
            let srcURL = URL.createObjectURL(file)
            etiquetaIMG.src = srcURL
            nombre_img.textContent = `Nombre: ${name}`
            tamaño_img.textContent = `Tamaño: ${sizekb} Kb / ${sizemb} Mb`
            if (intsize > 3.00) {
                $('#link_diss_img').attr('hidden', false)
            }
            if (intsize < 3.00) {
                $('#link_diss_img').attr('hidden', true)
            }
        } else{ 
            etiquetaIMG.src = ''
            nombre_img.textContent = ''
            tamaño_img.textContent = ''
        }
    })
})