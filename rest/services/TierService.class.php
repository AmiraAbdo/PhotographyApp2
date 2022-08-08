<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/TierDao.class.php';

class TierService extends BaseService{

  public function __construct(){
    parent::__construct(new TierDao());
  }

  public function get_tier_by_posting_id($posting_id){
    return $this->dao->get_tier_by_posting_id($posting_id);
  }

}
?>
