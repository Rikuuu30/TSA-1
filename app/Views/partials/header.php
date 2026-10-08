<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f7f6f2">
    <title><?= esc($pageTitle) ?> · Tasks for Today</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>?v=6">
</head>
<body>
<div class="site-shell">
    <header class="site-header">
        <a class="brand" href="<?= site_url('/') ?>" aria-label="Tasks for Today home">
            <span class="brand-mark" aria-hidden="true"><span></span><span></span><span></span></span>
            <span>Tasks<span class="brand-muted"> for Today</span></span>
        </a>
        <nav class="main-nav" aria-label="Primary navigation">
            <a href="<?= site_url('/') ?>" <?= $activePage === 'home' ? 'aria-current="page"' : '' ?>>Today</a>
            <a href="<?= site_url('tasks') ?>" <?= $activePage === 'tasks' ? 'aria-current="page"' : '' ?>>All tasks</a>
            <a href="<?= site_url('profile') ?>" <?= $activePage === 'profile' ? 'aria-current="page"' : '' ?>>Profile</a>
            <a href="<?= site_url('about') ?>" <?= $activePage === 'about' ? 'aria-current="page"' : '' ?>>About</a>
        </nav>
    </header>
    <main id="main-content">
        <?php if ($message = session()->getFlashdata('success')): ?>
            <div class="flash-message flash-success" role="status"><?= esc($message) ?></div>
        <?php endif; ?>
        <?php if ($message = session()->getFlashdata('error')): ?>
            <div class="flash-message flash-error" role="alert"><?= esc($message) ?></div>
        <?php endif; ?>
