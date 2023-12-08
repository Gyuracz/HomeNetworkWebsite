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
                                <a href="./cronjobs.php" id="active">Cron jobs</a>
                                <a href="./temperature.php">Temperature</a>
                            </nav>
                        </div>
                    </div>
                </div>
        </header>

        <?php
            $file = fopen("./drop_cache_log.csv", "r") or die("Unable to open file!");
            $cacheData = array();
            while(!feof($file)){
                array_push($cacheData, fgets($file));
            }
            $cacheData = array_reverse($cacheData);
            $actualCacheData = explode(";", $cacheData[1]);     // A 0. sor üres, mert a fájl végén van egy üres sor.
            fclose($file);

            $file = fopen("./auto_remount_log.csv", "r") or die("Unable to open file!");
            $remountData = array();
            while(!feof($file)){
                array_push($remountData, fgets($file));
            }
            $remountData = array_reverse($remountData);
            $actualRemountData = explode(";", $remountData[1]); // A 0. sor üres, mert a fájl végén van egy üres sor.
            fclose($file);
        ?>

        <section class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <h2>Cron jobs</h2>
                            <table>
                                <tr>
                                    <th>Cron job</th>
                                    <th>Script location</th>
                                    <th>Last run</th>
                                    <th>Message</th>
                                    <th>View logs</th>
                                </tr>
                                <tr>
                                    <td>Drop cached memory</td>
                                    <td>/home/admin/drop_cache.sh</td>
                                    <td>
                                        <?php
                                            echo $actualCacheData[0];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $actualCacheData[1];
                                        ?>
                                    </td>
                                    <td>
                                        <a href="cronlogs.php?cronjob=drop_cache_log" class="mount">View logs</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Auto remount dropped disks</td>
                                    <td>/home/admin/auto_remount.sh</td>
                                    <td>
                                        <?php
                                            echo $actualRemountData[0];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $actualRemountData[1];
                                        ?>
                                    </td>
                                    <td>
                                        <a href="cronlogs.php?cronjob=auto_remount_log" class="mount">View logs</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
