<h1><?= esc($event['name']) ?></h1>

<!-- Wiadomość zwrotna -->
<?php if (session()->getFlashdata('message')): ?>
    <p style="color: green;"><?= session()->getFlashdata('message') ?></p>
<?php endif; ?>

<p>Opis: <?= esc($event['description']) ?></p>
<p>Data rozpoczęcia: <?= esc($event['start_datetime']) ?></p>
<p>Data zakończenia: <?= esc($event['end_datetime']) ?></p>

<h3>Lokalizacja:</h3>
<p><strong>Nazwa:</strong> <?= esc($event['location_name']) ?></p>
<p><strong>Adres:</strong> <?= esc($event['location_address']) ?></p>


<!-- Formularz do dodawania zdjęć -->
<?php if (session()->get('loggedUser') == $event['created_by_user_id']): ?>
    <h3>Dodaj zdjęcia do wydarzenia</h3>
    <?= form_open_multipart("events/addMedia/{$event['event_id']}") ?>
    <label for="media">Wybierz zdjęcie:</label>
    <input type="file" name="media" id="media" required />
    <button type="submit">Dodaj zdjęcie</button>
    <?= form_close() ?>
<?php endif; ?>

<!-- Lista zdjęć przypisanych do wydarzenia -->
<h3>Zdjęcia wydarzenia</h3>
<ul>
    <?php foreach ($media as $m): ?>
        <li>
            <img src="<?= base_url($m['media_url']) ?>" alt="Media" style="max-width: 150px;" />
            <?php if (session()->get('loggedUser') == $event['created_by_user_id']): ?>
                <a href="<?= base_url("events/deleteMedia/{$m['media_id']}") ?>">Usuń</a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

<!-- Wyświetlenie liczby zapisanych osób -->
<p><strong>Liczba zapisanych osób: </strong><?= $registeredCount ?></p>

<!-- Opcje zapisania i wypisania -->
<?php if ($loggedIn): ?>
    <?php if ($registration): ?>
        <p style="color: green;">Jesteś zapisany na to wydarzenie.</p>
        <a href="<?= site_url('events/unregister/' . $event['event_id']) ?>">Wypisz się</a>
    <?php else: ?>
        <form action="<?= site_url('events/register/' . $event['event_id']) ?>" method="post">
            <label>
                <input type="checkbox" name="is_anonymous" value="1"> Zapisz mnie anonimowo
            </label>
            <br>
            <button type="submit">Zapisz się na wydarzenie</button>
        </form>
    <?php endif; ?>
<?php endif; ?>
<br>

<!-- Skontaktuj się z organizatorem -->
<?php if (isset($organizer['email'])): ?>
    <p>Organizator: <?= esc($organizer['username']) ?></p>
    <a href="mailto:<?= esc($organizer['email']) ?>?subject=Kontakt%20w%20sprawie%20wydarzenia:%20<?= urlencode($event['name']) ?>&body=Dzień dobry%2C%0D%0A%0D%0AChciałbym dowiedzieć się więcej o wydarzeniu '<?= urlencode($event['name']) ?>'.%0D%0A%0D%0ADziękuję." style="color: blue; text-decoration: underline;">
        Skontaktuj się z organizatorem
    </a>
<?php endif; ?>

<br>

<!-- Sekcja zapisanych uczestników dla organizatora -->
<?php if ($isOrganizer && !empty($participants)): ?>
    <h2>Lista uczestników (Widoczne tylko dla organizatora)</h2>
    <ul>
        <?php foreach ($participants as $participant): ?>
            <li>
                <?= $participant['is_anonymous'] ? 'Anonim' : esc($participant['username']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <br>
<?php endif; ?>


<a href="<?= site_url('events/events') ?>">Powrót do listy wydarzeń</a>