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
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
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
            for ($i = $currentYear; $i >= $startYear; $i--) {
              echo "<option value=\"$i\">$i</option>";
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