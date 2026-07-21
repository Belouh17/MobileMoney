<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon indigo">🏦</div>
    <div class="stat-info">
      <div class="stat-label">Taux d'épargne actuel</div>
      <div class="stat-value"><?= number_format($tauxEpargne, 0) ?>%</div>
      <div class="stat-sub">Appliqué à chaque dépôt</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">💰</div>
    <div class="stat-info">
      <div class="stat-label">Montant épargné total</div>
      <div class="stat-value"><?= number_format($montantEpargne, 2) ?> Ar</div>
      <div class="stat-sub">Cumul de vos dépôts</div>
    </div>
  </div>
</div>

<div class="card" style="margin-bottom: 20px;">
  <div class="card-header">
    <h3>🏦 Définir mon taux d'épargne</h3>
  </div>
  <div class="card-body">
    <p style="color: var(--text-secondary); margin-bottom: 16px;">
      Un pourcentage de vos dépôts sera automatiquement mis de côté.
    </p>
    <form method="post" action="/client/epargne/definir">
      <div class="form-group">
        <label>Pourcentage d'épargne (0% — 100%)</label>
        <input type="number" name="pourcentage" min="0" max="100" step="1" value="<?= (int) $tauxEpargne ?>" class="form-control" style="max-width: 200px;" required>
      </div>
      <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3>💡 Comment ça fonctionne ?</h3>
  </div>
  <div class="card-body">
    <ul style="color: var(--text-secondary); line-height: 2; padding-left: 20px;">
      <li>Définissez un pourcentage entre 0% et 100%</li>
      <li>Lors de chaque dépôt, ce pourcentage est prélevé et mis de côté</li>
      <li>L'épargne est déduite du montant déposé avant crédit du solde</li>
      <li>Vous pouvez modifier ce taux à tout moment</li>
    </ul>
  </div>
</div>
<?= $this->endSection() ?>