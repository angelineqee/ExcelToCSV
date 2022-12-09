<?php
    chdir(dirname(__DIR__));//parent folder
    shell_exec('javac -cp "poi-bin-5.2.3/poi-5.2.3.jar;poi-bin-5.2.3/lib/commons-io-2.11.0.jar;poi-bin-5.2.3/poi-ooxml-5.2.3.jar;poi-bin-5.2.3/lib/commons-collections4-4.4.jar;poi-bin-5.2.3/ooxml-lib/xmlbeans-5.1.1.jar;poi-bin-5.2.3/apache-log4j-2.17.1-bin/log4j-api-2.17.1.jar;poi-bin-5.2.3/log4j-core-2.17.2.0001L.jar;poi-bin-5.2.3\ooxml-lib\commons-compress-1.21.jar;poi-bin-5.2.3\poi-ooxml-full-5.2.3.jar" CAT201_assignment\ConvertExcelToCSV.java');
    shell_exec('java -cp "poi-bin-5.2.3/poi-5.2.3.jar;poi-bin-5.2.3/lib/commons-io-2.11.0.jar;poi-bin-5.2.3/poi-ooxml-5.2.3.jar;poi-bin-5.2.3/lib/commons-collections4-4.4.jar;poi-bin-5.2.3/ooxml-lib/xmlbeans-5.1.1.jar;poi-bin-5.2.3/apache-log4j-2.17.1-bin/log4j-api-2.17.1.jar;poi-bin-5.2.3/log4j-core-2.17.2.0001L.jar;poi-bin-5.2.3\ooxml-lib\commons-compress-1.21.jar;poi-bin-5.2.3\poi-ooxml-full-5.2.3.jar" CAT201_assignment\ConvertExcelToCSV.java');

    $path = __DIR__."./converted/";
    //Read filepath
    $files = scandir($path);
    if(count($files) == 2){
        echo '<script>alert("No file uploaded!")</script>';
    }
    else{
        $filePaths = array_values(array_diff($files, array('.','..')));
        for($i=0;$i<sizeof($filePaths);$i++){
            $filePaths[$i] = $path.$filePaths[$i]; 
        }

        $zip = new ZipArchive();
        $zip_name = "files.zip"; // Zip name
        $zip->open($zip_name,  ZipArchive::CREATE);
        foreach ($filePaths as $file) {
            if(file_exists($file)){
                $zip->addFromString(basename($file),  file_get_contents($file));  
            }
            else{
                echo"file does not exist";
            }
        }
        $zip->close();

        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$zip_name);
        header('Content-Length: ' . filesize($zip_name));
        readfile($zip_name);

        // loop through the files one by one
        foreach(glob("CAT201_assignment/uploads./*") as $file){
            // check if is a file and not sub-directory
            if(is_file($file)){
                // delete file
                unlink($file);
            }
        }

        foreach(glob("CAT201_assignment/converted./*") as $file){
            // check if is a file and not sub-directory
            if(is_file($file)){
                // delete file
                unlink($file);
            }
        }
        
        unlink("files.zip");
    }
    
    
   
exit;

?>
