<?php

require_once "airports.php";  //funkcja airportList($airports);

?>

<form action="pdf.php" method="post">
    <label for="flights"><h2>Flights form:</h2></label></br>

    Departure airport:</br>
    <select name="departure" id="flights">
        <?php

        airportList($airports);

        ?>
    </select></br></br>
    Arrival airport:</br>
    <select name="arrival" id="flights">
        <?php

        airportList($airports);

        ?>
    </select></br></br>
    Departure time:</br>
    <input type="datetime-local" name="deptime" id="flights"></br></br>
    Flight duration [h]:</br>
    <input type="number" min="0" step="1" name="flightdur" id="flights"></br></br>
    Price:</br>
    <input type="number" min="0" step="0.01" name="price" id="flights"></br></br>

    </br><input type="submit" value="submit">
</form>


