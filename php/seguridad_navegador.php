<?php
session_start();
if (!isset($_SESSION['categoria']) or !isset($_SESSION['user'])) {
header("location:../index.php");
}

?>