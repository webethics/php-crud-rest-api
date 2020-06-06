<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/users.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $user->id = isset($_GET['id']) ? $_GET['id'] : die();

    $user->getSingleUser();

    if($user->first_name != null){
        $user_arr = array(
            "id" =>  $user->id,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "age" => $user->age,
            "phone" => $user->phone,
            "created" => $user->created
        );

        http_response_code(200);
        echo json_encode($user_arr);
    }

    else{
        http_response_code(404);
        echo json_encode("User not found.");
    }
?>
