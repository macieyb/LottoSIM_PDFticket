<?php

require "vendor/autoload.php";

use NumberToWords\NumberToWords;


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if ((isset($_POST['departure'])
        && isset($_POST['arrival'])
        && isset($_POST['deptime'])
        && isset($_POST['flightdur'])
        && isset($_POST['price'])
        && ($_POST['price'] > 0)
        && ($_POST['departure']) != $_POST['arrival'])) {

        $departure = $_POST['departure'];
        $arrival = $_POST['arrival'];
        $depTime = $_POST['deptime'];
        $flightDur = $_POST['flightdur'];
        $price = $_POST['price'];
    } else {
        echo "Proszę wprowadzić prawidłowe dane!";
    }
}


// Data i czas:
$departureArr = explode(", ", $departure);
$depTz = $departureArr[2];

$arrivalArr = explode(", ", $arrival);
$arrTz = $arrivalArr[2];


$arrTime = new DateTime($depTime);
$arrTime->modify($flightDur . 'hour');

$arrTz = new DateTimeZone($arrTz);
$arrTime->setTimezone($arrTz);

$departureTime = new DateTime($depTime);

//Funkcja generująca dane pasażera -
function createFakeData()
{
    $faker = Faker\Factory::create('pl_PL');
    $passanger = $faker->name;
    return "$passanger";
}

//Funkcja czytająca cenę -

function readPrice($price)
{
    $numberToWords = new NumberToWords();
    $numberTransformer = $numberToWords->getCurrencyTransformer('pl');
    $pricePl = $numberTransformer->toWords($price * 100, 'PLN');
    return "$pricePl";
}

//Składanie zmiennych do HTML
$wylot = "$departureArr[0] ($departureArr[1])";
$przylot = "$arrivalArr[0] ($arrivalArr[1])";

$x = $departureTime->format("d.m.Y H:i:s");
$xx = $departureArr[2];
$czasWylotu = "$x $xx";


$y = $arrTime->format('d.m.Y H:i:s');
$yy = $arrivalArr[2];
$czasPrzylotu = "$y $yy";

$czasLotu = $flightDur . "h.";
$pasazer = createFakeData();

$cena = "$price zł";
$q = readPrice($price);
$cenaSlownie = "$q";


//Generowanie PDF z HTML
$html = "<table style='border-collapse:collapse;border-spacing:0; table-layout: fixed; width: 500px'>
    <tr>
        <th style='font-size:30px; font-weight:normal; padding:10px 10px; border:2px solid black; color:#fff; background-color:#f38630;' colspan=\"2\">Dream Airlines</th>
    </tr>
    <tr>
        <td style='border:1px solid black; width: 250px; font-weight:bold;font-size:10px;vertical-align:top'>From:</td>
        <td style='border:1px solid black; border-collapse:collapse;border-spacing:0; width: 250px; font-weight:bold;font-size:10px;vertical-align:top'>To:</td>
    </tr>
    <tr>
        <td style='border:1px solid black; width: 250px; font-weight: bold; font-size:20px'>$wylot</td>
        <td style='border:1px solid black; width: 250px; font-weight: bold; font-size:20px'>$przylot</td>
    </tr>
    <tr>
        <td style='border:1px solid black; font-weight:bold;font-size:10px;vertical-align:top; width: 250px'>Departure (local time):</td>
        <td style='border:1px solid black; font-weight:bold;font-size:10px;vertical-align:top; width: 250px'>Arrival (local time):</td>
    </tr>
    <tr>
        <td style='border:1px solid black; width: 250px'>$czasWylotu</td>
        <td style='border:1px solid black; width: 250px'>$czasPrzylotu</td>
    </tr>
    <tr>
        <td style='border:1px solid black; font-weight:bold;vertical-align:top' colspan=2>Flight time:</td>
    </tr>
    <tr>
        <td style='border:1px solid black;' colspan=2>$czasLotu</td>
    </tr>
    <tr>
        <td style='border:1px solid black; font-weight:bold;vertical-align:top' colspan=2>Passenger:</td>
    </tr>
    <tr>
        <td style='border:1px solid black; color: crimson; font-weight:bolder; font-size:20px' colspan=2>$pasazer</td>
    </tr>
    <tr>
        <td style='border:1px solid black; font-weight:bold;vertical-align:top' colspan=2>Price:</td>
    </tr>
    <tr>
        <td style='border:1px solid black;' colspan=2><p style='color:dodgerblue; font-weight: bold; font-size:25px'>$cena</p><p>$cenaSlownie</p></td></tr>
</table>";

$mpdf = new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output("ticket.pdf", "D");