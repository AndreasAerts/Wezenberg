<?php

class Wedstrijd_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('Wedstrijd');
    }
}