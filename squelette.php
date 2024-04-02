<!doctype html>
<html lang="fr">
<head>
  <title>Menus</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="form.css"  type="text/css" >
  <link rel="icon" type="image/png" sizes="16x16" href="icone.png">
</head>
<body>
  <h1>Page de création de menus</h1>
  <hr>
  <table class="tabM">
  <tr>
    <td class="tdM"><?php echo $zonePrincipale; ?></td>
    <td style="background-color : #12b042;">
      <p>
        <a href="index.php?">Page d'accueil</a><br>
        <a href="index.php?action=insert">Ajouter une composition</a><br>
        <a href="index.php?action=liste">Liste des menus</a><br>
        <a href="index.php?action=about">A propos</a><br>
        <a href="index.php?action=complement">Complément</a><br>
      </p>
    </td>
  </tr>
  </table>
  <hr>
</body>
</html>
