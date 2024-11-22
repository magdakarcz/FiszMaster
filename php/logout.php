<?php
session_start(); // Rozpoczynamy sesję

// Zniszczenie wszystkich zmiennych sesji
session_unset();

// Zniszczenie sesji
session_destroy();

// Przekierowanie do strony logowania
header("Location: ../views/login.html");
exit();
?>