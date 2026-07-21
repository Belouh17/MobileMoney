<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>👥 Envoi multiple (même opérateur)</h3>
    </div>
    <div class="card-body">
        <div class="stat-card" style="margin-bottom: 24px;">
            <div class="stat-icon green">💰</div>
            <div class="stat-info">
                <div class="stat-label">Solde actuel</div>
                <div class="stat-value"><?= number_format($client['solde'], 2) ?> Ar</div>
            </div>
        </div>

        <form method="post" action="/client/transfert-multiple">
            <div class="form-group">
                <label>Numéros destinataires (séparés par des virgules)</label>
                <textarea name="numeros" rows="3" placeholder="Ex: 0331234567,0337654321,0341234567" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>Montant total à répartir (Ar)</label>
                <input type="number" name="montant_total" step="0.01" min="1" placeholder="Ex: 30000" class="form-control" required>
            </div>

            <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 16px;">
                Le montant total est divisé à parts égales entre chaque numéro. Tous les numéros doivent appartenir à notre réseau.
            </p>

            <button type="submit" class="btn btn-primary">👥 Envoyer</button>
            <a href="/client/dashbord" class="btn btn-outline">← Retour</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>