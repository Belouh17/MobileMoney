<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mobile Money — Connexion Client</title>
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
      <p>Espace client — Connexion</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <form method="post" action="/client/auth">
      <div class="form-group">
        <label>Numéro de téléphone</label>
        <input type="text" name="telephone" placeholder="Ex: 0331234567" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success btn-lg">💳 Se connecter</button>
      <p style="text-align:center;margin-top:16px;font-size:13px;color:var(--text-muted);">
        Si vous n'avez pas encore de compte, il sera créé automatiquement.
      </p>
    </form>
  </div>
</div>
</body>
</html>
