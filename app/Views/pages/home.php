<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-4">Hello <?= $uData; ?></h1>
            <hr>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>