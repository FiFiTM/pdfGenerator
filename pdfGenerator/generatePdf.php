<?php
//include connection file 
include "config.php";
include_once('fpdf/fpdf.php');

$stationId = $_POST['stationId'];

$date = $_POST['date'];

$myDate = date('Y-m-d');

$monthsChoice = $_POST['months'];

$yearsChoice = $_POST['years'];


if ($date == 'month') {
    // Get the current month and year
    $month = $monthsChoice;
    $year = date('Y');
    // Modify the SQL query to filter by month and year
    $sql = "SELECT 
    DATE_FORMAT(data, '%d.%m') as fecha,
    MIN(temp) AS min_temp, 
    round(AVG(temp),2) AS avg_temp, 
    MAX(temp) AS max_temp, 
    MIN(wind) AS min_wind, 
    round(AVG(wind),2) AS avg_wind, 
    MAX(wind) AS max_wind, 
    MIN(press) AS min_press, 
    round(AVG(press),2) AS avg_press, 
    MAX(press) AS max_press,
    MIN(hum) AS min_hum, 
    round(AVG(hum),2) AS avg_hum, 
    MAX(hum) AS max_hum,
    rainfall_daily_mm
FROM wp_weatherlink 
WHERE station_id = '$stationId' 
    AND MONTH(data) = '$month' 
    AND YEAR(data) = '$year' 
GROUP BY DATE_FORMAT(data, '%d.%m'), rainfall_daily_mm
";
    $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
    $tempAvg = mysqli_query($conn, "SELECT (SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month' AND temp = (SELECT MIN(temp) FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month') LIMIT 1) AS min_temp_date,MIN(temp) AS min_temp,
    round(AVG(temp),2) AS avg_temp,
    (SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month' AND temp = (SELECT MAX(temp) FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month') LIMIT 1) AS max_temp_date,
    MAX(temp) AS max_temp
FROM wp_weatherlink
WHERE station_id = '$stationId' AND MONTH(data) = '$month'
GROUP BY DATE_FORMAT(data, '%m.%Y')
") or die("database error:" . mysqli_error($conn));

    $windAvg = mysqli_query($conn, "SELECT 
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month' AND wind = (SELECT MIN(wind) FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month') LIMIT 1) AS min_wind_date,
MIN(wind) AS min_wind,
ROUND(AVG(wind),2) AS avg_wind,
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month' AND wind = (SELECT MAX(wind) FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month') LIMIT 1) AS max_wind_date,
MAX(wind) AS max_wind
FROM wp_weatherlink
WHERE station_id = '$stationId' AND MONTH(data) = '$month'
GROUP BY DATE_FORMAT(data, '%m.%Y')") or die("database error:" . mysqli_error($conn));

    $pressAvg = mysqli_query($conn, "SELECT 
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month' AND press = (SELECT MIN(press) FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month') LIMIT 1) AS min_press_date,
MIN(press) AS min_press,
ROUND(AVG(press),2) AS avg_press,
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month' AND press = (SELECT MAX(press) FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month') LIMIT 1) AS max_press_date,
MAX(press) AS max_press
FROM wp_weatherlink
WHERE station_id = '$stationId' AND MONTH(data) = '$month'
GROUP BY DATE_FORMAT(data, '%m.%Y')") or die("database error:" . mysqli_error($conn));

    $humAvg = mysqli_query($conn, "SELECT
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month' AND hum = (SELECT MIN(hum) FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month') LIMIT 1) AS min_hum_date,
MIN(hum) AS min_hum,
round(AVG(hum),2) AS avg_hum,
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month' AND hum = (SELECT MAX(hum) FROM wp_weatherlink WHERE station_id = '$stationId' AND MONTH(data) = '$month') LIMIT 1) AS max_hum_date,
MAX(hum) AS max_hum
FROM wp_weatherlink
WHERE station_id = '$stationId' AND MONTH(data) = '$month'
GROUP BY DATE_FORMAT(data, '%m.%Y')
") or die("database error:" . mysqli_error($conn));
} else if ($date == 'year') {
    // Get the current year
    $year = $yearsChoice;
    // Modify the SQL query to filter by year
    $sql = "SELECT 
        DATE_FORMAT(data, '%m.%Y') as data, 
        MIN(temp) AS min_temp, 
        round(AVG(temp),2) AS avg_temp, 
        MAX(temp) AS max_temp, 
        MIN(wind) AS min_wind, 
        round(AVG(wind),2) AS avg_wind, 
        MAX(wind) AS max_wind, 
        MIN(press) AS min_press, 
        round(AVG(press),2) AS avg_press, 
        MAX(press) AS max_press,
        MIN(hum) AS min_hum, 
        round(AVG(hum),2) AS avg_hum, 
        MAX(hum) AS max_hum,
        AVG(rainfall_monthly_mm) 
        FROM wp_weatherlink 
        WHERE station_id = '$stationId' 
        AND YEAR(data) = '$year' 
        GROUP BY DATE_FORMAT(data, '%m.%Y')";
    $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
    $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
    $tempAvg = mysqli_query($conn, "SELECT (SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year' AND temp = (SELECT MIN(temp) FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year') LIMIT 1) AS min_temp_date,MIN(temp) AS min_temp,
    round(AVG(temp),2) AS avg_temp,
    (SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year' AND temp = (SELECT MAX(temp) FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year') LIMIT 1) AS max_temp_date,
    MAX(temp) AS max_temp
FROM wp_weatherlink
WHERE station_id = '$stationId' AND YEAR(data) = '$year'") or die("database error:" . mysqli_error($conn));

    $windAvg = mysqli_query($conn, "SELECT 
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year' AND wind = (SELECT MIN(wind) FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year') LIMIT 1) AS min_wind_date,
MIN(wind) AS min_wind,
ROUND(AVG(wind),2) AS avg_wind,
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year' AND wind = (SELECT MAX(wind) FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year') LIMIT 1) AS max_wind_date,
MAX(wind) AS max_wind
FROM wp_weatherlink
WHERE station_id = '$stationId' AND YEAR(data) = '$year'") or die("database error:" . mysqli_error($conn));

    $pressAvg = mysqli_query($conn, "SELECT 
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year' AND press = (SELECT MIN(press) FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year') LIMIT 1) AS min_press_date,
MIN(press) AS min_press,
ROUND(AVG(press),2) AS avg_press,
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year' AND press = (SELECT MAX(press) FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year') LIMIT 1) AS max_press_date,
MAX(press) AS max_press
FROM wp_weatherlink
WHERE station_id = '$stationId' AND YEAR(data) = '$year'") or die("database error:" . mysqli_error($conn));

    $humAvg = mysqli_query($conn, "SELECT
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year' AND hum = (SELECT MIN(hum) FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year') LIMIT 1) AS min_hum_date,
MIN(hum) AS min_hum,
round(AVG(hum),2) AS avg_hum,
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year' AND hum = (SELECT MAX(hum) FROM wp_weatherlink WHERE station_id = '$stationId' AND YEAR(data) = '$year') LIMIT 1) AS max_hum_date,
MAX(hum) AS max_hum
FROM wp_weatherlink
WHERE station_id = '$stationId' AND YEAR(data) = '$year'") or die("database error:" . mysqli_error($conn));
} else {
    // Use the original SQL query to retrieve all data
    $sql = "SELECT 
        DATE_FORMAT(data, '%m.%Y') as data, 
        MIN(temp) AS min_temp, 
        round(AVG(temp),2) AS avg_temp, 
        MAX(temp) AS max_temp, 
        MIN(wind) AS min_wind, 
        round(AVG(wind),2) AS avg_wind, 
        MAX(wind) AS max_wind, 
        MIN(press) AS min_press, 
        round(AVG(press),2) AS avg_press, 
        MAX(press) AS max_press,
        MIN(hum) AS min_hum, 
        round(AVG(hum),2) AS avg_hum, 
        MAX(hum) AS max_hum,
        AVG(rainfall_monthly_mm) 
        FROM wp_weatherlink 
        WHERE station_id = '$stationId' 
        GROUP BY DATE_FORMAT(data, '%m.%Y')";
    $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
    $result = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
    $tempAvg = mysqli_query($conn, "SELECT 
    (SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND temp = (SELECT MIN(temp) FROM wp_weatherlink WHERE station_id = '$stationId') LIMIT 1) AS min_temp_date,
    MIN(temp) AS min_temp,
    ROUND(AVG(temp), 2) AS avg_temp,
    (SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND temp = (SELECT MAX(temp) FROM wp_weatherlink WHERE station_id = '$stationId') LIMIT 1) AS max_temp_date,
    MAX(temp) AS max_temp
FROM wp_weatherlink
WHERE station_id = '$stationId'") or die("database error:" . mysqli_error($conn));


    $windAvg = mysqli_query($conn, "SELECT 
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND wind = (SELECT MIN(wind) FROM wp_weatherlink WHERE station_id = '$stationId') LIMIT 1) AS min_wind_date,
MIN(wind) AS min_wind,
ROUND(AVG(wind),2) AS avg_wind,
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND wind = (SELECT MAX(wind) FROM wp_weatherlink WHERE station_id = '$stationId') LIMIT 1) AS max_wind_date,
MAX(wind) AS max_wind
FROM wp_weatherlink
WHERE station_id = '$stationId'") or die("database error:" . mysqli_error($conn));

    $pressAvg = mysqli_query($conn, "SELECT 
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND press = (SELECT MIN(press) FROM wp_weatherlink WHERE station_id = '$stationId') LIMIT 1) AS min_press_date,
MIN(press) AS min_press,
ROUND(AVG(press),2) AS avg_press,
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND press = (SELECT MAX(press) FROM wp_weatherlink WHERE station_id = '$stationId') LIMIT 1) AS max_press_date,
MAX(press) AS max_press
FROM wp_weatherlink
WHERE station_id = '$stationId'") or die("database error:" . mysqli_error($conn));

    $humAvg = mysqli_query($conn, "SELECT
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND hum = (SELECT MIN(hum) FROM wp_weatherlink WHERE station_id = '$stationId') LIMIT 1) AS min_hum_date,
MIN(hum) AS min_hum,
round(AVG(hum),2) AS avg_hum,
(SELECT data FROM wp_weatherlink WHERE station_id = '$stationId' AND hum = (SELECT MAX(hum) FROM wp_weatherlink WHERE station_id = '$stationId') LIMIT 1) AS max_hum_date,
MAX(hum) AS max_hum
FROM wp_weatherlink
WHERE station_id = '$stationId'") or die("database error:" . mysqli_error($conn));
}

class PDF extends FPDF
{
    private $title, $province, $region, $long, $lat;

    // Constructor
    function __construct($title, $province, $region, $long, $lat)
    {
        parent::__construct();
        $this->title = $title;
        $this->province = $province;
        $this->region = $region;
        $this->long = $long;
        $this->lat = $lat;
    }

    // Page header
    function Header()
    {
        // Logo
        $this->Image('img/cropped-ibericam-webcam-y-el-tiempo-en-directo-espana-weather-spain-logo-400x100-azul.png', 150, 10, 50);
        $this->SetFont('Arial', 'B', 13);
        // Title
        $this->Cell(80, 10, $this->title, 0, 0, 'C');
        $this->Ln(10);
        $this->Cell(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(30, 5, $this->province, 0, 0);
        $this->Cell(20, 5, $this->region, 0, 0);
        $this->Cell(20, 5, 'Long: ' . $this->long, 0, 0);
        $this->Cell(20, 5, 'Lat: ' . $this->lat, 0, 0);
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Present date and time
        $dateTime = new DateTime();
        $this->Cell(1, 10, 'Generado en ' . $dateTime->format('Y-m-d H:i:s'), 0, 0);
        $this->Cell(95);
        // Page number
        $this->Cell(1, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(70);
        //page address
        $this->Cell(1, 10, "ibericam.com", 0, 0);
    }
}

// Query database for title
$query = "SELECT Name_station FROM wp_station_location WHERE station_id LIKE '" . $stationId . "'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $stationId);
$stmt->execute();
$name = $stmt->get_result();
$row = $name->fetch_assoc();
$title = $row['Name_station'];

$query = "SELECT Province FROM wp_station_location WHERE station_id LIKE '" . $stationId . "'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $stationId);
$stmt->execute();
$name = $stmt->get_result();
$row = $name->fetch_assoc();
$province = $row['Province'];

$query = "SELECT Region FROM wp_station_location WHERE station_id LIKE '" . $stationId . "'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $stationId);
$stmt->execute();
$name = $stmt->get_result();
$row = $name->fetch_assoc();
$region = $row['Region'];

$query = "SELECT Longitude FROM wp_station_location WHERE station_id LIKE '" . $stationId . "'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $stationId);
$stmt->execute();
$name = $stmt->get_result();
$row = $name->fetch_assoc();
$long = $row['Longitude'];

$query = "SELECT Latitude FROM wp_station_location WHERE station_id LIKE '" . $stationId . "'";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $stationId);
$stmt->execute();
$name = $stmt->get_result();
$row = $name->fetch_assoc();
$lat = $row['Latitude'];

$header = array('Data', 'Min Temp', 'Mit Temp', 'Max Temp', 'Min Viento', 'Mit Viento', 'Max Viento', 'Min Pres', 'Mit Pres', 'Max Pres', 'Min Hum', 'Mit Hum', 'Max Hum', 'Prec (mm)');

$tempAvg_header = array('Temp Min del dia', 'Min Temp', 'Mit Temp', 'Temp Max del dia', 'Max Temp');

$windAvg_header = array('Viento Min del dia', 'Min Viento', 'Mit Viento', 'Viento Min del dia', 'Max Viento');

$pressAvg_header = array('Pres Min del dia', 'Min Pres', 'Mit Pres', 'Pres Min del dia', 'Max Pres');

$humAvg_header = array('Hum Min del dia', 'Min Hum', 'Mit Hum', 'Hum Min del dia', 'Max Hum');

$pdf = new PDF($title, $province, $region, $long, $lat);
//File title
$pdf->SetTitle($title . " - visio general del temps");
//header
$pdf->AddPage();
//footer page
$pdf->AliasNbPages();
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(14);
$pdf->Cell(42, 10, 'Temperatura', 1, 0, 'C');
$pdf->Cell(42, 10, 'Viento', 1, 0, 'C');
$pdf->Cell(42, 10, 'Pressio', 1, 0, 'C');
$pdf->Cell(42, 10, 'Humitat', 1, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 6);
foreach ($header as $heading) {
    $pdf->Cell(14, 10, $heading, 1);
}
foreach ($result as $row) {
    $pdf->SetFont('Arial', '', 7);
    $pdf->Ln();
    foreach ($row as $column)
        $pdf->Cell(14, 5, $column, 1);
}

//table with min, max, avg temps
$pdf->Ln(15); foreach ($tempAvg_header as $heading) {
    $pdf->Cell(35, 5, $heading, 1);
}
foreach ($tempAvg as $row) {
    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln();
    foreach ($row as $column)
        $pdf->Cell(35, 5, $column, 1);
}

//table with min, max, avg wind
$pdf->Ln(10); foreach ($windAvg_header as $heading) {
    $pdf->Cell(35, 5, $heading, 1);
}
foreach ($windAvg as $row) {
    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln();
    foreach ($row as $column)
        $pdf->Cell(35, 5, $column, 1);
}

//table with min, max, avg press
$pdf->Ln(10); foreach ($pressAvg_header as $heading) {
    $pdf->Cell(35, 5, $heading, 1);
}
foreach ($pressAvg as $row) {
    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln();
    foreach ($row as $column)
        $pdf->Cell(35, 5, $column, 1);
}

//table with min, max, avg humidity
$pdf->Ln(10); foreach ($humAvg_header as $heading) {
    $pdf->Cell(35, 5, $heading, 1);
}
foreach ($humAvg as $row) {
    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln();
    foreach ($row as $column)
        $pdf->Cell(35, 5, $column, 1);
}
$pdf->Output();
?>