<?php
require_once './connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

$pdo->exec($query);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $friend = array_map('trim', $_POST);

    $maxFirstnameLength = 45;
    if (strlen($friend['firstname']) > $maxFirstnameLength) {
        $errors[] = 'Le firstname doit faire moins de' . $maxfirstnameLength;
    }
    $maxlastnameLength = 45;
    if (strlen($friend['lastname']) > $maxlastnameLength) {
        $errors[] = 'Le lastname doit faire moins de' . $maxlastnameLength;
    }

    if (empty($errors)) {
        $query = "INSERT INTO friend (firstname, lastname) VALUES ('$firstname', '$lastname')";
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
    <title>Document</title>
</head>

<body>

    <h1>List of Friends</h1>

    <ul>
        <?php foreach ($friends as $friend) : ?>
            <li>
                <?= $friend['firstname'] . " " . $friend['lastname']  ?>
            </li>
        <?php endforeach ?>
    </ul>

    <form action="" method="POST" novalidate>
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" id="firstname" required>
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" id="lastname" required>
        <button>Envoyer</button>
    </form>

</body>

</html>