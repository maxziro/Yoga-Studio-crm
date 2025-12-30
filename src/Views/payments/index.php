<div class="dashboard-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2>Gestione Entrate</h2>
            <p style="margin: 5px 0; font-size: 1.2em; color: var(--secondary-color); font-weight: 600;">
                Totale: €
                <?php echo number_format($totalRevenue, 2, ',', '.'); ?>
            </p>
        </div>
        <a href="/payments/create" class="cta-button" style="text-decoration: none; font-size: 0.9em;">+ Nuovo
            Pagamento</a>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #eee;">
                <th style="padding: 10px;">Data</th>
                <th style="padding: 10px;">Studente</th>
                <th style="padding: 10px;">Abbonamento</th>
                <th style="padding: 10px;">Importo</th>
                <th style="padding: 10px;">Metodo</th>
                <th style="padding: 10px;">Note</th>
                <th style="padding: 10px;">Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($payments)): ?>
                <?php foreach ($payments as $payment): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">
                            <?php echo date('d/m/Y', strtotime($payment['payment_date'])); ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php echo htmlspecialchars($payment['student_name']); ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php echo htmlspecialchars($payment['subscription_name']); ?>
                        </td>
                        <td style="padding: 10px; font-weight: 600;">€
                            <?php echo number_format($payment['amount'], 2, ',', '.'); ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php
                            $methods = [
                                'cash' => 'Contanti',
                                'bank_transfer' => 'Bonifico',
                                'credit_card' => 'Carta di Credito'
                            ];
                            echo $methods[$payment['payment_method']] ?? $payment['payment_method'];
                            ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php echo htmlspecialchars($payment['notes'] ?? '-'); ?>
                        </td>
                        <td style="padding: 10px;">
                            <a href="/payments/edit?id=<?php echo $payment['id']; ?>"
                                style="color: var(--secondary-color); text-decoration: none; margin-right: 10px;">Modifica</a>
                            <a href="/payments/delete?id=<?php echo $payment['id']; ?>"
                                onclick="return confirm('Sei sicuro di voler eliminare questo pagamento?');"
                                style="color: red; text-decoration: none;">Elimina</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="padding: 20px; text-align: center; color: #777;">Nessun pagamento registrato.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>