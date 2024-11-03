<h1>Logowanie użytkownika</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p style="color:red;"><?= esc($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('user/login/submit') ?>" method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?= old('email') ?>" required>

    <label for="password">Hasło:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Zaloguj</button>
</form>