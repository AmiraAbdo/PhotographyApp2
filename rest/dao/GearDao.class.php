<?php
require_once __DIR__.'/BaseDao.class.php';

class GearDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("gear");
  }

  public function get_gear_by_photographer_id($photographer_id){
    return $this->query("SELECT * FROM gear where photographer_id = :photographer_id", ['photographer_id' => $photographer_id]);
  }

}

?>
