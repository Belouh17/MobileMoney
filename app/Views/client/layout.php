<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mobile Money — Client' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <div class="layout">

        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="logo-icon">MM</div>
                <div class="brand-text">Mobile<span>Money</span></div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-label">Mon Compte</div>
                <a href="/client/dashbord" class="nav-item <?= $activeMenu === 'dashbord' ? 'active' : '' ?>">
                    <span class="nav-icon">📊</span> Tableau de bord
                </a>
                <a href="/client/historique" class="nav-item <?= $activeMenu === 'historique' ? 'active' : '' ?>">
                    <span class="nav-icon">📋</span> Historique
                </a>

                <div class="nav-label">Opérations</div>
                <a href="/client/depot" class="nav-item <?= $activeMenu === 'depot' ? 'active' : '' ?>">
                    <span class="nav-icon">📥</span> Dépôt
                </a>
                <a href="/client/retrait" class="nav-item <?= $activeMenu === 'retrait' ? 'active' : '' ?>">
                    <span class="nav-icon">📤</span> Retrait
                </a>
                <a href="/client/transfert" class="nav-item <?= $activeMenu === 'transfert' ? 'active' : '' ?>">
                    <span class="nav-icon">🔄</span> Transfert
                </a>
                <a href="/client/transfert-multiple" class="nav-item <?= $activeMenu === 'transfertMultiple' ? 'active' : '' ?>">
                    <span class="nav-icon">👥</span> Envoi multiple
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="/client/logout" class="nav-item">
                    <span class="nav-icon">🚪</span> Déconnexion
                </a>
            </div>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="header-left">
                    <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>
                    <div>
                        <div class="header-title"><?= $title ?? 'Mobile Money' ?></div>
                        <div class="header-breadcrumb">Client / <span><?= $title ?? '' ?></span></div>
                    </div>
                </div>
                <div class="header-right">
                    <span class="badge badge-success">💳 <?= session()->get('telephone') ?? 'Client' ?></span>
                </div>
            </header>

            <div class="page-content page-transition">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
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