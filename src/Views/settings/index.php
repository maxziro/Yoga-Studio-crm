<div class="dashboard-card">
    <h2>Gestione Amministratore</h2>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <form action="/settings/update_password" method="POST" style="max-width: 400px; margin-bottom: 30px;">
        <h3>Cambia Password Admin</h3>
        <div class="form-group">
            <label>Nuova Password</label>
            <input type="password" name="password" required placeholder="Inserisci nuova password">
        </div>
        <button type="submit" class="cta-button">Aggiorna Password</button>
    </form>
</div>

<div class="dashboard-card" style="border-top: 5px solid #ffa500;">
    <h2>Strumenti Sviluppo & Dati</h2>

    <div style="margin-bottom: 30px;">
        <h3>Popolamento Dati</h3>
        <p>Aggiungi 10 allievi di prova al database.</p>
        <form action="/settings/seed" method="POST">
            <button type="submit" class="cta-button" style="background-color: #2196F3;">Popola Database (Seed)</button>
        </form>
    </div>
</div>

<div class="dashboard-card" style="border-top: 5px solid red;">
    <h2 style="color: red;">Zona Pericolosa: Gestione Database</h2>

    <div style="margin-bottom: 30px;">
        <h3>Elimina Tabelle Singole</h3>
        <table style="width: 100%; text-align: left; margin-top: 10px;">
            <?php if (!empty($tables)): ?>
                <?php foreach ($tables as $table): ?>
                    <tr>
                        <td style="padding: 5px;"><?php echo $table; ?></td>
                        <td>
                            <?php if ($table !== 'users'): ?>
                                <form action="/settings/drop_table" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Sei sicuro di voler ELIMINARE la tabella <?php echo $table; ?>? I dati andranno persi.');">
                                    <input type="hidden" name="table" value="<?php echo $table; ?>">
                                    <button type="submit"
                                        style="background: red; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px;">Elimina</button>
                                </form>
                            <?php else: ?>
                                <span style="color: #999; font-size: 0.8em;">(Protetto)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nessuna tabella trovata.</p>
            <?php endif; ?>
        </table>
    </div>

    <div>
        <h3>Reset Totale</h3>
        <p>Attenzione: Questa azione cancellerà TUTTE le tabelle e i dati.</p>
        <form action="/settings/nuke" method="POST"
            onsubmit="return confirm('SEI SICURO? QUESTA AZIONE CANCELLERÀ TUTTO IL DATABASE E NON È REVERSIBILE!');">
            <button type="submit"
                style="background: darkred; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold;">ELIMINA
                TUTTO IL DATABASE</button>
        </form>
    </div>
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