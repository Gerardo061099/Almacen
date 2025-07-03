<?php

/**
 * 
 */

/**
 * 
 */

function getImgValitation($fileName, $path) {}
function saveImage($pathTMP, $path, $fileName)
{
    move_uploaded_file($pathTMP, "{$path}{$fileName}") ?  true : false;
}
