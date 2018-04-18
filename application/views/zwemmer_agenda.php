<script type="text/javascript">

function haalWedstrijdenOp(week, jaar) {
    $.ajax({type: "GET",
        url: site_url + "/gebruiker/haalJsonOp_Wedstrijden",
        data: {huidigeWeek: week, huidigJaar: jaar},
        success: function (result) {
            try {
                // datum = .datum tijdstip = .tijdstip afstand = .afstand slag = .soort wedstrijd = .naam plaats = .plaats beschrijving = .beschrijving reeksid = .id
                var wedstrijdenWeek = jQuery.parseJSON(result);
                console.log(JSON.stringify(result));

                for (var i = 0; i < wedstrijdenWeek.length; i++) {
                    var tijd = wedstrijdenWeek[i].tijdstip;
                    var datum = wedstrijdenWeek[i].datum;

                    $("tr[class=" + tijd + "]").find("td[class=" + datum + "]").css("background-color", "yellow").addClass("wedstrijd").addClass("wedstrijd" + i);
                }
            } catch (error) {
                alert("-- ERROR IN JSON --\n" + result);
            }
        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
};

$(document).ready(function () {

    var id = $("input[name=id]").val();
    var week = $("input[name=week]").val();
    var jaar = $("input[name=jaar]").val();
    var output = "test";

    haalWedstrijdenOp(week, jaar);


    $("table").on('click', '.wedstrijd', function () {
            $(".event").html(output);
    });

});

</script>

<?php
$maandag = new DateTime;
$maandag->setTime(0, 0, 0);
$maandag->setISODate(intval($jaar), intval($week));
$zondag = clone $maandag;
$zondag->modify('+6 day');

if ($week == 52)
{
    $volgendeWeek = 1;
    $volgendJaar  = $jaar + 1;
} else {
    $volgendeWeek = $week + 1;
    $volgendJaar = $jaar;
}

if ($week == 1)
{
    $vorigeWeek = 52;
    $vorigJaar  = $jaar - 1;
} else {
    $vorigeWeek = $week - 1;
    $vorigJaar = $jaar;
}

// Verwijderen
// foreach ($wedstrijdWeek as $wedstrijd) {
//     $datumnotatie = explode('-', $wedstrijd['datum']);
//     $wedstrijd['datum'] = $datumnotatie[2] . $datumnotatie[1] . $datumnotatie[0];
// }


$dt = clone $maandag;



if (isset($_GET['y']) && isset($_GET['w']))
{
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
              '13' => "19:00", '14' => "20:00", '15' => "21:00", '16' => "22:00", '17' => "23:00", '18' => "24:00");
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
      <?php echo form_button(array("content" => "Test", "class" => "btn btn-primary", "id" => "knop")); ?>

      <!-- PHP test
      <p id="phpwedstrijden">
          <?php
          print_r($wedstrijdWeek); ?>
      </p> -->

      <div id="jquery">
          <p id="test"></p>
      </div>

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
        <table class="table table-striped table-bordered">
          <thead>
            <?php
                $t = 1;
                do {
                    echo "<td>" . $dagen[$t] . "<br>" . $dt->format('d-m-Y') . "</td>\n";
                    $dt->modify('+1 day');
                    $t++;
                } while ($w == $dt->format('W'));
            ;?>
          </thead>
          <?php
              for ($i=1; $i < 19; $i++) {
                echo '<tr class="' . str_replace(':', '', $uren[$i]) . '">';
                $dt3 = clone $dt;
                $dt3->modify('-1 week');
                for ($j=1; $j < 8; $j++)
                {
                  echo '<td class="' . $dt3->format('Y-m-d'). '">' . '&nbsp;' . $uren[$i] . '</td>';
                  $dt3->modify('+1 day');
                }
                echo '</tr>';
              }
          ;?>
        </table>
      </div>
    </div>
  </div>

  <div class="row">
      <div class="col-sm-12">
          <div class="event">
              &nbsp;
          </div>
      </div>
  </div>
</div>
