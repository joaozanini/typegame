<?php
session_start();

if (isset($_SESSION['user_id'])) {
    echo "Usuário logado. ID: " . $_SESSION['user_id'];
} else {
    echo "Usuário não está logado.";
}
?>