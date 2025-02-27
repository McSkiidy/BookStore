<?php


header('Content-Type: application/json');

// Check if the query parameter is set
if(isset($_GET['query'])) {     
    $query = $_GET['query'];
    // $query = "python";

    // Execute the Python script and capture the output
    exec("C:\Users\ss289\AppData\Local\Programs\Python\Python311\python.exe D:/Xampp/htdocs/BookStore/api1.py \"$query\" 2>&1", $output, $return_value);
    // print_r($output);
    
    // Check if the execution was successful
    if($return_value === 0){
        // Encode the output as JSON
        echo json_encode(['output' => $output[2]]);
    } else {
        echo json_encode(['error' => implode("\n", $output)]);
    }
}   
