<?php 
    
    if(isset($_POST["accion"])) {
        if($_POST["accion"] == "crear") {
            // creara un nuevo registro en la base de datos
    
            include_once("../funciones/bd.php");
            
            $nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING);
            $empresa = filter_var($_POST["empresa"], FILTER_SANITIZE_STRING);
            $telefono = filter_var($_POST["telefono"], FILTER_SANITIZE_STRING);
    
            try {
                $sql = "INSERT INTO contactos(nombre, empresa, telefono) VALUES(?, ?, ?)";
                
                if($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("sss", $nombre, $empresa, $telefono);
                    $stmt->execute();
    
                    if($stmt->affected_rows == 1) {
                        $respuesta = array(
                            "respuesta" => "correcto",
                            "datos" => array(
                                "nombre" => $nombre,
                                "empresa" => $empresa,
                                "telefono" => $telefono,
                                "info" => $stmt->insert_id
                            )
                        );
    
                    }
                    
                    $stmt->close();
                    $conn->close();
                } else {
                    $respuesta = array (
                        "error" => $conn->errno." ".$conn->error
                    );
    
                }
    
    
            } catch(Exception $ex) {
                $respuesta = array (
                    "error" => $ex->getMessage()
                );
    
            }
    
            echo json_encode($respuesta);
    
        }
    }

    if(isset($_GET["accion"])) {
        if($_GET["accion"] == "borrar") {
            
            $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);

            require_once("../funciones/bd.php");

            $sql = "DELETE FROM contactos WHERE id = ?";

            try {
                if($stmt = $conn->prepare($sql)) {
                    
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    
                    if($stmt->affected_rows == 1) {
                        $respuesta = array(
                            "respuesta" => "correcto"
                        );
                    } else {

                    }
                    
                    $stmt->close();
                    $conn->close();

                } else {
                    $respuesta = array(
                        "exception" => $conn->errno." ".$conn->error
                    );
                }
            } catch (Exception $ex) {
                $respuesta = array(
                    "error" => $ex->getMessage()
                );
            }

            echo json_encode($respuesta);

        }
    }

    if(isset($_POST["accion"])) {
        if($_POST["accion"] == "editar") {
            
            // edito el contacto

            $nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING);
            $empresa = filter_var($_POST["empresa"], FILTER_SANITIZE_STRING);
            $telefono = filter_var($_POST["telefono"], FILTER_SANITIZE_STRING);
            $id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);

            require_once("../funciones/bd.php");

            $sql = "UPDATE contactos SET nombre = ?, empresa = ?, telefono = ? WHERE id = ?";

            try {
                if($stmt = $conn->prepare($sql)) {

                    $stmt->bind_param("sssi", $nombre, $empresa, $telefono, $id);
                    $stmt->execute();
    
                    if($stmt->affected_rows == 1) {
                        $respuesta = array (
                            "respuesta" => "correcto"
                        ); 
                    }

                    $stmt->close();
                    $conn->close();
    
                } else {
                    $respuesta = array (
                        "respuesta" => "error"
                    ); 
                }
            } catch(Exception $ex) {
                $respuesta = array (
                    "respuesta" => "error"
                );              
            }

            echo json_encode($respuesta);

        }
    }

?>