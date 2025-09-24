<?php
require 'load.php'; // lädt PDO + Shortener-Klasse

$shortLink = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
    try {
        $shortener = new Shortener($pdo, "http://veyran.net/");
        $shortLink = $shortener->shorten(trim($_POST['url']));
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>44er URL-Shortener</title>
    <!-- Bootstrap 5.3 CSS lokal -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm p-4" style="max-width: 500px; width: 100%;">
        <h1 class="h3 mb-3 text-center">44er URL-Shortener</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="mb-3">
            <div class="mb-3">
                <label for="url" class="form-label">Gib deine URL ein:</label>
                <input type="url" name="url" class="form-control" id="url" placeholder="https://example.com" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Kurzlink erstellen</button>
        </form>

        <?php if ($shortLink): ?>
            <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
                <div>
                    ✅ Dein Shortlink:
                    <a href="redirect.php?c=<?= htmlspecialchars(substr($shortLink, strlen('http://veyran.net/')), ENT_QUOTES, 'UTF-8') ?>" target="_blank">
                        <?= htmlspecialchars($shortLink, ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </div>
                <button class="btn btn-outline-secondary btn-sm" onclick="copyLink()">Kopieren</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap 5.3 JS lokal -->
<script src="js/bootstrap.bundle.min.js"></script>
<script>
    function copyLink() {
        const link = document.querySelector('.alert-success a').href;
        navigator.clipboard.writeText(link).then(() => {
            alert('Shortlink kopiert!');
        });
    }
</script>

</body>
</html>
