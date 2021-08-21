<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profiles_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

    }

    public function getUser($username)
    {

        $this->db->where('username', $username);
        $query = $this->db->get('users');  
        return $query->row();

    }

    public function getUserByEmail($email)
    {

        $this->db->where('email', $email);
        $query = $this->db->get('users');  
        return $query->row();

    }

    public function newPassword($email, $password)
    {

        $this->db->where('email', $email);
        $this->db->set('password', password_hash($password, PASSWORD_DEFAULT));
        $this->db->update('users');

    }

    public function updateUser($username, $data)
    {

        $this->db->where('username', $username);

        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->db->set($data);
            $this->db->update('users');
        } else {
            $this->db->set($data);
            $this->db->update('users');
        }
        
    }

    public function login($data)
    {

        $this->db->where('username', $data['username']);
        $query = $this->db->get('users');

        if ($query->num_rows() === 1) {
            if (password_verify($data['password'], $query->row()->password)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }

    }

    public function deleteUser($username)
    {

        $this->db->where('username', $username);
        $this->db->delete('users');

    }

    public function register($data, $password)
    
    {
        $this->db->set($data);
        $this->db->set('password', $password);
        $this->db->insert('users');

    }

}
