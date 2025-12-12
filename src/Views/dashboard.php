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
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1 class="logo">Parsifal Yoga Studio <span style="font-size: 0.8em; color: var(--secondary-color);">| CRM</span></h1>
            <nav>
                <ul>
                    <li><a href="/">Sito Pubblico</a></li>
                    <li><a href="#" class="active">Dashboard</a></li>
                    <li><a href="#">Studenti</a></li>
                    <li><a href="#">Corsi</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dashboard-container">
        <div class="dashboard-card">
            <h2>Benvenuto nel Backend</h2>
            <p>Questa è l'area amministrativa (Accesso Libero per ora).</p>
        </div>

        <div class="dashboard-card">
            <h3>Statistiche Veloci</h3>
            <p>Iscritti: 0</p>
            <p>Lezioni oggi: 0</p>
        </div>
    </div>
</body>
</html>
