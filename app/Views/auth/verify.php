<div style="min-height: 85vh;" class="d-flex align-items-center justify-content-center container-fluid">
    <form action="<?php echo base_url(); ?>/SignupController/verifyMail" method="post" class="col-lg-4 col-md-5 col-12 p-5 shadow-lg bg-white border" style="border-radius: 70px; color: #092635;">
        <h4 class="fw-bold py-3 text-success">Email verification:</h4>

        <?php if(session()->getFlashdata('msg')):?>
            <div class="alert alert-warning">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif;?>

        <div class="text-muted text-center">
            <small>We have sent a 6-digit verification code to your Gmail account.</small>
        </div>

        <div class="my-1">
            <label class="form-label fw-bold">Enter 6 digit code: </label>
            <input value="<?= session()->getFlashdata('data')['otp'] ?? null ?>" required type="number" name="otp" class="form-control form-control-sm border border-1" style="height: 45px; border-radius: 18px; padding: 0 30px;">
        </div>

        <div class="d-grid mt-3">
            <button class="btn btn-block btn-sm fw-bold col-5 mx-auto" style="height: 45px; border-radius: 18px;letter-spacing: 2px; background: #1B4242; color: #DCF2F1">Submit</button>
        </div>

        <div class="mt-3">
            <p class="text-center">
                Didn't received mail? <a href="#">Resend</a>
            </p>
        </div>
    </form>
</div>