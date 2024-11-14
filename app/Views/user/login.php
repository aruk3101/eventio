<h1 class="h1">Logowanie użytkownika</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p style="color:red;"><?= esc($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form class="container" action="<?= site_url('user/login/submit') ?>" method="post">
    <label class="form-label" for="email">Email:</label>
    <input class="form-control" type="email" name="email" id="email" value="<?= old('email') ?>" required>
    <br>
    <label class="form-label" for="password">Hasło:</label>
    <input class="form-control" type="password" name="password" id="password" required>
    <br>
    <button class="button" type="submit">Zaloguj</button>
</form>

<div class="center">
    <a class="link" href="<?= site_url('user/register') ?>">Nie masz konta? Zarejestruj się!</a>
</div>