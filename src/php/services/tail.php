<?php
set_include_path(get_include_path() . PATH_SEPARATOR . getcwd());
include('config.php.inc');


// full path to text file
define("TEXT_FILE", $GLOBALS['LOG_FILE']);
// number of lines to read from the end of file
define("LINES_COUNT", $GLOBALS['LIVE_LOG_ROW_COUNT']);


function read_file($file, $lines) {
    //global $fsize;
    $handle = fopen($file, "r");
    $linecounter = $lines;
    $pos = -2;
    $beginning = false;
    $text = array();
    while ($linecounter > 0) {
        $t = " ";
        while ($t != "\n") {
            if(fseek($handle, $pos, SEEK_END) == -1) {
                $beginning = true; 
                break; 
            }
            $t = fgetc($handle);
            $pos --;
        }
        $linecounter --;
        if ($beginning) {
            rewind($handle);
        }
        $text[$lines-$linecounter-1] = fgets($handle);
        if ($beginning) break;
    }
    fclose ($handle);
    return array_reverse($text);
}

function get_lines() {
	$lines = read_file(TEXT_FILE, LINES_COUNT);
	return $lines;
}
?>
