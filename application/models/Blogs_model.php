<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blogs Model Class
 * 
 * @author  Antonio Granaldi
 */
class Blogs_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

    }

    /**
     * Gets the number of Blogs in the database
     * 
     * @return  int
     */
    public function blogsNumber()
    {

        return $this->db->get('blogs')->num_rows();

    }

    /**
     * Gets the username of the user with the given ID
     * 
     * @param   int $user_id the ID of the user.
     * @return  string|false
     */
    public function getUser(int $user_id)
    {

        $this->db->where('id', $user_id);
        $query = $this->db->get('users');

        return $query->row()->username;

    }

    /**
     * Gets the ID of the user with the given username
     * 
     * @param   string $username the username.
     * @return  int|false
     */
    public function getUserId(string $username)
    {

        $this->db->where('username', $username);
        $query = $this->db->get('users');

        return $query->row()->id;

    }

    /**
     * Gets the given number of Blogs in the given order and between the given dates. If a ID is given, that particular Blog is returned
     * 
     * @param   int $limit the number of Blogs to show.
     * @param   string $order the order in which the Blogs are showed. 'desc' for descending order and 'asc' for ascending order.
     * @param   string $date_min the minimum date in which to start showing Blogs.
     * @param   string $date_max the maximum date of showed Blogs.
     * @param   int $id the Blog ID.
     * @return  array|object|false
     */
    public function getBlog(int $limit, string $order, string $date_min, string $date_max, int $id = null)
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

                return false;

            }

        } else {

            $this->db->where('id', $id);
            $query = $this->db->get('blogs');

            if ($query->num_rows() > 0) {

                return $query->row();

            } else {

                return false;

            }

        }
        
    }

    /**
     * Inserts the given Blog in the database
     * 
     * @param   array $data all the Blog data with the table fields as keys.
     * @return  void
     */
    public function insertBlog(array $data)
    {

        $this->db->set($data);
        $this->db->insert('blogs');

    }

    /**
     * Deletes the Blog with the given ID from the database
     * 
     * @param   int $id the Blog ID.
     * @return  void
     */
    public function deleteBlog(int $id)
    {

        $this->db->where('id', $id);
        $this->db->delete('blogs');

    }

    /**
     * Updates the given Blog
     * 
     * @param   array $data all the Blog data with the table fields as keys.
     * @return  void
     */
    public function updateBlog(array $data)
    {

        $this->db->where('id', $data['id']);
        $this->db->set('title', $data['title']);
        $this->db->set('body', $data['body']);
        $this->db->update('blogs');

    }

}
