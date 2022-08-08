<?php
require_once __DIR__.'/BaseDao.class.php';

class CategoryDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("categories");
  }

  public function get_category_by_photographer_id($photographer_id){
    return $this->query("SELECT c.* from photographers p join categories c on p.category_id=c.id where p.id = :photographer_id", ['photographer_id' => $photographer_id]);
  }

}

?>
