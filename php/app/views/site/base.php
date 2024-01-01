<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= assets('/images/favicon.ico'); ?>" />
    <link rel="stylesheet" href="<?= assets('/css/site.min.css'); ?>">
    <script src="<?= assets('/js/scripts.min.js'); ?>"></script>
    <title><?= $this->e("{$title}"); ?></title>
</head>
<body>
    <?= $this->insert('site/partials/header', []); ?>
    <main>
        <div style="width:100%;"><?= session()->flash(); ?></div>
        <?= $this->section('content'); ?>
    </main>
    <?= $this->insert('site/partials/footer',[]); ?>
</body>
</html>
