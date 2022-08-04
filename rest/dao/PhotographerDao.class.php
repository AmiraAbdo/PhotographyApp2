<?php
require_once __DIR__.'/BaseDao.class.php';

class PhotographerDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("photographers");
  }

  public function get_photographer_by_email($email){
    return $this->query_unique("SELECT * FROM photographers WHERE email = :email", ['email' => $email]);
  }

  public function get_photographer_by_posting_id($posting_id){
    return $this->query("SELECT ph.id from postings p join photographers ph on p.photographer_id=ph.id where p.id = :posting_id", ['posting_id' => $posting_id]);
  }

}

?>
