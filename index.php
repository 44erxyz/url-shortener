<?php
require 'load.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #181823 0%, #23243a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(10,10,30,0.7);
            background: rgba(24, 24, 35, 0.95);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(60,60,90,0.3);
        }
        .btn-gradient {
            background: linear-gradient(90deg, #23243a 0%, #3a3a5d 100%);
            color: #fff;
            border: none;
            transition: background 0.3s;
        }
        .btn-gradient:hover, .btn-gradient:focus {
            background: linear-gradient(90deg, #3a3a5d 0%, #23243a 100%);
            color: #fff;
        }
        .main-title {
            font-weight: 700;
            letter-spacing: 1px;
            color: #e0e0e0;
            text-shadow: 0 2px 8px #0008;
        }
        .form-label {
            color: #b0b0c0;
        }
        .form-control {
            background: #23243a;
            color: #fff;
            border: 1px solid #3a3a5d;
        }
        .form-control:focus {
            background: #23243a;
            color: #fff;
            border-color: #7f53ac;
        }
        .alert-success, .alert-danger {
            background: #23243a;
            color: #fff;
            border: 1px solid #3a3a5d;
        }
        .alert-success a {
            color: #b388ff;
            text-decoration: underline;
        }
        .alert-success a:hover {
            color: #fff;
        }
        .btn-outline-light {
            border-color: #b388ff;
            color: #b388ff;
        }
        .btn-outline-light:hover {
            background: #b388ff;
            color: #23243a;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-5" style="max-width: 500px; width: 100%;">
        <h1 class="main-title mb-3 text-center">44er URL-Shortener</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="mb-3">
            <div class="mb-3">
                <label for="url" class="form-label">Gib deine URL ein:</label>
                <input type="url" name="url" class="form-control form-control-lg" id="url" placeholder="https://example.com" required>
            </div>
            <button type="submit" class="btn btn-gradient btn-lg w-100">Kurzlink erstellen</button>
        </form>

        <?php if ($shortLink): ?>
            <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
                <div>
                    ✅ Dein Shortlink:
                    <a href="redirect.php?c=<?= htmlspecialchars(substr($shortLink, strlen('http://veyran.net/')), ENT_QUOTES, 'UTF-8') ?>" target="_blank">
                        <?= htmlspecialchars($shortLink, ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </div>
                <button class="btn btn-outline-light btn-sm" onclick="copyLink()">Kopieren</button>
            </div>
        <?php endif; ?>
    </div>
</div>

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
