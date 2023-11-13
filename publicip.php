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
        <header class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <h1><span id="logo">Home network</span></h1>
                        </div>
                        <div class="col-md-8 col-12">
                            <nav>
                                <a href="./index.php" id="active">Main page</a>
                                <a href="./services.php">Services</a>
                                <a href="./cronjobs.php">Cron jobs</a>
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
                            <h2>Public IP</h2>
                            <div>
                                <?php
                                    $externalContent = file_get_contents('http://checkip.dyndns.com/');
                                    preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
                                    echo "<h3>" . $m[1] . "</h3>";
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
                        <a href="index.php" class="back">Back</a>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
