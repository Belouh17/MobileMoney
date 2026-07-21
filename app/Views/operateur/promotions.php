<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header">
    <h3>🎉 Gestion des promotions</h3>
  </div>
  <div class="card-body">
    <div class="stat-card" style="margin-bottom: 24px;">
      <div class="stat-icon yellow">🎉</div>
      <div class="stat-info">
        <div class="stat-label">Promotion actuelle</div>
        <div class="stat-value"><?= number_format($promo, 0) ?>%</div>
        <div class="stat-sub">Réduction sur les frais de transfert interne</div>
      </div>
    </div>

    <form method="post" action="/operateur/promotions/modifier">
      <div class="form-group">
        <label>Pourcentage de réduction (0% — 100%)</label>
        <input type="number" name="promo_pourcentage" min="0" max="100" step="1" value="<?= (int) $promo ?>" class="form-control" style="max-width: 200px;" required>
      </div>
      <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>

    <hr style="margin: 24px 0; border-color: var(--border);">

    <div class="card" style="box-shadow: none; border: 1px solid var(--border);">
      <div class="card-header">
        <h3>💡 Comment ça fonctionne ?</h3>
      </div>
      <div class="card-body">
        <ul style="color: var(--text-secondary); line-height: 2; padding-left: 20px;">
          <li>La promotion s'applique sur les <strong>frais de transfert interne</strong> (vers notre réseau)</li>
          <li>Le pourcentage défini est déduit des frais de transfert</li>
          <li>Les clients voient la promotion affichée sur leur page de transfert</li>
          <li>Mettez 0% pour désactiver la promotion</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>