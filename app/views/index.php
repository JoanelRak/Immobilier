<?php

include "components/functions/incs.php";
$base_url = Flight::get('flight.base_url');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immobilier</title>
    <base href="<?= $base_url ?>">
    <link rel="stylesheet" href="css/main-css.css">
    <link rel="stylesheet" href="css/auth-css.css">
    <link rel="stylesheet" href="css/selected-css.css">
    <link rel="stylesheet" href="css/admin-css.css">

</head>

<body>
<?php
if (!empty($header)) {
    include('components/page/header.php');
} ?>

<?php
if (!empty($message)) {
    include('components/page/error.php');
}



if (!empty($main)) {
    include('components/page/' . $main . '.php');
}

if (!empty($footer)) {
    include('components/page/footer.php');
}
if (!empty($others)) {
    if (is_array($others)) {
        foreach ($others as $page) {
            include($page);
        }
    } else {
        include($others);
    }
}

?>
</body>
</html>