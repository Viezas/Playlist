<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>labelForm</title>
</head>
<body>
<?php require ('partials/header.php'); ?>
<?php require ('partials/menu.php'); ?>



ici formulaire du label :<br><br>
<small>*champ obligatoire</small>

<?php if(isset($_SESSION['messages'])): ?>
    <div>
        <?php foreach($_SESSION['messages'] as $message): ?>
            <h3><?= $message ?></h3>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="index.php?controller=labels&action=<?= isset($label) || isset($_SESSION['old_inputs']) && $_GET['action'] != 'new' ? 'edit&id='. $_GET['id'] : 'add' ?>" method="post" enctype="multipart/form-data">

    <label for="title">Nom :*</label>
    <!--Lors de l'édition, si il existe un label ou d'anciennes données, on fait correspondre les données afin de pré remplir les champs -->
    <input  type="text" name="name" id="name" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['name'] : '' ?><?= isset($label) ? $label['name'] : '' ?>"/><br>

    <input type="submit" value="Enregistrer" />

</form>
</body>
</html>