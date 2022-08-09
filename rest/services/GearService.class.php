<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/GearDao.class.php';

class GearService extends BaseService{

  public function __construct(){
    parent::__construct(new GearDao());
  }

  public function get_gear_by_photographer_id($photographer_id){
    return $this->dao->get_gear_by_photographer_id($photographer_id);
  }

}
?>
