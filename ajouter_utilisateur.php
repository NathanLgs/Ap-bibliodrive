<?php
require_once 'connexion.php';

$erreur = "";
$success = "";

/* Traitement du formulaire */
if (isset($_POST['btnAjouter'])) {

    $mel = trim($_POST['mel'] ?? '');
    $motdepasse = trim($_POST['motdepasse'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $codepostal = $_POST['codepostal'] ?? '';
    $profil = $_POST['profil'] ?? '';

    if ($mel && $motdepasse && $nom && $prenom && $adresse && $ville && $codepostal && $profil) {

        $stmt = $connexion->prepare(
            "INSERT INTO utilisateur
            (mel, motdepasse, nom, prenom, adresse, ville, codepostal, profil)
            VALUES
            (:mel, :motdepasse, :nom, :prenom, :adresse, :ville, :codepostal, :profil)"
        );

        $stmt->execute([
            'mel' => $mel,
            'motdepasse' => $motdepasse,
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'ville' => strtoupper($ville),
            'codepostal' => $codepostal,
            'profil' => $profil
        ]);

        $success = "Utilisateur ajouté avec succès ✅";

    } else {
        $erreur = "Tous les champs sont obligatoires";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="style.css" rel="stylesheet">
</head>

<body class="text-light bg-blur">

<?php include 'entete.php'; ?>

<div class="container mt-5 mb-5">

    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">➕ Ajouter un utilisateur</h3>

        <?php if ($erreur): ?>
            <div class="alert alert-danger"><?= $erreur ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="post">

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="mel" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="text" name="motdepasse" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Adresse</label>
                <input type="text" name="adresse" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Ville</label>
                <input type="text" name="ville" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Code postal</label>
                <input type="number" name="codepostal" class="form-control" required>
            </div>

            <div class="mb-4">
                <label>Profil</label>
                <select name="profil" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    <option value="client">Client</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button name="btnAjouter" class="btn btn-success btn-lg w-100">
                Ajouter l’utilisateur
            </button>

        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
