<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Mobile Money — Opérateur' ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="layout">

  <!-- Sidebar Overlay (mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">MM</div>
      <div class="brand-text">Mobile<span>Money</span></div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-label">Général</div>
      <a href="/operateur/dashboard" class="nav-item <?= $activeMenu === 'dashboard' ? 'active' : '' ?>">
        <span class="nav-icon">📊</span>
        Tableau de bord
      </a>

      <div class="nav-label">Configuration</div>
      <a href="/operateur/prefixes" class="nav-item <?= $activeMenu === 'prefixes' ? 'active' : '' ?>">
        <span class="nav-icon">📞</span>
        Préfixes opérateur
      </a>
      <a href="/operateur/types" class="nav-item <?= $activeMenu === 'types' ? 'active' : '' ?>">
        <span class="nav-icon">⚙️</span>
        Types / Barèmes
      </a>

      <div class="nav-label">Opérateurs externes</div>
      <a href="/operateur/autres-operateurs" class="nav-item <?= $activeMenu === 'autresOperateurs' ? 'active' : '' ?>">
        <span class="nav-icon">🏢</span>
        Autres opérateurs
      </a>
      <a href="/operateur/montants-a-envoyer" class="nav-item <?= $activeMenu === 'montantsEnvoyer' ? 'active' : '' ?>">
        <span class="nav-icon">💰</span>
        Montants à envoyer
      </a>

      <div class="nav-label">Rapports</div>
      <a href="/operateur/gains" class="nav-item <?= $activeMenu === 'gains' ? 'active' : '' ?>">
        <span class="nav-icon">📈</span>
        Situation des gains
      </a>
      <a href="/operateur/comptes" class="nav-item <?= $activeMenu === 'comptes' ? 'active' : '' ?>">
        <span class="nav-icon">👥</span>
        Comptes clients
      </a>
    </nav>

    <div class="sidebar-footer">
      <a href="/operateur/logout" class="nav-item">
        <span class="nav-icon">🚪</span>
        Déconnexion
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Header -->
    <header class="header">
      <div class="header-left">
        <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>
        <div>
          <div class="header-title"><?= $title ?? 'Mobile Money' ?></div>
          <div class="header-breadcrumb">Opérateur / <span><?= $title ?? '' ?></span></div>
        </div>
      </div>
      <div class="header-right">
        <span class="badge badge-info">
          👤 <?= session()->get('operateur_nom') ?? 'Opérateur' ?>
        </span>
      </div>
    </header>

    <!-- Page Content -->
    <div class="page-content page-transition">
      <?php if (session()->getFlashdata('erreur')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('erreur')) ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('succes')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('succes')) ?></div>
      <?php endif; ?>

      <?= $this->renderSection('content') ?>
    </div>
  </main>

</div>

<script>
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('sidebarOverlay').classList.toggle('active');
}
</script>
</body>
</html>