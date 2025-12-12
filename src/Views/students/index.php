<div class="dashboard-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Gestione Allievi</h2>
        <a href="/students/create" class="cta-button" style="text-decoration: none; font-size: 0.9em;">+ Nuovo
            Allievo</a>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #eee;">
                <th style="padding: 10px;">Nome</th>
                <th style="padding: 10px;">Email</th>
                <th style="padding: 10px;">Ruolo</th>
                <th style="padding: 10px;">Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $student): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;"><?php echo htmlspecialchars($student['name']); ?></td>
                        <td style="padding: 10px;"><?php echo htmlspecialchars($student['email']); ?></td>
                        <td style="padding: 10px;"><?php echo htmlspecialchars($student['role']); ?></td>
                        <td style="padding: 10px;">
                            <a href="/students/edit?id=<?php echo $student['id']; ?>"
                                style="color: var(--secondary-color); text-decoration: none; margin-right: 10px;">Modifica</a>
                            <a href="/students/delete?id=<?php echo $student['id']; ?>"
                                onclick="return confirm('Sei sicuro di voler eliminare questo allievo?');"
                                style="color: red; text-decoration: none;">Elimina</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="padding: 20px; text-align: center; color: #777;">Nessun allievo trovato.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>