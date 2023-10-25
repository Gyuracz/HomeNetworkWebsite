<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home website</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="bootstrap.css">
    </head>
    <body>
        <?php
            $service = $_GET["service"];
        ?>

        <header class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <h1><span id="logo">Home network</span></h1>
                        </div>
                        <div class="col-md-8 col-12">
                            <nav>
                                <a href="./index.php">Main page</a>
                                <a href="./services.php" id="active">Services</a>
                                <a href="./temperature.php">Temperature</a>
                            </nav>
                        </div>
                    </div>
                </div>
        </header>

        <section class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <h2>
                                <?php
                                    echo $service;
                                ?>
                            </h2>
                            <div>
                                <?php
                                    exec("journalctl -u " . $service . " 2>&1", $logs);
                                    $logs = array_reverse($logs);
                                    foreach($logs as $it){
                                        echo $it . "<br>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="services.php" class="back">Back</a>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
