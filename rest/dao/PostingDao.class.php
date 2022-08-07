<?php
require_once __DIR__.'/BaseDao.class.php';

class PostingDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("postings");
  }

  public function get_postings_by_photographer_id($photographer_id){
    return $this->query("SELECT * FROM postings WHERE photographer_id = :photographer_id", ['photographer_id' => $photographer_id]);
  }

}

?>
