<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Hello World!</h1>
            <a href="/login/logout" class="btn btn-danger">Log Out</a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>