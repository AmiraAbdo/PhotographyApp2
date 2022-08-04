<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/PhotographerDao.class.php';

class PhotographerService extends BaseService{

  public function __construct(){
    parent::__construct(new PhotographerDao());
  }

  public function get_photographer_by_posting_id($posting_id){
    return $this->dao->get_photographer_by_posting_id($posting_id);
  }

}
?>
