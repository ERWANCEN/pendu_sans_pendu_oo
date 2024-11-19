<?php
session_start();
require_once 'autoload.php';

$erreur = "";
$resultat = "";
$lettresTrouvees = $_SESSION['lettresTrouvees'] ?? [];
$propositionPrecedente = $_SESSION['propositions'] ?? [];

if (isset($_POST['nouveauMot']) || !isset($_SESSION['motAleatoire'])) {
    $motAleatoire = new MotAleatoire();
    $_SESSION['motAleatoire'] = $motAleatoire->getMotAleatoire();
    $_SESSION['lettresTrouvees'] = [];
    $_SESSION['propositions'] = [];
    $_SESSION['partieGagnee'] = false;
    $lettresTrouvees = [];
    $propositionPrecedente = [];
} else {
    $motAleatoire = new MotAleatoire($_SESSION['motAleatoire']);
}

if (isset($_POST['tester'])) {
    $proposition = strtoupper(trim($_POST['proposition'] ?? ''));
    $motActuel = $_SESSION['motAleatoire'];

    if (empty($proposition)) {
        $erreur = '<div class="alert alert-danger">Veuillez entrer une lettre ou un mot.</div>';
    } elseif (strlen($proposition) > 1 && $proposition === $motActuel) {
        $resultat = '<div class="alert alert-success text-center">
            <h3>🎉 VICTOIRE ! 🎉</h3>
            <h4>Bravo ! Vous avez trouvé le mot : <strong>'.$motActuel.'</strong></h4>
            <p class="mt-3">Cliquez sur "Nouveau mot" pour rejouer</p>
        </div>';
        $_SESSION['lettresTrouvees'] = str_split($motActuel);
        $_SESSION['partieGagnee'] = true;
    } elseif (strlen($proposition) === 1) {
        if (in_array($proposition, $propositionPrecedente)) {
            $erreur = '<div class="alert alert-warning">Lettre déjà essayée !</div>';
        } else {
            $premiereLettre = $motActuel[0];
            $derniereLettre = $motActuel[strlen($motActuel) - 1];
            $autreLettrePresente = false;
            
            for ($i = 1; $i < strlen($motActuel) - 1; $i++) {
                if ($motActuel[$i] === $proposition) {
                    $autreLettrePresente = true;
                    break;
                }
            }

            if (!$autreLettrePresente && ($proposition === $premiereLettre || $proposition === $derniereLettre)) {
                $erreur = '<div class="alert alert-danger">Cette lettre n\'apparaît pas ailleurs dans le mot !</div>';
                $_SESSION['propositions'][] = $proposition;
            } elseif ($autreLettrePresente) {
                $resultat = '<div class="alert alert-success">Bonne lettre !</div>';
                $_SESSION['lettresTrouvees'][] = $proposition;
                $_SESSION['propositions'][] = $proposition;
            } else {
                $erreur = '<div class="alert alert-danger">Lettre incorrecte !</div>';
                $_SESSION['propositions'][] = $proposition;
            }
        }
    } else {
        $erreur = '<div class="alert alert-danger">Mot incorrect !</div>';
    }
    
    $motAleatoire->setLettresTrouvees($_SESSION['lettresTrouvees']);
    
    // Vérification de la victoire après avoir trouvé une lettre
    if (!array_diff(str_split($motActuel), $_SESSION['lettresTrouvees'])) {
        $resultat = '<div class="alert alert-success text-center">
            <h3>🎉 VICTOIRE ! 🎉</h3>
            <h4>Bravo ! Vous avez trouvé le mot : <strong>'.$motActuel.'</strong></h4>
            <p class="mt-3">Cliquez sur "Nouveau mot" pour rejouer</p>
        </div>';
        $_SESSION['partieGagnee'] = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendu sans pendu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <style>
        .letter-display {
            font-size: 2rem;
            letter-spacing: 0.5rem;
        }
        .propositions {
            font-size: 1.2rem;
            color: #666;
        }
        .wrong-letter {
            color: #dc3545;
        }
        .correct-letter {
            color: #198754;
        }
    </style>
</head>
<body class="container py-4">
    <h1 class="text-center mb-4">Jeu du pendu</h1>
    
    <div class="text-center mb-4">
        <div class="letter-display"><?php echo $motAleatoire->getMotAffiche(); ?></div>
    </div>

    <?php if (!empty($erreur)) echo $erreur; ?>
    <?php if (!empty($resultat)) echo $resultat; ?>

    <?php if (!empty($_SESSION['propositions'])): ?>
    <div class="text-center mb-3 propositions">
        Lettres essayées : 
        <?php foreach ($_SESSION['propositions'] as $lettre): ?>
            <span class="<?php echo in_array($lettre, $_SESSION['lettresTrouvees']) ? 'correct-letter' : 'wrong-letter'; ?>">
                <?php echo $lettre; ?>
            </span>
            &nbsp;
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <form method="post" class="row g-3 justify-content-center">
        <div class="col-auto">
            <input type="text" name="proposition" class="form-control" 
                <?php echo isset($_SESSION['partieGagnee']) && $_SESSION['partieGagnee'] ? 'disabled' : ''; ?>
                placeholder="Lettre ou mot" maxlength="20" autocomplete="off" autofocus>
        </div>
        <div class="col-auto">
            <button type="submit" name="tester" class="btn btn-primary" 
                <?php echo isset($_SESSION['partieGagnee']) && $_SESSION['partieGagnee'] ? 'disabled' : ''; ?>>
                Tester
            </button>
            <button type="submit" name="nouveauMot" class="btn btn-secondary">Nouveau mot</button>
        </div>
    </form>
</body>
</html>
