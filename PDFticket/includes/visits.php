<?php

if (!$_COOKIE['visits']) {
    echo "Witaj pierwszy raz na naszej stronie!";
    setcookie("visits", 1, time() + 365 * 24 * 3600);
} else {
    $visits = $_COOKIE['visits'];
    echo "Witaj! Odwiedziłeś nas już $visits razy!";
    setcookie("visits", $visits + 1, time() + 365 * 24 * 3600);
}