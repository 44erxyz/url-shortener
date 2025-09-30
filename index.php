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
            background-color: #181823;
            background-image: url("data:image/svg+xml;utf8,<svg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'><rect x='0' y='0' width='40' height='40' fill='none'/><path d='M 40 0 L 0 0 L 0 40' stroke='%233a3a5d' stroke-width='1'/></svg>");
            background-size: 30px 30px;
            animation: gridmove 10s linear infinite;
            color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        @keyframes gridmove {
            0% { background-position: 0 0; }
            100% { background-position: 40px 40px; }
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
<?php if ($error): ?>
    <div class="alert alert-danger" role="alert" style="position: absolute; top: 0; left: 0; width: 100%; border-radius: 0;">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>
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
