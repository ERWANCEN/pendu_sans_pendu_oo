<?php
require_once 'autoload.php';

session_start();

if (!isset($partieGagnee)) {
    $partieGagnee = false;
}

// Si "Nouveau Mot" est cliqué, réinitialisez la session et générez un nouveau mot
if (isset($_POST['nouveauMot']) || (!isset($_SESSION['motAleatoire']))) {
    $resetSession = new ResetSession();
    $motAleatoire = new MotAleatoire();
    $_SESSION['motAleatoire'] = $motAleatoire->getMotAleatoire();
    $_SESSION['premiereEtDerniereLettre'] = $motAleatoire->getPremiereEtDerniereLettre();
    $_SESSION['motAffiche'] = $motAleatoire->getMotAffiche();
    $_SESSION['lettresTrouvees'] = $motAleatoire->getLettresTrouvees();
    // $_SESSION['lettresProposees'] = $motAleatoire->getLettresProposees();
    $_SESSION['essaisRestants'] = $motAleatoire->getEssaisRestants();
    
    $_SESSION['partieGagnee'] = false;
}

// Utiliser le mot de la session pour afficher
$motAleatoire = new MotAleatoire($_SESSION['motAleatoire']);



if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['proposition'])) {
    $proposition = new MotAleatoire();
    $proposition->verifierLettre($_POST['proposition'], $_SESSION);
    $proposition->lettresProposees($_POST['proposition']);
    $proposition->lettresTrouvees($_POST['proposition']);
    $_SESSION['motAffiche'] = $motAleatoire->getMotAffiche();
    $_SESSION['lettresTrouvees'] = $motAleatoire->getLettresTrouvees();
}



echo '<pre>';
print_r($_SESSION);
print_r($_POST);
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
        <p class="h2"><?php echo $_SESSION['motAffiche']; ?></p>
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