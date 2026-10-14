<?php
include_once 'CRUD/connection/conexion.php';

$tituloPagina = "Carta Salon | Granja Azul";
$estiloPagina = 'CSS/estiloCartaSalon.css';
include 'encabezado.php';

$resultado = $conexion->query(
    "SELECT ID, NOMBRE, PRECIO, DESCRIPCION, IMAGEN FROM productos ORDER BY ID ASC"
);
?>

<main class="main-cartasSalon">
    <section class="cuadro-cartas-Salon">
        <h1 class="titulo-Salon">Carta Salon - Granja Azul</h1>

        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <div class="grid-productos-Salon">
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <div class="producto-Salon">
                        <img src="<?php echo imagenBase64($fila['IMAGEN']); ?>" class="imagen-producto-Salon"
                            alt="<?php echo htmlspecialchars($fila['NOMBRE']); ?>">
                        <div class="cuerpo-producto-Salon">
                            <h5 class="nombre-producto-Salon"><?php echo htmlspecialchars($fila['NOMBRE']); ?></h5>
                            <p class="descripcion-producto-Salon"><?php echo htmlspecialchars($fila['DESCRIPCION']); ?></p>
                        </div>
                        <span class="precio-producto-Salon">S/ <?php echo number_format($fila['PRECIO'], 2); ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="vacio-Salon">Próximamente nuevos productos en nuestra carta.</p>
        <?php endif; ?>
    </section>
</main>

<?php include('footer.php'); ?>