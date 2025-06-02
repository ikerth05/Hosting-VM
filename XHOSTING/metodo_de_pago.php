<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Método de Pago - Xhosting</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/icono.svg" type="image/svg">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 80px auto;
            padding: 40px;
            background-color: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .method {
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .method:hover {
            border-color: #0066ff;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
        }

        .method h3 {
            margin: 0 0 10px;
        }

        .method p {
            margin: 0;
            color: #555;
        }

        .back-link {
            display: block;
            margin-top: 40px;
            text-align: center;
            text-decoration: none;
            color: #0066ff;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Elige tu método de pago</h1>

        <div class="payment-methods">
            <a href="pago_completado.html" style="text-decoration: none; color: inherit;">
                <div class="method">
                    <h3>💳 Tarjeta de crédito / débito</h3>
                    <p>Paga de forma segura con tu tarjeta Visa, MasterCard o similar.</p>
                </div>
            </a>
            
            <a href="pago_completado.html" style="text-decoration: none; color: inherit;">
                <div class="method">
                    <h3>🅿️ PayPal</h3>
                    <p>Usa tu cuenta PayPal para pagar rápida y cómodamente.</p>
                </div>
            </a>
            <a href="pago_completado.html" style="text-decoration: none; color: inherit;">
                <div class="method">
                    <h3>📱 Bizum</h3>
                    <p>Realiza el pago al instante desde tu móvil mediante Bizum.</p>
                </div>
            </a>
        </div>

        <a href="index.php" class="back-link">← Volver al inicio</a>
    </div>
</body>
</html>
