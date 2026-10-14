<?php
// Hace que los errores de MySQL lancen excepciones (mysqli_sql_exception)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Datos del servidor
$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "GA_Produc";

// Crear conexion usando mysqli
try {
    $conexion = new mysqli($servidor, $usuario, $password, $bd);
    $conexion->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Error de conexion con la base de datos. Verifica que MySQL este encendido y que exista la base GA_Produc.");
}

function mensajeEstado($estado)
{
    if (!is_string($estado)) {
        return null;
    }

    $mensajes = [
        'guardado'    => ['mensaje-ok', 'Producto guardado correctamente.'],
        'actualizado' => ['mensaje-ok', 'Producto actualizado correctamente.'],
        'eliminado'   => ['mensaje-ok', 'Producto eliminado correctamente.'],
        'duplicado'   => ['mensaje-error', 'Ya existe un producto con ese codigo.'],
        'invalido'    => ['mensaje-error', 'Revisa los datos: todos los campos son obligatorios y el precio debe ser un numero valido.'],
        'imagen'      => ['mensaje-error', 'La imagen debe ser JPG, PNG, WEBP o GIF y pesar maximo 2 MB.'],
        'noexiste'    => ['mensaje-error', 'El producto no existe.'],
        'error'       => ['mensaje-error', 'Ocurrio un error inesperado. Intentalo nuevamente.'],
    ];

    return $mensajes[$estado] ?? null;
}

// Lee la imagen subida desde el formulario
function leerImagen($campo)
{
    if (!isset($_FILES[$campo]) || $_FILES[$campo]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES[$campo]['error'] !== UPLOAD_ERR_OK || $_FILES[$campo]['size'] > 2 * 1024 * 1024) {
        return false;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $tipo = $finfo->file($_FILES[$campo]['tmp_name']);
    $permitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

    if (!in_array($tipo, $permitidos, true)) {
        return false;
    }

    return file_get_contents($_FILES[$campo]['tmp_name']);
}

function imagenBase64($contenido)
{
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $tipo = $finfo->buffer($contenido);

    return "data:" . $tipo . ";base64," . base64_encode($contenido);
}
