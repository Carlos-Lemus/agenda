<?php include "includes/funciones/funciones.php"; ?>
<?php include "includes/layout/header.php"; ?>

<div class="contenedor-barra">
    <h1>Agenda de contactos</h1>
</div>

<div class="bg-amarillo contenedor sombra">
    <form id="contacto" action="#">
    
        <legend>Añade un contacto <span>Todos los campos son obligatorios</span> </legend>

        <?php include "includes/layout/formulario.php" ?>

    </form>
</div>

<div class="bg-blanco contenedor contactos sombra">
    <div class="cotenedor-contactos">
        <h2>Contactos</h2>

        <input type="text" id="buscar"  class="buscador sombra" placeholder="buscar contactos...">

        <p class="total-contactos"><span>2</span> Contactos</p>

        <div class="contedor-tabla">
            <table id="listado-contactos" class="listado-contactos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Empresa</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $contactos = obtenerContactos();
                    ?>

                    <?php foreach($contactos as $contacto) { ?>
                        
                        <tr>
                            <td><?php echo $contacto["nombre"]; ?></td>
                            <td><?php echo $contacto["empresa"]; ?></td>
                            <td><?php echo $contacto["telefono"]; ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $contacto['id']; ?>" class="btn btn-editar">
                                    <i class="fas fa-pen-square"></i>
                                </a>
                                <button class="btn btn-eliminar" id_data="<?php echo $contacto['id']; ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>
        </div>

    </div>
</div>

<?php include "includes/layout/footer.php"; ?>