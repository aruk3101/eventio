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
    <a href="#">Edytuj</a>
</div>