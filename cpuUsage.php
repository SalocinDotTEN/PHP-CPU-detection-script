<?php

/**
 * CPU Usage PHP function open sourced by Salocin.TEN
 * Programming knowledge of PHP is essential for the usage of this.
 * Originally made for a corporate database migration project.
 * This function only works on Linux based systems and it works to detect the CPU usage in percentage.
 * Future implementation will see a configuration to adapt to multiple CPU systems.
 * Adapted from a very awesome no rights reserved Bash script at http://colby.id.au/node/39
 * 
 * Visit the Salocin.TEN Virtual Place at www.salocinten.info!
 * */

// Set the session variables. These are essential. You can also adopt them to store into a file.
$_SESSION['prevTotal'] = 0;
$_SESSION['prevIdle'] = 0;
/**
 * This is the function itself.
 * @return CPU usage in percentage rounded to 2 decimals, or you can set what you like.
 */
function checkCpu() {
    $cpuMetrics = exec("cat /proc/stat | grep '^cpu '");
    $cpuNumbers = explode(" ", $cpuMetrics);
    array_shift($cpuNumbers);
    array_shift($cpuNumbers);
    $totalCpu = array_sum($cpuNumbers);
    $diffIdle = $cpuNumbers[3] - $_SESSION['prevIdle'];
    $diffTotal = $totalCpu - $_SESSION['prevTotal'];
    $_SESSION['prevTotal'] = $totalCpu;
    $_SESSION['prevIdle'] = $cpuNumbers[3];
    return round((1000 * ($diffTotal - $diffIdle) / $diffTotal + 5) / 10, 2);
}

// Sample run to check the CPU usage every second...
$i = 0;
while ($i >= 0) {
    echo checkCpu() . '</br>';
    sleep(1);
    $i++;
}
?>
