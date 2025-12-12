<div class="dashboard-card">
    <h2><?php echo isset($student->id) ? 'Modifica Allievo' : 'Nuovo Allievo'; ?></h2>

    <?php if (isset($error)): ?>
        <p style="color: red; margin-bottom: 15px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="<?php echo isset($student->id) ? '/students/update' : '/students/store'; ?>" method="POST"
        style="max-width: 500px;">
        <?php if (isset($student->id)): ?>
            <input type="hidden" name="id" value="<?php echo $student->id; ?>">
        <?php endif; ?>

        <div class="form-group">
            <label>Nome Completo</label>
            <input type="text" name="name" required value="<?php echo isset($student->name) ? $student->name : ''; ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required
                value="<?php echo isset($student->email) ? $student->email : ''; ?>">
        </div>

        <?php if (!isset($student->id)): ?>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
        <?php else: ?>
            <p style="font-size: 0.8em; color: #777;">La modifica della password non è ancora disponibile qui.</p>
        <?php endif; ?>

        <div style="margin-top: 20px;">
            <button type="submit" class="cta-button"><?php echo isset($student->id) ? 'Aggiorna' : 'Crea'; ?></button>
            <a href="/students" style="margin-left: 15px; color: #777; text-decoration: none;">Annulla</a>
        </div>
    </form>
</div>
<style>
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>