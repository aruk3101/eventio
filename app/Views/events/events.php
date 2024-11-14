<h1 class="h1">Wszystkie Wydarzenia</h1>

<form class="container center" action="<?= site_url('events/events') ?>" method="get">
    <input class="search" width="200px" type="text" name="search" value="<?= esc($search) ?>" placeholder="Szukaj wydarzeń">
    <button class="button" type="submit">Szukaj</button>
</form>

<?php if (!empty($events) && count($events) > 0): ?>
    <ul>
        <?php foreach ($events as $event): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= esc($event['name']) ?>
                        <!-- Status wydarzenia -->
                        <span class="badge <?= $event['is_finished'] ? 'badge-danger' : 'badge-success' ?>">
                            <?= $event['is_finished'] ? 'Nieaktywne' : 'Aktywne' ?>
                        </span>
                    </h5>

                    <p class="card-text">
                        <small class="text-muted">
                            <?= esc($event['start_datetime']) ?> - <?= esc($event['end_datetime']) ?>
                        </small>
                    </p>

                    <p class="card-text"><?= esc($event['description']) ?></p>

                    <div class="d-flex justify-content-between align-items-center flex-column">

                        <!-- Lokalizacja i limit uczestników -->
                        <p class="card-text mb-0">
                            <i class="bi bi-geo-alt-fill me-1"></i> Lokalizacja: <?= esc($event['location_name'] . " - " . $event['location_address']) ?><br>
                            <i class="bi bi-people-fill me-1"></i> Limit uczestników: <?= esc($event['max_participants']) ?>
                        </p>

                        <!-- Link do szczegółów wydarzenia -->
                        <a href="<?= site_url('/events/view/' . $event['event_id']) ?>" class="btn btn-primary btn-sm">
                            Zobacz szczegóły
                        </a>
                    </div>

                    <footer class="blockquote-footer mt-2 text-white">
                        Dodano: <?= esc($event['created_at']) ?> |
                        Ostatnia aktualizacja: <?= esc($event['updated_at']) ?>
                    </footer>
                </div>
            </div>
        <?php endforeach; ?>
    </ul>

    <!-- Paginacja -->
    <div id="pager" class="link">
        <p>Strony</p>
        <?= $pager->links(); ?>
    </div>
<?php else: ?>
    <p>Brak wydarzeń do wyświetlenia.</p>
<?php endif; ?>