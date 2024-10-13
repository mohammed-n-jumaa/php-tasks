<?php
function checkSum($firstInteger, $secondInteger) {
    $sum = $firstInteger + $secondInteger;
    
    // Check if the sum equals 30
    if ($sum == 30) {
        return $sum;
    } else {
        return 'false';
    }
}


$firstInteger = 10;
$secondInteger = 10;

$result = checkSum($firstInteger, $secondInteger);
echo $result; 
?>

<?php
echo "<hr>";
function isMultipleOfThree($number) {
    // Check if the number is a multiple of 3
    if ($number > 0 && $number % 3 == 0) {
        return 'true';
    } else {
        return 'false';
    }
}


$number = 20;

$result = isMultipleOfThree($number);
echo $result; 
?>

<?php
echo "<hr>";
function isInRange($number) {
    if ($number >= 20 && $number <= 50) {
        return 'true';
    } else {
        return 'false';
    }
}


$number = 50;

$result = isInRange($number);
echo $result; 
?>

<?php
echo "<hr>";
function findLargest($a, $b, $c) {
    return max($a, $b, $c);
}


$numbers = [1, 5, 9];

$result = findLargest($numbers[0], $numbers[1], $numbers[2]);
echo $result; 
?>

<?php
echo "<hr>";

function calculateElectricityBill($units) {
    $bill = 0;

    if ($units <= 50) {
        // For the first 50 units
        $bill = $units * 2.50;
    } elseif ($units <= 150) {
        // For the first 50 units + next 100 units
        $bill = (50 * 2.50) + (($units - 50) * 5.00);
    } elseif ($units <= 250) {
        // For the first 50 units + next 100 units + next 100 units
        $bill = (50 * 2.50) + (100 * 5.00) + (($units - 150) * 6.20);
    } else {
        // For the first 50 units + next 100 units + next 100 units + units above 250
        $bill = (50 * 2.50) + (100 * 5.00) + (100 * 6.20) + (($units - 250) * 7.50);
    }

    return $bill;
}

// Sample Input
$units = 300;

$result = calculateElectricityBill($units);
echo "The total electricity bill is: " . $result . " JOD"; 
?>

<?php
echo "<hr>";
function calculator($num1, $num2, $operation) {
    switch ($operation) {
        case 'addition':
            return $num1 + $num2;
        case 'subtraction':
            return $num1 - $num2;
        case 'multiplication':
            return $num1 * $num2;
        case 'division':
            if ($num2 != 0) {
                return $num1 / $num2;
            } else {
                return "Error: Division by zero!";
            }
        default:
            return "Invalid operation!";
    }
}

// Sample Input
$num1 = 10;
$num2 = 5;
$operation = 'division'; 

$result = calculator($num1, $num2, $operation);
echo "The result of the " . $operation . " is: " . $result;
?>

<?php
echo "<hr>";
function checkEligibilityToVote($age) {
    if ($age >= 18) {
        return 'is eligible to vote';
    } else {
        return 'is not eligible to vote';
    }
}

// Sample Input
$age = 15;

$result = checkEligibilityToVote($age);
echo "The person " . $result;
?>

<?php
echo "<hr>";
function checkNumber($number) {
    if ($number > 0) {
        return 'Positive';
    } elseif ($number < 0) {
        return 'Negative';
    } else {
        return 'Zero';
    }
}

// Sample Input
$number = -60;

$result = checkNumber($number);
echo $result; // Outputs 'Negative'
?>

<?php
echo "<hr>";
function calculateGrade($scores) {
    $average = array_sum($scores) / count($scores);

    if ($average < 60) {
        return 'F';
    } elseif ($average < 70) {
        return 'D';
    } elseif ($average < 80) {
        return 'C';
    } elseif ($average < 90) {
        return 'B';
    } else {
        return 'A';
    }
}

$scores = [60, 86, 95, 63, 55, 74, 79, 62, 50];

$result = calculateGrade($scores);
echo "Sample Output: '" . $result . "'";
?>
