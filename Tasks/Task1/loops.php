<?php
for ($i = 1; $i <= 10; $i++) {
    echo $i;
    if ($i < 10) {
        echo "-";
    }
}
?>

<?php
echo "<hr>";
$total = 0;

for ($i = 0; $i <= 30; $i++) {
    $total += $i;
}

echo "Total: " . $total;
?>

<?php

$letters = ['A', 'B', 'C', 'D', 'E'];  
echo "<hr>";
for ($i = 0; $i < 5; $i++) {  
    for ($j = 0; $j < 5; $j++) {  
        if ($j < (5 - $i - 1)) {
            echo "A ";  
        } else {
            echo $letters[$i] . " ";  
        }
    }
    echo "<br>";  
}
?>

<?php

$letters = [1, 2, 3, 4, 5];  
echo "<hr>";
for ($i = 0; $i < 5; $i++) {  
    for ($j = 0; $j < 5; $j++) {  
        if ($j < (5 - $i - 1)) {
            echo "1 ";  
        } else {
            echo $letters[$i] . " ";  
        }
    }
    echo "<br>"; 
}
?>

<?php
echo "<hr>";
for ($i = 0; $i < 5; $i++) {  
    for ($j = 0; $j < 5; $j++) {  
        if ($i == $j) {
            echo ($i + 1) . " ";  
        } else {
            echo "0 ";  
        }
    }
    echo "<br>";  
}
?>
<?php
echo "<hr>";
$number = 5;
$factorial = 1;

for ($i = 1; $i <= $number; $i++) {
    $factorial *= $i;
}

echo "Factorial of " . $number . " is: " . $factorial;
?>

<?php
echo "<hr>";
echo "<table border='1' cellpadding='3px' cellspacing='0px'>";

for ($i = 1; $i <= 6; $i++) { // Loop for the rows (1 to 6)
    echo "<tr>"; 
    for ($j = 1; $j <= 5; $j++) { // Loop for the columns (1 to 5)
        $result = $i * $j;
        echo "<td>" . $i . " * " . $j . " = " . $result . "</td>"; 
    }
    echo "</tr>"; 
}

echo "</table>"; 
?>
