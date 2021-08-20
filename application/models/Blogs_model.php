<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

    }

    public function blogsNumber()
    {

        return $this->db->get('blogs')->num_rows();

    }

    public function getUser($user_id)
    {

        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row()->username;

    }

    public function getUserId($username)
    {

        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row()->id;

    }

    public function getBlog($limit, $order, $date_min, $date_max, $id = NULL)
    {

        if ( ! (bool)$date_min) {
            $date_min = date('Y-m-d H:i:s', 0);
        }

        if ( ! (bool)$date_max) {
            $date_max = date('Y-m-d H:i:s');
        }

        if ( ! $id) {

            $this->db->order_by('created_at', $order);
            $this->db->limit($limit);
            $this->db->where('created_at >=', $date_min);
            $this->db->where('created_at <=', $date_max);
            
            $query = $this->db->get('blogs');

            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return FALSE;
            }

        } else {

            $this->db->where('id', $id);
            $query = $this->db->get('blogs');

            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return FALSE;
            }

        }
        
    }

    public function insertBlog($data) {

        $this->db->set($data);
        $this->db->insert('blogs');

    }

    public function deleteBlog($id) {

        $this->db->where('id', $id);
        $this->db->delete('blogs');

    }

    public function update_blog($data){

        $this->db->where('id', $data['id']);
        $this->db->set('title', $data['title']);
        $this->db->set('body', $data['body']);
        $this->db->update('blogs');

    }

}
