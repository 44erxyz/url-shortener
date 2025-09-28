<?php

try {
    $pdo = new PDO(

    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ DB-Fehler: " . $e->getMessage());
}

spl_autoload_register(function ($class) {
    $file = __DIR__ . "/Classes/" . $class . ".php";
    if (file_exists($file)) {
        require_once $file;
    }
});
