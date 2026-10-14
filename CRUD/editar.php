<?php
include_once 'connection/conexion.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $conexion->prepare(
    "SELECT ID, CODIGO, NOMBRE, PRECIO, DESCRIPCION, IMAGEN FROM productos WHERE ID = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$fila = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$fila) {
    header("Location: index.php?estado=noexiste");
    exit();
}

$mensaje = mensajeEstado($_GET['estado'] ?? '');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Editar producto</title>
</head>

<body>
    <main class="main-editar">
        <section class="registro registro-editar">
            <h2>Editar producto</h2>

            <?php if ($mensaje): ?>
                <p class="mensaje <?php echo $mensaje[0]; ?>"><?php echo $mensaje[1]; ?></p>
            <?php endif; ?>

            <form action="actualizar.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $fila['ID']; ?>">
                <div>
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" maxlength="20"
                        value="<?php echo htmlspecialchars($fila['CODIGO']); ?>" required>
                </div>
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" maxlength="100"
                        value="<?php echo htmlspecialchars($fila['NOMBRE']); ?>" required>
                </div>
                <div>
                    <label for="precio">Precio (S/):</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0"
                        value="<?php echo $fila['PRECIO']; ?>" required>
                </div>
                <div>
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4"
                        required><?php echo htmlspecialchars($fila['DESCRIPCION']); ?></textarea>
                </div>
                <div>
                    <label>Imagen actual:</label>
                    <img src="<?php echo imagenBase64($fila['IMAGEN']); ?>" class="imagen-actual"
                        alt="<?php echo htmlspecialchars($fila['NOMBRE']); ?>">
                    <label for="imagen">Nueva imagen (opcional):</label>
                    <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp,image/gif">
                </div>
                <button type="submit">Actualizar</button>
                <a href="index.php" class="boton-cancelar">Cancelar</a>
            </form>
        </section>
    </main>
</body>

</html>
