# Liste des Routes de l'API

## 🔑 Authentification
### Login
- **URL** : `/login_check`
- **Méthode** : `POST`
- **Description** : Permet de ce connecter.
- **JSON attendu** :
  ```json
  {
    "email": "utilisateur@example.com",
    "password": "motdepasse"
  }
  ```

## 👥 Gestion des Utilisateurs
### ➕ Ajouter un utilisateur
- **URL** : `/utilisateur`
- **Méthode** :  `POST`
- **Description** : Crée un nouvel utilisateur dans le système.
- **JSON attendu** :
  ```json
    {
      "email": "nouvelutilisateur@example.com",
      "password": "motdepasse",
      "roles": ["ROLE_ETUDIANT"] //role par Defaut si non précisé 
    }
  ```
### 📋 Récupérer la liste des utilisateurs
  - **URL** : /utilisateurs
  - **Méthode**:  GET
  -  **Description** : Renvoie une liste paginée de tous les utilisateurs.

### ✏️ Modifier un utilisateur
  - **URL** :`/utilisateurs/{id}`
  - **Méthode** : `PUT`
  - **Description** : Modifie les informations d’un utilisateur existant.
  - **JSON attendu** :
  ```json
    {
      "email": "utilisateurmisajour@example.com",
      "password": "nouveaumotdepasse",
      "roles": ["ROLE_ADMIN"]
    }
  ``` 
### Mettre à jour un role :
  - **URL** : `/utilisateur/{id}/role`
  - **Méthode** : `PUT`
  - **Description** : Mettre un jour un role d'un utilisateur
  - **Roles Disponible**: 'ROLE_ETUDIANT' , 'ROLE_SUPERVISEUR' , 'ROLE_ADMIN'

### 🗑️ Supprimer un utilisateur
- **URL** : `/utilisateurs/{id}`
  - **Méthode**  `DELETE`
  - **Description** : Supprime un utilisateur spécifique.
  - **JSON attendu** :

## 🚨 Gestion des Alertes
### ➕ Ajouter une alerte
  - **URL** : `/alertes`
  - **Méthode**: `POST`
  -  **Description** : Crée une nouvelle alerte.
  - **JSON attendu** :
  ```json
    {
      "dateEnvoi": "2025-01-23T11:00:35.527Z",
      "statut": 0,
      "historiques": ["/api/historiques/1"]
    }
  ```
### 📋 Récupérer la liste des alertes
  - **URL** : `/alertes`
  - **Méthode** : `GET`
  -  **Description** : Renvoie une liste paginée de toutes les alertes.

### ✏️ Modifier une alerte
  - **URL** : `/alertes/{id}`
  - **Méthode** : `PUT`
  -  **Description** : Modifie les informations d’une alerte existante.
  - **JSON attendu** :
  ```json
  {
  "dateEnvoi": "2025-01-24T10:00:00.000Z",
  "statut": 1,
  "historiques": ["/api/historiques/2"]
  }
  ```

### 🗑️ Supprimer une alerte
  - **URL** : `/alertes/{id}`
  - **Méthode** : `DELETE`
  - **Description** : Supprime une alerte existante.

## 🗂️ Gestion des Cohortes
### ➕ Ajouter une cohorte
  - **URL** : `/cohortes`
  - **Méthode** :` POST`
  -  **Description** : Crée une nouvelle cohorte.
  - **JSON attendu** :
  ```json
  {
  "nom": "Cohorte A",
  "description": "Description de la cohorte A",
  "utilisateurs": ["/api/utilisateurs/1", "/api/utilisateurs/2"]
  }
  ```

### 📋 Récupérer la liste des cohortes
  - **URL** :`/cohortes`
  - **Méthode**  `GET`
  -  **Description** : Renvoie une liste paginée de toutes les cohortes.
 
## 🕒 Gestion des Historiques
### 📋 Récupérer la liste des historiques
  - **URL** :`/historiques`
  - **Méthode**  `GET`
  -  **Description** : Renvoie une liste paginée de tous les historiques.

## 🚫 Gestion de la Blacklist
### ➕ Ajouter un élément à la blacklist
  - **URL** : `/blacklists`
  - **Méthode**:  `POST`
  - **Description** : Ajoute un nouvel élément à la blacklist.
  - **JSON attendu** :
  ```json
  {
  "motif": "Utilisateur spammeur",
  "utilisateur": "/api/utilisateurs/1"
  } 
  ```

### 📋 Récupérer la liste des éléments blacklistés
  - **URL** : `/blacklists`
  - **Méthode**: ` GET`
  -  **Description** : Renvoie une liste paginée de tous les éléments blacklistés.