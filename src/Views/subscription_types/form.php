<div class="dashboard-card">
    <h2>
        <?php echo isset($subscriptionType) ? 'Modifica Tipo di Abbonamento' : 'Nuovo Tipo di Abbonamento'; ?>
    </h2>

    <?php if (isset($error)): ?>
        <div style="padding: 10px; background: #ffebee; color: #c62828; border-radius: 4px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo isset($subscriptionType) ? '/subscription-types/update' : '/subscription-types/store'; ?>"
        method="POST">
        <?php if (isset($subscriptionType)): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subscriptionType->id); ?>">
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nome Abbonamento *</label>
            <input type="text" name="name" required
                value="<?php echo isset($subscriptionType) ? htmlspecialchars($subscriptionType->name) : ''; ?>"
                placeholder="es. Abbonamento Mensile"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo di Accesso *</label>
            <select name="type" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
                <option value="">Seleziona...</option>
                <option value="single_weekly" <?php echo (isset($subscriptionType) && $subscriptionType->type == 'single_weekly') ? 'selected' : ''; ?>>1 Lezione/Settimana</option>
                <option value="full_access" <?php echo (isset($subscriptionType) && $subscriptionType->type == 'full_access') ? 'selected' : ''; ?>>Accesso Full</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Prezzo (€) *</label>
            <input type="number" name="price" required min="0" step="0.01"
                value="<?php echo isset($subscriptionType) ? htmlspecialchars($subscriptionType->price) : ''; ?>"
                placeholder="50.00"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descrizione</label>
            <textarea name="description" rows="4" placeholder="Descrizione opzionale dell'abbonamento"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;"><?php echo isset($subscriptionType) ? htmlspecialchars($subscriptionType->description) : ''; ?></textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="cta-button">
                <?php echo isset($subscriptionType) ? 'Aggiorna' : 'Crea'; ?> Tipo
            </button>
            <a href="/subscription-types" class="cta-button"
                style="background: #6c757d; text-decoration: none; display: inline-block;">Annulla</a>
        </div>
    </form>
</div>