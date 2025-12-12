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

<div class="dashboard-card" style="margin-top: 30px;">
    <h2>Strumenti Sviluppo & Dati</h2>

    <div style="margin-bottom: 30px;">
        <h3>Popolamento Dati</h3>
        <p>Aggiungi 10 allievi con nomi verosimili al database.</p>
        <form action="/settings/seed" method="POST">
            <button type="submit" class="cta-button">Popola Database (Seed)</button>
        </form>
    </div>

    <div style="margin-bottom: 30px; border-top: 1px solid #eee; padding-top: 20px;">
        <h3>Export & Import Completo</h3>
        <p>Esporta o ripristina l'intero database (struttura e dati).</p>

        <div style="display: flex; gap: 20px; align-items: flex-start; flex-wrap: wrap;">
            <div>
                <h4>Esporta</h4>
                <a href="/settings/export" class="cta-button"
                    style="text-decoration: none; display: inline-block;">Scarica Backup SQL</a>
            </div>

            <div style="flex: 1; min-width: 300px;">
                <h4>Importa</h4>
                <form action="/settings/import" method="POST" enctype="multipart/form-data"
                    onsubmit="return confirm('ATTENZIONE: Questa operazione sovrascriverà i dati esistenti. Sei sicuro?');">
                    <div style="display: flex; gap: 10px;">
                        <input type="file" name="backup_file" accept=".sql" required
                            style="border: 1px solid #ddd; padding: 5px;">
                        <button type="submit" class="cta-button" style="background-color: #f39c12;">Ripristina</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 30px; border-top: 1px solid #eee; padding-top: 20px;">
        <h3>Gestione Tabelle</h3>
        <table style="width: 100%; text-align: left; margin-top: 15px; border-collapse: collapse;">
            <?php if (!empty($tables)): ?>
                <?php foreach ($tables as $table): ?>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 10px;"><?php echo $table; ?></td>
                        <td style="text-align: right;">
                            <?php if ($table !== 'users'): ?>
                                <form action="/settings/drop_table" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Sei sicuro di voler ELIMINARE la tabella <?php echo $table; ?>? I dati andranno persi.');">
                                    <input type="hidden" name="table" value="<?php echo $table; ?>">
                                    <button type="submit"
                                        style="background: transparent; color: #d32f2f; border: 1px solid #ddd; padding: 5px 10px; cursor: pointer; border-radius: 4px; font-size: 0.9em;">Elimina</button>
                                </form>
                            <?php else: ?>
                                <span style="color: #999; font-size: 0.8em; padding: 5px 10px;">(Protetto)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nessuna tabella trovata.</p>
            <?php endif; ?>
        </table>
    </div>

    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
        <h3 style="color: #d32f2f;">Zona Pericolosa</h3>
        <p style="font-size: 0.9em; color: #666;">Questa azione cancellerà tutto il contenuto del database.</p>
        <form action="/settings/nuke" method="POST"
            onsubmit="return confirm('SEI SICURO? QUESTA AZIONE CANCELLERÀ TUTTO IL DATABASE E NON È REVERSIBILE!');">
            <button type="submit"
                style="background: #fee; color: #d32f2f; border: 1px solid #d32f2f; padding: 8px 15px; cursor: pointer; border-radius: 4px;">Elimina
                Tutto il Database</button>
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