<?php
include "config.php";
?>

<head>
  <title>Weather data overview - PDF Generator</title>
  <link rel="stylesheet" href="style.css" type="text/css">
  <style>
    /* CSS to display radio buttons inline */
    .radio-container {
      display: inline-block;
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <form class="form" action="generatePdf.php" method="post" target="_blank">
    <div class="title">Generar PDF</div>
    <div class="subtitle">con visión general del tiempo</div>
    <input id="stationId" name="stationId" type="text" value="<?php echo $_GET['station'] ?>" hidden />
    <div class="input-container ic1">
      <div class="container">
        <div class="radio-container">
          <input type="radio" id="month" name="date" value="month">
          <label class="date--label" for="month"
            style="color: #666; font-family: sans-serif; cursor: pointer;">Mes</label>
        </div>
        <div class="select-container">
          <select class="select" id="months" name="months">
            <?php
            $query = "SELECT DISTINCT MONTH(Data) as month FROM wp_weatherlink";
            $result = mysqli_query($conn, $query);

            $spanishMonthNames = array(
              'Enero',
              'Febrero',
              'Marzo',
              'Abril',
              'Mayo',
              'Junio',
              'Julio',
              'Agosto',
              'Septiembre',
              'Octubre',
              'Noviembre',
              'Diciembre'
            );

            while ($row = mysqli_fetch_assoc($result)) {
              $month = $row['month'];
              $monthName = $spanishMonthNames[$month - 1];
              echo "<option value=\"$month\">$monthName</option>";
            }
            ?>
          </select>
        </div>
      </div><br>
      <div class="container">
        <div class="radio-container">
          <input type="radio" id="year" name="date" value="year">
          <label class="date--label" for="year"
            style="color: #666; font-family: sans-serif; cursor: pointer;">Año</label>
        </div>
        <div class="select-container">
          <select class="select" id="years" name="years">
            <?php
            $startYear = 2010;
            $currentYear = date('Y');

            // Assuming you have a database connection and a table named 'weather_data'
// Modify the query according to your database structure
            $query = "SELECT DISTINCT YEAR(Data) as year FROM wp_weatherlink ORDER BY year DESC";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
              $year = $row['year'];
              echo "<option value=\"$year\">$year</option>";
            }
            ?>

          </select>
        </div>
      </div><br>
      <div class="radio-container">
        <input type="radio" id="allTime" name="date" value="allTime">
        <label class="date--label" for="allTime" style="color: #666; font-family: sans-serif; cursor: pointer;">Todo el
          tiempo</label>
      </div>
    </div>
    <input type="submit" class="button" value="Generar!">
  </form>
</body>