<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? APP_NAME); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
</head>
<body>
<header class="navbar">
    <div class="container nav-inner">
        <a class="brand" href="<?php echo BASE_URL; ?>/index.php?route=home/index">Smart Municipality</a>
        <nav class="nav-links">
            <a href="<?php echo BASE_URL; ?>/index.php?route=home/index">Carte</a>
            <a href="<?php echo BASE_URL; ?>/index.php?route=signalements/create">Créer</a>
            <a href="<?php echo BASE_URL; ?>/index.php?route=signalements/list">Mes signalements</a>
            <a href="<?php echo BASE_URL; ?>/index.php?route=admin/list">BackOffice</a>
        </nav>
    </div>
</header>

<main class="container main-content">
    <?php if (!empty($flash)): ?>
        <div class="alert <?php echo $flash['type'] === 'success' ? 'alert-success' : 'alert-error'; ?>">
            <?php echo e($flash['message']); ?>
        </div>
    <?php endif; ?>
