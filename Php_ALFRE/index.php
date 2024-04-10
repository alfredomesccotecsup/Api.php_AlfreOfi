<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-wiGFG, initial-scale=1.0">
<title>Buscador de GIFs_Apitener</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%);
        background-size: cover;
    }

    .container {
        width: 400px;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    input[type="number"] {
        flex: 1;
        padding: 10px;
        font-size: 16px;
        border-radius: 10px;
        border: 2px solid #fff;
        outline: none;
        transition: border-color 0.3s ease;
    }

    input[type="number"]:focus {
        border-color: #f8b500;
    }

    button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #f8b500;
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        outline: none;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #f39c12;
    }

    img {
        max-width: 100%;
        margin-top: 20px;
        display: block;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    p {
        text-align: center;
        margin-top: 10px;
        color: #333;
        font-size: 14px;
    }

    .success-message {
        color: #28a745;
    }

    .error-message {
        color: #dc3545;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Buscador de GIFs</h1>
        <form method="post">
            <input type="number" id="numero" name="numero" placeholder="Ingrese un número" required>
            <button type="submit">Buscar</button>
        </form>
        <?php
        if (isset($_POST['numero'])) {
            $numero = $_POST['numero'];
            $url = "http://localhost:5162/api?numero={$numero}";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            if ($data && isset($data['results'][$numero - 1]['media'][0]['gif']['url'])) {
                $gifUrl = $data['results'][$numero - 1]['media'][0]['gif']['url'];
                echo "<img src='{$gifUrl}' alt='GIF'>";
                echo "
                <form method='post'>
                    <input type='hidden' name='gif_url' value='{$gifUrl}'>
                    <button type='submit' name='save_gif' style='margin-top: 10px;'>Guardar GIF</button>
                </form>";
            } else {
                echo '<p class="error-message">No se encontró un GIF para el número ingresado</p>';
            }
        }

        if (isset($_POST['save_gif'])) {
            $gifUrl = $_POST['gif_url'];
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gifdb";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }
            $sql = "INSERT INTO gifs (url) VALUES ('{$gifUrl}')";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success-message'>URL del GIF guardada correctamente en la base de datos</p>";
            } else {
                echo "<p class='error-message'>Error al guardar la URL del GIF en la base de datos: " . $conn->error . "</p>";
            }
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
