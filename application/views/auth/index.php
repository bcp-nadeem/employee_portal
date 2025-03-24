<div class="min-vh-100 bg-primary d-flex align-items-center">
    <div class="container">
        <div id="alerts-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            <?php if($uploaded = $this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible alert-floating" role="alert">
                    <strong><?php echo $uploaded; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if($uploaded = $this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible alert-floating" role="alert">
                    <strong><?php echo $uploaded; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left side with image -->
                        <div class="col-12 col-md-6 bg-light d-flex align-items-center justify-content-center p-5">
                            <div class="text-center">
                                <img src="<?= base_url('assets/img/logo/bimcap_logo.png') ?>" alt="BIM CAP Logo" class="img-fluid mb-4" style="max-width: 150px;">
                                <h3 class="text-primary fw-bold">Welcome Back!</h3>
                                <p class="text-muted">Access your portal</p>
                            </div>
                        </div>

                        <!-- Right side with form -->
                        <div class="col-12 col-md-6 p-5">
                            <div class="mb-4">
                                <h2 class="fw-bold mb-2 display-6">Login</h2>
                                <p class="text-muted">Please sign-in to your account and start the adventure</p>
                            </div>

                            <?php if($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <?= $this->session->flashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <?= form_open('auth/login/authenticate', ['class' => 'needs-validation', 'novalidate' => '']) ?>
                                <div class="form-floating mb-4">
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="employee_email" 
                                           placeholder="name@example.com"
                                           required>
                                    <label for="email">Email address</label>
                                    <div class="invalid-feedback">
                                        Please enter a valid email address
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password" 
                                           name="emp_password" 
                                           placeholder="Password"
                                           required>
                                    <label for="password">Password</label>
                                    <div class="invalid-feedback">
                                        Please enter your password
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <a href="<?= base_url('forgot-password') ?>" class="text-decoration-none text-primary small">
                                        Forgot password?
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign in
                                </button>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>