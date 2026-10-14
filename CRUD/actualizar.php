<?php
include_once 'connection/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$id = (int)($_POST['id'] ?? 0);
$codigo = trim($_POST['codigo'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$precio = trim($_POST['precio'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');

if (
    $id <= 0 ||
    $codigo === '' || $nombre === '' || $descripcion === '' ||
    strlen($codigo) > 20 || strlen($nombre) > 100 ||
    !is_numeric($precio) || $precio < 0 || $precio > 999999.99
) {
    header("Location: editar.php?id=" . $id . "&estado=invalido");
    exit();
}
$precio = round((float)$precio, 2);

$imagen = leerImagen('imagen');
if ($imagen === false) {
    header("Location: editar.php?id=" . $id . "&estado=imagen");
    exit();
}

try {
    if ($imagen !== null) {
        $stmt = $conexion->prepare(
            "UPDATE productos SET CODIGO = ?, NOMBRE = ?, PRECIO = ?, DESCRIPCION = ?, IMAGEN = ? WHERE ID = ?"
        );
        $vacio = null;
        $stmt->bind_param("ssdsbi", $codigo, $nombre, $precio, $descripcion, $vacio, $id);
        $stmt->send_long_data(4, $imagen);
    } else {
        $stmt = $conexion->prepare(
            "UPDATE productos SET CODIGO = ?, NOMBRE = ?, PRECIO = ?, DESCRIPCION = ? WHERE ID = ?"
        );
        $stmt->bind_param("ssdsi", $codigo, $nombre, $precio, $descripcion, $id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: index.php?estado=actualizado");
} catch (mysqli_sql_exception $e) {
    // 1062 = codigo repetido
    $estado = ($e->getCode() == 1062) ? 'duplicado' : 'error';
    header("Location: editar.php?id=" . $id . "&estado=" . $estado);
}
exit();
