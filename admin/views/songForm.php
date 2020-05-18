<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>songForm</title>
</head>
<body>

<?php require ('partials/header.php'); ?>

<?php require ('partials/menu.php'); ?>

ici formulaire du morceau :<br><br>
<small>*champ obligatoire</small>

<?php if(isset($_SESSION['messages'])): ?>
    <div>
        <?php foreach($_SESSION['messages'] as $message): ?>
            <h3><?= $message ?></h3>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="index.php?controller=songs&action=<?= isset($song) || isset($_SESSION['old_inputs']) && $_GET['action'] != 'new' ? 'edit&id='. $_GET['id'] : 'add' ?>" method="post" enctype="multipart/form-data">

    <label for="title">Titre :*</label>
    <!--Lors de l'édition, si il existe un song ou d'anciennes données, on fait correspondre les données afin de pré remplir les champs -->
    <input  type="text" name="title" id="title" value="<?= isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['title'] : '' ?><?= isset($song) ? $song['title'] : '' ?>"/><br>

    <label for="artist">Artiste :*</label>
    <select name="artist" id="artist">
        <!--Lors de l'édition, si il existe un song, on fait correspondre les données afin de pré remplir les champs -->
        <?php foreach ($artists as $artist): ?>
            <option value="<?= $artist['id']; ?>"<?php if(isset($song) && $song['artist_id'] == $artist['id']):?> selected="selected"<?php endif; ?> ><?= $artist['name']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="album">Album :</label>
    <select name="album" id="album">
        <!--Lors de l'édition, si il existe un song, on fait correspondre les données afin de pré remplir les champs -->
        <?php foreach ($albums as $album): ?>
            <option value="<?= $album['id']; ?>"<?php if(isset($song) && $song['album_id'] == $album['id']):?> selected="selected"<?php endif; ?> ><?= $album['name']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <input type="submit" value="Enregistrer" />

</form>

</body>
</html>