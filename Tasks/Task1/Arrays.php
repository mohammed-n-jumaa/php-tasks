<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
//.......................1....................
$colors = array('white', 'green', 'red');

echo "<ul>";
echo "<li>{$colors[1]}</li>";
echo "<li>{$colors[2]}</li>";
echo "<li>{$colors[0]}</li>";
echo "</ul>";
?>
<?php
//.......................2.....................
echo "<hr>";
$cities = array(
    "Italy" => "Rome", 
    "Luxembourg" => "Luxembourg", 
    "Belgium" => "Brussels",
    "Denmark" => "Copenhagen", 
    "Finland" => "Helsinki", 
    "France" => "Paris", 
    "Slovakia" => "Bratislava",
    "Slovenia" => "Ljubljana", 
    "Germany" => "Berlin", 
    "Greece" => "Athens", 
    "Ireland" => "Dublin",
    "Netherlands" => "Amsterdam", 
    "Portugal" => "Lisbon", 
    "Spain" => "Madrid"
);

asort($cities);
foreach ($cities as $country => $capital) {
    echo "The capital of $country is $capital.<br>";
}?>

<?php
//...........................3....................
echo "<hr>";
$color = array(4 => 'white', 6 => 'green', 11 => 'red');
echo reset($color);?>

<?php
//..........................4....................
echo "<hr>";
// Sample Input
$array = [1, 2, 3, 4, 5];
$location = 4;
$new_item = '$';

// Adjust the index for 0-based array
$location = $location - 1;

// Insert the new item
array_splice($array, $location, 0, $new_item);

echo "Updated Array: " . implode(' ', $array);?>
<?php
//..........................5....................
echo "<hr>";

$fruits = array(
    "d" => "lemon",
    "a" => "orange",
    "b" => "banana",
    "c" => "apple"
);

asort($fruits);

foreach ($fruits as $key => $value) {
    echo "$key = $value\n";
}
?>
<?php
echo "<hr>";
//..........................6....................
// Sample input temperatures
$temperatures = array(78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73);

// Calculate average temperature
$totalTemperatures = count($temperatures);
$sumTemperatures = array_sum($temperatures);
$averageTemperature = $sumTemperatures / $totalTemperatures;

// Sort temperatures in ascending order
sort($temperatures);

// Get the five lowest temperatures
$lowestTemperatures = array_slice($temperatures, 0, 5);

// Get the five highest temperatures
$highestTemperatures = array_slice($temperatures, -5);

// Display the results
echo "Average Temperature is: " . round($averageTemperature, 1) . "\n <br>";
echo "List of five lowest temperatures: " . implode(", ", $lowestTemperatures) . "\n <br>";
echo "List of five highest temperatures: " . implode(", ", $highestTemperatures) . "\n <br>";
?>

<?php
//..........................7....................
echo "<hr>";
$array1 = array("color" => "red", 2, 4);
$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);

$result = array_merge($array1, $array2);

print_r($result);

?>
<?php

//..........................8....................
echo "<hr>";

function convertToUpperCase($array) {
    return array_map('strtoupper', $array);
}

$colors = array("red", "blue", "white", "yellow");
$upperCaseColors = convertToUpperCase($colors);

print_r($upperCaseColors);
?>




</body>
</html>