<?php

class Gebruiker_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('notation');
        $this->load->helper('date');
    }

    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('gebruiker');
        return $query->row();
    }
    public function getAllZwemmers()
    {
      $this->db->where('soort', 'zwemmer');
      $query = $this->db->get('gebruiker');
      if ($query->num_rows() == 0)
      {
        return null;
      } else {
        return $query->result();
      }
    }

    public function getGebruiker($email, $wachtwoord)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('gebruiker');

        if ($query->num_rows() == 1) {
            $gebruiker = $query->row();
            if (password_verify($wachtwoord, $gebruiker->wachtwoord))
            {
              return $gebruiker;
            } else {
              return null;
            }
        } else {
            return null;
        }
    }
    
    public function getActieveGebruikers()
    {
        $this->db->where('status', '1');
        $query = $this->db->get('gebruiker');
        return $query->result();
    }
    
    public function getActieveTrainers()
    {
        $this->db->where('soort', 'trainer');
        $this->db->where('status', '1');
        $query = $this->db->get('gebruiker');
        return $query->result();
    }

    public function getGebruikerMetWachtwoord($email, $wachtwoord)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('gebruiker');

        if ($query->num_rows() == 1) {
            $gebruiker = $query->row();
            if (password_verify($wachtwoord, $gebruiker->wachtwoord)) {
                return $gebruiker;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function controleerEmailVrij($email)
    {
        // is email al dan niet aanwezig
        $this->db->where('email', $email);
        $query = $this->db->get('gebruiker');

        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insert($gebruiker)
    {
        $this->db->insert('gebruiker', $gebruiker);
        return $this->db->insert_id();
    }

    public function update($gebruiker)
    {
        $this->db->where('id', $gebruiker->id);
        $this->db->update('gebruiker', $gebruiker);
    }

    public function toonZwemmers()
    {
        $this->db->where('soort', 'zwemmer');
        $this->db->where('status', '1');
        $query = $this->db->get('gebruiker');
        return $query->result();
    }

    public function delete($id)
    {
        $this->db->where('gebruikerIdZwemmer', $id);
        $this->db->delete('supplementPerZwemmer');

        $this->db->where('gebruikerIdZwemmer', $id);
        $this->db->delete('activiteitPerGebruiker');

        $this->db->where('gebruikerId', $id);
        $this->db->delete('meldingPerGebruiker');

        $this->db->where('gebruikerIdZwemmer', $id);
        $this->db->delete('deelname');

        $this->db->where('id', $id);
        $this->db->delete('gebruiker');
    }

    public function toonInactieveZwemmers()
    {
        $this->db->where('soort', 'zwemmer');
        $this->db->where('status', '0');
        $query = $this->db->get('gebruiker');
        return $query->result();
    }

}
