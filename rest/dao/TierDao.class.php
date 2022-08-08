<?php
require_once __DIR__.'/BaseDao.class.php';

class TierDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("tiers");
  }

  public function get_tier_by_posting_id($posting_id){
    return $this->query("SELECT t.* from postings p join tiers t on p.tier_id=t.id where p.id = :posting_id", ['posting_id' => $posting_id]);
  }

}

?>
