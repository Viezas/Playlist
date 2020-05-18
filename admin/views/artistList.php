<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>artistList</title>
</head>
<body>
<?php require ('partials/header.php'); ?>

<?php require ('partials/menu.php'); ?>

<?php if(isset($_SESSION['messages'])): ?>
    <div>
        <?php foreach($_SESSION['messages'] as $message): ?>
            <h3><?= $message ?></h3>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<h2>ici la liste complète des songs : </h2>

<?php foreach($artists as $artist): ?>
    <p><?=  htmlspecialchars($artist['name']) ?>
        <a href="index.php?controller=artists&action=edit&id=<?= $artist['id'] ?>">modifier</a>
        <a href="index.php?controller=artists&action=delete&id=<?= $artist['id'] ?>">supprimer</a></p>
<?php endforeach; ?>

</body>
</html>

