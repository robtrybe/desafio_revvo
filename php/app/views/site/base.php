<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= assets('/images/favicon.ico'); ?>">
    <title><?= $this->e("{$title}"); ?></title>
</head>
<body>
    <?= $this->section('content'); ?>
</body>
</html>
