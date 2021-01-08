<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Ubah Data Anime</h2>
            <form action="/anime/update/<?= $anime['id']; ?>" method="post" enctype="multipart/form-data">
                <!-- manjaga agar formnya hanya bisa dijalankan disini -->
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" value="<?= $anime['slug']; ?>">
                <input type="hidden" name="key_visualLama" value="<?= $anime['key_visual']; ?>">
                <div class="row mb-3">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value="<?= (old('judul')) ? old('judul') : $anime['judul']; ?>">
                        <div id="judul" class="invalid-feedback">
                            <?= $validation->getError('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="pengarang" class="col-sm-2 col-form-label">Pengarang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('pengarang')) ? 'is-invalid' : ''; ?>" id="pengarang" name="pengarang" value="<?= (old('pengarang')) ? old('pengarang') : $anime['pengarang']; ?>">
                        <div id="judul" class="invalid-feedback">
                            <?= $validation->getError('pengarang'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="studio" class="col-sm-2 col-form-label">Studio</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('studio')) ? 'is-invalid' : ''; ?>" id="studio" name="studio" value="<?= (old('studio')) ? old('studio') : $anime['studio']; ?>">
                        <div id="judul" class="invalid-feedback">
                            <?= $validation->getError('studio'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="key_visual" class="col-sm-2 col-form-label">Key Visual</label>
                    <div class="col-sm-10">
                        <div class="mb-3">
                            <input class="form-control <?= ($validation->hasError('key_visual')) ? 'is-invalid' : ''; ?>" type="file" id="key_visual" name="key_visual" value="<?= $anime['key_visual']; ?>" onchange="previewImg()">
                            <div id="key_visual" class="invalid-feedback">
                                <?= $validation->getError('key_visual'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Ubah Data</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>