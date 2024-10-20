<!-- app/views/index.php -->
<?php ob_start(); ?>
<section class="index-login">
    <div class="row">
        <div class="col-md-6">
            <h4>SIGN UP</h4>
            <p>Don't have an account yet? Sign up here!</p>
            <form action="/public/index.php?action=register" method="post">
                <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>
                <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
                <input type="password" name="repeat_password" placeholder="Repeat Password" class="form-control mb-3" required>
                <input type="email" name="email" placeholder="E-mail" class="form-control mb-3" required>
                <button type="submit" name="submit" class="btn btn-primary">SIGN UP</button>
            </form>
        </div>

        <div class="col-md-6">
            <div class="login-box">
                <h4>LOGIN</h4>
                <p>Already have an account? Login here!</p>
                <form action="/public/index.php?action=login" method="post">
                    <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>
                    <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
                    <button type="submit" name="login" class="btn btn-secondary">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . './layout.php'; ?>
