<?php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fungsi untuk mengambil data user berdasarkan username
    public function getUserByUsername($username) {
        $collection = $this->db->users; // Nama koleksi MongoDB
        return $collection->findOne(['username' => $username]);
    }
}
?>
