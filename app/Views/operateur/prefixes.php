<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header">
    <h3>📞 Préfixes de l'opérateur</h3>
    <span class="badge badge-info"><?= count($prefixes) ?> préfixe(s)</span>
  </div>
  <div class="card-body">
    <form method="post" action="/operateur/prefixes/ajouter" class="form-inline" style="margin-bottom: 20px;">
      <input type="text" name="prefixe" maxlength="3" placeholder="ex: 033" class="form-control" required>
      <button type="submit" class="btn btn-primary">➕ Ajouter</button>
    </form>

    <?php if (empty($prefixes)): ?>
      <div class="empty-state">
        <div class="empty-icon">📞</div>
        <h4>Aucun préfixe configuré</h4>
        <p>Ajoutez un préfixe ci-dessus pour commencer.</p>
      </div>
    <?php else: ?>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Préfixe</th>
              <th>Date de création</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($prefixes as $p): ?>
            <tr>
              <td><strong><?= esc($p['prefixe']) ?></strong></td>
              <td><?= $p['date_creation'] ?? '—' ?></td>
              <td>
                <form method="post" action="/operateur/prefixes/supprimer/<?= $p['id'] ?>" style="display:inline">
                  <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                </form>
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