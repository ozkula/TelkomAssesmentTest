<?php
$debug = false;
if ($debug == true) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}
    $listArg = $argv;
    $filename = basename($_SERVER['PHP_SELF']);
    // print_r($listArg);
    if (isset($listArg[1])) {
        if ($listArg[1] == '-h') {
            helpFiles($filename);
        } else if (in_array("-t", $listArg) && $listArg[2] == '-t') {
            // Extracting from -t 
            if (count($listArg) < 4) {
                errorList(1,$filename);
            }

            checkFileExist($listArg[1]);

            $filePath = $listArg[1];
            $extension = $listArg[3];
            if (isset($listArg[4]) == '-o') {

                $getDestination = $listArg[5];
                $explodeExtension = explode('/',$getDestination);
                $getExtension = explode('.',end($explodeExtension));

                if ($getExtension[1] == 'json' || $getExtension[1] == 'txt') {
                    convertingPath($listArg[1],$getDestination);
                } else {
                    errorList(1,$filename);
                }
            } else if ($extension == 'json') {
                convertingJson($listArg[1]);
            } else if ($extension == 'text') {
                convertingTxt($listArg[1]);
            } else {
                errorList(1,$filename);
            }
            
        } else if (in_array("-o", $listArg) && $listArg[2] == '-o') {
            
            if (count($listArg) < 4) {
                errorList(1,$filename);
            }
            checkFileExist($listArg[1]);

            $getDestination = $listArg[3];
            $explodeExtension = explode('/',$getDestination);
            $getExtension = explode('.',end($explodeExtension));
            if ($getExtension[1] == 'json' || $getExtension[1] == 'txt') {
                checkFileExist($listArg[1]);
                convertingPath($listArg[1],$getDestination);
            } else {
                errorList(1,$filename);
            }
            

        }
        else {
            // default command Convert into text files
            checkFileExist($listArg[1]);
            convertingTxt($listArg[1]);
        }
    } else {
        echo "Please run 'php convertlog.php -h' for help";
    }

function helpFiles($filename){
    echo "Purpose of this tools is get Log Files from Linux log directory then convert into JSON or Txt format,\nThis files is in PHP formated file please install PHP First\n\n";
    echo "Usage: php $filename <dir> <options>\n\n";
    echo "Options:\n";
    echo "-h                : Help \n";
    echo "-t<space>json     : Convert to Json File \n";
    echo "-t<space>text     : Convert to Text File \n";
    echo "-o<space><newdir> : Move to another directory \n\n";

    echo "php $filename <file dir> -o <newdir> \n";
    echo "php $filename <file dir> -t convert -o <newdir>\n";
}
function checkFileExist($filePath){
    if (!file_exists($filePath)) {
        echo "File $filePath does not exist\n";
        die();
    }
}

function errorList($errorNumber,$filename){
    switch ($errorNumber) {
        case '1':
            echo "Please using following format, try using 'php $filename -h' for Help\n";die();
            break;
    }
}

function convertingTxt($filePath){
    $newFilenameConvert = explode(".log", $filePath);
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        echo "Converting ..\n";
        rename ($filePath,$newFilenameConvert[0].".txt");
        echo "Finish Convert '".$newFilenameConvert[0].".txt'..\n";
    } else {
        echo "Converting ..\n";
        shell_exec("mv ".$filePath." ".$newFilenameConvert[0].".txt");
        echo "Finish Convert '".$newFilenameConvert[0].".txt'..\n";
    }
}

function convertingJson($filePath){
    $newFilenameConvert = explode(".log", $filePath);
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        echo "Converting ..\n";
        rename ($filePath,$newFilenameConvert[0].".json");
        echo "Finish Convert '".$newFilenameConvert[0].".json'..\n";
    } else {
        echo "Converting ..\n";
        shell_exec("mv ".$filePath." ".$newFilenameConvert[0].".json");
        echo "Finish Convert '".$newFilenameConvert[0].".json'..\n";
    }
}

function convertingPath($filePath,$filePath2){
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        echo "Converting ..\n";
        copy ($filePath, $filePath2);
        echo "Finish Convert and Copied to '".$filePath2."'..\n";
    } else {
        echo "Converting ..\n";
        shell_exec("cp ".$filePath." ".$filePath2);
        echo "Finish Convert and Copied to '".$filePath2."'..\n";
    }
}
