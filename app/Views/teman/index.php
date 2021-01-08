<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Daftar Teman</h1>
            <hr>
            <a href="/teman" class="btn btn-success mt-2 ">Refresh</a>
            <br>
            <form action="" method="post" class="mb-2">
                <select class="form-select mt-3  col-sm-2 samping mr-3" aria-label="Default select example" name="nama">
                    <option selected value="">-Pilih Nama-</option>
                    <option value="Maimunah">Maimunah</option>
                    <option value="Restu">Restu</option>
                    <option value="Genta">Genta</option>
                </select>
                <select class="form-select mt-3 mr-3 col-sm-2 samping" aria-label="Default select example" name="alamat">
                    <option selected value="">-Pilih Alamat-</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Bengkulu">Bengkulu</option>
                    <option value="Malang">Malang</option>
                </select>
                <button type="submit" class="btn btn-primary mt-3">Cari</button>
            </form>

            <form action="" method="post" class="mb-1"> 
                <select class="form-select mb-2 mr-3 col-sm-2 samping" aria-label="Default select example" name="page" value="<?= old('page'); ?>">
                    <option selected>-Batas Halaman-</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <button type="submit" class="btn btn-primary mb-2">Mulai</button>
            </form>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (10 * ($currentPage - 1)) ?>
                    <?php foreach ($teman as $t) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $t['nama']; ?></td>
                            <td><?= $t['alamat']; ?></td>
                            <td>
                                <a href="" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?= $pager->links('teman', 'teman_pagination'); ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>