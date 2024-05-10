<?php
// $conn = mysqli_connect("localhost", "root", "", "db");
// if ($conn == false) {
//     die("Connection error" . mysqli_connect_error());
// }

require('vendor/autoload.php');

use Parse\ParseClient;

// Initialize Parse SDK with your Back4App keys
ParseClient::initialize(
    'mKSFDcQwiclF1anLd0QKpYDUV6oLQifbzQpsZaGq',
    '76BPfzCQCdtpmoFu6GVGCc5ggf2NOhfBBYo4Iefp',
    'c9KlaaUWmHpWBr2Ll7ppFlke5eXmt1ZQgQqKJg1Z'
);
ParseClient::setServerURL('https://parseapi.back4app.com', 'parse');
