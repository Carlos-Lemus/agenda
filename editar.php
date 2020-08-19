<?php include "includes/funciones/funciones.php" ?>
<?php include "includes/layout/header.php" ?>

<?php 
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);

    if(!$id) {
        die("El id no es valido");
    }

    $resultado = obtenerContacto($id);
    $contacto = $resultado->fetch_assoc();

?>

<div class="contenedor-barra">

    <div class="contenedor barra">
        <a href="index.php" class="button volver">Volver</a>
        <h1>Editar Contacto</h1>
    </div>
</div>

<div class="bg-amarillo contenedor sombra">
    <form id="contacto" action="#">
    
        <legend>Edite el contacto</legend>

        <?php include "includes/layout/formulario.php" ?>

    </form>
</div>

<?php include "includes/layout/footer.php" ?>

