
<?php
$link = mysqli_connect("localhost", "u2340971_default", "BgKsv718K9qyVKp6", "u2340971_default");
$myArray = array();
$element = json_decode(file_get_contents('php://input'), true);

switch ($element["choice"]) {
    case "alfabet":
        $sql = 'SELECT name,price FROM `parf` ORDER BY name DESC';
        break;
    case "non_alfabet":
        $sql = 'SELECT name,price FROM `parf` ORDER BY name ASC';
        break;
    case "desk":
        $sql = 'SELECT name,price FROM `parf` ORDER BY price DESC';
        break;
    case "asc":
        $sql = 'SELECT name,price FROM `parf` ORDER BY price ASC';
        break;
    default:
        $sql = 'SELECT name,price FROM `parf`';
        break;
}

$result = mysqli_query($link, $sql);
while ($row = $result->fetch_row()) {
    $myArray[] = $row;
}
echo json_encode($myArray);
?>

