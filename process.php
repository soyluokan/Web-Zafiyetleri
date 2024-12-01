<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zafiyetli Sayfa</title>
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

        h1 {
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
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
        <h1>Web Güvenlik Testleri</h1>
        <form method="POST" action="" onsubmit="return preserveInputValues()">
            <label for="xss">XSS Testi:</label>
            <input type="text" id="xss" name="xss" placeholder="XSS Testi" value="<?php echo isset($_POST['xss']) ? $_POST['xss'] : ''; ?>">

            <label for="sql">SQL Testi:</label>
            <input type="text" id="sql" name="sql" placeholder="SQL Testi" value="<?php echo isset($_POST['sql']) ? $_POST['sql'] : ''; ?>">

            <label for="oscommand">OS Command Testi:</label>
            <input type="text" id="oscommand" name="oscommand" placeholder="OS Komutunu Girin" value="<?php echo isset($_POST['oscommand']) ? $_POST['oscommand'] : ''; ?>">

            <input type="submit" value="Gönder">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $xss = $_POST['xss'];
            $sql = $_POST['sql'];
            $oscommand = $_POST['oscommand'];

            $output = '';

            // XSS
            if (!empty($xss)) {
                $output .= "<p>" . $xss . "</p>"; 
            }

            // SQL
            if (!empty($sql)) {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "proje";
            
                $conn = new mysqli($servername, $username, $password, $dbname);
                $sql_query = "SELECT * FROM kişiler WHERE id = '$sql'";
                $result = $conn->query($sql_query);

                if ($result === false) {
                    die("SQL sorgusu başarısız: " . $conn->error);
                }
            
                if ($result->num_rows > 0) {
                    $output .= "<h3>SQL Sonuçları:</h3>";
                    while ($row = $result->fetch_assoc()) {
                        $output .= "<p>ID: " . $row["id"] . "<br>";
                        $output .= "Ad: " . $row["ad"] . "<br>";
                        $output .= "Soyad: " . $row["soyad"] . "</p><br>";
                    }
                } else {
                    $output .= "<p>Bu isimde bir personel bulunamadı.</p>";
                }
            
                $conn->close();
            }
            
            // OS COMMAND (zafiyetli)
            if (!empty($oscommand)) {
                // Kullanıcının girdiği komut doğrudan çalıştırılır
                $command = $oscommand;  // Hiçbir doğrulama yapılmadan kullanıcı komutu çalıştırılır

                // Komutun çıktısını al
                $command_output = shell_exec($command);  

                if ($command_output !== null) {
                    $output .= "<pre>" . $command_output . "</pre>";
                } else {
                    $output .= "<p>Komut çalıştırılamadı veya çıktı yok.</p>";
                }
            }

            echo "<div class='output'>$output</div>";
        }
        ?>

    </div>

    <script>
        // Form gönderildiğinde input değerlerini korumak için
        function preserveInputValues() {
            var xssValue = document.getElementById('xss').value;
            var sqlValue = document.getElementById('sql').value;
            var oscommandValue = document.getElementById('oscommand').value;

            // Verileri form gönderildiğinde korunacak şekilde ekle
            document.getElementById('xss').value = xssValue;
            document.getElementById('sql').value = sqlValue;
            document.getElementById('oscommand').value = oscommandValue;
            
            return true; // Formun gönderilmesine izin ver
        }
    </script>
</body>
</html>
