<?php
include_once 'connection/conexion.php';

// Solo se permite eliminar desde el icono de la tabla (envia el ID por POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$id = (int)($_POST['id'] ?? 0);

try {
    $stmt = $conexion->prepare("DELETE FROM productos WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $eliminados = $stmt->affected_rows;
    $stmt->close();

    $estado = ($eliminados > 0) ? 'eliminado' : 'noexiste';
} catch (mysqli_sql_exception $e) {
    $estado = 'error';
}

header("Location: index.php?estado=" . $estado);
exit();
