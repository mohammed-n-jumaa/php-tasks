<!-- app/views/login.php -->
<?php ob_start(); ?>
<section class="index-login">
    <div class="form-container">
        <h4>LOGIN</h4>
        <p>Already have an account? Login here!</p>
        <form action="/OOPPROJ/public/login.php" method="post">
            <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>
            <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
            <button type="submit" class="btn btn-secondary">LOGIN</button>
        </form>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/layout.php'; ?>
