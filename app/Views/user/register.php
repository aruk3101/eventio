Zarejestruj się
<h2>Simple Form</h2>

<?php if (session()->getFlashdata('errors')): ?>
    <div>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p style="color:red;"><?= esc($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('user/register/submit') ?>" method="post">

    <label for="username">Nazwa użytkownika:</label>
    <input type="text" name="username" id="username" value="<?= old('username') ?>" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?= old('email') ?>" required>
    <br>
    <label for="password">Hasło:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit">Submit</button>
</form>

<?php if (session()->getFlashdata('message')): ?>
    <div style="color: green;">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php endif; ?>