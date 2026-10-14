<?php
include_once 'connection/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$codigo = trim($_POST['codigo'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$precio = trim($_POST['precio'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');

if (
    $codigo === '' || $nombre === '' || $descripcion === '' ||
    strlen($codigo) > 20 || strlen($nombre) > 100 ||
    !is_numeric($precio) || $precio < 0 || $precio > 999999.99
) {
    header("Location: index.php?estado=invalido");
    exit();
}
$precio = round((float)$precio, 2);

$imagen = leerImagen('imagen');
if ($imagen === null || $imagen === false) {
    header("Location: index.php?estado=imagen");
    exit();
}

try {
    $stmt = $conexion->prepare(
        "INSERT INTO productos (CODIGO, NOMBRE, PRECIO, DESCRIPCION, IMAGEN) VALUES (?, ?, ?, ?, ?)"
    );
    $vacio = null;
    $stmt->bind_param("ssdsb", $codigo, $nombre, $precio, $descripcion, $vacio);
    $stmt->send_long_data(4, $imagen);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php?estado=guardado");
} catch (mysqli_sql_exception $e) {
    $estado = ($e->getCode() == 1062) ? 'duplicado' : 'error';
    header("Location: index.php?estado=" . $estado);
}
exit();
