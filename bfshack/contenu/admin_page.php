<!DOCTYPE html>
  <html lang="fr">

  <head>
    <title>Panel administrateur</title>
    <link href="../styles/admin_page.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>

  <?php require_once(__DIR__ . '/header.php'); ?>
  <?php require_once(__DIR__ . '/footer.php'); ?>

  <body>

    

    <noscript>
      <style>
        #page {
          display: none !important;
        }
      </style>
      <div class="container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5">
        <div class="row mt-2">
          <div class="col-md-auto">
            <div class="alert alert-danger text-justify" role="alert">
              JavaScript est actuellement désactivé dans votre navigateur. Veuillez activer JavaScript dans les paramètres de votre navigateur afin de pouvoir accéder à <strong>bfshack</strong>.
            </div>
          </div>
        </div>
      </div>
    </noscript>

    <?php
      // Lire le fichier .env et le transformer en tableau associatif
      $env = parse_ini_file(__DIR__ . '/../private.env');
      
      // Utiliser les valeurs
      $host = $env['DB_HOST'];
      $dbname = $env['DB_NAME'];
      $user = $env['DB_USER'];
      $pass = $env['DB_PASS'];
    ?>

    <?php

      // Connexion à la base de données
      $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // Défini l'utilisateur comme non administrateur
      $isAdmin = false;
      // Si un utilisateur est connecté via une variable de session
      if (isset($_SESSION['userName'])) {
        // Vérification du statut administrateur via la base de donnée pour l'utilisateur connecté
        $stmtAdmin = $pdo->prepare("SELECT admin FROM account WHERE userName = :userName");
        $stmtAdmin->execute([':userName' => $_SESSION['userName']]);
        $userData = $stmtAdmin->fetch(PDO::FETCH_ASSOC);
        if ($userData && $userData['admin'] == 1) {
          $isAdmin = true;
        }
      }
      // S'il y a un cookie de session
      else if (isset($_COOKIE['rememberMe'])) {
        $token = $_COOKIE['rememberMe'];
        // Vérification du statut administrateur via la base de donnée pour l'utilisateur connecté
        $stmt = $pdo->prepare("SELECT userName, admin FROM account WHERE token = :token");
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
          $_SESSION['userName'] = $user['userName'];
          if ($user['admin'] == 1) {
            $isAdmin = true;
          }
        }
      }

      // Si l'utilisateur n'est pas administrateur, redirection à l'index en JS car impossible de le faire en PHP à cause des includes des header/footer
      if (!$isAdmin) {
        echo "<div id='page' class='container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5'>
        <div class='row mt-2'>
        <div class='col-md-auto'> ";
        echo "<div class='alert alert-danger text-justify' role='alert'>
        Vous n’avez pas les droits nécessaires pour accéder à cette section. <a href='#' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
        </div>";
        echo "<script>
        setTimeout(function() {
          window.location.href = '/bfshack/index.php';
        }, 5000);
        </script>";
        echo "</div></div></div>";
        exit;
      }
      // Si l'utilisateur est administrateur, affichage du panel administrateur
      if ($isAdmin) {       
        echo "<div id='page' class='container-fluid d-flex align-items-center justify-content-center mt-5 mb-5'>
        <div class='row w-100 mt-4 mb-4 card shadow p-4'>
        <div class='col-12 col-md-auto'> ";
        echo "<br><br><h1>Panel administrateur</h1><br><br>";
        // Valeurs à enregistrer dans les logs
        $page = "Page administrateur";
        $donnees['ip'] = $_SERVER['REMOTE_ADDR'];
        $donnees['date'] = date('d/m/Y');
        $donnees['heure'] = date('H:i:s');
        $donnees['userAgent'] = $userAgent = $_SERVER['HTTP_USER_AGENT'];
        // Préparation de la requête d'insertion
        $sqlQuery = "INSERT INTO log_admin (page, compte, ip, date, heure, userAgent) VALUES (:page, :compte, :ip, :date, :heure, :userAgent)";
        // Préparation de la requête SQL
        $stmt = $pdo->prepare($sqlQuery);
        // Liaison des paramètres
        $stmt->bindParam(':page', $page);
        if (isset($_SESSION['userName'])) {
          $stmt->bindParam(':compte', $_SESSION['userName']);
        }
        if (!isset($_SESSION['userName'])) {
          $stmt->bindValue(':compte', "Utilisateur anonyme", PDO::PARAM_STR);
        }
        $stmt->bindParam(':ip', $donnees['ip']);
        $stmt->bindParam(':date', $donnees['date']);
        $stmt->bindParam(':heure', $donnees['heure']);
        $stmt->bindParam(':userAgent', $donnees['userAgent']);
        // Exécution de la requête, enregistrement des logs
        $stmt->execute();
        // Récupération de tous les logs dans des tableaux associatifs
        $sqlQuery = 'SELECT * FROM log_index';
        $log_indexStatement = $pdo->prepare($sqlQuery);
        $log_indexStatement->execute();
        $log_index = $log_indexStatement->fetchAll();

        $sqlQuery = 'SELECT * FROM log_upload';
        $log_uploadStatement = $pdo->prepare($sqlQuery);
        $log_uploadStatement->execute();
        $log_upload = $log_uploadStatement->fetchAll();
        
        $sqlQuery = 'SELECT * FROM log_admin';
        $log_adminStatement = $pdo->prepare($sqlQuery);
        $log_adminStatement->execute();
        $log_admin = $log_adminStatement->fetchAll();
        
        $sqlQuery = 'SELECT * FROM log_adminlogin';
        $log_adminloginStatement = $pdo->prepare($sqlQuery);
        $log_adminloginStatement->execute();
        $log_adminlogin = $log_adminloginStatement->fetchAll();
        
        $sqlQuery = 'SELECT * FROM contact';
        $contactStatement = $pdo->prepare($sqlQuery);
        $contactStatement->execute();
        $contact = $contactStatement->fetchAll();
        
        $sqlQuery = 'SELECT * FROM login_logout';
        $login_logoutStatement = $pdo->prepare($sqlQuery);
        $login_logoutStatement->execute();
        $login_logout = $login_logoutStatement->fetchAll();
        
        $sqlQuery = 'SELECT * FROM account';
        $accountStatement = $pdo->prepare($sqlQuery);
        $accountStatement->execute();
        $account = $accountStatement->fetchAll();
        
        // premier accordeon
                      
        echo "
        <div class='accordion' id='Accordeon1'>
        <div class='accordion-item'>
        <h2 class='accordion-header' id='header1'>
        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse1' aria-expanded='false' aria-controls='collapse1'>
        📂 Journal de l'index
        </button>
        </h2>
        <div id='collapse1' class='accordion-collapse collapse' aria-labelledby='header1' data-bs-parent='#Accordeon1'>
        <div class='accordion-body'>";
        
        // Affichage de la légende
        echo "
        <div class='container-fluid mt-5'>
        <h2 class='text-center mb-4 titresh2'>Historique des connexions</h2>
        <div class='table-responsive'>
        <table class='table table-bordered table-striped table-hover w-100'>
            <thead class='table-dark'>
                <tr>
                    <th>#</th>
                    <th>Compte</th>
                    <th>Page</th>
                    <th>Adresse IP</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>UserAgent</th>
                </tr>
            </thead>
        <tbody>";
        
        // Boucle pour afficher les données
        foreach ($log_index as $log) {
            echo "
            <tr>
                <td>{$log['clics']}</td>
                <td>{$log['compte']}</td>
                <td>{$log['page']}</td>
                <td>{$log['ip']}</td>
                <td>{$log['date']}</td>
                <td>{$log['heure']}</td>
                <td>{$log['userAgent']}</td>
            </tr>";
        }
        
        echo "</tbody></table></div></div>";
        
        echo "</div></div></div></div>";
        
        
        // deuxième accordeon
        
        
        echo "
        <div class='accordion' id='Accordeon2'>
        <div class='accordion-item'>
        <h2 class='accordion-header' id='header2'>
        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse2' aria-expanded='true' aria-controls='collapse2'>
        📂 Journal de l'upload
        </button>
        </h2>
        <div id='collapse2' class='accordion-collapse collapse' aria-labelledby='header2' data-bs-parent='#Accordeon2'>
        <div class='accordion-body'>";
        
        // Affichage de la légende
        echo "
        <div class='container-fluid mt-5'>
        <h2 class='text-center mb-4 titresh2'>Historique des uploads</h2>
        <div class='table-responsive'>
        <table class='table table-bordered table-striped table-hover w-100'>
            <thead class='table-dark'>
                <tr>
                    <th>#</th>
                    <th>Compte</th>
                    <th>Page</th>
                    <th>Adresse IP</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>UserAgent</th>
                    <th>Nom de l'image </th>
                    <th>Taille</th>
                    <th>Image</th>
                </tr>
            </thead>
        <tbody>
        ";
        
        // Boucle pour afficher les données
        foreach ($log_upload as $log) {
            echo "
            <tr>
                <td>{$log['clics']}</td>
                <td>{$log['compte']}</td>
                <td>{$log['page']}</td>
                <td>{$log['ip']}</td>
                <td>{$log['date']}</td>
                <td>{$log['heure']}</td>
                <td>{$log['userAgent']}</td>
                <td>{$log['image']}</td>
                <td>{$log['taille']} Mo</td>
                <td> 
                    <a href='{$log['urlImage']}' target='_blank'>
                        <img src='{$log['urlImage']}' alt='Aperçu' class='img-fluid rounded mb-2' style='max-width: 150px; height: auto;'>
                    </a>
                </td>                        
            </tr>
            ";
        }
        
        echo "</tbody></table></div></div>";
        
        echo "</div></div></div></div>";
        
        
        // troisième accordeon
        
        echo "
        <div class='accordion' id='Accordeon3'>
        <div class='accordion-item'>
        <h2 class='accordion-header' id='header3'>
        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse3' aria-expanded='true' aria-controls='collapse3'>
        📂 Journal de la page de login administrateur
        </button>
        </h2>
        <div id='collapse3' class='accordion-collapse collapse' aria-labelledby='header3' data-bs-parent='#Accordeon3'>
        <div class='accordion-body'>";
        
        // Affichage de la légende
        echo "
        <div class='container-fluid mt-5'>
        <h2 class='text-center mb-4 titresh2'>Erreurs de connexion administrateur</h2>
        <div class='table-responsive'>
        <table class='table table-bordered table-striped table-hover w-100'>
            <thead class='table-dark'>
                <tr>
                    <th>#</th>
                    <th>Page</th>
                    <th>Adresse IP</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>UserAgent</th>
                </tr>
            </thead>
        <tbody>";
        
        // Boucle pour afficher les données
        foreach ($log_adminlogin as $log) {
            echo "
            <tr>
                <td>{$log['clics']}</td>
                <td>{$log['page']}</td>
                <td>{$log['ip']}</td>
                <td>{$log['date']}</td>
                <td>{$log['heure']}</td>
                <td>{$log['userAgent']}</td>
            </tr>";
        }
        
        echo "</tbody></table></div></div>";
        
        echo "</div></div></div></div>";
        
        // quatrième accordeon
        
        echo "
        <div class='accordion' id='Accordeon4'>
        <div class='accordion-item'>
        <h2 class='accordion-header' id='header4'>
        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse4' aria-expanded='true' aria-controls='collapse4'>
        📂 Journal de la page administrateur
        </button>
        </h2>
        <div id='collapse4' class='accordion-collapse collapse' aria-labelledby='header4' data-bs-parent='#Accordeon4'>
        <div class='accordion-body'>";
        
        echo "
        <div class='container-fluid mt-5'>
        <h2 class='text-center mb-4 titresh2'>Connexions au panel administrateur</h2>
        <div class='table-responsive'>
        <table class='table table-bordered table-striped table-hover w-100'>
            <thead class='table-dark'>
                <tr>
                    <th>#</th>
                    <th>Compte</th>
                    <th>Page</th>
                    <th>Adresse IP</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>UserAgent</th>
                </tr>
            </thead>
        <tbody>";
        
        // Boucle pour afficher les données
        foreach ($log_admin as $log) {
            echo "
            <tr>
                <td>{$log['clics']}</td>
                <td>{$log['compte']}</td>
                <td>{$log['page']}</td>
                <td>{$log['ip']}</td>
                <td>{$log['date']}</td>
                <td>{$log['heure']}</td>
                <td>{$log['userAgent']}</td>
            </tr>";
        }
        
        echo "</tbody></table></div></div>";
        
        echo "</div></div></div></div>";
        
        // cinquième accordeon
        
        echo "
        <div class='accordion' id='Accordeon5'>
        <div class='accordion-item'>
        <h2 class='accordion-header' id='header5'>
        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse5' aria-expanded='true' aria-controls='collapse5'>
        📂 Demande de contact
        </button>
        </h2>
        <div id='collapse5' class='accordion-collapse collapse' aria-labelledby='header5' data-bs-parent='#Accordeon5'>
        <div class='accordion-body'>";
        
        // Affichage de la légende
        echo "
        <div class='container-fluid mt-5'>
        <h2 class='text-center mb-4 titresh2'>Messages de contact</h2>
        <div class='table-responsive'>
        <table class='table table-bordered table-striped table-hover w-100'>
            <thead class='table-dark'>
                <tr>
                    <th>#</th>
                    <th>Compte</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Adresse eMail</th>
                    <th>Abus</th>
                    <th>Message</th>
                    <th>Adresse IP</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>UserAgent</th>
                </tr>
            </thead>
        <tbody>
        ";
        
        // Boucle pour afficher les données
        foreach ($contact as $log) {
            echo "
            <tr>
                <td>{$log['clics']}</td>
                <td>{$log['compte']}</td>
                <td>{$log['prenom']}</td>
                <td>{$log['nom']}</td>
                <td>{$log['adresseMail']}</td>
                <td>{$log['abus']}</td>
                <td>{$log['message']}</td>
                <td>{$log['ip']}</td>
                <td>{$log['date']}</td>
                <td>{$log['heure']}</td>
                <td>{$log['userAgent']}</td>
            </tr>
            ";
        }
        
        echo "</tbody></table></div></div>";
        
        echo "</div></div></div></div>";
        
        // sixième accordeon
        
        echo "
        <div class='accordion' id='Accordeon6'>
        <div class='accordion-item'>
        <h2 class='accordion-header' id='header6'>
        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse6' aria-expanded='true' aria-controls='collapse6'>
        📂 Journal des connexions - déconnexions
        </button>
        </h2>
        <div id='collapse6' class='accordion-collapse collapse' aria-labelledby='header6' data-bs-parent='#Accordeon6'>
        <div class='accordion-body'>";
        
        // Affichage de la légende
        echo "
        <div class='container-fluid mt-5'>
        <h2 class='text-center mb-4 titresh2'>Historique des connexions et déconnexions</h2>
        <div class='table-responsive'>
        <table class='table table-bordered table-striped table-hover w-100'>
            <thead class='table-dark'>
                <tr>
                    <th>#</th>
                    <th>Compte</th>
                    <th>État</th>
                    <th>Adresse IP</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>UserAgent</th>
                </tr>
            </thead>
        <tbody>
        ";
        
        // Boucle pour afficher les données
        foreach ($login_logout as $log) {
            echo "
            <tr>
                <td>{$log['clics']}</td>
                <td>{$log['userName']}</td>
                <td>{$log['etat']}</td>
                <td>{$log['ip']}</td>
                <td>{$log['date']}</td>
                <td>{$log['heure']}</td>
                <td>{$log['userAgent']}</td>
            </tr>
            ";
        }
        
        echo "</tbody></table></div></div>";
        
        echo "</div></div></div></div>";
        
        // septième accordeon
        
        echo "
        <div class='accordion' id='Accordeon7'>
        <div class='accordion-item'>
        <h2 class='accordion-header' id='header7'>
        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse7' aria-expanded='true' aria-controls='collapse7'>
        📂 Comptes utilisateurs
        </button>
        </h2>
        <div id='collapse7' class='accordion-collapse collapse' aria-labelledby='header7' data-bs-parent='#Accordeon7'>
        <div class='accordion-body'>";
        
        // Affichage de la légende
        echo "
        <div class='container-fluid mt-5'>
        <h2 class='text-center mb-4 titresh2'>Liste des comptes utilisateurs</h2>
        <div class='table-responsive'>
        <table class='table table-bordered table-striped table-hover w-100'>
            <thead class='table-dark'>
                <tr>
                    <th>#</th>
                    <th>Compte</th>
                    <th>Adresse eMail</th>
                    <th>Hash du Mot de Passe</th>
                    <th>Adresse IP</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>UserAgent</th>
                    <th>Token</th>
                </tr>
            </thead>
        <tbody>
        ";
        
        // Boucle pour afficher les données
        foreach ($account as $log) {
            echo "
            <tr>
                <td>{$log['clics']}</td>
                <td>{$log['userName']}</td>
                <td>{$log['email']}</td>
                <td>{$log['password']}</td>
                <td>{$log['ip']}</td>
                <td>{$log['date']}</td>
                <td>{$log['heure']}</td>
                <td>{$log['userAgent']}</td>
                <td>{$log['token']}</td>
            </tr>
            ";
        }
        
        echo "</tbody></table></div></div>";
        
        echo "</div></div></div></div>";
                            
        echo "</div></div></div>";                     
      }     
    ?>
              
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
            
  </body>
  
</html>