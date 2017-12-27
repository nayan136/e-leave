<?php
session_start();
if(isset($_SESSION["email"]) && !empty($_SESSION["email"])){
    if(isset($_SESSION['application_details'])){
        $data = $_SESSION['application_details'];
        //unset($_SESSION['application_details']);

        // email
        $to = $_SESSION["email"];
        $subject = "CL Application Details";
        echo $to."<br>";
        $message = '
        <html>
        <head>
            <title>HTML email</title>
            <style>
                    table {
                        font-family: arial, sans-serif;
                        border-collapse: collapse;
                        width: 80%;
                    }
                    
                    td, th {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }
            </style>
        </head>
        <body>
            <h2 style="text-align:center">Cotton University</h2>
            <h3 style="text-align:center">CL Application</h3>
            <table align="center">
                <tr>
                    <td><strong>Department</strong></td>
                    <td>'.$data[0].'</td>
                </tr>
                <tr>
                    <td><strong>Application Id</strong></td>
                    <td>'.$data[1].'</td>
                </tr>
                <tr>
                    <td><strong>Applicant Name</strong></td>
                    <td>'.$data[2].'</td>
                </tr>
                <tr>
                    <td><strong>CL</strong></td>
                    <td>'.$data[3].'</td>
                </tr>
                <tr>
                    <td><strong>CL Left</strong></td>
                    <td>'.$data[4].'</td>
                </tr>
                <tr>
                    <td><strong>Apply Time</strong></td>
                    <td>'.$data[5].'</td>
                </tr>
            </table>
        </body>
        </html>
        ';
        // echo $message;
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // More headers
        // $headers .= 'From: <webmaster@example.com>' . "\r\n";
        // $headers .= 'Cc: myboss@example.com' . "\r\n";
        
        mail($to,$subject,$message,$headers);
    }else{
        echo "Session not saved";
    }   
}

?>