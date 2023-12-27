<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= assets('/images/favicon.ico'); ?>">
    <link rel="stylesheet" href="<?= assets('/css/style.min.css'); ?>">
    <title><?= $this->e("{$title}"); ?></title>
</head>
<body>
    <?= $this->insert('site/partials/header', []); ?>
    <main>
        <?= $this->section('content'); ?>
    </main>
    <?= $this->insert('site/partials/footer',[]); ?>
</body>
</html>
