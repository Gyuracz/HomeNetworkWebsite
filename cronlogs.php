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
            $cronjob = $_GET["cronjob"];
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
                                <a href="./services.php">Services</a>
                                <a href="./cronjobs.php" id="active">Cron jobs</a>
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
                                    echo $cronjob;
                                ?>
                            </h2>
                            <div style="text-align: left;">
                                <?php
                                    $file = fopen($cronjob . ".csv", "r") or die("Unable to open file!");
                                    $logs = array();
                                    while(!feof($file)){
                                        array_push($logs, fgets($file));
                                    }
                                    $logs = array_reverse($logs);
                                    fclose($file);
                                    foreach($logs as $it){
                                        $it = explode(";", $it);
                                        echo "<pre>" . $it[0] . "    " . $it[1] . "</pre>";
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
                        <a href="cronjobs.php" class="back">Back</a>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
