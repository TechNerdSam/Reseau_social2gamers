# 🎮 Gamer's Hub - Le Réseau Social pour les Joueurs

Bienvenue sur **Gamer's Hub**, le projet de réseau social ultime conçu par et pour les passionnés de jeux vidéo \! Partagez vos exploits, discutez avec vos amis, et restez à jour sur les dernières tendances du monde du gaming. 🚀

## ✨ Aperçu du Projet

Gamer's Hub est une application web dynamique et entièrement fonctionnelle qui simule un réseau social. Elle est construite avec une pile `PHP / MySQL` pour le backend et `HTML / CSS / JavaScript` pour un frontend interactif et animé.

-----

## 🚀 Fonctionnalités Clés

Ce projet intègre toutes les fonctionnalités attendues d'un réseau social moderne :

  * 👤 **Système d'Authentification Complet :**

      * **Inscription :** Création de compte sécurisée avec hachage des mots de passe.
      * **Connexion :** Accès à la plateforme via un système de sessions PHP.
      * **Déconnexion :** Mettre fin à une session en toute sécurité.

  * 📝 **Fil d'Actualité Dynamique :**

      * Créer des publications avec du texte et des médias (images).
      * Voir un flux de publications de la communauté, chargées depuis la base de données.

  * ❤️ **Interactions Sociales :**

      * Système de "J'aime" sur les publications.
      * Notifications en temps réel (simulées pour les likes).

  * 👤 **Profils Utilisateur :**

      * Pages de profil dédiées affichant les informations de l'utilisateur et ses publications.
      * Lien vers son propre profil dans le menu de navigation.

  * 💬 **Messagerie Privée (Base) :**

      * Interface pour voir la liste des conversations avec d'autres utilisateurs.

  * 🔔 **Centre de Notifications :**

      * Page dédiée pour voir les notifications (par exemple, quand quelqu'un aime une de vos publications).

  * 🎨 **Interface Riche et Animée :**

      * Animations fluides et modernes grâce à la bibliothèque **GSAP (GreenSock Animation Platform)**.
      * Design sombre et immersif, pensé pour les gamers.

-----

## 🛠️ Technologies et Outils

Ce projet a été construit avec une combinaison de technologies web robustes et modernes.

| Domaine | Technologie | Description |
|---|---|---|
| **Backend** |  | Logique serveur, gestion des API et des sessions. |
| **Base de Données** |  | Stockage persistant des utilisateurs, publications, etc. |
| **Frontend** |  | Structure sémantique des pages. |
| **Styling** |  | Design, mise en page et thème sombre. |
| **Interactivité** |  | Logique côté client, appels API (Fetch). |
| **Animations** |  | Animations professionnelles et fluides. |
| **Serveur Local** |  | Environnement de développement Apache + MySQL + PHP. |

-----

## ⚙️ Installation et Lancement

Pour lancer ce projet sur votre machine locale, suivez ces étapes :

1.  **Prérequis :**

      * Assurez-vous d'avoir un environnement de serveur local comme **XAMPP** ou **WAMP** installé.
      * Accès à **phpMyAdmin** ou tout autre client de base de données.

2.  **Cloner le Dépôt :**

    ```bash
    git clone https://github.com/VOTRE_NOM_UTILISATEUR/gamers-hub.git
    ```

3.  **Placer les Fichiers :**

      * Déplacez le dossier cloné dans le répertoire `htdocs` de votre installation XAMPP.

4.  **Configurer la Base de Données :**

      * Lancez **phpMyAdmin** depuis votre panneau de contrôle XAMPP.
      * Créez une nouvelle base de données nommée `gamers_hub_db`.
      * Allez dans l'onglet `SQL` et exécutez le script complet de création de tables fourni dans le projet.

5.  **Configurer la Connexion :**

      * Ouvrez le fichier `config.php`.
      * Modifiez les constantes `DB_USERNAME` et `DB_PASSWORD` pour correspondre à vos identifiants de base de données (par défaut, souvent `root` et un mot de passe vide).

6.  **Lancer l'Application :**

      * Ouvrez votre navigateur et accédez à `http://localhost/gamers-hub/`.
      * Vous devriez voir la page de connexion. Créez un compte et commencez à explorer \! 🎉

-----

## 🏗️ Structure du Projet

Le projet est organisé de manière modulaire pour une maintenance et une évolution faciles.

```
/gamers-hub/
|
|-- api/              # Logique backend (gestion des données)
|-- templates/        # Modèles PHP réutilisables (header, footer...)
|-- uploads/          # Dossier pour les médias uploadés par les utilisateurs
|-- config.php        # Fichier de configuration (BDD, sessions)
|-- index.php         # Page d'accueil (fil d'actualité)
|-- profil.php        # Page de profil
|-- messages.php      # Page de messagerie
|-- notifications.php # Page de notifications
|-- inscription.php   # Page d'inscription
|-- connexion.php     # Page de connexion
|-- deconnexion.php   # Script de déconnexion
|-- script.js         # Logique frontend principale
|-- style.css         # Feuille de style
|-- README.md         # Ce fichier !
```

-----

## 🤝 Contribution

Les contributions sont les bienvenues \! Si vous souhaitez améliorer ce projet, n'hésitez pas à :

1.  **Forker** le dépôt.
2.  Créer une nouvelle branche (`git checkout -b feature/amelioration-geniale`).
3.  **Commiter** vos changements (`git commit -m 'Ajout d'une amélioration géniale'`).
4.  **Pusher** vers la branche (`git push origin feature/amelioration-geniale`).
5.  Ouvrir une **Pull Request**.

-----

## 👨‍💻 Auteur

Ce projet a été conçu et développé avec passion par :

**TechNerdSam (Samyn-Antoy ABASSE)**

  * 📧 **Contact :** [samynantoy@gmail.com](mailto:samynantoy@gmail.com)
  * 🐙 **GitHub :** [TechNerdSam]([(https://github.com/TechNerdSam)])

-----

## 📜 Licence

Ce projet est distribué sous la **Creative Commons Zero v1.0 Universal**. Consultez le fichier `LICENSE` pour plus de détails.
