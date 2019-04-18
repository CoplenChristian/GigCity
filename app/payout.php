<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$conn = new mysqli("db.soic.indiana.edu","i494f18_team45","my+sql=i494f18_team45", "i494f18_team45");

if (!$conn) { die("Connection failed: " . mysqli_connect_error());}

$username = $_SESSION["username"];
$id = $_SESSION["id"];

$paymentamt = $_GET['payment'];
$performer_email = $_GET['email'];

$emailsql = "SELECT * FROM users WHERE id = " . $id . ";";
$emailresult = mysqli_query($conn, $emailsql);

$ch = curl_init('https://api.sandbox.paypal.com/v1/payments/payouts');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Authorization: Bearer A21AAGZYKjevQaugwGNyWbjsDUQYtyY5ACkNbUJ7TYsUObZG9MDPDWj8kebB5uh1MfBL95PHghTyZACN4jNMWqU5doJ93Xajw'
));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$payoutData = '{
	"sender_batch_header": {
    "sender_batch_id": "2014021801",
    "email_subject": "You have a payout!",
    "email_message": "You have received a payout! Thanks for using our service!"
  },
  "items": [
    {
      "recipient_type": "EMAIL",
      "amount": {
        "value": "' . $paymentamt . '",
        "currency": "USD"
      },
      "note": "Thanks for your patronage!",
      "sender_item_id": "201403140001",
      "receiver": "' . $performer_email . '"
    },
	]
}';

curl_setopt($ch, CURLOPT_POSTFIELDS, $payoutData);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

$result = curl_exec($ch);
$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
?>
<html>
<body>
<?php echo $user; ?>
<?php echo $httpStatusCode; ?>

</body>
</html>