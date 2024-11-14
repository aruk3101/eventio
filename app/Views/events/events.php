<h1 class="h1">Wszystkie Wydarzenia</h1>

<form class="container center" action="<?= site_url('events/events') ?>" method="get">
    <input class="search" width="200px"  type="text" name="search" value="<?= esc($search) ?>" placeholder="Szukaj wydarzeń">
    <button class="button" type="submit">Szukaj</button>
</form>

<?php if (!empty($events) && count($events) > 0): ?>
    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <a class="link" href="<?= site_url('events/view/' . $event['event_id']) ?>">
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
    <div id="pager" class="link">
    <p>Strony</p>
    <?= $pager->links() ?>
    </div>
<?php else: ?>
    <p>Brak wydarzeń do wyświetlenia.</p>
<?php endif; ?>