<?php if (session()->getFlashdata('message')): ?>
    <div>
        <?php echo session()->getFlashdata('message'); ?>
    </div>
<?php endif; ?>


<div class="center">
    <h1 class="h1">Dane użytkownika</h1>
    <label class="label">Nazwa użytkownika: </label> <?php echo $user['username'] ?><br>
    <label class="label">Email: </label><?php echo $user['email'] ?><Br>
    <label class="label">W Event.io od: </label><?php echo $user['created_at'] ?>
    <br>
    <a class="link" href="<?= site_url('user/edit') ?>">Edytuj</a>
    <br>
    <a class="link" href="<?= site_url('user/events') ?>">Moje wydarzenia</a>
</div>