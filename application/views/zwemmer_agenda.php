<?php
/**
 * @file zwemmer_agenda.php
 *
 * View waarin de zwemmer zijn agenda kan bekijken
 */
$maandag = new DateTime;
$maandag->setTime(0, 0, 0);
$maandag->setISODate(intval($jaar), intval($week));
$zondag = clone $maandag;
$zondag->modify('+6 day');

if ($week == 52) {
    $volgendeWeek = 1;
    $volgendJaar  = $jaar + 1;
} else {
    $volgendeWeek = $week + 1;
    $volgendJaar = $jaar;
}

if ($week == 1) {
    $vorigeWeek = 52;
    $vorigJaar  = $jaar - 1;
} else {
    $vorigeWeek = $week - 1;
    $vorigJaar = $jaar;
}

$dt = clone $maandag;



if (isset($_GET['y']) && isset($_GET['w'])) {
    $dt->setISODate($_GET['y'], $_GET['w']);
} else {
    $dt->setISODate($dt->format('o'), $dt->format('W'));
}



$y = $dt->format('o');
$w = $dt->format('W');
$dagen = array('0' => "", '1' => "Maandag", '2' => "Dinsdag", '3' => "Woensdag", '4' => "Donderdag",
                '5' => "Vrijdag", '6' => "Zaterdag", '7' => "Zondag");
$maanden = array('1' => "Januari", '2' => "Februari", '3' => "Maart", '4' => "April", '5' => "Mei", '6' => "Juni",
                  '7' => "Juli", '8' => "Augustus", '9' => "September", '10' => "Oktober", '11' => "November", '12' => "December");
$uren = array('1' => "07:00", '2' => "08:00", '3' => "09:00", '4' => "10:00", '5' => "11:00", '6' => "12:00",
              '7' => "13:00", '8' => "14:00", '9' => "15:00", '10' => "16:00", '11' => "17:00", '12' => "18:00",
              '13' => "19:00", '14' => "20:00", '15' => "21:00", '16' => "22:00");
;?>





<div class="container text-center">
  <div class="row">
    <div class="col-sm-12">
      <h2>Mijn agenda</h2>
      <h3>

          <?php
              echo $maandag->format('j') . ' ' . $maanden[$maandag->format('n')] . ' ' . $maandag->format('Y') . ' - '
                  . $zondag->format('j') . ' ' . $maanden[$zondag->format('n')] . ' ' . $zondag->format('Y');
              echo form_hidden('week', $week);
              echo form_hidden('jaar', $jaar);
              echo form_hidden('id', $gebruiker->id);
          ?>
      </h3>
      <p>Klik op een evenement om de details te bekijken</p>
    </div>
  </div>


  <div class="row">
    <div class="col-sm-2 offset-3">
      <?php echo anchor('gebruiker/agenda/' . $vorigeWeek . '/' . $vorigJaar, 'Vorige week', 'class="nav-link"'); ?>
    </div>
    <div class="col-sm-2 offset-2">
      <?php echo anchor('gebruiker/agenda/' . $volgendeWeek . '/' . $volgendJaar, 'Volgende week', 'class="nav-link"'); ?>
    </div>
  </div>


  <div class="row">
    <div class="col-sm-12">
      <div class="table-responsive">
        <table class="table table-striped table-bordered text-muted">
          <thead class="font-weight-bold">
            <?php
                $t = 1;

                do {
                    $maand = $dt->format('n');
                    echo "<th>" . $dagen[$t] . "<br>" . $dt->format('j') . " " . $maanden[$maand] . " " . $dt->format('Y') . "</th>\n";
                    $dt->modify('+1 day');
                    $t++;
                } while ($w == $dt->format('W'));
            ;?>
          </thead>
          <?php
              for ($i=1; $i < 17; $i++) {
                  echo '<tr class="' . substr($uren[$i], 0, 2) . '">';
                  $dt3 = clone $dt;
                  $dt3->modify('-1 week');
                  for ($j=1; $j < 8; $j++) {
                      echo '<td class="' . $dt3->format('Y-m-d'). '">' . '&nbsp;' . $uren[$i]
                  . '<div class="event-rij">'
                  . '<div class="1"></div>'
                  . '<div class="2"></div>'
                  . '<div class="3"></div>'
                  . '<div class="4"></div>'
                  . '</div></td>';
                      $dt3->modify('+1 day');
                  }
                  echo '</tr>';
              }
          ;?>
        </table>
      </div>
    </div>
  </div>
</div>

  <div class="modal fade" id="gebeurtenis-modal" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailoverzicht</h4>
              <button type="button" class="close" data-dismiss='modal'>&times;</button>
            </div>
            <div class="modal-body">
              <?php
                $teller = 0;
                if ($wedstrijden != null) {
                    foreach ($wedstrijden as $wedstrijd) {
                        echo "<div class='gebeurtenis " . $wedstrijd->reeks->datum . " " . $wedstrijd->reeks->tijdstip . " wed" . $teller. "'>";
                        echo "<span><b>" . $wedstrijd->wedstrijd->naam . " " . $wedstrijd->wedstrijd->plaats . "</b></span><br />";
                        echo "Beginuur: " . $wedstrijd->reeks->uur . "<br />";
                        echo "Slag: " . $wedstrijd->slag->soort . "<br />";
                        echo "Afstand: " . $wedstrijd->afstand->afstand . "<br />";
                        echo "Beschrijving: " . $wedstrijd->wedstrijd->beschrijving . "<br />";
                        echo "</div>";
                        $teller++;
                    }
                }

                $teller = 0;
                if ($supplementen != null) {
                    foreach ($supplementen as $supplement) {
                        echo "<div class='gebeurtenis " . $supplement->tijdstip . " " . $supplement->datumInname . " supp" . $teller . "'>";
                        echo "<span><b>" . $supplement->informatie->naam . "</b></span><br />";
                        echo "Tijdstip: " . $supplement->uur . "<br />";
                        echo "Hoeveelheid: " . $supplement->hoeveelheid . "g<br />";
                        echo "Beschrijving: " . $supplement->informatie->beschrijving . "<br />";
                        echo "</div>";
                        $teller++;
                    }
                }

                $teller = 0;
                if ($activiteiten != null) {
                    foreach ($activiteiten as $activiteit) {
                        if (isset($activiteit)) {
                            echo "<div class='gebeurtenis " . $activiteit->andereActiviteit->beginDatum . " " . $activiteit->andereActiviteit->tijdstip . " ander" . $teller . "'>";
                            echo "<span><b>" . $activiteit->andereActiviteit->naam . "</b></span><br />";
                            if ($activiteit->andereActiviteit->soortId == 1) {
                                echo "Vertrek: " . zetOmNaarDDMMYYYY($activiteit->andereActiviteit->beginDatum) . "<br />";
                                echo "Terug: " . zetOmNaarDDMMYYYY($activiteit->andereActiviteit->eindDatum) . "<br />";
                            }
                            echo "Tijdstip: " . $activiteit->andereActiviteit->uur . "<br />";
                            echo "Locatie: " . $activiteit->andereActiviteit->plaats . "<br />";
                            echo "Beschrijving: " . $activiteit->andereActiviteit->beschrijving . "<br />";
                            echo "</div>";
                            $teller++;
                        }
                    }
                }
              ;?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-round btn-primary" data-dismiss="modal">Sluit</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/agendaZwemmer.js" type="text/javascript"></script>
