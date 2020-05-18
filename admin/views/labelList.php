<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>labelList</title>
</head>
<body>
<?php require ('partials/header.php'); ?>

<?php require ('partials/menu.php'); ?>

<h2>ici la liste complète des labels : </h2>

<?php if(isset($_SESSION['messages'])): ?>
    <div>
        <?php foreach($_SESSION['messages'] as $message): ?>
            <h3><?= $message ?></h3>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!--Afficher tout les labels-->
<?php foreach($labels as $label): ?>
    <p><?=  htmlspecialchars($label['name']) ?>
        <a href="index.php?controller=labels&action=edit&id=<?= $label['id'] ?>">modifier</a>
        <a href="index.php?controller=labels&action=delete&id=<?= $label['id']?>">supprimer</a></p>
<?php endforeach; ?>

</body>
</html>
