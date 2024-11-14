<div>

    <?php if (session()->getFlashdata('message')): ?>
        <div>
            <?php echo session()->getFlashdata('message'); ?>
        </div>
    <?php endif; ?>

    <div class="center">
        <a class="link" href="<?php echo site_url() ?>events/add">Dodaj wydarzenie</a><br>
    </div>

    <h1 class="h1">Moje wydarzenia</h1>
    <div class="container">
        <?php if (!empty($events) && count($events) > 0): ?>
            <div>
                <ul>
                    <?php foreach ($events as $event): ?>
                        <li>
                            <div>
                                <a class="link" href="<?= site_url('events/view/' . $event['event_id']) ?>">
                                    <?= esc($event['name']) ?> - <?= esc($event['start_datetime']) ?>
                                </a>
                                <a class="label" href="<?= site_url('events/edit/' . $event['event_id']) ?>">Edytuj</a>
                            </div>

                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="pager" class="link">
                <p>Strony</p>
                <?= $pager->links() ?>
            </div>
        <?php else: ?>
            <div>
                <p>Nie masz żadnych wydarzeń.</p>
            </div>
        <?php endif; ?>
    </div>
</div>