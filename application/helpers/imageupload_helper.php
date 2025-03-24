<?php
        function uploadimgfile($index,$folder="other",$prefix="other")
{
    $target_dir  = FCPATH;  // try to put full physical path
    // identity accstatement address advtimg other
    $uploadOk = 1;
    $senddata = array();
    $senddata['data'] = "NILL";
    $notallowed = array("php","js","css","html");  // defined here the extesion not to upload
    $shownotallowed = "PHP, JS, CSS, HTML fie is not allowed to upload.";
    $extension = explode(".",basename($_FILES[$index]["name"]));
    $extension = end($extension);          
    $realfilnename = basename($_FILES[$index]["name"]);
    $datetofolder = date("Y/M/d");
    $datetofolder = strtolower($datetofolder);       
    $checkdirectory = $target_dir."$folder/$datetofolder";        
    if (!file_exists($checkdirectory))
    {
        mkdir($checkdirectory, 0777, true);
    }
    $filnename   = "$folder/$datetofolder/$realfilnename";
    $target_file = $target_dir . $filnename;
    if (in_array($extension, $notallowed))
    {
        $uploadOk = 0;
        $senddata['status']  = 0;
        $senddata['message'] = $shownotallowed;
        return $senddata;
    }
    // Check file size
    if ($_FILES[$index]["size"] > 10485760)
    {
        $uploadOk = 0;
        $senddata['status']  = 0;
        $senddata['message'] = "Maximum File Upload size is 10MB.";
        return $senddata;
        // echo "Sorry, your file is too large.";
        // $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0)
    {
        $senddata['status']  = 0;
        $senddata['message'] = "<b>Sorry!</b> There was an error uploading your file.2";
        return $senddata;
        // echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {     
        if (move_uploaded_file($_FILES[$index]["tmp_name"], $target_file)){
            // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            $senddata['status']  = 1;
            $tempdata = array();
            $tempdata['name']   = $filnename;
            $tempdata['realname']  = $realfilnename;
            $senddata['data']  = $tempdata;
            $senddata['message'] = "File Uploaded successfully.";
            return $senddata;
        } else {
            // echo "Sorry, there was an error uploading your file.";
            $senddata['status']  = 0;
            $senddata['message'] = "<b>Sorry!</b> There was an error uploading your file. Allowed formats are jpg,png,jpeg,pdf,doc,xml .";
            return $senddata;
        }
    }
}
?>