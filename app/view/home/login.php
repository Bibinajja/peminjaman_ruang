<?php require_once '../templates/header.php'; ?>

<div class="container">
    <h2>Login</h2>
    <?php if (isset($data['error'])): ?>
        <p class="error"><?php echo $data['error']; ?></p>
    <?php endif; ?>
    <form action="/login" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" class="btn">Login</button>
    </form>
    <p>Belum punya akun? <a href="/register">Register</a></p>
</div>

<?php require_once '../templates/footer.php'; ?>