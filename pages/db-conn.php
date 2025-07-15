<?php

$conn = mysqli_connect('localhost', 'root', '', 'browz_invoice');

if (!$conn) {
    die('connection error' . mysqli_connect_errno());
} else {
    // echo 'success';
}
