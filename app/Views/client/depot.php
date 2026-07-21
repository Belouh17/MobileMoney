<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header">
    <h3>📥 Dépôt d'argent</h3>
  </div>
  <div class="card-body">
    <div class="stats-grid" style="margin-bottom: 24px;">
      <div class="stat-card">
        <div class="stat-icon green">💰</div>
        <div class="stat-info">
          <div class="stat-label">Solde actuel</div>
          <div class="stat-value"><?= number_format($client['solde'], 2) ?> Ar</div>
        </div>
      </div>
      <?php if ($tauxEpargne > 0): ?>
      <div class="stat-card">
        <div class="stat-icon indigo">🏦</div>
        <div class="stat-info">
          <div class="stat-label">Épargne active</div>
          <div class="stat-value"><?= number_format($tauxEpargne, 0) ?>%</div>
index.php/client/login          <div class="stat-sub">Montant épargné: <?= number_format($montantEpargne, 2) ?> Ar</div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <?php if ($tauxEpargne > 0): ?>
    <div class="alert alert-info">
      🏦 <strong><?= number_format($tauxEpargne, 0) ?>%</strong> de votre dépôt sera automatiquement placé dans votre épargne.
    </div>
    <?php endif; ?>

    <form method="post" action="/client/depot">
      <div class="form-group">
        <label>Montant à déposer (Ar)</label>
        <input type="number" name="montant" step="0.01" min="1" placeholder="Ex: 10000" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">📥 Déposer</button>
      <a href="/client/dashbord" class="btn btn-outline">← Retour</a>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
