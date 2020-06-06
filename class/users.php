<?php
    class User {

        private $conn;

        // Table
        private $db_table = "users";

        // Columns
        public $id;
        public $first_name;
        public $last_name;
        public $email;
        public $age;
        public $phone;
        public $created;

        // Db connection
        public function __construct($db)
        {
            $this->conn = $db;
        }

        // GET ALL
        public function getUsers()
        {
            $sqlQuery = "SELECT id, first_name, last_name, email, age, phone, created FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createUser()
        {
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        age = :age,
                        phone = :phone,
                        created = :created";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->first_name = htmlspecialchars(strip_tags($this->first_name));
            $this->last_name = htmlspecialchars(strip_tags($this->last_name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->created=htmlspecialchars(strip_tags($this->created));

            // bind data
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":created", $this->created);

            if ($stmt->execute()) {
               return true;
            }

            return false;
        }

        // READ single
        public function getSingleUser()
        {
            $sqlQuery = "SELECT
                        id,
                        first_name,
                        last_name,
                        email,
                        age,
                        phone,
                        created
                      FROM
                        ". $this->db_table ."
                    WHERE
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->first_name = $dataRow['first_name'];
            $this->last_name = $dataRow['last_name'];
            $this->email = $dataRow['email'];
            $this->age = $dataRow['age'];
            $this->phone = $dataRow['phone'];
            $this->created = $dataRow['created'];
        }

        // UPDATE
        public function updateUser()
        {
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        age = :age,
                        phone = :phone,
                        created = :created
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $this->first_name=htmlspecialchars(strip_tags($this->first_name));
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->created=htmlspecialchars(strip_tags($this->created));
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind data
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":created", $this->created);
            $stmt->bindParam(":id", $this->id);

            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteUser()
        {
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);

            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(1, $this->id);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        }

    }
?>
