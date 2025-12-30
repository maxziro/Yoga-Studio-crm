<div class="dashboard-card">
    <h2>
        <?php echo isset($payment) ? 'Modifica Pagamento' : 'Nuovo Pagamento'; ?>
    </h2>

    <?php if (isset($error)): ?>
        <div style="padding: 10px; background: #ffebee; color: #c62828; border-radius: 4px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo isset($payment) ? '/payments/update' : '/payments/store'; ?>" method="POST">
        <?php if (isset($payment)): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($payment->id); ?>">
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Abbonamento Studente *</label>
            <select name="student_subscription_id" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
                <option value="">Seleziona abbonamento...</option>
                <?php if (!empty($subscriptions)): ?>
                    <?php foreach ($subscriptions as $sub): ?>
                        <option value="<?php echo $sub['id']; ?>" <?php echo (isset($payment) && $payment->student_subscription_id == $sub['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($sub['student_name']) . ' - ' . htmlspecialchars($sub['subscription_name']); ?>
                            (
                            <?php echo date('d/m/Y', strtotime($sub['start_date'])); ?> -
                            <?php echo date('d/m/Y', strtotime($sub['end_date'])); ?>)
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Importo (€) *</label>
                <input type="number" name="amount" required min="0" step="0.01"
                    value="<?php echo isset($payment) ? htmlspecialchars($payment->amount) : ''; ?>" placeholder="50.00"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Data Pagamento *</label>
                <input type="date" name="payment_date" required
                    value="<?php echo isset($payment) ? htmlspecialchars($payment->payment_date) : date('Y-m-d'); ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Metodo di Pagamento *</label>
            <select name="payment_method" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
                <option value="">Seleziona...</option>
                <option value="cash" <?php echo (isset($payment) && $payment->payment_method == 'cash') ? 'selected' : ''; ?>>Contanti</option>
                <option value="bank_transfer" <?php echo (isset($payment) && $payment->payment_method == 'bank_transfer') ? 'selected' : ''; ?>>Bonifico</option>
                <option value="credit_card" <?php echo (isset($payment) && $payment->payment_method == 'credit_card') ? 'selected' : ''; ?>>Carta di Credito</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Note</label>
            <textarea name="notes" rows="3" placeholder="Note opzionali sul pagamento"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;"><?php echo isset($payment) ? htmlspecialchars($payment->notes) : ''; ?></textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="cta-button">
                <?php echo isset($payment) ? 'Aggiorna' : 'Registra'; ?> Pagamento
            </button>
            <a href="/payments" class="cta-button"
                style="background: #6c757d; text-decoration: none; display: inline-block;">Annulla</a>
        </div>
    </form>
</div>