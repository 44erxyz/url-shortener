<?php
require 'load.php';

if (!isset($_GET['c'])) {
    die("❌ Kein Shortcode angegeben.");
}

$shortener = new Shortener($pdo);
$shortCode = $_GET['c'];

$url = $shortener->resolve($shortCode);

if ($url) {
    header("Location: $url");
    exit;
} else {
    echo "❌ Shortlink nicht gefunden.";
}
