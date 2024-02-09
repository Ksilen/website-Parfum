<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="ndex.css">
</head>

<body>
    <div class="head_fon">
        <div class="menu_add">
            <a href="index.php">
                <img src="main_img/home_svg.svg" />
            </a>
        </div>
    </div>
    <?php
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    $link = mysqli_connect("localhost", "u2340971_default", "BgKsv718K9qyVKp6", "u2340971_default");
    if ($link == false) {
        print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    } else {
        //print("Соединение установлено успешно");
    }

    if (isset($_POST['but_post'])) {
        $sql = 'SELECT * FROM `loginner`';
        $reslog = mysqli_query($link, $sql);
        while ($row = $reslog->fetch_row()) {
            $myArray[] = str_replace (["\r\n", "\n", "\r"], '', $row);
        }
        if ($_POST['name'] == $myArray[0][0] && $_POST['pass'] == $myArray[0][1]) {
            if ($_FILES && $_FILES["filename"]["error"] == UPLOAD_ERR_OK) {
                //Обнулить БД 
                $sql = 'DELETE FROM `parf`';
                mysqli_query($link, $sql);
                $sql = 'ALTER TABLE parf AUTO_INCREMENT=0';
                mysqli_query($link, $sql);
                $worksheet = "";
                $name = "tmp/" . $_FILES["filename"]["name"];
                move_uploaded_file($_FILES["filename"]["tmp_name"], $name);
                echo "Файл загружен";
                $worksheet = "tmp/" . $_FILES["filename"]["name"];
                $reader = IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load($worksheet);
                $data = $spreadsheet->getActiveSheet()->toArray();
                try {
                    $pdo = new PDO("mysql:host=localhost;dbname=u2340971_default", "u2340971_default", "BgKsv718K9qyVKp6");
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    echo 'connection failed: ' . $e->getMessage();
                }
                foreach ($data as $list) {
                    $sql = "INSERT INTO parf(name, price) VALUES (?,?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$list[0], $list[1]]);
                    $sqlq = $stmt->fetchAll();
                }
               echo "<script>window.location.replace('http://iliasaveliev.ru/index.php');</script>";
            } else {
                echo "Файл Не Загружен";
            }
        } else {
            echo "Введите корректные данные";
        }
    }
    ?>
    <form class="form" action="" method="post" enctype="multipart/form-data">
        <input class="input" type="text" placeholder="Ваше имя" name="name">
        <input class="input" type="tel" placeholder="Ваш телефон" name="tel">
        <input class="input" type="passwor" placeholder="Пароль" name="pass">
        <p><input type="file" name="filename" /></p>
        <button class="btn" type="submit" name="but_post">Отправить</button>
    </form>
</body>

</html>