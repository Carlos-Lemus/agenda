<?php 

    // obtiene todos los contactos
    function obtenerContactos(){

        try {

            require_once("bd.php");
            
            $sql = "SELECT * FROM contactos";

            return $conn->query($sql);

        } catch (Exception $ex) {

            echo  $ex.errno." ".$ex.error;        
        }

    }

    //obtiene un unico contacto atravez del id
    function obtenerContacto($id){

        try {

            require_once("bd.php");
            
            $sql = "SELECT * FROM contactos WHERE id = $id";

            return $conn->query($sql);

        } catch (Exception $ex) {

            echo  $ex.errno." ".$ex.error;        
        }

    }

?>