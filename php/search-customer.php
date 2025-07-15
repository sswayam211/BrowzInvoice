<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

// Get the search query from the GET request
$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$queryParts = explode(",", $query);
$query1 = isset($queryParts[0]) ? trim($queryParts[0]) : '';
$query2 = isset($queryParts[1]) ? trim($queryParts[1]) : '';

// Include the database connection
include 'db-conn.php';

$where1 = "(
    `CUST_CODE` LIKE '%$query1%' 
    OR `CUST_FULL_NAME` LIKE '%$query1%' 
    OR `CUST_EMAIL` LIKE '%$query1%'
    OR `CUST_PHONE_NO` LIKE '%$query1%'
)";

$where2 = (!empty($query2)) ? " AND (
    `CUST_CODE` LIKE '%$query2%' 
    OR `CUST_FULL_NAME` LIKE '%$query2%' 
    OR `CUST_EMAIL` LIKE '%$query2%'
    OR `CUST_PHONE_NO` LIKE '%$query2%'
)" : "";

$sql = "SELECT * FROM `customer` WHERE $where1$where2";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('SQL Error: ' . mysqli_error($conn));
}

function highlightText($text, $query1, $query2)
{
    if (!empty($query1) || !empty($query2)) {
        $patterns = [];
        if (!empty($query1)) $patterns[] = preg_quote($query1, '/');
        if (!empty($query2)) $patterns[] = preg_quote($query2, '/');
        $regex = '/(' . implode('|', $patterns) . ')/i';
        $text = preg_replace($regex, '<span class="highlight">$1</span>', $text);
    }
    return $text;
}

// Check if any results were found
if ($result->num_rows > 0) {
    echo '<table class="table table-hover mb-0">';
    echo '<thead>
            <tr class="">
                <th></th>
                <th>C_ID</th>
                <th>C_NAME</th>
                <th>C_EMAIL</th>
                <th>C_PHONE</th>
                <th>C_ADDRESS 1</th>
                <th>C_GSTIN</th>
            </tr>
          </thead>';
    echo '<tbody>';
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $count++;
        echo '     
            <tr>
                <td><button type="button" class="take-cust" value="' . htmlspecialchars($row['CUST_CODE']) . '">+</button></td>
                <td>' . highlightText(htmlspecialchars($row['CUST_CODE']), $query1, $query2) . '</td>
                <td>' . highlightText(htmlspecialchars($row['CUST_FULL_NAME']), $query1, $query2) . '</td>
                <td>' . highlightText(htmlspecialchars($row['CUST_EMAIL']), $query1, $query2) . '</td>
                <td>' . highlightText(htmlspecialchars($row['CUST_PHONE_NO']), $query1, $query2) . '</td>
                <td>' . htmlspecialchars($row['CUST_ADDRESS_1']) . '</td>
                <td>' . highlightText(htmlspecialchars($row['CUST_GSTIN']), $query1, $query2) . '</td>
            </tr>
            ';
    }
    echo '</tbody></table></div>';
} else {
    echo '
    <div class="alert alert-warning text-center">No user found matching your search query.</div>
    ';
}

$conn->close();
