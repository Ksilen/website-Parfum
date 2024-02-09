<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="classes.css">
    <script type="text/javascript" src="javascript.js"></script>
</head>

<body>
    <div class="head_fon">
        <div class="head_slogan">
            ОРИГИНАЛЬНАЯ<br> БРЕНДОВАЯ <br>ПАРФЮМЕРИЯ <br><br>
        </div>
        <div class="admin_add">
            <a href="admin.php">
                <img src="main_img/anmin_add20.png" />
            </a>
        </div>
    </div>
    <div class="serfind">
        <form>
            <input type="text" name=text" id="searchIn" class="search" placeholder="Найти аромат..." oninput="find_word()">
        </form>
        <div>
            <select class="selectordata" name="sorter" id="select_id" onchange="select_db()">
                <option value="default">Порядок: по умолчанию</option>
                <option value="alfabet">По названию: от А до Я</option>
                <option value="non_alfabet">По названию: от Я до А</option>
                <option value="desk">По цене: по убыванию</option>
                <option value="asc">По цене: по возрастанию </option>
            </select>
        </div>
    </div>
    <div id="textdb" class="textdb" />
    <script>
        select_db();
    </script>

</body>

</html>