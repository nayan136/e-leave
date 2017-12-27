<?php
    session_start();
    if(isset($_SESSION['application_details'])){
        $data = $_SESSION['application_details'];
        //unset($_SESSION['application_details']);
        print_r($data);
    }else{
        echo "Session not saved";
    }
?>
<html>
    <head>
        <title>HTML email</title>
        <style>
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 50%;
                }
                
                td, th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }
                
                /* tr:nth-child(even) {
                    background-color: #dddddd;
                } */
                </style>
    </head>
    <body>
        <h2 style="text-align:center">Cotton University</h2>
        <h3 style="text-align:center">CL Application</h3>
        <table align="center">
            <tr>
                <td><strong>Department</strong></td>
                <td>Doe</td>
            </tr>
            <tr>
                <td><strong>Application Id</strong></td>
                <td>Doe</td>
            </tr>
            <tr>
                <td><strong>Applicant Name</strong></td>
                <td>Doe</td>
            </tr>
            <tr>
                <td><strong>CL</strong></td>
                <td>Doe</td>
            </tr>
            <tr>
                <td><strong>CL Left</strong></td>
                <td>Doe</td>
            </tr>
            <tr>
                <td><strong>Apply Time</strong></td>
                <td>Doe</td>
            </tr>
        </table>
    </body>
</html>