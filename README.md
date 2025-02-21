# PEC-S1

**Collaborateurs du projet :**

- MALLET YOANN, compte associé = [Yolvwar]
- CHAMEN Sohane, compte associé = []
- MBOSSA Jonathan, compte associé = []

## Sommaire

1. [Convention de commits du projet : atomic commit](#convention-de-commits--commits-atomiques)
2. [Procédure de lancement du projet en local](#procédure-de-lancement-du-projet-en-local)
3. [Fonctionnalités présentes](#fonctionnalités-présentes-)
3. [Commits Autosignés avec GPG](#commits-autosignés-avec-gpg)
4. [Accéder à la base de données via MySQL CLI](#accéder-à-la-base-de-données-via-mysql-cli)

---

## Convention de commits : Commits Atomiques

Pour qu'on s'y retrouve tous et que le repo soit lisible et simple a travailler avec on va faire des **commit atomique**

Voici quelques exemples de commits récurrents :

- **`feat(exemple):`** Ajouter une nouvelle fonctionnalité.  
  _Exemple :_

  ```
  feat(auth): Add login functionality with password encrypt
  ```

- **`fix(exemple):`** Corriger un bug.  
  _Exemple :_

  ```
  fix(auth): Resolve login expiration issue
  ```

- **`docs(exemple):`** Mettre à jour la documentation.  
  _Exemple :_
  ```
  docs(README): Update GPG commit configuration guide
  ```

**Soyez clair et concis**. Un bon message de commit décrit ce qui a été fait et pourquoi cela a été fait.

## Fonctionnalités présentes :

Fonctionnalités Présentes
1. Authentification et Gestion des Utilisateurs
Inscription et Connexion

Système complet de création de compte avec vérification d'identité
Gestion de profil utilisateur personnalisable
Processus d'authentification sécurisé avec validation par email
Interface de gestion du profil utilisateur

2. Gestion des Demandes de Réparation
Création de Demande

Interface intuitive pour la sélection du type de service :

Réparation standard
Service d'entretien
Dépannage d'urgence


Système d'ajout d'une localisation
Sélection de plages horaires disponibles

Système de Devis

Génération automatique de devis préliminaire avec tarification de base
Calcul dynamique des coûts via GEOCODING (après assignation d'un technicien a la demande):
Évaluation de la distance entre le technicien et le lieu d'intervention
Ajustement automatique du prix en fonction de la distance

Suivi et Communication

Système de suivi des demandes avec historique complet
Notifications automatiques par email pour :

Confirmation de la demande
Acceptation de l'intervention

Système d'Évaluation

Notation des prestations des techniciens
Laissez un commentaire sur la prestations
Collecte des retours d'expérience clients

3. Interface Administrateur
Tableau de Bord Analytique

Suivi en temps réel des performances :

Nombre total d'interventions
Indices de satisfaction client
Taux de fidélisation
Graphiques
Statistiques de retour client


Analyse financière détaillée :

Revenus par période
Performance par technicien


Gestion des Entités
Interface administrative complète pour la gestion de :

Comptes utilisateurs
Demandes de réparation
Équipe de techniciens
Catalogue de services

Gestion Opérationnelle

Système d'attribution des interventions :

Assignation des techniciens aux demandes
Gestion des disponibilités
Suivi des interventions en cours
Validation et suivi des demandes de réparation

## Procédure de lancement du projet en local

Pour lancer le projet en local, suivez les étapes suivantes :

1. Démarrez les conteneurs Docker :

```bash
   docker-compose up -d
```

2. Accéder au conteneur de la bd :

```bash
docker exec -it php-app-db mysql -u user -p
```

3. Lancer le script init_database

```bash
mysql -u root -p < /app/init_database.sql
```

## Commits Autosignés avec GPG

Le projet demande que tous les commits soient signés. Vous pouvez passer par une signature avec une **clé SSH** si vous avez déjà fait une configuration auparavant. Cependant, si vous n'avez jamais configuré votre signature de commit, vous pouvez suivre cette méthode plutôt simple avec **GPG**.

### 1. **Installer GPG**

Assurez-vous que GPG est installé sur votre machine. Sous Linux, vous pouvez l'installer avec :

```bash
sudo apt install gnupg
```

Sur Windows, vous pouvez trouver l'installer GPG ici : https://gpg4win.org/

### 2. **Générer une clé GPG**

Pour générer une nouvelle clé GPG :

```bash
gpg --full-generate-key
```

### 3. **Lister vos clés GPG**

Une fois votre clé générée, listez-la pour obtenir son identifiant :

```bash
gpg --list-secret-keys --keyid-format=long
```

Exemple de sortie :

```
sec   rsa4096/ABCDEF1234567890 2024-12-03 [SC]
```

Notez l’identifiant de la clé (`ABCDEF1234567890` dans cet exemple).

### 4. **Configurer votre clé dans Git**

Ajoutez cette clé à votre configuration Git pour qu’elle soit utilisée pour signer vos commits :

```bash
git config --global user.signingkey ABCDEF1234567890
```

### 5. **Exporter votre clé publique pour GitHub**

Exportez votre clé publique pour l’ajouter à votre compte GitHub :

```bash
gpg --armor --export yoann.mallet@eemi.com
```

### 6. **Configurer Git pour utiliser GPG**

Assurez-vous que Git utilise GPG et non SSH pour les signatures :

```bash
git config --global gpg.format openpgp
```

### 7. **Ajouter votre clé publique à GitHub**

Ajoutez votre clé publique exportée à votre compte GitHub en suivant ce lien :  
[Github: ajouter la clé GPG dans les settings](https://github.com/settings/keys)

### 8. **Activer les commits signés automatiquement**

Pour que tous vos commits soient signés automatiquement, configurez Git ainsi :

```bash
git config --global commit.gpgsign true
```

### 9. **Vérifier vos commits signés**

Après avoir effectué un commit, vous pouvez vérifier que la signature est valide avec :

```bash
git log --show-signature
```

Si tout est correctement configuré, vous verrez un message comme celui là :

```
Good "gpg" signature for {username}
```

---

## Accéder à la base de données via MySQL CLI

Pour interagir directement avec la base de données MySQL de l'application via la ligne de commande, suivez les étapes ci-dessous :

### 1. **Se connecter au conteneur MySQL**

Utilisez la commande suivante pour accéder au conteneur MySQL via Docker :

```bash
docker exec -it php-app-db mysql -u user -p
```

Vous serez invité à entrer le mot de passe. Tapez le mot de passe configuré dans le fichier `docker-compose.yml` (par défaut : `password`).

### 2. **Sélectionner la base de données**

Une fois connecté à MySQL, utilisez la commande suivante pour accéder à la base de données :

```sql
USE db;
```

### 3. **Vérifier les tables**

Pour afficher les tables disponibles dans la base de données :

```sql
SHOW TABLES;
```

### 4. **Effectuer des requêtes SQL**

Vous pouvez maintenant exécuter des requêtes SQL sur la base de données, par exemple :

```sql
SELECT * FROM users;
```

---
