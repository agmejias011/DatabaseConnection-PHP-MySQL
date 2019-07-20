<?php

function saveIntoDatabase($string, $value, $encOrDec){
//$encOrDec -> e = encrypt
//$encOrDec -> d = decrypt

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn-> connect_error);
 } 

if($encOrDec == 'e'){
   // save encrypted message in the database
    $sql = mysqli_query($conn,"INSERT INTO message(original_message, encrypted_message, decrypted_message)
    VALUES ('$string', '$value','$string')");


}


$conn->close();

}

function encrypt($string, $key = 'PrivateKey', $secret = 'SecretKey', $method = 'AES-256-CBC') {
    // hash
    $key = hash('sha256', $key);
    // create iv - encrypt method AES-256-CBC expects 16 bytes
    $iv = substr(hash('sha256', $secret), 0, 16);
    // encrypt
    $output = openssl_encrypt($string, $method, $key, 0, $iv);
    // encode
   
    saveIntoDatabase($string, base64_encode($output), 'e');

    return base64_encode($output);
}

function decrypt($string, $key = 'PrivateKey', $secret = 'SecretKey', $method = 'AES-256-CBC') {
    // hash
    $key = hash('sha256', $key);
    // create iv - encrypt method AES-256-CBC expects 16 bytes
    $iv = substr(hash('sha256', $secret), 0, 16);

    saveIntoDatabase($string, openssl_decrypt($string, $method, $key, 0, $iv), 'd');

    // decode
    $string = base64_decode($string);
    // decrypt  
    
   
    return openssl_decrypt($string, $method, $key, 0, $iv);
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>
<form method="post"> 
Enter message to encrypt here <input type="text" name="ostring"><br>
<input type="submit" name="encrypt" value="Encrypt"><br>
Encrypted String <input type="text" name="encrypted" value="<?php if(isset($_POST['encrypt'],$_POST['ostring'])){ echo encrypt($_POST['ostring']);} ?>"><br>
<input type="submit" name="decrypt" value="Decrypt"><br>
Decrypted message <input type="text" name="decrypted" value="<?php if(isset($_POST['decrypt'],$_POST['encrypted'])){ echo decrypt($_POST['encrypted']);} ?>"><br>
</form> 
</form>
</body>
</html>