<!-- app/views/register.php -->
<?php ob_start(); ?>
<section class="index-register">
    <div class="form-container">
        <h4>SIGN UP</h4>
        <p>Don't have an account yet? Sign up here!</p>
        <form action="/OOPPROJ/public/register.php" method="post">
            <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>
            <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
            <input type="password" name="repeat_password" placeholder="Repeat Password" class="form-control mb-3" required>
            <input type="email" name="email" placeholder="E-mail" class="form-control mb-3" required>
            <button type="submit" class="btn btn-primary">SIGN UP</button>
        </form>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/layout.php'; ?>
