<!DOCTYPE html>
<html lang="fr">

  <head>
    <title>Foire aux questions</title>
    <link href="../styles/faq.css" rel="stylesheet" >
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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

    <div id="page" class="container-fluid d-flex align-items-center justify-content-center mt-5 mb-5">
      <div class="row mt-2" id="fondfaq">
        <div class="col-md-auto" id="faq">
          <div class="card shadow p-4">
            <h1>Foire aux questions</h1>
            <div class="ligne-separatrice-h1"></div>
            <p id="intro">Vous trouverez ici des réponses aux questions les plus fréquemment posées concernant l'utilisation de bfshack.</p>
            <div class="ligne-separatrice-p"></div>

            <h2>Quels sont les formats d'image que je peux uploader ?</h2>
            <p id="texte">Vous pouvez uploader des images dans les formats suivants : JPEG, JPG, PNG, BMP, GIF, WEBP, TIF, TIFF, HEIC, AVIF et SVG. bfshack supporte une large gamme de formats pour faciliter le partage et la visualisation de vos images.</p>

            <h2>Quelle est la taille maximale autorisée pour un fichier image ?</h2>
            <p id="texte">La taille maximale pour un fichier image est de 50 Mo. Cela permet d'assurer une bonne qualité pour vos images tout en maintenant une performance optimale de la plateforme.</p>

            <h2>Puis-je supprimer une image que j'ai uploadée ?</h2>
            <p id="texte">Actuellement, les utilisateurs ne peuvent pas supprimer directement une image qu'ils ont uploadée. Cependant, si vous souhaitez supprimer une image pour quelque raison que ce soit (contenu offensant, dangereux, ou autre), nous vous invitons à utiliser notre formulaire de contact pour nous en informer. Nous traiterons votre demande dans les plus brefs délais.</p>

            <h2>Dois-je créer un compte pour uploader des images ?</h2>
            <p id="texte">Non, il n'est pas nécessaire de créer un compte pour utiliser notre service. Notre site est un simple service d'upload d'image, conçu pour être aussi accessible et facile à utiliser que possible. Vous pouvez uploader et partager vos images sans avoir besoin de vous inscrire.</p>

            <h2>Comment puis-je partager une image après l'avoir uploadée ?</h2>
            <p id="texte">Une fois votre image uploadée, un lien direct vers l'image vous sera fourni. Vous pouvez partager ce lien avec qui vous souhaitez, par email, messagerie instantanée, ou sur les réseaux sociaux, pour permettre à d'autres de voir ou de télécharger votre image.</p>

            <h2>Que faire si je trouve une image offensante ou inappropriée sur le site ?</h2>
            <p id="texte">Si vous trouvez sur une image qui vous semble offensante, inappropriée, ou dangereuse, nous vous encourageons à utiliser notre formulaire de contact pour signaler cette image. Veuillez fournir le lien direct vers l'image concernée et décrire brièvement le problème. Nous prenons ces signalements très au sérieux et agirons en conséquence pour maintenir un environnement sûr pour tous les utilisateurs.</p>

            <p id="texte">Nous espérons que cette FAQ vous a été utile. Si vous avez d'autres questions ou si vous avez besoin d'assistance supplémentaire, n'hésitez pas à nous contacter via notre formulaire de contact. Merci d'utiliser notre service d'upload d'image !</p>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

  </body>

</html>