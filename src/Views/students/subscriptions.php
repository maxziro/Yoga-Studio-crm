<div class="dashboard-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Abbonamenti di
            <?php echo htmlspecialchars($student->name); ?>
        </h2>
        <div style="display: flex; gap: 10px;">
            <a href="/students/assign-subscription?id=<?php echo $student->id; ?>" class="cta-button"
                style="text-decoration: none; font-size: 0.9em;">+ Assegna Abbonamento</a>
            <a href="/students" class="cta-button"
                style="background: #6c757d; text-decoration: none; font-size: 0.9em;">Torna alla Lista</a>
        </div>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #eee;">
                <th style="padding: 10px;">Abbonamento</th>
                <th style="padding: 10px;">Tipo</th>
                <th style="padding: 10px;">Periodo</th>
                <th style="padding: 10px;">Prezzo</th>
                <th style="padding: 10px;">Stato</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($subscriptions)): ?>
                <?php foreach ($subscriptions as $sub): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">
                            <?php echo htmlspecialchars($sub['subscription_name']); ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php
                            $typeLabel = $sub['type'] === 'single_weekly' ? '1 Lezione/Settimana' : 'Accesso Full';
                            echo htmlspecialchars($typeLabel);
                            ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php
                            $start = date('d/m/Y', strtotime($sub['start_date']));
                            $end = date('d/m/Y', strtotime($sub['end_date']));
                            echo "$start - $end";
                            ?>
                        </td>
                        <td style="padding: 10px;">€
                            <?php echo number_format($sub['price'], 2, ',', '.'); ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php
                            $statusColors = [
                                'active' => '#4caf50',
                                'expired' => '#f44336',
                                'suspended' => '#ff9800'
                            ];
                            $statusLabels = [
                                'active' => 'Attivo',
                                'expired' => 'Scaduto',
                                'suspended' => 'Sospeso'
                            ];
                            $color = $statusColors[$sub['status']] ?? '#999';
                            $label = $statusLabels[$sub['status']] ?? $sub['status'];
                            ?>
                            <span
                                style="padding: 4px 8px; background: <?php echo $color; ?>; color: white; border-radius: 4px; font-size: 0.85em;">
                                <?php echo $label; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="padding: 20px; text-align: center; color: #777;">Nessun abbonamento assegnato.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>