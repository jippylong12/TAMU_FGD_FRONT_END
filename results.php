
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Results</title>
</head>

<body class="container">
    <?php
    require 'ResultsGenerator.php';
    (new ResultsGenerator())->generate();
?>
</body>
</html>
