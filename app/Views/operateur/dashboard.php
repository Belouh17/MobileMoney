<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Opérateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --primary: #0d6efd; --success: #198754; --warning: #ffc107; --info: #0dcaf0; }
        
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            position: fixed;
            width: 260px;
            z-index: 1000;
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .sidebar-brand i { color: var(--info); margin-right: 0.5rem; }
        
        .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 0.9rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left: 3px solid var(--info);
        }
        
        .nav-link i { font-size: 1.1rem; width: 24px; text-align: center; }
        
        .main-content { margin-left: 260px; padding: 2rem; }
        
        .topbar {
            background: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stat-icon.blue { background: rgba(13, 110, 253, 0.1); color: var(--primary); }
        .stat-icon.green { background: rgba(25, 135, 84, 0.1); color: var(--success); }
        .stat-icon.orange { background: rgba(255, 193, 7, 0.1); color: #b38600; }
        .stat-icon.purple { background: rgba(111, 66, 193, 0.1); color: #6f42c1; }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.25rem;
        }
        
        .stat-label { color: #6c757d; font-size: 0.9rem; font-weight: 500; }
        
        .menu-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
            border: 2px solid transparent;
        }
        
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
            border-color: var(--primary);
            color: inherit;
        }
        
        .menu-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }
        
        .menu-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .menu-desc {
            color: #6c757d;
            font-size: 0.85rem;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-bank"></i> MonOpérateur
    </div>
    <div class="nav flex-column mt-3">
        <a href="<?= base_url('operateur/dashboard') ?>" class="nav-link active">
            <i class="bi bi-speedometer2"></i> Tableau de bord
        </a>
        <a href="<?= base_url('operateur/prefixes') ?>" class="nav-link">
            <i class="bi bi-telephone-plus"></i> Préfixes
        </a>
        <a href="<?= base_url('operateur/types') ?>" class="nav-link">
            <i class="bi bi-tags"></i> Types d'opérations
        </a>
        <a href="<?= base_url('operateur/baremes/1') ?>" class="nav-link">
            <i class="bi bi-cash-stack"></i> Barèmes de frais
        </a>
        <a href="<?= base_url('operateur/comptes') ?>" class="nav-link">
            <i class="bi bi-people"></i> Comptes clients
        </a>
        <a href="<?= base_url('operateur/gains') ?>" class="nav-link">
            <i class="bi bi-graph-up-arrow"></i> Gains & Rapports
        </a>
        <a href="<?= base_url('operateur/autres-operateurs') ?>" class="nav-link">
            <i class="bi bi-building"></i> Autres opérateurs
        </a>
        <a href="<?= base_url('operateur/montants-a-envoyer') ?>" class="nav-link">
            <i class="bi bi-send"></i> Montants à envoyer
        </a>
    </div>
</nav>

<div class="main-content">
    
    <div class="topbar">
        <div>
            <h4 class="m-0 fw-bold">Tableau de bord</h4>
            <small class="text-muted"><?= date('l d F Y') ?></small>
        </div>
        <div class="text-muted">
            <i class="bi bi-person-circle me-2"></i>Mode opérateur
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-telephone"></i></div>
                <div class="stat-value"><?= $nbPrefixes ?></div>
                <div class="stat-label">Préfixes actifs</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
                <div class="stat-value"><?= $nbClients ?></div>
                <div class="stat-label">Clients inscrits</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="bi bi-cash-coin"></i></div>
                <div class="stat-value"><?= number_format($gainsAujourdhui, 0, ',', ' ') ?> FCFA</div>
                <div class="stat-label">Gains aujourd'hui</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="bi bi-building"></i></div>
                <div class="stat-value"><?= $nbAutresOperateurs ?></div>
                <div class="stat-label">Opérateurs partenaires</div>
            </div>
        </div>
    </div>

    <h5 class="section-title">
        <i class="bi bi-grid-3x3-gap-fill text-primary"></i> Navigation rapide
    </h5>
    <div class="row g-4">
        <div class="col-md-4 col-lg-3">
            <a href="<?= base_url('operateur/prefixes') ?>" class="menu-card">
                <div class="menu-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-telephone-plus"></i></div>
                <div class="menu-title">Préfixes</div>
                <div class="menu-desc">Gérer les préfixes téléphoniques</div>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?= base_url('operateur/types') ?>" class="menu-card">
                <div class="menu-icon bg-success bg-opacity-10 text-success"><i class="bi bi-tags"></i></div>
                <div class="menu-title">Types d'opérations</div>
                <div class="menu-desc">Définir les types de transactions</div>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?= base_url('operateur/baremes/1') ?>" class="menu-card">
                <div class="menu-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-cash-stack"></i></div>
                <div class="menu-title">Barèmes de frais</div>
                <div class="menu-desc">Configurer les tarifs</div>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?= base_url('operateur/comptes') ?>" class="menu-card">
                <div class="menu-icon bg-info bg-opacity-10 text-info"><i class="bi bi-people"></i></div>
                <div class="menu-title">Comptes clients</div>
                <div class="menu-desc">Situation des comptes</div>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?= base_url('operateur/gains') ?>" class="menu-card">
                <div class="menu-icon bg-danger bg-opacity-10 text-danger"><i class="bi bi-graph-up-arrow"></i></div>
                <div class="menu-title">Gains & Rapports</div>
                <div class="menu-desc">Bénéfices et statistiques</div>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?= base_url('operateur/autres-operateurs') ?>" class="menu-card">
                <div class="menu-icon bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-building"></i></div>
                <div class="menu-title">Autres opérateurs</div>
                <div class="menu-desc">Opérateurs partenaires</div>
            </a>
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="<?= base_url('operateur/montants-a-envoyer') ?>" class="menu-card">
                <div class="menu-icon bg-dark bg-opacity-10 text-dark"><i class="bi bi-send"></i></div>
                <div class="menu-title">Montants à envoyer</div>
                <div class="menu-desc">Suivi des transferts externes</div>
            </a>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>