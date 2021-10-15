<?php
require_once './connec.php';
$pdo = new \PDO(DSN, USER, PASS);
$data = array_map('trim', $_POST);
$data = array_map('htmlentities', $data);
$errors = [];
if (!empty($data)) {
    if (empty($data['firstname'])) {
        $errors['noFirstname'] = 'Le prénom doit être remplis';
    }

    if (strlen($data['firstname']) >= 45) {
        $errors['longFirstname'] = 'Le prénom doit faire moins de 45 charactères';
    }

    if (empty($data['lastname'])) {
        $errors['noLastname'] = 'Le nom doit être remplis';
    }

    if (strlen($data['lastname']) >= 45) {
        $errors['longLastname'] = 'Le nom doit faire moins de 45 charactères';
    }

    if (empty($errors)) {
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];

        $query = 'INSERT INTO  friend (firstname, lastname) VALUES(:firstname, :lastname)';
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

        $statement->execute();

        header('Location: index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO quest</title>
</head>

<body>
    <?php
    $query = 'SELECT * FROM friend';
    $statement = $pdo->query($query);
    $friends = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <ul>
        <?php foreach ($friends as $friend) : ?>
            <li><?= $friend['firstname'] . ' ' . $friend['lastname'] ?></li>
        <?php endforeach ?>
    </ul>

    <form action="" method="POST">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname" placeholder="Firstname">
        <label for="lastname">Nom</label>
        <input type="text" name="lastname" id="lastname" placeholder="Lastname">
        <button>Envoyer</button>
    </form>
</body>

</html>
