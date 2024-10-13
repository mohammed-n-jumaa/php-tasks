<?php
//................................1.....................
function isPrime($number) {
   
    if ($number <= 1) {
        return false;
    }

    // Check from 2 to sqrt($number)
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) {
            return false; 
        }
    }

    return true; // Prime number
}

$inputNumber = 3; 

if (isPrime($inputNumber)) {
    echo $inputNumber . " is a prime number.";
} else {
    echo $inputNumber . " is not a prime number.";
}
?>
<?php
echo "<hr>";
function reverseString($string) {
    return strrev($string);
}

$inputString = "remove"; 
$reversedString = reverseString($inputString);

echo $reversedString; 
?>
<?php
echo "<hr>";
function swap(&$x, &$y) {
    // Swap values using arithmetic operations
    $x = $x + $y; 
    $y = $x - $y; 
    $x = $x - $y; 
}

$x = 12; 
$y = 10;

swap($x, $y); 

echo "x = $x, y = $y";
?>

<?php
echo "<hr>";
function isArmstrongNumber($number) {
    $digits = str_split($number);
    $sum = 0;

    foreach ($digits as $digit) {
        $sum += pow($digit, 3); 
    }

    // Check if the sum is equal to the original number
    if ($sum == $number) {
        return true;
    } else {
        return false;
    }
}

$inputNumber = 407; 

if (isArmstrongNumber($inputNumber)) {
    echo $inputNumber . " is an Armstrong Number.";
} else {
    echo $inputNumber . " is not an Armstrong Number.";
}
?>

<?php
echo "<hr>";
function isPalindrome($string) {
    $cleanedString = strtolower(preg_replace("/[^A-Za-z0-9]/", '', $string));
    
    // Reverse the cleaned string
    $reversedString = strrev($cleanedString);
    
    // Check if the cleaned string is equal to the reversed string
    if ($cleanedString === $reversedString) {
        return true;
    } else {
        return false;
    }
}

$inputString = "Eva, can I see bees in a cave?"; 

if (isPalindrome($inputString)) {
    echo "Yes, it is a palindrome.";
} else {
    echo "No, it is not a palindrome.";
}
?>

<?php
echo "<hr>";
function removeDuplicates($array) {
    return array_unique($array);
}

$array1 = array(2, 4, 7, 4, 8, 4);
$array1 = removeDuplicates($array1); 

print_r($array1); 
?>


