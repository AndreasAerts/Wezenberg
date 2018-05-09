<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @class Wedstrijd
 * @brief Controller-klasse voor wedstrijden
 *
 * Controller-klasse met methoden die worden gebruikt bij het tonen en beren van wedstrijden.
 */
class Wedstrijd extends CI_Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
    }

    /**
     * Haalt alle wedstrijden op via Wedstrijd_model en toont deze in de view bekijken.php
     * @see Authex::getGebruikerInfo()
     * @see Wedstrijd_model::toonWedstrijden()
     * @see bekijken.php
     */
    public function index()
    {
        $data['titel'] = 'Wedstrijden bekijken';
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';
        $data['gebruiker']  = $this->authex->getGebruikerInfo();
        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->toonWedstrijdenASC();

        $partials = array('hoofding' => 'main_header',
          'inhoud' => 'Wedstrijd/bekijken',
          'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Toont het scherm om een nieuwe wedstrijd te maken
     * @see maken.php
     */
    public function maakWedstrijd()
    {
        $data['titel'] = 'Wedstrijden aanmaken';
        $data['paginaVerantwoordelijke'] = 'De Coninck Mattias';
        $data['gebruiker']  = $this->authex->getGebruikerInfo();

        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAllAfstanden();
        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAllSlagen();
        $this->load->model('status_model');
        $data['statussen'] = $this->status_model->getAll();
        $partials = array('hoofding' => 'main_header',
          'inhoud' => 'Wedstrijd/maken',
          'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Maakt een nieuwe entry aan in de wedstrijd-database met de opgegeven info uit maken.php
     * @see Wedstrijd_model::insert()
     * @see Wedstrijd_model::update()
     */
    public function registreer()
    {
        $wedstrijd = new stdClass();
        $wedstrijd->id = $this->input->post('id');
        $wedstrijd->plaats = $this->input->post('plaats');
        $wedstrijd->naam = $this->input->post('naam');
        $wedstrijd->beginDatum = $this->input->post('beginDatum');
        $wedstrijd->eindDatum = $this->input->post('eindDatum');
        $wedstrijd->laatsteInschrijvingDatum = $this->input->post('laatsteInschrijvingDatum');
        $wedstrijd->beschrijving = $this->input->post('beschrijving');

        $afstand = new stdClass();
        $afstand->naam = $this->input->post('afstand');

        $this->load->model('wedstrijd_model');
        if ($wedstrijd->id == null) {
            $this->wedstrijd_model->insert($wedstrijd);
        } else {
            $this->wedstrijd_model->update($wedstrijd);
        }

        $this->load->model('deelname_model');
        $status = $this->deelname_model->get($wedstrijd->id);
        $status->statusId = '4';

        redirect('/wedstrijd/beheerWedstrijden');
    }

    /**
     * Maakt een nieuwe entry aan in de wedstrijd-database met de opgegeven info uit maken.php
     * @see Wedstrijd_model::insert()
     * @see Wedstrijd_model::update()
     */
    public function registreerReeks()
    {
        $reeks = new stdClass();
        $reeks->id = $this->input->post('id');
        $reeks->datum = $this->input->post('datum');
        $reeks->afstandId = $this->input->post('afstand');
        $reeks->tijdstip = $this->input->post('tijdstip');
        $reeks->slagId = $this->input->post('slag');
        $reeks->wedstrijdId = $this->input->post('wedstrijdId');
        /*$afstand = new stdClass();
        $afstand->afstand = $this->input->post('afstand');*/

        $this->load->model('reeks_model');
        if ($reeks->id == null) {
            $this->reeks_model->insert($reeks);
        } else {
            $this->reeks_model->update($reeks);
        }

        $this->load->model('deelname_model');
        $gebruiker = $this->authex->getGebruikerInfo();
        $status = $this->deelname_model->getStatusPerGebruiker($gebruiker->id);
        $status->statusId = '4';

        redirect('/wedstrijd/reeksenToevoegen/' . $reeks->wedstrijdId);
    }

    /**
     * Toont de pagina voor de wedstrijd-informatie aan te passen
     * @param id De id van de aan te passen wedstrijd
     * @see Wedstrijd_model::get()
     * @see beheren.php
     */
    public function updateWedstrijd($id)
    {
        $data['titel'] = 'Wedstrijden wijzigen';
        $data['gebruiker']  = $this->authex->getGebruikerInfo();
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';
        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);

        $this->load->model('wedstrijd_model');
        $partials = array('hoofding' => 'main_header',
          'inhoud' => 'Wedstrijd/maken',
          'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }


    /**
     * Toont de pagina voor de wedstrijden te beheren
     * @see Authex::getGebruikerInfo()
     * @see Wedstrijd_model::toonWedstrijden()
     * @see bekijken.php
     */
    public function beheerWedstrijden()
    {
        $data['titel'] = 'Wedstrijden bekijken';
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';
        $data['gebruiker']  = $this->authex->getGebruikerInfo();

        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->toonWedstrijdenASC();

        $partials = array('hoofding' => 'main_header',
          'inhoud' => 'Wedstrijd/bekijken',
          'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
    * Hiermee verwijdert de trainer een wedstrijd
    * @param id De id van de aan te verwijderen wedstrijd
    * @see Authex::getGebruikerInfo()
    */
    public function verwijder($id)
    {
        $data['gebruiker'] = $this->authex->getGebruikerInfo();
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';
        $this->load->model('wedstrijd_model');
        $this->wedstrijd_model->delete($id);

        redirect('/wedstrijd/beheerWedstrijden');
    }

    /**
     * Verwijdert het nieuwsartikel en toont opnieuw de lijst van nieuwsartikels.
     * @param $id van de te verwijderen nieuwsartikel
     */
    public function verwijderReeks($id)
    {
        //$id = $this->input->get('id');
        $data['gebruiker'] = $this->authex->getGebruikerInfo();
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';
        $this->load->model('reeks_model');
        $this->reeks_model->delete($id);

        redirect("/wedstrijd/index");
    }

    /**
    * Toont de pagina waarin een zwemmer zich kan inschrijven voor een wedstrijd
    * @see Authex::getGebruikerInfo()
    * @see Wedstrijd_model::toonWedstrijden()
    * @see Deelname_model::getStatusPerGebruiker()
    * @see Deelname_model::get()
    * @see inschrijvingen.php
    */
    public function inschrijvingen()
    {
        $data['titel'] = "Inschrijven wedstrijden";
        $data['gebruiker']  = $this->authex->getGebruikerInfo();
        $gebruiker = $data['gebruiker'];
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';

        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->toonWedstrijdenASC();
        $this->load->model('deelname_model');
        $data['status'] = $this->deelname_model->getStatusPerGebruiker($gebruiker->id);
        $data['deelname'] = $this->deelname_model->get($gebruiker->id);

        $partials = array('hoofding' => 'main_header',
          'inhoud' => 'Wedstrijd/inschrijvingen',
          'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
    * Toont de pagina waarin een zwemmer de melding krijgt om te wachten op goedkeuring voor de inschrijving
    * @see Authex::getGebruikerInfo()
    * @see inschrijven.php
    */
    public function inschrijven()
    {
        $data['titel'] = "Inschrijven webstrijden";
        $data['gebruiker']  = $this->authex->getGebruikerInfo();
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';

        $partials = array('hoofding' => 'main_header',
          'inhoud' => 'Wedstrijd/inschrijven',
          'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
    * Toont de pagina waarin een trainer reeksen per wedstrijd kan toevoegen
    * @param id De id van de wedstrijd waar reeksen aan moeten toegevoegd worden
    * @see Authex::getGebruikerInfo()
    * @see Wedstrijd_model::getReeksenPerWedstrijd()
    * @see reeksen.php
    */
    public function reeksenToevoegen($id)
    {
        $data['titel'] = "Reeksen toeveogen";
        $data['gebruiker']  = $this->authex->getGebruikerInfo();
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';
        $this->load->model('wedstrijd_model');
        //$data['wedstrijd'] = $this->wedstrijd_model->get($id);
        $data['wedstrijdId'] = $id;
        $data['reeksen'] = $this->wedstrijd_model->getReeksenPerWedstrijd($id);
        $this->load->model('reeks_model');
        $data['slagen'] = $this->reeks_model->getSlagenPerReeks($id);
        $data['afstanden'] = $this->reeks_model->getAfstandenPerReeks($id);

        $partials = array('hoofding' => 'main_header',
        'inhoud' => 'Wedstrijd/reeksen',
        'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
    * Toont het invulformulier dat de trainer dient in te vullen om een reeks toe te voegen
    * @see Authex::getGebruikerInfo()
    * @see Wedstrijd_model::getReeksenPerWedstrijd()
    * @see Wedstrijd_model::getSlagenPerWedstrijd()
    * @see Wedstrijd_model::getAfstandenPerWedstrijd()
    * @see Slag_model::getAllSlagen()
    * @see Afstand_model::getAllAfstanden()
    * @see maakReeks.php
    */
    public function maakReeks($id)
    {
        $data['titel'] = "Reeksen toevoegen";
        $data['gebruiker']  = $this->authex->getGebruikerInfo();
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';
        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);
        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAllSlagen();
        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAllAfstanden();
        $data['reeks'] = null;
        $partials = array('hoofding' => 'main_header',
          'inhoud' => 'Wedstrijd/maakReeks',
          'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
    * Toont en overzicht met meer informatie over een bepaalde wedstrijd
    * @param id van de aangeklikte wedstrijd
    * @see Authex::getGebruikerInfo()
    * @see Wedstrijd_model::get($id)
    * @see Wedstrijd_model::getReeksenPerWedstrijd()
    * @see Wedstrijd_model::getSlagenPerWedstrijd()
    * @see Wedstrijd_model::getAfstandenPerWedstrijd()
    * @see info.php
    */
    public function info($id)
    {
        $data['titel'] = "Meer info van wedstrijd";
        $data['gebruiker']  = $this->authex->getGebruikerInfo();
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';
        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);
        $wedstrijd = $data['wedstrijd'];
        $data['reeksen'] = $this->wedstrijd_model->getReeksenPerWedstrijd($wedstrijd->id);
        $this->load->model('reeks_model');
        $data['slagenPerReeks'] = $this->reeks_model->getSlagenPerReeks($id);
        $data['afstanden'] = $this->reeks_model->getAfstandenPerReeks($id);

        $partials = array('hoofding' => 'main_header',
          'inhoud' => 'Wedstrijd/info',
          'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Toont de pagina met alle afgelopen wedstrijden
     * @see Authex::getGebruikerInfo()
     * @see Wedstrijd_model::toonWedstrijdenASC()
     * @see afgelopen.php
     */
    public function toonAfgelopen()
    {
        $data['titel'] = 'Wedstrijden bekijken';
        $data['paginaVerantwoordelijke'] = 'Andreas Aerts';
        $data['gebruiker']  = $this->authex->getGebruikerInfo();

        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->toonWedstrijdenASC();

        $partials = array('hoofding' => 'main_header',
          'inhoud' => 'Wedstrijd/afgelopen',
          'voetnoot' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
