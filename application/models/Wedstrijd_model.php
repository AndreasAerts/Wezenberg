<?php

/**
 * @class Wedstrijd_model
 * @brief Model-klasse voor wedstrijden
 *
 * Model-klasse die alle methodes bevat om te interageren met de wedstrijd tabel
 */
class Wedstrijd_model extends CI_Model
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Een wedstrijd ophalen uit de database
     * @param $id Het id van de wedstrijd die opgevraagd wordt
     * @return De opgevraagde record
     */
    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('wedstrijd');
        return $query->row();
    }

    /**
     * Opvragen van alle wedstrijden uit de database, oplopend gesorteerd
     * \return De opgevraagde records
     */
    public function toonWedstrijdenASC()
    {
        $this->db->order_by('beginDatum', 'asc');
        $query = $this->db->get('wedstrijd');
        return $query->result();
    }

    /**
     * Opvragen van alle nieuws artikels uit de database, aflopend gesorteerd
     * \return De opgevraagde records
     */
    public function toonWedstrijdenDESC()
    {
        $this->db->order_by('beginDatum', 'desc');
        $query = $this->db->get('wedstrijd');
        return $query->result();
    }

    /**
     * Afstanden uit de database ophalen
     * @return De opgevraagde record
     */
    public function getAfstanden()
    {
        $query = $this->db->get('afstand');
        return $query->result();
    }

    public function getReeksen($id)
    {
        $this->db->where('wedstrijdId', $id);
        $query = $this->db->get('reeks');
        return $query->row();
    }

    /**
     * Slagen uit de database ophalen
     * @return De opgevraagde record
     */
    public function getSlagen()
    {
        $query = $this->db->get('slag');
        return $query->result();
    }

    /**
     * Reeks behorende bij een deelname uit de database ophalen
     * @param $id Het id van de deelname waar de reeks aan gekoppeld is
     * @return De opgevraagde record
     */
    public function getReeksenPerWedstrijd($id)
    {
        $this->db->where('wedstrijdId', $id);
        $query = $this->db->get('reeks');
        return $query->result();
    }

    public function getSlagenPerWedstrijd($id)
    {
        /*$this->db->where('wedstrijdId', $id);
        $query = $this->db->get('reeks');
        $reeks =  $query->row();

        $this->load->model('slag_model');
        if (isset($reeks)) {
            $reeks->slag = $this->slag_model->getSlag($reeks->slagId);
        }

        return $reeks;*/
        $this->db->where('id', $id);
        $query = $this->db->get('slag');
        return $query->result();
    }

    /**
     * Een wedstrijd toevoegen aan de database
     * @param $wedstrijd De wedstrijd die moet toegevoegd worden
     * @return De insert functie van de wedstrijd
     */
    public function insert($wedstrijd)
    {
        $this->db->insert('wedstrijd', $wedstrijd);
        return $this->db->insert_id();
    }

    /**
     * Een wedstrijd wijzigen in de database
     * @param $wedstrijd De wedstrijd die moet gewijzigd worden
     */
    public function update($wedstrijd)
    {
        $this->db->where('id', $wedstrijd->id);
        $this->db->update('wedstrijd', $wedstrijd);
    }

    /**
     * Een wedstrijd verwijderen uit de database
     * @param $id Het id van de wedstrijd die moet verwijderd worden
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('wedstrijd');
    }
}
