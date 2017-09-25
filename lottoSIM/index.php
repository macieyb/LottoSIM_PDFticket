<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["number1"])
        && isset($_POST["number2"])
        && isset($_POST["number3"])
        && isset($_POST["number4"])
        && isset($_POST["number5"])
        && isset($_POST["number6"])) {

        $no1 = $_POST['number1'];
        $no2 = $_POST['number2'];
        $no3 = $_POST['number3'];
        $no4 = $_POST['number4'];
        $no5 = $_POST['number5'];
        $no6 = $_POST['number6'];
    }
    $bet = [$no1, $no2, $no3, $no4, $no5, $no6];
    switch ($bet) {
        case (array_sum($bet) == 0):
            echo "<h1>Proszę wprowadzić wybrane liczby!</h1>";
            break;
    }

    $randarray = [];
    for ($i = 1; $i <= 6;) {
        unset($rand);
        $rand = rand(1, 49);
        if (!in_array($rand, $randarray)) {
            $randarray[] = $rand;
            $i++;
        }
    }

    sort($bet);
    sort($randarray);


    echo "Twoje liczby to:</br>";
    echo "$bet[0], $bet[1], $bet[2], $bet[3], $bet[4], $bet[5]"; // foreachem!?
    echo "</br>";
    echo "Wylosowane liczby:</br>";
    echo "$randarray[0], $randarray[1], $randarray[2], $randarray[3], $randarray[4], $randarray[5]"; // foreachem!?
    echo "</br>";


    $result = array_intersect($bet, $randarray);

    echo "<h1>TWOJE TRAFIONE LICZBY TO:</h1>";
    if (count($result) == 0) {
        echo "<h3>Niestety nie trafiłeś żadnej z liczb :(</h3>";
    }

    foreach ($result as $values) {
        if (count($result) > 0) {
            echo "$values, ";
        }
    }
}

?>


<!DOCTYPE html>
<html>
<body>
<form action="" method="post">
    <label for="numbers"><h1>Wybierz 6 liczb z zakresu 1-49:</h1></label></br></br>
    <input type="number" min="1" max="49" name="number1" id="numbers" placeholder="Liczba od 1 do 49">
    <input type="number" min="1" max="49" name="number2" id="numbers" placeholder="Liczba od 1 do 49">
    <input type="number" min="1" max="49" name="number3" id="numbers" placeholder="Liczba od 1 do 49">
    <input type="number" min="1" max="49" name="number4" id="numbers" placeholder="Liczba od 1 do 49">
    <input type="number" min="1" max="49" name="number5" id="numbers" placeholder="Liczba od 1 do 49">
    <input type="number" min="1" max="49" name="number6" id="numbers" placeholder="Liczba od 1 do 49">

    <input type="submit" value="submit">
</form>
</body>
</html>