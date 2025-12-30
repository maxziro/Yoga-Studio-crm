<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Parsifal Yoga Studio</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .dashboard-container {
            padding: 50px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="container">
            <h1 class="logo">Parsifal Yoga Studio <span style="font-size: 0.8em; color: var(--secondary-color);">|
                    CRM</span></h1>
            <nav>
                <ul>
                    <li><a href="/">Sito Pubblico</a></li>
                    <li><a href="/dashboard" class="<?php echo (!isset($view)) ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="/students"
                            class="<?php echo (isset($view) && strpos($view, 'students') !== false) ? 'active' : ''; ?>">Allievi</a>
                    </li>
                    <li><a href="/courses"
                            class="<?php echo (isset($view) && strpos($view, 'courses') !== false) ? 'active' : ''; ?>">Corsi</a>
                    </li>
                    <li><a href="/subscription-types"
                            class="<?php echo (isset($view) && strpos($view, 'subscription_types') !== false) ? 'active' : ''; ?>">Abbonamenti</a>
                    </li>
                    <li><a href="/payments"
                            class="<?php echo (isset($view) && strpos($view, 'payments') !== false) ? 'active' : ''; ?>">Entrate</a>
                    </li>
                    <li><a href="/settings"
                            class="<?php echo (isset($view) && strpos($view, 'settings') !== false) ? 'active' : ''; ?>">Impostazioni</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar / Navigation is handled in Header for now, could be improved -->

        <?php if (isset($view) && file_exists(__DIR__ . '/' . $view)): ?>
            <?php include __DIR__ . '/' . $view; ?>
        <?php else: ?>
            <!-- Default Dashboard Home -->
            <div class="dashboard-card">
                <h2>Benvenuto nel Backend</h2>
                <p>Area amministrativa Parsifal Yoga Studio.</p>
            </div>

            <div class="dashboard-card">
                <h3>Statistiche Veloci</h3>
                <p>Iscritti: 0</p>
                <p>Lezioni oggi: 0</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>