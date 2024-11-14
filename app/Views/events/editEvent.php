<h1 class="h1">Edytuj Wydarzenie</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <div style="color: red;">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p><?= esc($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form class="container" action="<?= site_url('events/update/' . $event['event_id']) ?>" method="post">

    <label class="form-label" for="name">Nazwa wydarzenia:</label>
    <input class="form-control" type="text" id="name" name="name" value="<?= esc($event['name']) ?>" required><br>
    <br>

    <label class="form-label" for="description">Opis:</label>
    <textarea class="form-control" id="description" name="description" required><?= esc($event['description']) ?></textarea><br>
    <br>

    <label class="form-label" for="start_datetime">Data rozpoczęcia:</label>
    <input class="form-control" type="datetime-local" id="start_datetime" name="start_datetime" value="<?= date('Y-m-d\TH:i', strtotime($event['start_datetime'])) ?>" required><br>
    <br>

    <label class="form-label" for="end_datetime">Data zakończenia:</label>
    <input class="form-control" type="datetime-local" id="end_datetime" name="end_datetime" value="<?= date('Y-m-d\TH:i', strtotime($event['end_datetime'])) ?>" required><br>
    <br>

    <label class="form-label" for="location_name">Nazwa miejsca:</label>
    <input class="form-control" type="text" name="location_name" id="location_name" value="<?= esc($event['location_name']) ?>" required>
    <br>

    <label class="form-label" for="location_address">Adres miejsca:</label>
    <input class="form-control" type="text" name="location_address" id="location_address" value="<?= esc($event['location_address']) ?>" required>
    <br>

    <label class="form-label" for="max_participants">Maksymalna liczba uczestników:</label>
    <input class="form-control" type="number" id="max_participants" name="max_participants" value="<?= esc($event['max_participants']) ?>" required><br>
    <br>

    <button type="submit" class="button">Zapisz</button>
</form>
<div class="center">
    <a class="link" href="<?= site_url('/user/events') ?>">Powrót do moich wydarzeń</a>
</div>