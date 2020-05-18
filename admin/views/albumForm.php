<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>albumForm</title>
</head>
<body>

<?php require ('partials/header.php'); ?>

<?php require ('partials/menu.php'); ?>

ici formulaire de l'album :<br><br>
<small>*champ obligatoire</small>

<?php if(isset($_SESSION['messages'])): ?>
    <div>
        <?php foreach($_SESSION['messages'] as $message): ?>
            <h3><?= $message ?></h3>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="index.php?controller=albums&action=<?= isset($album) || isset($_SESSION['old_inputs']) && $_GET['action'] != 'new' ? 'edit&id='. $_GET['id'] : 'add' ?>" method="post" enctype="multipart/form-data">

    <label for="title">Titre :*</label>
    <input  type="text" name="title" id="title" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['title'] : '' ?><?= isset($album) ? $album['name'] : '' ?>"/><br>

    <label for="title">Année :</label>
    <input  type="text" name="year" id="year" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['year'] : '' ?><?= isset($album) ? $album['year'] : '' ?>"/><br>

    <label for="artist">Artiste :*</label>
    <select name="artist" id="artist">
        <?php foreach ($artists as $artist): ?>
            <option value="<?= $artist['id']; ?>"<?php if(isset($album) && $album['artist_id'] == $artist['id']):?> selected="selected"<?php endif; ?> ><?= $artist['name']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <input type="submit" value="Enregistrer" />

</form>

</body>
</html>