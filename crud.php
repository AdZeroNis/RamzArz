<?php
include('db.php');

class Crud extends Database {
    public function __construct() {
        parent::__construct();
    }

    public function execute($data) {
        $result = $this->getConnection()->exec($data);

        if ($result === false) {
            echo json_encode([
                'status' => false,
                'message' => 'It was not added to the database'
            ]);
            return false;
        } else {
            echo json_encode([
                'status' => true,
                'message' => 'Added to the database'
            ]);
        }
    }
}
