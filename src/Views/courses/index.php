<div class="dashboard-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Gestione Corsi</h2>
        <a href="/courses/create" class="cta-button" style="text-decoration: none; font-size: 0.9em;">+ Nuovo Corso</a>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #eee;">
                <th style="padding: 10px;">Nome Corso</th>
                <th style="padding: 10px;">Periodicità</th>
                <th style="padding: 10px;">Periodo</th>
                <th style="padding: 10px;">Giorno e Orario</th>
                <th style="padding: 10px;">Durata</th>
                <th style="padding: 10px;">Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">
                            <?php echo htmlspecialchars($course['name']); ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php echo htmlspecialchars(ucfirst($course['periodicity'])); ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php
                            $start = date('d/m/Y', strtotime($course['start_date']));
                            $end = date('d/m/Y', strtotime($course['end_date']));
                            echo "$start - $end";
                            ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php
                            if ($course['day_of_week']) {
                                echo htmlspecialchars(ucfirst($course['day_of_week'])) . ' ';
                            }
                            echo date('H:i', strtotime($course['time']));
                            ?>
                        </td>
                        <td style="padding: 10px;">
                            <?php echo htmlspecialchars($course['duration']); ?> min
                        </td>
                        <td style="padding: 10px;">
                            <a href="/courses/edit?id=<?php echo $course['id']; ?>"
                                style="color: var(--secondary-color); text-decoration: none; margin-right: 10px;">Modifica</a>
                            <a href="/courses/delete?id=<?php echo $course['id']; ?>"
                                onclick="return confirm('Sei sicuro di voler eliminare questo corso?');"
                                style="color: red; text-decoration: none;">Elimina</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 20px; text-align: center; color: #777;">Nessun corso trovato.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>