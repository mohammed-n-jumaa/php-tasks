<?php
// Sample input string
$inputString = "hello world! this is a php script example.";
echo "<br>";
// a. Convert the entered string to uppercase
$upperCaseString = strtoupper($inputString);
echo "Uppercase: " . $upperCaseString . "\n";
echo "<br>";

// b. Convert the entered string to lowercase
$lowerCaseString = strtolower($upperCaseString);  // Reusing the uppercase string for example
echo "Lowercase: " . $lowerCaseString . "\n";
echo "<br>";

// c. Make the first letter of the string uppercase
$firstUpperString = ucfirst($lowerCaseString);
echo "First letter uppercase: " . $firstUpperString . "\n";
echo "<br>";

// d. Make the first letter of each word capitalized
$titleCaseString = ucwords($lowerCaseString);
echo "First letter of each word capitalized: " . $titleCaseString . "\n";
?>

<?php
echo "<hr>";
$numericString = "085119";

// Ensure the input is exactly 6 digits
if (strlen($numericString) == 6) {
    // Split the string into hours, minutes, and seconds
    $hours = substr($numericString, 0, 2);
    $minutes = substr($numericString, 2, 2);
    $seconds = substr($numericString, 4, 2);

    // Format the time as hh:mm:ss
    $formattedTime = $hours . ":" . $minutes . ":" . $seconds;

    // Output the result
    echo "Formatted Time: " . $formattedTime;
} else {
    echo "Invalid input! Please provide a 6-digit numeric string.";
}
?>

<?php
echo "<hr>";
$sentence = "I am a full stack developer at orange coding academy";
$searchWord = "Orange";

$lowerSentence = strtolower($sentence);
$lowerSearchWord = strtolower($searchWord);

// Check if the word exists in the sentence
if (strpos($lowerSentence, $lowerSearchWord) !== false) {
    echo "Word Found!";
} else {
    echo "Word Not Found!";
}
?>

<?php
echo "<hr>";
$url = "http://www.orange.com/index.php";

$fileName = basename($url);

echo "File Name: " . $fileName;
?>

<?php
echo "<hr>";
$email = "info@orange.com";

// Use the strstr() function to find the substring before '@'
$username = strstr($email, '@', true);

// Output the username
echo "Username: " . $username;
?>

<?php
echo "<hr>";
$string = "info@orange.com";

// Use the substr() function to get the last three characters
$lastThreeChars = substr($string, -3);

// Output the last three characters
echo "Last Three Characters: " . $lastThreeChars;
?>

<?php
echo "<hr>";
$characters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

// Function to generate a random password
function generateRandomPassword($input, $length = 8) {
    $password = '';
    $inputLength = strlen($input);

    // Use mt_rand() instead of rand()
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = mt_rand(0, $inputLength - 1);
        $password .= $input[$randomIndex];
    }

    return $password;
}

// Generate a random password of length 10
$randomPassword = generateRandomPassword($characters, 10);

// Output the random password
echo "Generated Password: " . $randomPassword;
?>

<?php
echo "<hr>";
$sentence = "That new trainee is so genius.";
$replacementWord = "Our";

// Use preg_replace to replace the first word
$newSentence = preg_replace('/^\w+/', $replacementWord, $sentence);

// Output the modified sentence
echo "Modified Sentence: " . $newSentence;
?>
