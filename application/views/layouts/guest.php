<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('layouts/_partials/head'); ?>

    <link rel="stylesheet" crossorigin href="<?= base_url("assets/compiled/css/auth.css") ?>">

    <?php foreach ($styles as $style) : ?>
        <link rel="stylesheet" crossorigin href="<?= base_url($style); ?>">
    <?php endforeach; ?>
</head>

<body>
    <script src="<?= base_url("assets/static/js/initTheme.js") ?>"></script>

    <div id="auth">
        <?= $contents; ?>
    </div>

    <!-- Scripts -->
    <script src=<?= base_url("assets/extensions/jquery/jquery.min.js") ?>></script>
    <?php foreach ($scripts as $script) : ?>
        <script src="<?= base_url($script); ?>"></script>
    <?php endforeach; ?>
</body>

</html>