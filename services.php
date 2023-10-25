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
        <header>
            <div class="container-fluid">
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
            </div>
        </header>

        <?php
                                            if(isset($_POST["startSSH"])){
                                                exec("sudo systemctl start sshd");
                                            }
                                            if(isset($_POST["stopSSH"])){
                                                exec("sudo systemctl stop sshd");
                                            }
                                            if(isset($_POST["startAdguard"])){
                                                exec("sudo systemctl start AdGuardHome 2>&1");
                                            }
                                            if(isset($_POST["stopAdguard"])){
                                                exec("sudo systemctl stop AdGuardHome 2>&1");
                                            }
                                            if(isset($_POST["startPlex"])){
                                                exec("sudo systemctl start plexmediaserver 2>&1");
                                            }
                                            if(isset($_POST["stopPlex"])){
                                                exec("sudo systemctl stop plexmediaserver 2>&1");
                                            }
                                            if(isset($_POST["startDHCP"])){
                                                exec("sudo systemctl start isc-dhcp-server 2>&1");
                                            }
                                            if(isset($_POST["stopDHCP"])){
                                                exec("sudo systemctl stop isc-dhcp-server 2>&1");
                                            }
                                            if(isset($_POST["startSMBD"])){
                                                exec("sudo systemctl start smbd 2>&1");
                                            }
                                            if(isset($_POST["stopSMBD"])){
                                                exec("sudo systemctl stop smbd 2>&1");
                                            }
                                            if(isset($_POST["startNMBD"])){
                                                exec("sudo systemctl start smbd 2>&1");
                                            }
                                            if(isset($_POST["stopNMBD"])){
                                                exec("sudo systemctl stop smbd 2>&1");
                                            }
                                            if(isset($_POST["startDocker"])){
                                                exec("sudo systemctl start docker 2>&1");
                                            }
                                            if(isset($_POST["stopDocker"])){
                                                exec("sudo systemctl stop docker 2>&1");
                                            }
                                            if(isset($_POST["startApache"])){
                                                exec("sudo systemctl start apache2 2>&1");
                                            }
                                            if(isset($_POST["stopApache"])){
                                                exec("sudo systemctl stop apache2 2>&1");
                                            }
                                            if(isset($_POST["startTemperature"])){
                                                exec("sudo systemctl start temperature 2>&1");
                                            }
                                            if(isset($_POST["stopTemperature"])){
                                                exec("sudo systemctl stop temperature 2>&1");
                                            }
         ?>

        <section class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <h2>Services</h2>
                            <table>
                                <tr>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Logs</th>
                                    <th>Start</th>
                                    <th>Stop</th>
                                </tr>
                                <tr>
                                    <td>SSHD</td>
                                    <td>
                                        <?php
                                            echo exec("systemctl status sshd | grep Active: | awk '{print $2,$3}'");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="logs.php?service=sshd" class="mount">View logs</a>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="start" value="Start" name="startSSH">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="stop" value="Stop" name="stopSSH">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="http://192.168.1.10" target="_blank">AdGuard</a></td>
                                    <td>
                                        <?php
                                            echo exec("systemctl status AdGuardHome | grep Active: | awk '{print $2,$3}'");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="logs.php?service=AdGuardHome" class="mount">View logs</a>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="start" value="Start" name="startAdguard">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="stop" value="Stop" name="stopAdguard">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="http://192.168.1.10:32400/web" target="_blank">Plex</a></td>
                                    <td>
                                        <?php
                                            echo exec("systemctl status plexmediaserver | grep Active: | awk '{print $2,$3}'");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="logs.php?service=plexmediaserver" class="mount">View logs</a>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="start" value="Start" name="startPlex">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="stop" value="Stop" name="stopPlex">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>DHCP</td>
                                    <td>
                                        <?php
                                            echo exec("systemctl status isc-dhcp-server | grep Active: | awk '{print $2,$3}'");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="logs.php?service=isc-dhcp-server" class="mount">View logs</a>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="start" value="Start" name="startDHCP">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="stop" value="Stop" name="stopDHCP">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Samba (smbd)</td>
                                    <td>
                                        <?php
                                            echo exec("systemctl status smbd | grep Active: | awk '{print $2,$3}'");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="logs.php?service=smbd" class="mount">View logs</a>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="start" value="Start" name="startSMBD">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="stop" value="Stop" name="stopSMBD">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Samba (nmbd)</td>
                                    <td>
                                        <?php
                                            echo exec("systemctl status nmbd | grep Active: | awk '{print $2,$3}'");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="logs.php?service=nmbd" class="mount">View logs</a>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="start" value="Start" name="startNMBD">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="stop" value="Stop" name="stopNMBD">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Docker</td>
                                    <td>
                                        <?php
                                            echo exec("systemctl status docker | grep Active: | awk '{print $2,$3}'");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="logs.php?service=docker" class="mount">View logs</a>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="start" value="Start" name="startDocker">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="stop" value="Stop" name="stopDocker">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Apache2</td>
                                    <td>
                                        <?php
                                            // echo exec("systemctl status apache2 | grep Active: | awk '{print $2,$3}'");
                                        ?>
                                        active (running)
                                    </td>
                                    <td>
                                        <a href="logs.php?service=apache2" class="mount">View logs</a>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="start" value="Start" name="startApache">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="stop" value="Stop" name="stopApache">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Temperature</td>
                                    <td>
                                        <?php
                                            echo exec("systemctl status temperature | grep Active: | awk '{print $2,$3}'");
                                        ?>
                                    </td>
                                    <td>
                                        <a href="logs.php?service=temperature" class="mount">View logs</a>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="start" value="Start" name="startTemperature">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" class="stop" value="Stop" name="stopTemperature">
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <?php
                            if(isset($_POST["mount"])){
                                exec("mount -a 2>&1");
                            }
                        ?>
                        <form method="post">
                            <input type="submit" class="mount" value="Mount all disk" name="mount">
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-6 text-center">
                        <?php
                            if(isset($_POST["reboot"])){
                                exec("sudo reboot 2>&1");
                            }
                        ?>
                        <form method="post">
                            <input type="submit" class="stop" value="Reboot" name="reboot">
                        </form>
                    </div>
                    <div class="col-6 text-center">
                        <?php
                            if(isset($_POST["sh"])){
                                exec("sudo shutdown now 2>&1");
                            }
                        ?>
                        <form method="post">
                            <input type="submit" class="stop" value="Shutdown" name="sh">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
