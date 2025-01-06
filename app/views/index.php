<?php

include "components/functions/incs.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noel</title>
    <link rel="stylesheet" href="/css/static.css">
    <link rel="stylesheet" href="/css/specific.css">
    <link rel="stylesheet" href="/css/table.css">



    <style>
        /* Loading screen styles */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9) url('/spinner.gif') no-repeat center center;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body.loaded #loading-screen {
            display: none;
        }
    </style>
</head>

<body>
<div id="loading-screen"></div>

<?php
if (!empty($header)) {
    include('components/page/header.php');
}


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

<script src="/js/app.js"></script>


</body>
</html>