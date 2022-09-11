<?php
require_once 'C:/xampp/htdocs/CV-Manager/database/Database.php';

class PositionModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getAllPositions()
  {
    $this->db->query('SELECT * FROM position');
    $results = $this->db->resultSet();
    return $results;
  }
}
