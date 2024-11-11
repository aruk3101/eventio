<h1>Dodaj Nowe Wydarzenie</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div>
        <ul style="color:red;">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('events/add/submit') ?>" method="post">

    <label for="name">Nazwa wydarzenia:</label>
    <input type="text" name="name" id="name" value="<?= old('name') ?>" required>
    <br>

    <label for="description">Opis:</label>
    <textarea name="description" id="description" required><?= old('description') ?></textarea>
    <br>

    <label for="start_datetime">Data rozpoczęcia:</label>
    <input type="datetime-local" name="start_datetime" id="start_datetime" value="<?= old('start_datetime') ?>" required>
    <br>

    <label for="end_datetime">Data zakończenia:</label>
    <input type="datetime-local" name="end_datetime" id="end_datetime" value="<?= old('end_datetime') ?>" required>
    <br>

    <label for="location_name">Nazwa miejsca:</label>
    <input type="text" name="location_name" id="location_name" value="<?= old('location_name') ?>" required>
    <br>

    <label for="location_address">Adres miejsca:</label>
    <input type="text" name="location_address" id="location_address" value="<?= old('location_address') ?>" required>
    <br>

    <label for="max_participants">Maksymalna liczba uczestników:</label>
    <input type="number" name="max_participants" id="max_participants" value="<?= old('max_participants') ?>" required>
    <br>

    <button type="submit">Dodaj Wydarzenie</button>
</form>
<a href="<?= site_url('user/') ?>">Powrót do listy wydarzeń</a>