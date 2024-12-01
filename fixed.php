<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Zafiyet Test Sayfası</title>
    <style>
        /* Sayfa genel düzeni */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        /* İçerik kutusu */
        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1, h2, h3 {
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
        }

        input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 80%;
            max-width: 300px;
        }

        input[type="submit"] {
            padding: 10px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            width: 80%;
            max-width: 300px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .output {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 80%;
            max-width: 300px;
            text-align: left;
            margin: 20px auto;
        }

        pre {
            background-color: #333;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Web Güvenlik Testleri</h2>
        <form method="POST" action="">
            <label for="xss">XSS  Testi:</label>
            <!-- XSS alanını kullanıcıdan gelen değer ile doldur -->
            <input type="text" name="xss" id="xss" value="<?php echo isset($_POST['xss']) ? htmlspecialchars($_POST['xss'], ENT_QUOTES, 'UTF-8') : ''; ?>"><br><br>

            <label for="sql">SQL  Testi:</label>
            <!-- SQL alanını kullanıcıdan gelen değer ile doldur -->
            <input type="text" name="sql" id="sql" value="<?php echo isset($_POST['sql']) ? htmlspecialchars($_POST['sql'], ENT_QUOTES, 'UTF-8') : ''; ?>"><br><br>

            <label for="oscommand">OS Command  Testi:</label>
            <!-- OS Command alanını kullanıcıdan gelen değer ile doldur -->
            <input type="text" name="oscommand" id="oscommand" value="<?php echo isset($_POST['oscommand']) ? htmlspecialchars($_POST['oscommand'], ENT_QUOTES, 'UTF-8') : ''; ?>"><br><br>

            <input type="submit" value="Gönder">
        </form>

        <?php
        header('Content-Type: text/html; charset=UTF-8');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kullanıcıdan gelen girdileri güvenli hale getir
            $xss = isset($_POST['xss']) ? htmlspecialchars($_POST['xss'], ENT_QUOTES, 'UTF-8') : '';
            $sql = isset($_POST['sql']) ? htmlspecialchars($_POST['sql'], ENT_QUOTES, 'UTF-8') : '';
            $oscommand = isset($_POST['oscommand']) ? htmlspecialchars($_POST['oscommand'], ENT_QUOTES, 'UTF-8') : '';

            $output = '';

            // XSS girdisini işleyip güvenli bir şekilde yazdır
            if (!empty($xss)) {
                $output .= "<h3>XSS Sonuçları:</h3><p>" . $xss . "</p>";
            }

            // SQL Injection
            if (!empty($sql)) {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "proje";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Bağlantı hatası: " . $conn->connect_error);
                }

                $stmt = $conn->prepare("SELECT * FROM kişiler WHERE id = ?");
                if ($stmt === false) {
                    die("Hazırlanmış ifade oluşturulamadı: " . $conn->error);
                }

                $stmt->bind_param("s", $sql);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result === false) {
                    die("SQL sorgusu başarısız: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    $output .= "<h3>SQL Sonuçları:</h3>";
                    while ($row = $result->fetch_assoc()) {
                        $output .= "<p>ID: " . htmlspecialchars($row["id"], ENT_QUOTES) . "<br>";
                        $output .= "Ad: " . htmlspecialchars($row["ad"], ENT_QUOTES) . "<br>";
                        $output .= "Soyad: " . htmlspecialchars($row["soyad"], ENT_QUOTES) . "</p><br>";
                    }
                } else {
                    $output .= "<p>Geçersiz Giriş.</p>";
                }

                $conn->close();
            }

            // OS Command Injection
            if (!empty($oscommand)) {
                $parts = explode(' ', $oscommand);
                $ipAddress = $parts[0];

                if (filter_var($ipAddress, FILTER_VALIDATE_IP)) {
                    $command = 'ping ' . escapeshellarg($ipAddress);
                    $command_output = shell_exec($command);

                    if ($command_output !== null) {
                        $output .= "<h3>Ping Çıktısı:</h3><pre>" . htmlspecialchars($command_output, ENT_QUOTES, 'UTF-8') . "</pre>";
                    } else {
                        $output .= "<p>Ping komutu çalıştırılamadı veya çıktı yok.</p>";
                    }
                } else {
                    $output .= "<p>Geçersiz veya Yanlış Kod.</p>";
                }
            }

            echo $output;
        }
        ?>
    </div>
</body>
</html>
