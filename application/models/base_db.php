<?php

class Base_db extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // 第二参数是每页纪录数，第三个参数是偏移
    public function getTableAll($tableName, $limit = null, $offset = null)
    {
        if($limit && $offset)
        {
            $query = $this->db->get($tableName, $limit, $offset);
        }
        else 
        {
            $query = $this->db->get($tableName);
        }

        return $query->result_array();
    }

    public function fetchAll($sql, $params = null)
    {
        $query = $this->db->query($sql, $params);
        if($query->num_rows() > 0) {
            return $query->result_array();
        }
        
        return null;
    }

    public function fetchRow($sql, $params = null)
    {
        $query = $this->db->query($sql, $params);
        if($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return null;
    }

    /*
    $data = array(
               'title' => 'My title' ,
               'name' => 'My Name' ,
               'date' => 'My date'
            );
    */
    public function insert($tableName, $insertData)
    {
        $this->db->insert($tableName, $insertData);
        return $this->db->insert_id();
    }

    /*
        $data = array(
           array(
              'title' => 'My title' ,
              'name' => 'My Name' ,
              'date' => 'My date'
           ),
           array(
              'title' => 'Another title' ,
              'name' => 'Another Name' ,
              'date' => 'Another date'
           )
        );
    */
    public function insertBatch($tableName, $insertData)
    {
        $this->db->insert_batch($tableName, $insertData); 
    }

    /*
        $data = array(
               'title' => $title,
               'name' => $name,
               'date' => $date
            );
        $params = array('id' => $id)
    */
    public function update($tableName, $data, $params)
    {
        $this->db->update($tableName, $data, $params);
    }

    /*
        $params = array('id' => $id)
    */
    public function delete($tableName, $params)
    {
        $this->db->delete($tableName, $params); 
    }
}