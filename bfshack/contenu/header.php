<!DOCTYPE html>
<html lang="fr">

  <head>
    <title>Header</title>
    <link href="/bfshack/styles/header.css" rel="stylesheet" >
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  </head> 



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

        // Récupération du nombre d'images uploadées, ancienne fonctionnalité
        $sqlQuery = 'SELECT * FROM log_upload ORDER BY clics DESC LIMIT 1';
        $log_uploadStatement = $pdo->prepare($sqlQuery);
        $log_uploadStatement->execute();
        $log_upload = $log_uploadStatement->fetch();

        // Défini que l'utilisateur n'est pas administrateur
        $isAdmin = false;

      // Vérifie si l'utilisateur est déjà connecté via une variable de session
      if (isset($_SESSION['userName'])) {
        // Requête SQL pour récupérer le champ "admin" dans la table "account" en se basant sur le nom d'utilisateur stocké dans la session
        $stmtAdmin = $pdo->prepare("SELECT admin FROM account WHERE userName = :userName");

        // Exécute la requête en liant le paramètre ":userName" à la valeur de $_SESSION['userName']
        $stmtAdmin->execute([':userName' => $_SESSION['userName']]);
        
        // Récupère le résultat de la requête sous forme de tableau associatif
        $userData = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        // Vérifie si l'utilisateur existe et possède les droits administrateur ; si c’est le cas, lui attribue les fonctionnalités réservées aux administrateurs
        if ($userData && $userData['admin'] == 1) {
          $isAdmin = true;
        }
      }
      // Vérifie si l'utilisateur possède un cookie
      else if (isset($_COOKIE['rememberMe'])) {
        // Récupère la valeur du cookie qui sert de token pour l'authentification
        $token = $_COOKIE['rememberMe'];

        // Requête SQL pour récupérer le nom d'utilisateur et le statut "admin" via le token stocké dans le cookie
        $stmt = $pdo->prepare("SELECT userName, admin FROM account WHERE token = :token");

        // Exécute la requête en liant le paramètre ":token" à la valeur récupérée du cookie
        $stmt->execute([':token' => $token]);

        // Récupère le résultat de la requête sous forme de tableau associatif
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si un utilisateur correspondant au token est trouvé dans la base de données
        if ($user) {
          // Connecte l'utilisateur en stockant son nom dans la variable de session
          $_SESSION['userName'] = $user['userName'];

          // Vérifie si l'utilisateur est administrateur ; si c'est le cas, lui attribue les fonctionnalités réservées aux administrateurs
          if ($user['admin'] == 1) {
            $isAdmin = true;
          }
        }
      }
    ?>

      <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="navbar-top">
          <div class="container-fluid">
            <div class="row justify-content-center align-items-center w-100">
              <div class="col">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="boutonmenu" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-arrow-down-circle"></i>
                </button>
                  <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton">

                    <?php if (isset($_SESSION['userName']) || isset($_COOKIE['rememberMe'])): ?>
                    <!-- Liens pour les utilisateurs connectés -->
                    <a class="dropdown-item" href="/bfshack/index.php"><i class="bi bi-house"></i> Accueil</a>
                    <a class="dropdown-item" href="/bfshack/contenu/logout.php"><i class="bi bi-box-arrow-up-right"></i> Deconnexion</a>
                    <a class="dropdown-item" href="/bfshack/contenu/faq.php"><i class="bi bi-question-square"></i> Foire aux questions</a>
                    <a class="dropdown-item" href="/bfshack/contenu/cgu.php"><i class="bi bi-info-square"></i> Conditions générales d'utilisation</a>
                    <a class="dropdown-item" href="/bfshack/contenu/contact.php"><i class="bi bi-envelope"></i> Contact</a>
                    <a class="dropdown-item" href="/bfshack/contenu/abus.php"><i class="bi bi-exclamation-square"></i> Signaler un abus</a>
                    <!-- Lien supplémentaire pour le panel administrateur -->
                    <?php if ($isAdmin): ?>
                    <a class="dropdown-item" href="/bfshack/contenu/admin_page.php"><i class="bi bi-shield-lock"></i> Panel Administrateur</a>
                    <?php endif; ?>

                    <?php else: ?>
                    <!-- Liens pour les visiteurs -->
                    <a class="dropdown-item" href="/bfshack/index.php"><i class="bi bi-house-door"></i> Accueil</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalLogin"><i class="bi bi-box-arrow-in-up-right"></i> Connexion</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalRegister"><i class="bi bi-file-text"></i> Inscription</a>
                    <a class="dropdown-item" href="/bfshack/contenu/faq.php"><i class="bi bi-question-square"></i> Foire aux questions</a>
                    <a class="dropdown-item" href="/bfshack/contenu/cgu.php"><i class="bi bi-info-square"></i> Conditions générales d'utilisation</a>
                    <a class="dropdown-item" href="/bfshack/contenu/contact.php"><i class="bi bi-envelope"></i> Contact</a>
                    <a class="dropdown-item" href="/bfshack/contenu/abus.php"><i class="bi bi-exclamation-square"></i> Signaler un abus</a>
                    <?php endif; ?>
                  </div>
              </div>

              <div class="col-auto">
                <p class="mb-0 logotexte">
                  <a href="/bfshack/index.php"> <i class="bi bi-cloud-arrow-up-fill"></i> bfshack</a>
                </p>
              </div>

              <div class="col d-flex justify-content-end align-items-center">
                  <p class="mb-0 text-end"> <?php if (isset($_SESSION['userName'])) {
                  echo "Bonjour, " . $_SESSION['userName'];
                } else if (isset($_COOKIE['rememberMe'])) {
                      $token = $_COOKIE['rememberMe'];
                      $sqlQuery = "SELECT userName FROM account WHERE token = :token";
                      $stmt = $pdo->prepare($sqlQuery);
                      $stmt->execute([':token' => $token]);
                      $user = $stmt->fetch(PDO::FETCH_ASSOC);
                      
                } else { echo "
                <button type='button' class='btn btn-secondary btn-sm d-block d-md-inline-block' data-bs-toggle='modal' data-bs-target='#modalLogin'>
                  <i class='bi bi-house-door fs-4 d-md-none'></i> <!-- Petites icones, petits écrans -->
                  <i class='bi bi-house-door fs-5 d-none d-md-inline'></i> <!-- Grosses icones, gros écrans -->
                  <span class='d-none d-md-inline'>Connexion</span> <!-- Texte caché sur mobile -->
                </button>"; } ?>
              </div>
            </div>
          </div>
        </nav>

      <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalLoginLabel">Connexion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="/bfshack/contenu/login.php" method="post">
                    <div class="mb-3">
                      <label for="userName" class="form-label">Nom d'utilisateur</label>
                      <input type="userName" class="form-control" id="userName" name="userName" required>
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label">Mot de passe</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-secondary">Se connecter</button>
                  </form>
              </div>
            </div>
          </div>
      </div>

      <div class="modal fade" id="modalRegister" tabindex="-1" aria-labelledby="modalRegisterLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalRegisterLabel">Inscription</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/bfshack/contenu/register.php" method="post">
                <div class="mb-3">
                  <label for="userName" class="form-label">Nom d'utilisateur</label>
                  <input type="text" class="form-control" id="userName" name="userName" required>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Adresse email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Mot de passe</label>
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-secondary">S'enregistrer</button>
              </form>
            </div>
          </div>
        </div>
      </div>

    </header>

</html>