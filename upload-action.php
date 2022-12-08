<?php

    if(isset($_FILES['fileToUpload'])){
        //get uploaded files information
        $name_arr = $_FILES['fileToUpload']['name'];
        $temp_name_arr = $_FILES['fileToUpload']['tmp_name'];
        $size_arr = $_FILES['fileToUpload']['size'];
        $type_arr = $_FILES['fileToUpload']['type'];
        $error_arr = $_FILES['fileToUpload']['error'];
        
        for($i = 0; $i < count($name_arr); $i++){
            //check file extension
            $fileExt = explode('.', $name_arr[$i]);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('xlsx','xls');
            if(in_array($fileActualExt,$allowed)){
                if($error_arr[$i]===0){
                    if($size_arr[$i] < 1000000){
                        $newFileName[$i] = uniqid('',true).".".$fileActualExt;
                        $fileDestination[$i] = "uploads/".$newFileName[$i];
                        move_uploaded_file($temp_name_arr[$i], $fileDestination[$i]);
                        header("Location:index.html?uploadsuccess");
                    }else{
                        echo $name_arr[$i]." is too big!";
                        continue;
                    }
                }else{
                    echo "There is an error uploading ".$name_arr[$i];
                    continue;
                }
            }else{
                echo '<script> alert("Only Excel file types accepted!") </script>';
                continue;
            }
        }
    }
    
    
?>

