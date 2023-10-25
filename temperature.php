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
            $file = fopen("./temperature.csv", "r") or die("Unable to open file!");
            $data = explode(";", fread($file, filesize("./temperature.csv")));
            fclose($file);
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
                                <a href="./temperature.php" id="active">Temperature</a>
                            </nav>
                        </div>
                    </div>
                </div>
        </header>

        <?php
            exec("systemctl status temperature | grep Active: | awk '{print $2,$3}' 2>&1", $res);
            if($res[0] != "active (running)"){
                echo "<section class='container-fluid'>";
                echo "<div class='container'>";
                echo "<div class='row'>";
                echo "<div class='col-12 text-center'>";
                echo "<h3>Service is not running!</h3>";
                echo "<h4>Last data:</h4>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</section>";
            }
        ?>

        <section class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="box">
                           <h2>Temperature</h2>
                            <?php
                                $color = "white";
                                if($data[0] > 25){
                                    $color = "red";
                                }
                                if($data[0] < 18){
                                    $color = "yellow";
                                }
                                echo "<h3 style='color:" . $color . "'>" . $data[0] . "°C</h3>";
                            ?>
                         </div>
                     </div>
                    <div class="col-md-6 col-12">
                        <div class="box">
                            <h2>Humidity</h2>
                            <?php
                                $color = "white";
                                if($data[1] >= 60){
                                    $color = "red";
                                }
                                echo "<h3 style='color:" . $color . "'>" . $data[1] . "%</h3>";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php
                            echo "Last update: " . date("Y F d H:i:s.", filemtime("./temperature.csv"));
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
