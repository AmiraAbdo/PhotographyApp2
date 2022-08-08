<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/CategoryDao.class.php';

class CategoryService extends BaseService{

  public function __construct(){
    parent::__construct(new CategoryDao());
  }

  public function get_category_by_photographer_id($photographer_id){
    return $this->dao->get_category_by_photographer_id($photographer_id);
  }

}
?>
