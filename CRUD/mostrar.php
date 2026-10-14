<?php
include_once 'connection/conexion.php';

$resultado = $conexion->query(
    "SELECT ID, CODIGO, NOMBRE, PRECIO, DESCRIPCION, IMAGEN FROM productos ORDER BY ID ASC"
);

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($fila['CODIGO']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['NOMBRE']) . "</td>";
        echo "<td>S/ " . number_format($fila['PRECIO'], 2) . "</td>";
        echo "<td class='descripcion-tabla' title='" . htmlspecialchars($fila['DESCRIPCION'], ENT_QUOTES) . "'>"
            . htmlspecialchars($fila['DESCRIPCION']) . "</td>";

        // Mostrar imagen en base64
        echo "<td><img src='" . imagenBase64($fila['IMAGEN']) . "' class='imagen-tabla' alt='"
            . htmlspecialchars($fila['NOMBRE'], ENT_QUOTES) . "'></td>";

        echo "<td><div class='acciones'>";
        echo "<a href='editar.php?id=" . $fila['ID'] . "' class='icono-editar' title='Editar'>"
            . "<i class='fa-solid fa-pencil'></i></a>";
        echo "<form action='eliminar.php' method='post' class='form-eliminar' "
            . "onsubmit=\"return confirm('¿Seguro que deseas eliminar este producto?');\">";
        echo "<input type='hidden' name='id' value='" . $fila['ID'] . "'>";
        echo "<button type='submit' class='icono-eliminar' title='Eliminar'>"
            . "<i class='fa-solid fa-xmark'></i></button>";
        echo "</form>";
        echo "</div></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No hay productos registrados</td></tr>";
}
