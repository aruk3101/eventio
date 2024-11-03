<h1>Edycja profilu</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div>
        <ul style="color:red;">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('user/edit/submit') ?>" method="post">
    <label for="username">Nazwa użytkownika:</label>
    <br>
    <input type="text" name="username" id="username" value="<?= esc($user['username']) ?>" required>
    <br>

    <label for="email">Email:</label>
    <br>
    <input type="email" name="email" id="email" value="<?= esc($user['email']) ?>" required>
    <br>

    <button type="submit">Edytuj</button>
</form>

<a href="<?= site_url('user') ?>">Powrót do profilu użytkownika</a>