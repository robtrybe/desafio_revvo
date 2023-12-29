<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= assets('/css/admin.min.css'); ?>">
    <script src="<?= assets('/js/scripts.min.js'); ?>"></script>
    <title><?php $this->e('title'); ?></title>
</head>
<body>
    <?= $this->insert('admin/partials/header', []); ?>
    <main>
        <?= $this->section('content'); ?>
    </main>
</body>
</html>