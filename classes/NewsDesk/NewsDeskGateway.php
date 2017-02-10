<?php


namespace phpCollab\NewsDesk;

use phpCollab\Database;

/**
 * Class NewsDeskGateway
 * @package phpCollab\NewsDesk
 */
class NewsDeskGateway
{
    protected $db;
    protected $initrequest;
    protected $tableCollab;

    /**
     * NewsDeskGateway constructor.
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->initrequest = $GLOBALS['initrequest'];
        $this->tableCollab = $GLOBALS['tableCollab'];
    }

    public function getNewsPostById($newsId)
    {
        $query = $this->initrequest["newsdeskposts"] . " WHERE news.id = :news_id";
        $this->db->query($query);
        $this->db->bind(':news_id', $newsId);
        return $this->db->single();
    }

    /**
     * @param $commentId
     * @return mixed
     */
    public function getCommentById($commentId)
    {
        $query = $this->initrequest["newsdeskcomments"] . " WHERE newscom.id = :comment_id";
        $this->db->query($query);
        $this->db->bind(':comment_id', $commentId);
        return $this->db->single();
    }

    public function getComments($commentId)
    {
        if ( strpos($commentId, ',') ) {
            $ids = explode(',', $commentId);
            $placeholders = str_repeat ('?, ', count($ids)-1) . '?';
            $sql = $this->initrequest["newsdeskcomments"] . " WHERE newscom.id IN ($placeholders) ORDER BY newscom.id";
            $this->db->query($sql);
            $this->db->execute($ids);

            return $this->db->fetchAll();
        } else {
            $query = $this->initrequest["newsdeskcomments"] . " WHERE newscom.id = :comment_id";
            $this->db->query($query);
            $this->db->bind(':comment_id', $commentId);
            return $this->db->single();
        }
    }


    public function getPostComments($commentId)
    {
        $query = $this->initrequest["newsdeskcomments"] . " WHERE newscom.id = :comment_id";
        $this->db->query($query);
        $this->db->bind(':comment_id', $commentId);
        return $this->db->single();
    }

    /**
     * @param $commentId
     * @return mixed
     */
    public function deleteCommentById($commentId)
    {
        $commentId = explode(',', $commentId);
        $placeholders = str_repeat('?, ', count($commentId) - 1) . '?';
        $query = "DELETE FROM " . $this->tableCollab["newsdeskcomments"] . " WHERE id IN (".$placeholders.")";
        $this->db->query($query);
        return $this->db->execute($commentId);
    }
}