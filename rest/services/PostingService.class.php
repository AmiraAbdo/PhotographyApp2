<?php
require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/PostingDao.class.php';

class PostingService extends BaseService{

  public function __construct(){
    parent::__construct(new PostingDao());
  }

  public function get_postings_by_photographer_id($photographer_id){
    return $this->dao->get_postings_by_photographer_id($photographer_id);
  }
}
?>
