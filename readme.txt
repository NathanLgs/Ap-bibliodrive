📕 BiblioDrive

Auteur : Nathan Le Gallais
Classe : SIO1 Rabelais – Année 2025/2026

BiblioDrive est une application web de gestion de bibliothèque en ligne, permettant aux utilisateurs de consulter un catalogue de livres, de gérer un panier et d’emprunter des livres. L’application inclut également une interface d’administration pour gérer les utilisateurs et les livres.

Technologies utilisées

Back-end : PHP 8.x, PDO pour la connexion sécurisée à MySQL

Base de données : MySQL

Front-end : HTML5, CSS3, Bootstrap 5

Sessions PHP : pour la gestion des utilisateurs et du panier



Fonctionnalités principales
1️⃣ Gestion des utilisateurs

Inscription / ajout utilisateur (admin)

Formulaire pour ajouter un utilisateur avec email, mot de passe, nom, prénom, adresse, ville, code postal et profil (client ou admin).

Données enregistrées dans la table utilisateur.

Connexion / déconnexion

Les utilisateurs se connectent via email et mot de passe.

Les informations de session permettent de personnaliser l’interface et gérer les droits d’accès.

Déconnexion avec confirmation via modal Bootstrap.



2️⃣ Gestion des livres

Affichage du catalogue

Liste des livres avec tri et filtrage par auteur.

Les livres s’affichent sous forme de cartes Bootstrap avec image, titre et année.

Modal détaillée pour voir le résumé complet, auteur, ISBN et image du livre.

Ajout de livres (admin)

Formulaire permettant à l’administrateur d’ajouter un nouveau livre.

Si l’auteur n’existe pas, il est automatiquement ajouté à la table auteur.

Les informations sont stockées dans la table livre (titre, auteur, ISBN, année, description, photo).



3️⃣ Panier et emprunt

Les utilisateurs peuvent ajouter des livres à leur panier (maximum 5 livres).

Gestion des actions : ajouter, supprimer ou valider le panier.

Lors de la validation :

Vérification que l’utilisateur n’a pas déjà plus de 5 livres empruntés simultanément.

Les livres sont enregistrés dans la table emprunter avec date d’emprunt et date de retour NULL.

Le panier est ensuite vidé.



4️⃣ Interface de navigation

Barre de navigation responsive :

Logo et lien vers la page d’accueil.

Recherche par nom d’auteur.

Boutons conditionnels visibles uniquement pour les admins :

Ajouter un livre

Ajouter un utilisateur

Bouton Panier pour les utilisateurs connectés, affichant le nombre de livres dans le panier.

Base de données