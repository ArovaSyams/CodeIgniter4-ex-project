<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <a href="/anime/tambah" class="btn btn-primary mt-3">Tambah Data</a>
            <a href="/anime" class="btn btn-success mt-3">Refresh</a>
            <h1 class="mt-2">Daftar Anime</h1>
            <?php if (session()->getFlashData('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashData('pesan'); ?>
                </div>
            <?php endif; ?>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Key Visual</th>
                        <th>Judul</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($anime as $a) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><img src="/img/<?= $a['key_visual']; ?>" alt="" class="poster"></td>
                            <td><?= $a['judul']; ?></td>
                            <td>
                                <a href="anime/<?= $a['slug']; ?>" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>