<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profiles Model Class
 * 
 * @author  Antonio Granaldi
 */
class Profiles_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

    }

    /**
     * Gets the user data of the user with the given username
     * 
     * @param   string      $username the username.
     * @return  object|null an object with the user data or null if a user with the given username doesn't exists.
     */
    public function getUser(string $username)
    {

        $this->db->where('username', $username);
        $query = $this->db->get('users');

        return $query->row();

    }

    /**
     * Gets the user data of the user with the given field value
     * 
     * @param   string      $field  the field in which to search the value.
     * @param   string      $value  the field value to search for.
     * @return  true|false  if a user with the given value in the given field exists, it return true, otherwise it returns false.
     */
    public function checkUsersByField(string $field, string $value)
    {

        $this->db->where($field, $value);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {

            return $query->row()->$field;

        } else {

            return false;

        }

    }

    /**
     * Gets the user data of the user with the given email address
     * 
     * @param   string      $email the email address.
     * @return  object|null an object with the user data or null if a user with the given email address doesn't exists.
     */
    public function getUserByEmail(string $email)
    {

        $this->db->where('email', $email);
        $query = $this->db->get('users');

        return $query->row();

    }

    /**
     * Updates the password of the user with the given email address
     * 
     * @param   string  $email      the email address.
     * @param   string  $password   the password.
     * @return  void
     */
    public function newPassword(string $email, string $password)
    {

        $this->db->where('email', $email);
        $this->db->set('password', password_hash($password, PASSWORD_DEFAULT));
        $this->db->update('users');

    }

    /**
     * Updates the user with the given username
     * 
     * @param   string  $username   the username.
     * @param   array   $data       all the user data with the table fields as keys.
     * @return  void
     */
    public function updateUser(string $username, array $data)
    {

        $this->db->where('username', $username);

        if (isset($data['password'])) {

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        }

        $this->db->set($data);
        $this->db->update('users');
        
    }

    /**
     * Checks if the login attempt is successful
     * 
     * @param   array       $data   array with the username and the password as elements.
     * @return  true|false  true if the login attempt is successful, false otherwise.
     */
    public function login(array $data)
    {

        $this->db->where('username', $data['username']);
        $query = $this->db->get('users');

        if ($query->num_rows() === 1) {
            if (password_verify($data['password'], $query->row()->password)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * Deletes the user with the given username from the database
     * 
     * @param   string  $username   the username.
     * @return  void
     */
    public function deleteUser($username)
    {

        $this->db->where('username', $username);
        $this->db->delete('users');

    }

    /**
     * Inserts a new user in the database
     * 
     * @param   array   $data       all the user data.
     * @param   string  $password   the password.
     * @return  void
     */
    public function register(array $data, string $password)
    {
        $this->db->set($data);
        $this->db->set('password', $password);
        $this->db->insert('users');

    }

}
