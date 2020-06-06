
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
    $data = json_decode(file_get_contents("php://input"));
    
    $user->id = $data->id;
    $user->first_name = $data->first_name;
    $user->last_name = $data->last_name;
    $user->email = $data->email;
    $user->age = $data->age;
    $user->phone = $data->phone;
    $user->created = date('Y-m-d H:i:s');

    if ($user->updateUser()) {
        http_response_code(201);
        echo json_encode($user);
    } else {
        echo json_encode("Data could not be updated");
    }
?>
