<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../class/users.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new User($db);

    $stmt = $items->getUsers();
    $itemCount = $stmt->rowCount();


    if($itemCount > 0){

        $users = array();
        $users["data"] = array();
        $users["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "age" => $age,
                "phone" => $phone,
                "created" => $created
            );

            array_push($users["data"], $e);
        }
        echo json_encode($users);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>
