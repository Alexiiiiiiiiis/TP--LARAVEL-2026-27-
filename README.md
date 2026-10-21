# MCB Bank – Arborescence de l'application

Site de banque en ligne réalisé avec Laravel et Blade, à partir des templates fournis.
Trois espaces : **client**, **manager**, **caissier**.

## Lancer le projet

```sh
php artisan migrate:fresh --seed   # crée les tables + données de démonstration
php artisan serve                  # http://localhost:8000
```

| Rôle     | Email                 | Mot de passe |
|----------|-----------------------|--------------|
| Client   | ali@mcbbank.com       | ali          |
| Manager  | manager@mcbbank.com   | manager      |
| Caissier | cashier@mcbbank.com   | cashier      |

## Arborescence (fichiers créés ou modifiés pour le TP)

```
TP-Laravel-2026-27/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php         # connexion / déconnexion (3 rôles)
│   │   │   ├── ClientController.php       # pages client : accueil, compte, relevé, notifications, feedback
│   │   │   ├── TransferController.php     # transfert de fonds entre comptes
│   │   │   ├── FeedbackController.php     # envoi (client) et suppression (manager) des feedbacks
│   │   │   ├── ManagerController.php      # pages manager : comptes, caissiers, nouveau compte, feedbacks
│   │   │   ├── AccountController.php      # création, détails et suppression d'un compte client
│   │   │   ├── StaffController.php        # CRUD des caissiers
│   │   │   ├── NoticeController.php       # notifications envoyées par le manager à un client
│   │   │   └── CashierController.php      # espace caissier : recherche de compte, dépôt, retrait
│   │   └── Middleware/
│   │       └── CheckRole.php              # protège chaque espace selon le rôle connecté
│   └── Models/
│       ├── Account.php                    # compte bancaire d'un client
│       ├── Branch.php                     # agence
│       ├── Staff.php                      # manager / caissier
│       ├── Transaction.php                # opération (dépôt, retrait, virement)
│       ├── Feedback.php                   # message d'un client
│       └── Notice.php                     # notification de la banque
├── bootstrap/
│   └── app.php                            # enregistrement du middleware "role"
├── database/
│   ├── database.sqlite                    # base de données SQLite
│   ├── migrations/
│   │   ├── 2026_10_21_100000_create_branches_table.php
│   │   ├── 2026_10_21_100001_create_accounts_table.php
│   │   ├── 2026_10_21_100002_create_staff_table.php
│   │   ├── 2026_10_21_100003_create_transactions_table.php
│   │   ├── 2026_10_21_100004_create_feedbacks_table.php
│   │   └── 2026_10_21_100005_create_notices_table.php
│   └── seeders/
│       └── DatabaseSeeder.php             # données de démonstration
├── public/
│   └── frontend/                          # assets du template
│       ├── css/                           # bootstrap + custom.css
│       ├── js/                            # jquery, popper, bootstrap
│       ├── font-awesome/                  # icônes
│       └── images/
│           └── clients/                   # photos des clients (upload)
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── master.blade.php           # structure HTML commune (head, css, js)
│       │   ├── client.blade.php           # master + navbar client
│       │   ├── manager.blade.php          # master + navbar manager
│       │   ├── cashier.blade.php          # master + navbar caissier
│       │   └── partials/
│       │       ├── navbar_client.blade.php
│       │       ├── navbar_manager.blade.php
│       │       ├── navbar_cashier.blade.php
│       │       └── alerts.blade.php       # messages de succès / d'erreur
│       ├── auth/
│       │   └── login.blade.php            # login.html
│       ├── client/
│       │   ├── home.blade.php             # index.html
│       │   ├── accounts.blade.php         # accounts.html   – détails du compte bancaire
│       │   ├── statements.blade.php       # statements.html – relevé bancaire
│       │   ├── transfer.blade.php         # transfer.html   – transfert (étape 1)
│       │   ├── transferconfirm.blade.php  # transfe.html    – transfert (étape 2)
│       │   ├── notice.blade.php           # notice.html
│       │   ├── feedback.blade.php         # feedback.html   – note de feedback
│       │   └── partials/
│       │       └── transferhistory.blade.php
│       ├── manager/
│       │   ├── home.blade.php             # mindex.html     – liste + suppression des comptes
│       │   ├── staff.blade.php            # maccounts.html  – CRUD caissiers
│       │   ├── addaccount.blade.php       # maddnew.html    – création de compte bancaire
│       │   ├── show.blade.php             # mshow.html      – détails du client
│       │   ├── notice.blade.php           # mnotice.html
│       │   └── feedback.blade.php         # mfeedback.html  – suppression de feedback
│       └── cashier/
│           ├── home.blade.php             # cindex.html
│           └── account.blade.php          # cindex1.html    – dépôt / retrait
└── routes/
    └── web.php                            # toutes les routes du site
```

## Fonctionnalités demandées → où les trouver

| Fonctionnalité                  | Route                                           | Contrôleur                         |
|---------------------------------|-------------------------------------------------|------------------------------------|
| Caissier (CRUD)                 | `/manager/staff` (+ save / update / delete)     | `StaffController`                  |
| Création de compte bancaire     | `/manager/addaccount` → `/manager/saveaccount`  | `AccountController@saveaccount`    |
| Afficher les détails du client  | `/manager/showaccount/{id}`                     | `AccountController@showaccount`    |
| Supprimer le compte client      | `DELETE /manager/deleteaccount/{id}`            | `AccountController@deleteaccount`  |
| Note de feedback de la banque   | `/feedback` → `/savefeedback`                   | `FeedbackController@savefeedback`  |
| Connexion du compte             | `/login`                                        | `AuthController@login`             |
| Suppression de feedback         | `DELETE /manager/deletefeedback/{id}`           | `FeedbackController@deletefeedback`|
| Détails du compte bancaire      | `/accounts`                                     | `ClientController@accounts`        |
| Transfert de fonds              | `/transfer` → `/transfer/search` → `/transfer/send` | `TransferController`           |
| Relevé bancaire                 | `/statements`                                   | `ClientController@statements`      |
| Dépôt / retrait (caissier)      | `/cashier` → `/cashier/account/{id}`            | `CashierController`                |
| Notifications                   | `/manager/notice/{id}` → `/notice`              | `NoticeController`                 |
