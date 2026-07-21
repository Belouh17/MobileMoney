<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon green">💰</div>
    <div class="stat-info">
      <div class="stat-label">Solde actuel</div>
      <div class="stat-value"><?= number_format($client['solde'], 2) ?> Ar</div>
      <div class="stat-sub">Mis à jour en temps réel</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3>Bienvenue, <?= esc(session()->get('telephone')) ?></h3>
  </div>
  <div class="card-body">
    <p style="color: var(--text-secondary); margin-bottom: 20px;">
      Que souhaitez-vous faire ?
    </p>
    <div class="quick-actions">
      <a href="/client/depot" class="btn btn-success">📥 Dépôt</a>
      <a href="/client/retrait" class="btn btn-warning">📤 Retrait</a>
      <a href="/client/transfert" class="btn btn-primary">🔄 Transfert</a>
      <a href="/client/transfert-multiple" class="btn btn-info">👥 Envoi multiple</a>
      <a href="/client/historique" class="btn btn-outline">📋 Historique</a>
    </div>
  </div>
</div>
<?= $this->endSection() ?>