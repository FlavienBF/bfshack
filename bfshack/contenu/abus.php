<!DOCTYPE html>
<html lang="fr">

  <head>
    <title>Signaler un abus</title>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="../styles/abus.css" rel="stylesheet" >
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  </head>

  <body>

    <?php require_once(__DIR__ . '/header.php'); ?>
    <?php require_once(__DIR__ . '/footer.php'); ?>

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

    <div id="page" class="container-fluid d-flex justify-content-center align-items-center mt-5">
      <div class="container-fluid d-flex justify-content-center align-items-center mt-5">
        <div class="row justify-content-center w-100">
          <div class="col-md-6 col-sm-10">
            <div class="card shadow p-4">
              <form action="contact_envoi.php" method="POST">
                <div class="mb-3">
                  <h1> Signaler un abus </h1>
                  <div class="ligne-separatrice"></div>
                  <p class="texte-abus"> Ce formulaire est destiné exclusivement aux signalements de contenus contraires à la loi, aux conditions d’utilisation du site, ou susceptibles de porter atteinte à autrui.
                  Merci de décrire le plus clairement possible le contenu concerné et d’indiquer les raisons de votre signalement.
                  Chaque requête sera examinée avec attention dans les plus brefs délais. </p>
                  <label for="prenom" class="form-label">Prénom * :</label>
                  <input type="text" class="form-control" id="prenom" name="prenom" required>
                </div>
                <div class="mb-3">
                  <label for="nom" class="form-label">Nom * :</label>
                  <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="mb-3">
                  <label for="adresseMail" class="form-label">Adresse mail * :</label>
                  <input type="email" class="form-control" id="adresseMail" name="adresseMail" required>
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="abus" name="abus" checked>
                  <label class="form-check-label" for="abus">Signaler un abus</label>
                </div>
                <div class="mb-3">
                  <label for="message" class="form-label">Message * :</label>
                  <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-secondary w-100">Envoyer</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    
  </body>

</html>