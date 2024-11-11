<h1>Wszystkie Wydarzenia</h1>

<form action="<?= site_url('events/events') ?>" method="get">
    <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Szukaj wydarzeń">
    <button type="submit">Szukaj</button>
</form>

<?php if (!empty($events) && count($events) > 0): ?>
    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <a href="<?= site_url('events/view/' . $event['event_id']) ?>">
                    <?= esc($event['name']) ?> - <?= esc($event['start_datetime']) ?>
                </a>
                <?php if ($event['is_finished']): ?>
                    <span style="color: red;">(Wydarzenie zakończone)</span>
                <?php else: ?>
                    <span style="color: green;">(Wydarzenie aktywne)</span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Paginacja -->
    <?= $pager->links() ?>
<?php else: ?>
    <p>Brak wydarzeń do wyświetlenia.</p>
<?php endif; ?>

<a href="<?= site_url('') ?>">Powrót do panelu</a>