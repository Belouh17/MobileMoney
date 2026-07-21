<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mobile Money — Connexion Opérateur</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="login-page">
  <div class="login-card">
    <div class="login-logo">
      <div class="logo-icon">MM</div>
      <h2>Mobile Money</h2>
      <p>Espace opérateur — Connexion</p>
    </div>

    <?php if (session()->getFlashdata('erreur')): ?>
      <div class="alert alert-danger"><?= esc(session()->getFlashdata('erreur')) ?></div>
    <?php endif; ?>

    <form method="post" action="/login">
      <?= csrf_field() ?>
      <div class="form-group">
        <label>Identifiant</label>
        <input type="text" name="username" placeholder="Nom d'utilisateur" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="Votre mot de passe" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary btn-lg">🔐 Se connecter</button>
    </form>
  </div>
</div>
</body>
</html>
