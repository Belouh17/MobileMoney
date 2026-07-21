<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header">
    <h3>💰 Montants à envoyer par opérateur</h3>
  </div>
  <div class="card-body">
    <?php if (empty($montants)): ?>
      <div class="empty-state">
        <div class="empty-icon">💰</div>
        <h4>Aucun montant à envoyer</h4>
        <p>Tous les montants sont à jour.</p>
      </div>
    <?php else: ?>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Opérateur</th>
              <th>Montant total à envoyer</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($montants as $m): ?>
            <tr>
              <td><strong><?= esc($m['autre_operateur']) ?></strong></td>
              <td><strong><?= number_format($m['montant_total_a_envoyer'], 2) ?> Ar</strong></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection() ?>