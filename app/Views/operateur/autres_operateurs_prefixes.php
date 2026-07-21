<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header">
    <h3>📞 Préfixes — <?= esc($operateur['nom']) ?></h3>
    <a href="/operateur/autres-operateurs" class="btn btn-outline btn-sm">← Retour</a>
  </div>
  <div class="card-body">
    <form method="post" action="/operateur/autres-operateurs/prefixes/ajouter" class="form-inline" style="margin-bottom: 20px;">
      <input type="hidden" name="autre_operateur_id" value="<?= $operateur['id'] ?>">
      <input type="text" name="prefixe" maxlength="3" placeholder="ex: 032" class="form-control" required>
      <button type="submit" class="btn btn-primary">➕ Ajouter</button>
    </form>

    <?php if (empty($prefixes)): ?>
      <div class="empty-state">
        <div class="empty-icon">📞</div>
        <h4>Aucun préfixe pour <?= esc($operateur['nom']) ?></h4>
        <p>Ajoutez un préfixe pour identifier cet opérateur.</p>
      </div>
    <?php else: ?>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Préfixe</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($prefixes as $p): ?>
            <tr>
              <td><strong><?= esc($p['prefixe']) ?></strong></td>
              <td>
                <form method="post" action="/operateur/autres-operateurs/prefixes/supprimer/<?= $p['id'] ?>" style="display:inline">
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