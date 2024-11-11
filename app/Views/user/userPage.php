Strona zalogowanego użytkownika

<?php if (session()->getFlashdata('message')): ?>
    <div>
        <?php echo session()->getFlashdata('message'); ?>
    </div>
<?php endif; ?>


<div>
    <h1>Dane użytkownika</h1>
    Nazwa użytkownika : <?php echo $user['username'] ?><br>
    Email : <?php echo $user['email'] ?><Br>
    W Event.io od : <?php echo $user['created_at'] ?>
    <br>
    <a href="<?= site_url('user/edit') ?>">Edytuj</a>
    <br>
    <a href="<?= site_url('user/events') ?>">Moje wydarzenia</a>
</div>