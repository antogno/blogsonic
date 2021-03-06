<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blogs Model Class
 * 
 * @author Antonio Granaldi <tonio.granaldi@gmail.com>
 */
class Blogs_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Gets the username of the user with the given ID
     * 
     * @param int $user_id the ID of the user.
     * @return string|false the username as a string, or false
     * if a user with the given ID doesn't exists.
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
     * @param string $username the username.
     * @return int|false the ID as a int, or false if a user with
     * the given username doesn't exists.
     */
    public function getUserId(string $username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');

        return $query->row()->id;
    }

    /**
     * Gets the given number of Blogs in the given order and between
     * the given dates
     * 
     * @param int $limit the number of Blogs to show.
     * @param string $order the order in which the Blogs are showed.
     * 'desc' for descending order and 'asc' for ascending order.
     * @param DateTime $date_min the minimum date in which to start
     * showing Blogs.
     * @param DateTime $date_max the maximum date of showed Blogs.
     * @param string $search the term to search in the Blog title or
     * body.
     * @param int $user_id the user ID of which to show the Blogs.
     * @return array|object|false if an ID isn't passed, it returns
     * an array containing the fetched rows. If an ID is given, it
     * returns the row of the requested Blog. If a Blog with the given
     * ID doesn't exists, it returns false.
     */
    public function getBlogs(int $limit, string $order, DateTime $date_min = null, DateTime $date_max = null, string $search = null, int $user_id = null)
    {
        $this->db->order_by('created_at', $order);
        $this->db->limit($limit);

        if (isset($date_min)) {
            $this->db->where('created_at >=',
                $date_min
                    ->setTime(0, 0, 0)
                    ->format('Y-m-d H:i:s')
            );
        }

        if (isset($date_max)) {
            $this->db->where('created_at <=',
                $date_max
                    ->setTime(23, 59, 59)
                    ->format('Y-m-d H:i:s')
            );
        }

        if (isset($user_id)) {
            $this->db->where('user_id =', $user_id);
        }
        
        if ($search) {
            $this->db->like('body', $search);
            $this->db->or_like('title', $search);
        }
        
        $query = $this->db->get('blogs');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Gets a particular Blog
     * 
     * @param int $id the Blog ID.
     * @return object|false it returns the row of the requested Blog.
     * If a Blog with the given ID doesn't exists, it returns false.
     */
    public function getBlog(int $id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('blogs');

        if ($query->num_rows() === 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Inserts the given Blog in the database
     * 
     * @param array $data all the Blog data with the table fields as keys.
     * @return void
     */
    public function insertBlog(array $data)
    {
        $this->db->set($data);
        $this->db->insert('blogs');
    }

    /**
     * Deletes the Blog with the given ID from the database
     * 
     * @param int $id the Blog ID.
     * @return void
     */
    public function deleteBlog(int $id)
    {
        $this->db->where('id', $id);
        $this->db->delete('blogs');
    }

    /**
     * Updates the given Blog
     * 
     * @param array $data all the Blog data with the table fields as keys.
     * @return void
     */
    public function updateBlog(array $data)
    {
        $this->db->where('id', $data['id']);
        $this->db->set('title', $data['title']);
        $this->db->set('body', $data['body']);
        $this->db->update('blogs');
    }
}