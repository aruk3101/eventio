<h1 class="h1">Edycja profilu</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div>
        <ul style="color:red;">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="container" action="<?= site_url('user/edit/submit') ?>" method="post">
    <label class="form-label" for="username">Nazwa użytkownika:</label>
    <br>
    <input class="form-control" type="text" name="username" id="username" value="<?= esc($user['username']) ?>" required>
    <br>

    <label class="form-label" for="email">Email:</label>
    <br>
    <input class="form-control" type="email" name="email" id="email" value="<?= esc($user['email']) ?>" required>
    <br>

    <button class="button" type="submit">Edytuj</button>
</form>
<div class="center">
    <a class="link" href="<?= site_url('user') ?>">Powrót do profilu użytkownika</a>
</div>
