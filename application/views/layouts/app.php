<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('layouts/_partials/head'); ?>
</head>

<body>
    <script src="<?= base_url("assets/static/js/initTheme.js") ?>"></script>
    <div id="app">
        <?php $this->load->view('layouts/admin/sidebar.php') ?>

        <div id="main" class='layout-navbar navbar-fixed'>
            <?php $this->load->view('layouts/admin/header'); ?>

            <div id="main-content">
                <?= $contents; ?>
            </div>

            <?php $this->load->view('layouts/admin/footer'); ?>
        </div>
    </div>

    <script src="<?= base_url("assets/static/js/components/dark.js") ?>"></script>
    <script src="<?= base_url("assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js") ?>"></script>

    <script src="<?= base_url("assets/compiled/js/app.js") ?>"></script>
    <script src="<?= base_url("assets/extensions/jquery/jquery.min.js") ?>"></script>


    <?php foreach ($scripts as $script) : ?>
        <script src="<?= base_url($script); ?>"></script>
    <?php endforeach; ?>


</body>

</html>