<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header">
    <h3>⚙️ Types d'opérations</h3>
    <span class="badge badge-info"><?= count($types) ?> type(s)</span>
  </div>
  <div class="card-body">
    <form method="post" action="/operateur/types/ajouter" class="form-row" style="margin-bottom: 20px;">
      <div class="form-group">
        <label>Code</label>
        <input type="text" name="code" placeholder="ex: DEPOT" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Libellé</label>
        <input type="text" name="libelle" placeholder="ex: Dépôt" class="form-control" required>
      </div>
      <div class="form-group" style="display:flex;align-items:flex-end;">
        <button type="submit" class="btn btn-primary">➕ Ajouter</button>
      </div>
    </form>

    <?php if (empty($types)): ?>
      <div class="empty-state">
        <div class="empty-icon">⚙️</div>
        <h4>Aucun type d'opération</h4>
        <p>Ajoutez un type d'opération pour configurer les barèmes.</p>
      </div>
    <?php else: ?>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Code</th>
              <th>Libellé</th>
              <th>Barèmes</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($types as $t): ?>
            <tr>
              <td><span class="badge badge-info"><?= esc($t['code']) ?></span></td>
              <td><?= esc($t['libelle']) ?></td>
              <td>
                <a href="/operateur/baremes/<?= $t['id'] ?>" class="btn btn-info btn-sm">📊 Voir barèmes</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection() ?>