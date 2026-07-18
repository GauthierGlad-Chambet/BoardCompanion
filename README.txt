# BoardCompanion

Application web permettant aux storyboarders de gérer leurs projets et d'optimiser leur flux de travail.

## Stack technique

- PHP 8.1
- MySQL 9.1
- Apache 2.4
- Docker / Docker Compose

## Prérequis

- [Docker](https://www.docker.com/) et Docker Compose installés
- Git

Aucune installation locale de PHP, Composer ou MySQL n'est nécessaire : tout tourne dans des conteneurs.

## Branches

Ce dépôt utilise deux branches principales :

| Branche | Usage |
|---|---|
| `dev` | Environnement de développement local (code monté en volume, rechargement à chaud) |
| `prod` | Image de production (code embarqué dans l'image, dépendances de prod uniquement) |

---

## Installation — Environnement de développement (`dev`)

### 1. Cloner le dépôt

```bash
git clone https://github.com/GauthierGlad-Chambet/BoardCompanion.git
cd BoardCompanion
git checkout dev
```

### 2. Configurer les variables d'environnement

Deux fichiers `.env` sont nécessaires :

**`.env`** à la racine du projet (utilisé par Docker Compose pour configurer MySQL) :

```dotenv
DB_ROOT_PASSWORD=votre_mot_de_passe_root
DB_NAME=board_companion
DB_USER=board_user
DB_PASSWORD=votre_mot_de_passe
```

**`src/.env`** (utilisé par l'application PHP) :

```dotenv
DB_HOSTNAME=db
DB_DATABASE=board_companion
DB_USERNAME=board_user
DB_PASSWORD=votre_mot_de_passe
```

⚠️ `DB_PASSWORD` doit être identique dans les deux fichiers.

### 3. Lancer les conteneurs

```bash
docker compose up -d --build
```

Le site est alors accessible sur [http://localhost:8080](http://localhost:8080).
Adminer (interface de gestion de la base) est disponible sur [http://localhost:8081](http://localhost:8081).

### 4. Importer un dump de base de données (optionnel)

```bash
docker compose cp votre_fichier.sql db:/dump.sql
docker compose exec db bash -c "mysql --default-character-set=utf8mb4 --init-command=\"SET SESSION sql_mode=''; SET FOREIGN_KEY_CHECKS=0;\" -u root -p'votre_mot_de_passe_root' board_companion < /dump.sql"
```

### 5. Lancer les tests

```bash
docker compose exec web vendor/bin/phpunit
```

---

## Déploiement — Environnement de production (`prod`)

La branche `prod` embarque le code directement dans l'image Docker (pas de bind mount) et n'installe que les dépendances de production (`composer install --no-dev`).

### 1. Cloner le dépôt

```bash
git clone https://github.com/GauthierGlad-Chambet/BoardCompanion.git
cd BoardCompanion
git checkout prod
```

### 2. Configurer les variables d'environnement

Mêmes fichiers `.env` que pour le développement (voir ci-dessus), avec des mots de passe forts et différents de ceux de dev.

### 3. Lancer les conteneurs

```bash
docker compose up -d --build
```

### 4. Importer la base de données

Même procédure que pour le développement (voir section précédente).

> Adminer n'est pas exposé en production pour des raisons de sécurité.

---

## Structure du projet

```
BoardCompanion/
├── src/                    # Code de l'application (PHP, vues, uploads, vendor)
├── Dockerfile              # Image PHP + Apache
├── docker-compose.yml      # Orchestration des services (web, db, adminer en dev)
├── php.ini                 # Configuration PHP (logs, uploads volumineux)
├── apache-uploads.conf     # Autorise les requêtes/uploads volumineux
├── .dockerignore
├── .gitignore
└── .github/workflows/      # Pipeline CI/CD
```

## Intégration continue

Un pipeline GitHub Actions (`.github/workflows/ci.yml`) exécute automatiquement :
- Les tests PHPUnit sur la branche `dev`
- La vérification du build de l'image Docker sur la branche `prod`

## Configuration des uploads volumineux

Les limites suivantes sont définies dans `php.ini` et `apache-uploads.conf`, et peuvent être ajustées selon les besoins :

- `upload_max_filesize` / `post_max_size` : 5 Go
- `memory_limit` : 512 Mo
- `max_execution_time` / `max_input_time` : 300 secondes
- `LimitRequestBody` (Apache) : 5 Go