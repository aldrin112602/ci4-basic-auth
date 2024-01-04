<div style="min-height: 85vh;" class="d-flex align-items-center justify-content-center container-fluid">
    <form action="<?php echo base_url(); ?>/LoginController/loginAuth" method="post" class="col-lg-4 col-md-5 col-12 p-5 shadow-lg bg-white border" style="border-radius: 70px; color: #092635;">
        <h4 class="fw-bold py-3 text-success">Login</h4>

        <?php if(session()->getFlashdata('msg')):?>
            <div class="alert alert-warning">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif;?>

        <div class="my-1">
            <label class="form-label fw-bold">Username</label>
            <input value="<?= session()->getFlashdata('data')['username'] ?? null ?>" required type="text" name="username" class="form-control form-control-sm border border-1" style="height: 45px; border-radius: 18px; padding: 0 30px;">
        </div>

        <div class="mt-2">
            <label class="form-label fw-bold">Password</label>
            <input value="<?= session()->getFlashdata('data')['password'] ?? null ?>" required type="password" name="password" class="form-control form-control-sm border border-1" style="height: 45px; border-radius: 18px; padding: 0 30px;">
        </div>

        <div class="d-grid mt-3">
            <button class="btn btn-block btn-sm fw-bold col-5 mx-auto" style="height: 45px; border-radius: 18px;letter-spacing: 2px; background: #1B4242; color: #DCF2F1">Log-in</button>
        </div>
    </form>
</div>