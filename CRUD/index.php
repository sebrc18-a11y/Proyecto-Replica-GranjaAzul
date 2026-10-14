<?php
include_once 'connection/conexion.php';

$mensaje = mensajeEstado($_GET['estado'] ?? '');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Registro de productos</title>
</head>

<body>
    <main>
        <section class="registro">
            <h2>Registro de productos</h2>

            <?php if ($mensaje): ?>
                <p class="mensaje <?php echo $mensaje[0]; ?>"><?php echo $mensaje[1]; ?></p>
            <?php endif; ?>

            <form action="insertar.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" maxlength="20" required>
                </div>
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" maxlength="100" required>
                </div>
                <div>
                    <label for="precio">Precio (S/):</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0" required>
                </div>
                <div>
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                </div>
                <div>
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp,image/gif" required>
                </div>
                <button type="submit">Registrar</button>
            </form>
        </section>

        <section class="tabla">
            <h2>Productos registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include_once 'mostrar.php'; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>
