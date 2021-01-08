<?= $this->extend('layout/logintemp'); ?>

<?= $this->section('login'); ?>
<div class="container">
    <div class="row">
        <div class="col-5">
            <h2 class="mt-5">Masuk</h2>
            <form action="/login/loging" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Alamat Email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control is-invalid" id="password" name="password" placeholder="Masukkan Password">
                    <div class="invalid-feedback">
                        Password yang anda masukkan salah
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>