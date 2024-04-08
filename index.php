<?php
    // Habilitar CORS para todas las solicitudes
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    
    include_once 'views/home.php';

?>