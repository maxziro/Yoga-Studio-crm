<div class="dashboard-card">
    <h2>
        <?php echo isset($course) ? 'Modifica Corso' : 'Nuovo Corso'; ?>
    </h2>

    <?php if (isset($error)): ?>
        <div style="padding: 10px; background: #ffebee; color: #c62828; border-radius: 4px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo isset($course) ? '/courses/update' : '/courses/store'; ?>" method="POST">
        <?php if (isset($course)): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($course->id); ?>">
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nome Corso *</label>
            <input type="text" name="name" required
                value="<?php echo isset($course) ? htmlspecialchars($course->name) : ''; ?>"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Periodicità *</label>
            <select name="periodicity" id="periodicity" required
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;"
                onchange="toggleDayOfWeek()">
                <option value="">Seleziona...</option>
                <option value="settimanale" <?php echo (isset($course) && $course->periodicity == 'settimanale') ? 'selected' : ''; ?>>Settimanale</option>
                <option value="mensile" <?php echo (isset($course) && $course->periodicity == 'mensile') ? 'selected' : ''; ?>>Mensile</option>
                <option value="giornaliera" <?php echo (isset($course) && $course->periodicity == 'giornaliera') ? 'selected' : ''; ?>>Giornaliera</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;" id="day_of_week_container">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Giorno della Settimana</label>
            <select name="day_of_week" id="day_of_week"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
                <option value="">Nessuno</option>
                <option value="lunedì" <?php echo (isset($course) && $course->day_of_week == 'lunedì') ? 'selected' : ''; ?>>Lunedì</option>
                <option value="martedì" <?php echo (isset($course) && $course->day_of_week == 'martedì') ? 'selected' : ''; ?>>Martedì</option>
                <option value="mercoledì" <?php echo (isset($course) && $course->day_of_week == 'mercoledì') ? 'selected' : ''; ?>>Mercoledì</option>
                <option value="giovedì" <?php echo (isset($course) && $course->day_of_week == 'giovedì') ? 'selected' : ''; ?>>Giovedì</option>
                <option value="venerdì" <?php echo (isset($course) && $course->day_of_week == 'venerdì') ? 'selected' : ''; ?>>Venerdì</option>
                <option value="sabato" <?php echo (isset($course) && $course->day_of_week == 'sabato') ? 'selected' : ''; ?>>Sabato</option>
                <option value="domenica" <?php echo (isset($course) && $course->day_of_week == 'domenica') ? 'selected' : ''; ?>>Domenica</option>
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Data Inizio *</label>
                <input type="date" name="start_date" required
                    value="<?php echo isset($course) ? htmlspecialchars($course->start_date) : ''; ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Data Fine *</label>
                <input type="date" name="end_date" required
                    value="<?php echo isset($course) ? htmlspecialchars($course->end_date) : ''; ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Orario *</label>
                <input type="time" name="time" required
                    value="<?php echo isset($course) ? htmlspecialchars($course->time) : ''; ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Durata (minuti) *</label>
                <input type="number" name="duration" required min="15" step="5"
                    value="<?php echo isset($course) ? htmlspecialchars($course->duration) : '60'; ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="cta-button">
                <?php echo isset($course) ? 'Aggiorna' : 'Crea'; ?> Corso
            </button>
            <a href="/courses" class="cta-button"
                style="background: #6c757d; text-decoration: none; display: inline-block;">Annulla</a>
        </div>
    </form>
</div>

<script>
    function toggleDayOfWeek() {
        const periodicity = document.getElementById('periodicity').value;
        const dayOfWeekContainer = document.getElementById('day_of_week_container');
        const dayOfWeekSelect = document.getElementById('day_of_week');

        if (periodicity === 'settimanale') {
            dayOfWeekContainer.style.display = 'block';
            dayOfWeekSelect.required = true;
        } else {
            dayOfWeekContainer.style.display = 'none';
            dayOfWeekSelect.required = false;
            dayOfWeekSelect.value = '';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function () {
        toggleDayOfWeek();
    });
</script>