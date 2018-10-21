<?php
	require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

	$connector = new WindowsPrintConnector("EPSONTM");
	$printer = new Printer($connector);
	$printer -> initialize();
	$printer -> text("Hello World!\n");
	$printer -> cut();
	$printer -> close();
?>