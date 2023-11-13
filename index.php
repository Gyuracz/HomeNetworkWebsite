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
                                <a href="./index.php" id="active">Main page</a>
                                <a href="./services.php">Services</a>
                                <a href="./cronjobs.php">Cron jobs</a>
                                <a href="./temperature.php">Temperature</a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?php
            function _getServerLoadLinuxData()
            {
                if (is_readable("/proc/stat"))
                {
                    $stats = @file_get_contents("/proc/stat");

                    if ($stats !== false)
                    {
                        // Remove double spaces to make it easier to extract values with explode()
                        $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

                        // Separate lines
                        $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                        $stats = explode("\n", $stats);

                        // Separate values and find line for main CPU load
                        foreach ($stats as $statLine)
                        {
                            $statLineData = explode(" ", trim($statLine));

                            // Found!
                            if
                            (
                                (count($statLineData) >= 5) &&
                                ($statLineData[0] == "cpu")
                            )
                            {
                                return array(
                                    $statLineData[1],
                                    $statLineData[2],
                                    $statLineData[3],
                                    $statLineData[4],
                                );
                            }
                        }
                    }
                }

                return null;
            }

            // Returns server load in percent (just number, without percent sign)
            function getServerLoad()
            {
                $load = null;

                if (stristr(PHP_OS, "win"))
                {
                    $cmd = "wmic cpu get loadpercentage /all";
                    @exec($cmd, $output);

                    if ($output)
                    {
                        foreach ($output as $line)
                        {
                            if ($line && preg_match("/^[0-9]+\$/", $line))
                            {
                                $load = $line;
                                break;
                            }
                        }
                    }
                }
                else
                {
                    if (is_readable("/proc/stat"))
                    {
                        // Collect 2 samples - each with 1 second period
                        // See: https://de.wikipedia.org/wiki/Load#Der_Load_Average_auf_Unix-Systemen
                        $statData1 = _getServerLoadLinuxData();
                        sleep(1);
                        $statData2 = _getServerLoadLinuxData();

                        if
                        (
                            (!is_null($statData1)) &&
                            (!is_null($statData2))
                        )
                        {
                            // Get difference
                            $statData2[0] -= $statData1[0];
                            $statData2[1] -= $statData1[1];
                            $statData2[2] -= $statData1[2];
                            $statData2[3] -= $statData1[3];

                            // Sum up the 4 values for User, Nice, System and Idle and calculate
                            // the percentage of idle time (which is part of the 4 values!)
                            $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                            // Invert percentage to get CPU time, not idle time
                            $load = 100 - ($statData2[3] * 100 / $cpuTime);
                        }
                    }
                }

                return $load;
            }

            function getServerMemoryUsage($getPercentage=true)
            {
                $memoryTotal = null;
                $memoryFree = null;
        
                if (stristr(PHP_OS, "win")) {
                    // Get total physical memory (this is in bytes)
                    $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
                    @exec($cmd, $outputTotalPhysicalMemory);
        
                    // Get free physical memory (this is in kibibytes!)
                    $cmd = "wmic OS get FreePhysicalMemory";
                    @exec($cmd, $outputFreePhysicalMemory);
        
                    if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
                        // Find total value
                        foreach ($outputTotalPhysicalMemory as $line) {
                            if ($line && preg_match("/^[0-9]+\$/", $line)) {
                                $memoryTotal = $line;
                                break;
                            }
                        }
        
                        // Find free value
                        foreach ($outputFreePhysicalMemory as $line) {
                            if ($line && preg_match("/^[0-9]+\$/", $line)) {
                                $memoryFree = $line;
                                $memoryFree *= 1024;  // convert from kibibytes to bytes
                                break;
                            }
                        }
                    }
                }
                else
                {
                    if (is_readable("/proc/meminfo"))
                    {
                        $stats = @file_get_contents("/proc/meminfo");
        
                        if ($stats !== false) {
                            // Separate lines
                            $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                            $stats = explode("\n", $stats);
        
                            // Separate values and find correct lines for total and free mem
                            foreach ($stats as $statLine) {
                                $statLineData = explode(":", trim($statLine));
        
                                //
                                // Extract size (TODO: It seems that (at least) the two values for total and free memory have the unit "kB" always. Is this correct?
                                //
        
                                // Total memory
                                if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                                    $memoryTotal = trim($statLineData[1]);
                                    $memoryTotal = explode(" ", $memoryTotal);
                                    $memoryTotal = $memoryTotal[0];
                                    $memoryTotal *= 1024;  // convert from kibibytes to bytes
                                }
        
                                // Free memory
                                if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                                    $memoryFree = trim($statLineData[1]);
                                    $memoryFree = explode(" ", $memoryFree);
                                    $memoryFree = $memoryFree[0];
                                    $memoryFree *= 1024;  // convert from kibibytes to bytes
                                }
                            }
                        }
                    }
                }
        
                if (is_null($memoryTotal) || is_null($memoryFree)) {
                    return null;
                } else {
                    if ($getPercentage) {
                        return (100 - ($memoryFree * 100 / $memoryTotal));
                    } else {
                        return array(
                            "total" => $memoryTotal,
                            "free" => $memoryFree,
                        );
                    }
                }
            }
        
            function getNiceFileSize($bytes, $binaryPrefix=true) {
                if ($binaryPrefix) {
                    $unit=array('B','KB','MB','GB','TB','PB');
                    if ($bytes==0) return '0 ' . $unit[0];
                    return @round($bytes/pow(1024,($i=floor(log($bytes,1024)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
                } else {
                    $unit=array('B','KiB','MiB','GiB','TiB','PiB');
                    if ($bytes==0) return '0 ' . $unit[0];
                    return @round($bytes/pow(1000,($i=floor(log($bytes,1000)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
                }
            }

            function getUptime(){
                if(!stristr(PHP_OS, "win")){
                    $output = @file_get_contents('/proc/uptime');
                    $uptime = explode(' ', $output)[0];
                    
                    $days = explode(".",(($uptime % 31556926) / 86400));
                    $hours = explode(".",((($uptime % 31556926) % 86400) / 3600));
                    $minutes = explode(".",(((($uptime % 31556926) % 86400) % 3600) / 60));
                    $seconds = explode(".",((((($uptime % 31556926) % 86400) % 3600) / 60) / 60));

                    return $days[0]."d ".$hours[0]."h ".$minutes[0]."m ".$seconds[0]."s";
                }
            }

            function getDiskSpaceSystem(){
                if(stristr(PHP_OS, "win")){
                    return getNiceFileSize(disk_total_space("C:") - disk_free_space("C:")) . " / " . getNiceFileSize(disk_total_space("C:"));
                }else{
                    $disk = "/dev/disk/by-partuuid/5dc7fad8-02";
                    return getNiceFileSize(disk_total_space("/") - disk_free_space("/")) . " / " . getNiceFileSize(disk_total_space("/"));
                }
            }

            function getDiskSpaceNas(){
                if(!stristr(PHP_OS, "win")){
                    $disk = "/dev/disk/by-partuuid/bc48a84b-01";
                    return getNiceFileSize(disk_total_space("/nas") - disk_free_space("/nas")) . " / " . getNiceFileSize(disk_total_space("/nas"));
                }
            }

            function getDiskSpacePlex(){
                if(!stristr(PHP_OS, "win")){
                    $disk = "/dev/disk/by-partuuid/05a98b11-01";
                    return getNiceFileSize(disk_total_space("/plex") - disk_free_space("/plex")) . " / " . getNiceFileSize(disk_total_space("/plex"));
                }
            }
        ?>

        <section class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-12"></div>
                    <div class="col-md-6 col-12">
                        <div class="box">
                            <h2>Server info</h2>
                            <table>
                                <tr>
                                    <th>Hostname:</th>
                                    <td>
                                        <?php
                                            echo php_uname("n");
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Private IP:</th>
                                    <td>
                                        <?php
                                            // echo getHostByName(php_uname("n"));
                                        ?>
                                        192.168.1.10
                                    </td>
                                </tr>
                                <tr>
                                    <th>Public IP:</th>
                                    <td>
                                        <a href="publicip.php">Get public IP of server.</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>OS:</th>
                                    <td>
                                        <?php
                                            echo php_uname("s") . " " . php_uname("r") . " " . php_uname("m");
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Uptime:</th>
                                    <td>
                                        <?php
                                            echo getUptime();
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>CPU load:</th>
                                    <td>
                                        <?php
                                            echo round(getServerLoad(), 2) . "%";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Memory usage (used/total):</th>
                                    <td>
                                        <?php
                                            $memUsage = getServerMemoryUsage(false);
                                            echo getNiceFileSize($memUsage["total"] - $memUsage["free"]) . " / " . getNiceFileSize($memUsage["total"]);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Disk space (/) (used/total):</th>
                                    <td>
                                        <?php
                                            echo getDiskSpaceSystem();
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Disk space (/nas) (used/total):</th>
                                    <td>
                                        <?php
                                            echo getDiskSpaceNas();
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Disk space (/plex) (used/total):</th>
                                    <td>
                                        <?php
                                            echo getDiskSpacePlex();
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-3 col-12"></div>
                </div>
            </div>
        </section>
    </body>
</html>
