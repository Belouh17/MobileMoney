<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header">
    <h3>🔄 Transfert d'argent</h3>
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
      <?php if ($promo > 0): ?>
      <div class="stat-card">
        <div class="stat-icon yellow">🎉</div>
        <div class="stat-info">
          <div class="stat-label">Promotion en cours</div>
          <div class="stat-value">-<?= number_format($promo, 0) ?>% sur les frais</div>
          <div class="stat-sub">Valable sur les transferts internes</div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <?php if ($promo > 0): ?>
    <div class="alert alert-info">
      🎉 Promotion : <strong>-<?= number_format($promo, 0) ?>%</strong> sur les frais de transfert interne !
    </div>
    <?php endif; ?>

    <form method="post" action="/client/transfert">
      <div class="form-group">
        <label>Numéro du destinataire</label>
        <input type="text" name="telephone_destinataire" placeholder="Ex: 0331234567" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Montant (Ar)</label>
        <input type="number" name="montant" step="0.01" min="1" placeholder="Ex: 10000" class="form-control" required>
      </div>

      <div class="form-group">
        <label class="form-checkbox">
          <input type="checkbox" name="option_frais_retrait" value="AVEC_FRAIS_RETRAIT">
          Inclure les frais de retrait (le destinataire retire sans frais)
        </label>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
          Cette option ne s'applique qu'aux transferts vers notre réseau.
        </p>
      </div>

      <button type="submit" class="btn btn-primary">🔄 Envoyer</button>
      <a href="/client/dashbord" class="btn btn-outline">← Retour</a>
    </form>
  </div>
</div>
<?= $this->endSection() ?>