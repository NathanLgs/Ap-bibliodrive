<?php

$erreur = "";

/* Déconnexion */
if (isset($_POST['btnSeDeconnecter'])) {
    session_unset();
    session_destroy();
    echo '<meta http-equiv="refresh" content="0">';
    exit;
}

/* Connexion */
if (isset($_POST['btnSeConnecter'])) {
    $mel = $_POST['mel'];
    $mot_de_passe = $_POST['mot_de_passe'];

    if (!empty($mel) && !empty($mot_de_passe)) {
        $stmt = $connexion->prepare(
            "SELECT * FROM utilisateur 
             WHERE mel = :mel 
             AND motdepasse = :motdepasse"
        );

        $stmt->execute([
            'mel' => $mel,
            'motdepasse' => $mot_de_passe
        ]);

        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur) {
            $_SESSION['connecte'] = true;
            $_SESSION['utilisateur'] = [
                'mel' => $utilisateur['mel'],
                'nom' => $utilisateur['nom'],
                'prenom' => $utilisateur['prenom'],
                'adresse' => $utilisateur['adresse'],
                'ville' => $utilisateur['ville'],
                'codepostal' => $utilisateur['codepostal'],
                'profil' => $utilisateur['profil']
            ];
            echo '<meta http-equiv="refresh" content="0">';
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect";
        }
    } else {
        $erreur = "Tous les champs sont obligatoires";
    }
}
?>

<!-- HTML -->
<div class="card p-4 text-light shadow" style="background:#212529">

<?php if (!empty($_SESSION['connecte'])): ?>

    <h4 class="text-center mb-3">
        <?= htmlspecialchars($_SESSION['utilisateur']['prenom']) ?> 
        <?= htmlspecialchars($_SESSION['utilisateur']['nom']) ?>
    </h4>

    <ul class="list-group mb-3">
        <li class="list-group-item">Email : <?= htmlspecialchars($_SESSION['utilisateur']['mel']) ?></li>
        <li class="list-group-item">Ville : <?= htmlspecialchars($_SESSION['utilisateur']['ville']) ?></li>
        <li class="list-group-item">Profil : <?= htmlspecialchars($_SESSION['utilisateur']['profil']) ?></li>
    </ul>

    <!-- Bouton pour modal de deco -->
    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#confirmLogoutModal">
        Se déconnecter
    </button>

    <!-- Modal de deco -->
    <div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-labelledby="confirmLogoutLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmLogoutLabel">Confirmation de déconnexion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir vous déconnecter ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form method="post" class="d-inline">
                        <button name="btnSeDeconnecter" class="btn btn-danger">Oui, se déconnecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>

    <!-- Formulaire de connexion -->
    <h4 class="text-center mb-3">Connexion</h4>

    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="mel" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" required>
        </div>
        <button name="btnSeConnecter" class="btn btn-primary w-100">
            Se connecter
        </button>
    </form>

<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


