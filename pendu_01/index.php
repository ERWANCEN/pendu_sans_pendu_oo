<?php
require_once 'autoload.php';



$motAleatoire = new MotAleatoire();
// $motAleatoire->getMotADeviner();

$session = new Session($_SESSION);
echo '<pre>';
print_r($session);
echo '</pre>';
echo '<pre>';
print_r($_POST);
echo '</pre>';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

$completion = new CompletionMot();

if (isset($_POST) || !empty($_POST['lettresProposees'])) {
    $lettreProposee = new LettresProposees($_POST, $_SESSION);
}

echo '<pre>';
print_r($_SERVER);
echo '</pre>';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendu sans pendu</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="d-flex justify-content-center">
        <h1>Jeu du pendu (sans pendu...)</h1>
    </div>
    <hr>
    <div class="d-grid justify-content-center">
        <p class="h2"><?php echo $motAleatoire->getMotCache(); ?></p>
    </div>
    <div class="d-flex justify-content-center">
        aaaaa
    </div>
    <form action="" method="post" class="w-75 d-grid mx-auto">
        <div class="mb-3">
            <input type="text" name="proposition" placeholder="Entrez une lettre ici ou le mot entier" 
                class="form-control">
        </div>
        <div class="d-grid gap-3">
            <button type="submit" name="tester" class="btn btn-success">Tester</button>
            <button type="submit" name="nouveauMot" class="btn btn-info">Nouveau Mot</button>
        </div>       
    </form>
</body>
</html>