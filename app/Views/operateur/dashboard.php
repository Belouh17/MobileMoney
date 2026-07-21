<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">📞</div>
        <div class="stat-info">
            <div class="stat-label">Préfixes configurés</div>
            <div class="stat-value"><?= $stats['nbPrefixes'] ?? '—' ?></div>
            <div class="stat-sub">Gérer les préfixes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">⚙️</div>
        <div class="stat-info">
            <div class="stat-label">Types d'opérations</div>
            <div class="stat-value"><?= $stats['nbTypes'] ?? '—' ?></div>
            <div class="stat-sub">Configurer les barèmes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">🏢</div>
        <div class="stat-info">
            <div class="stat-label">Autres opérateurs</div>
            <div class="stat-value"><?= $stats['nbAutresOperateurs'] ?? '—' ?></div>
            <div class="stat-sub">Gérer les partenaires</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">👥</div>
        <div class="stat-info">
            <div class="stat-label">Clients enregistrés</div>
            <div class="stat-value"><?= $stats['nbClients'] ?? '—' ?></div>
            <div class="stat-sub">Comptes actifs</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Actions rapides</h3>
    </div>
    <div class="card-body">
        <div class="quick-actions">
            <a href="/operateur/prefixes" class="btn btn-primary">➕ Ajouter un préfixe</a>
            <a href="/operateur/types" class="btn btn-info">⚙️ Configurer les types</a>
            <a href="/operateur/autres-operateurs" class="btn btn-success">🏢 Gérer les opérateurs</a>
            <a href="/operateur/gains" class="btn btn-warning">📈 Voir les gains</a>
            <a href="/operateur/comptes" class="btn btn-outline">👥 Comptes clients</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>