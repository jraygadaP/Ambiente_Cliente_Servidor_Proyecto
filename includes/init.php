<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar la sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
