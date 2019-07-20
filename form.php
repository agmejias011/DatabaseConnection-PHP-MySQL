<?php

function saveIntoDatabase($fname, $lname, $message, $country){

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

   // save encrypted message in the database
    $sql = mysqli_query($conn,"INSERT INTO customer(fname, lname, message, country)
    VALUES ('$fname', '$lname','$message','$country')");

$conn->close();

}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>

<body>

<h3>Contact us</h3>

<div>
  <form action="<?php if(isset($_POST['firstname'],$_POST['lastname'],$_POST['message'],$_POST['country'])){ saveIntoDatabase($_POST['firstname'],$_POST['lastname'],$_POST['message'],$_POST['country']);} ?>" method="POST">
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name..">

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name..">

    <label for="message">Message</label>
    <input type="text" id="message" name="message">   
       
    <label for="country">Country</label>
    <select id="country" name="country">
      <option value="usa">USA</option>
      <option value="australia">Australia</option>
      <option value="canada">Canada</option>
      
    </select>
   
    <input type="submit" value="Submit">
  </form>
</div>

</body>
</html>
