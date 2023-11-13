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

        <section class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <h2>Cron jobs</h2>
                            <table>
                                <tr>
                                    <th>Cron job</th>
                                    <th>Script</th>
                                    <th>Last run</th>
                                </tr>
                                <tr>
                                    <td>Drop cached memory</td>
                                    <td>/home/admin/drop_cache.sh</td>
                                    <td>
                                        <?php
                                            // echo exec("cat /var/log/syslog | grep -E '(drop_cache.sh\))$' | tail -n 1 | awk '{print $1,$2,$3}'");
                                            $file = fopen("./drop_cache_ts.txt", "r") or die("Unable to open file!");
                                            echo fread($file, filesize("./drop_cache_ts.txt"));
                                            fclose($file);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Auto remount dropped disks</td>
                                    <td>/home/admin/auto_remount.sh</td>
                                    <td>
                                        <?php
                                            // echo exec("cat /var/log/syslog | grep -E '(auto_remount.sh\))$' | tail -n 1 | awk '{print $1,$2,$3}'");
                                            $file = fopen("./auto_remount_ts.txt", "r") or die("Unable to open file!");
                                            echo fread($file, filesize("./auto_remount_ts.txt"));
                                            fclose($file);
                                        ?>
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
