<div style="min-height: 85vh;" class="d-flex align-items-center justify-content-center container-fluid p-5">
    <form action="<?php echo base_url(); ?>/SignupController/store" method="post"
        class="col-lg-4 col-md-5 col-12 p-5 py-3 shadow-lg bg-white border"
        style="border-radius: 70px; color: #092635;">
        <h4 class="fw-bold py-3 text-success">Register</h4>

        <?php if(session()->getFlashdata('msg')):?>
            <div class="alert alert-warning">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif;?>

        <?php if(isset($validation)):?>
        <div class="alert alert-warning fs-6">
            <?= $validation->listErrors() ?>
        </div>
        <?php endif;?>

        <div class="my-1">
            <label class="form-label fw-bold">Email</label>
            <input value="<?= session()->getFlashdata('data')['email'] ?? null ?>" required type="email" name="email"
                class="form-control form-control-sm border border-1"
                style="height: 45px; border-radius: 18px; padding: 0 30px;">
        </div>
        <div class="my-1">
            <label class="form-label fw-bold">Username</label>
            <input value="<?= session()->getFlashdata('data')['username'] ?? null ?>" required type="text"
                name="username" class="form-control form-control-sm border border-1"
                style="height: 45px; border-radius: 18px; padding: 0 30px;">
        </div>

        <div class="mt-2">
            <label class="form-label fw-bold">Password</label>
            <input value="<?= session()->getFlashdata('data')['password'] ?? null ?>" required type="password"
                name="password" class="form-control form-control-sm border border-1"
                style="height: 45px; border-radius: 18px; padding: 0 30px;">
        </div>

        <div class="form-check my-3">
            <input required name="termsOfService" class="form-check-input" type="checkbox" value="" id="termsOfService">
            <label class="form-check-label" for="termsOfService">
                <a href="">Agree to the Terms and Privacy Policy</a>
            </label>
        </div>


        <div class="d-grid mt-3">
            <button class="btn btn-block btn-sm fw-bold col-5 mx-auto"
                style="height: 45px; border-radius: 18px;letter-spacing: 2px; background: #1B4242; color: #DCF2F1">Register</button>
        </div>

        <div class="mt-3">
            <p class="text-center">
                Already registered? <a href="/login">Login</a>
            </p>
        </div>
    </form>
</div>