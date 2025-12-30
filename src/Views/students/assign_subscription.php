<div class="dashboard-card">
    <h2>Assegna Abbonamento a
        <?php echo htmlspecialchars($student->name); ?>
    </h2>

    <?php if (isset($error)): ?>
        <div style="padding: 10px; background: #ffebee; color: #c62828; border-radius: 4px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="/students/store-subscription" method="POST">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($student->id); ?>">

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo di Abbonamento *</label>
            <select name="subscription_type_id" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
                <option value="">Seleziona abbonamento...</option>
                <?php if (!empty($subscriptionTypes)): ?>
                    <?php foreach ($subscriptionTypes as $type): ?>
                        <option value="<?php echo $type['id']; ?>">
                            <?php
                            echo htmlspecialchars($type['name']);
                            echo ' - €' . number_format($type['price'], 2, ',', '.');
                            $typeLabel = $type['type'] === 'single_weekly' ? ' (1 Lezione/Settimana)' : ' (Accesso Full)';
                            echo $typeLabel;
                            ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Data Inizio *</label>
                <input type="date" name="start_date" required value="<?php echo date('Y-m-d'); ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Data Fine *</label>
                <input type="date" name="end_date" required value="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Stato *</label>
            <select name="status" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
                <option value="active" selected>Attivo</option>
                <option value="suspended">Sospeso</option>
                <option value="expired">Scaduto</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="cta-button">Assegna Abbonamento</button>
            <a href="/students/subscriptions?id=<?php echo $student->id; ?>" class="cta-button"
                style="background: #6c757d; text-decoration: none; display: inline-block;">Annulla</a>
        </div>
    </form>
</div>