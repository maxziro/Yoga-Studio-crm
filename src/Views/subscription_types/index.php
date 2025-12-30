<div class="dashboard-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Tipi di Abbonamento</h2>
        <a href="/subscription-types/create" class="cta-button" style="text-decoration: none; font-size: 0.9em;">+ Nuovo
            Tipo</a>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #eee;">
                <th style="padding: 10px;">Nome</th>
                <th style="padding: 10px;">Tipo</th>
                <th style="padding: 10px;">Prezzo</th>
                <th style="padding: 10px;">Descrizione</th>
                <th style="padding: 10px;">Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($subscriptionTypes)): ?>
                <?php foreach ($subscriptionTypes as $type): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">
                            <?php echo htmlspecialchars($type['name']); ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php
                            $typeLabel = $type['type'] === 'single_weekly' ? '1 Lezione/Settimana' : 'Accesso Full';
                            echo htmlspecialchars($typeLabel);
                            ?>
                        </td>
                        <td style="padding: 10px;">€
                            <?php echo number_format($type['price'], 2, ',', '.'); ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php echo htmlspecialchars($type['description'] ?? '-'); ?>
                        </td>
                        <td style="padding: 10px;">
                            <a href="/subscription-types/edit?id=<?php echo $type['id']; ?>"
                                style="color: var(--secondary-color); text-decoration: none; margin-right: 10px;">Modifica</a>
                            <a href="/subscription-types/delete?id=<?php echo $type['id']; ?>"
                                onclick="return confirm('Sei sicuro di voler eliminare questo tipo di abbonamento?');"
                                style="color: red; text-decoration: none;">Elimina</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="padding: 20px; text-align: center; color: #777;">Nessun tipo di abbonamento
                        trovato.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>