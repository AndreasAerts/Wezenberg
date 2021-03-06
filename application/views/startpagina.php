                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php
/**
 * @file startpagina.php
 *
 * View waarop de gebruiker als eerste komt bij het bezoeken van de website.
 * - Welkomtekst met een $trainingscentrum-object
 * - Nieuwsartikels worden getoond door middel van $artikel-objecten.
 * - AgendaItems worden getoond door middel van $agendaItem-objecten.
 *
 * Als je als zwemmer bent ingelogd krijg je ook te zien:
 * - $wedstrijd-objecten waarvoor hij zich nog kan inschrijven.
 *
 * Als je als trainer bent ingelogd krijg je ook te zien:
 * - Extra menu opties om bepaalde functionaliteiten te beheren.
 */
?>

<script>
    $(document).ready(function () {
        var nieuwsStartRij = 0;
        var agendaStartRij = 0;

        nieuwsartikels();
        agendaItems();

        $("#vorigNieuwsartikel").click(function (e) {
            e.preventDefault();
            if (nieuwsStartRij < 1) {
                nieuwsStartRij = 0;
            } else {
                nieuwsStartRij--;
            }
            vorigNieuwsartikel(nieuwsStartRij);
        });
        $("#volgendNieuwsartikel").click(function (e) {
            e.preventDefault();
            nieuwsStartRij++;
            volgendNieuwsartikel(nieuwsStartRij);
        });
        $("#vorigAgendaItem").click(function (e) {
            e.preventDefault();
            if (agendaStartRij < 1) {
                agendaStartRij = 0;
            } else {
                agendaStartRij--;
            }
            vorigAgendaItem(agendaStartRij);
        });
        $("#volgendAgendaItem").click(function (e) {
            e.preventDefault();
            agendaStartRij++;
            volgendAgendaItem(agendaStartRij);
        });
    });
    function nieuwsartikels(nieuwsStartRij = 0)
    {
        $.ajax({type: "GET",
            url: site_url + "/home/haalAjaxOp_Nieuwsartikels",
            data: {nieuwsStartRij: nieuwsStartRij},
            success: function (result) {
                $("#nieuwsartikels_content_wrapper").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }
    function vorigNieuwsartikel(nieuwsStartRij)
    {
        $.ajax({type: "GET",
            url: site_url + "/home/haalAjaxOp_Nieuwsartikels",
            data: {nieuwsStartRij: nieuwsStartRij},
            success: function (result) {
                $("#nieuwsartikels_content_wrapper").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }
    function volgendNieuwsartikel(nieuwsStartRij)
    {
        $.ajax({type: "GET",
            url: site_url + "/home/haalAjaxOp_Nieuwsartikels",
            data: {nieuwsStartRij: nieuwsStartRij},
            success: function (result) {
                $("#nieuwsartikels_content_wrapper").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }
    function agendaItems(agendaStartRij = 0)
    {
        $.ajax({type: "GET",
            url: site_url + "/home/haalAjaxOp_AgendaItems",
            data: {agendaStartRij: agendaStartRij},
            success: function (result) {
                $("#agenda_content_wrapper").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }
    function vorigAgendaItem(agendaStartRij)
    {
        $.ajax({type: "GET",
            url: site_url + "/home/haalAjaxOp_AgendaItems",
            data: {agendaStartRij: agendaStartRij},
            success: function (result) {
                $("#agenda_content_wrapper").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }
    function volgendAgendaItem(agendaStartRij)
    {
        $.ajax({type: "GET",
            url: site_url + "/home/haalAjaxOp_AgendaItems",
            data: {agendaStartRij: agendaStartRij},
            success: function (result) {
                $("#agenda_content_wrapper").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }
</script>

<?php

function haalArtikelsOp()
{
    echo '<h2 class="startTitel">Laatste nieuws</h2>';
    echo divAnchor('', '<i class="fas fa-caret-up fa-2x"></i>', array('class' => 'scrollknop text-center', 'id' => 'vorigNieuwsartikel'));
    echo '<ul id="nieuwsartikels_content_wrapper" class="list-unstyled">';
    /* Lijst met nieuwsartikels wordt opgehaald met behulp van Ajax */
    echo '</ul>';
    echo divAnchor('', '<i class="fas fa-caret-down fa-2x"></i>', array('class' => 'scrollknop text-center', 'id' => 'volgendNieuwsartikel'));
}

function haalAgendaOp($agendaItems)
{
    echo divAnchor('', '<i class="fas fa-caret-up fa-2x"></i>', array('class' => 'scrollknop text-center', 'id' => 'vorigAgendaItem'));
    echo '<div id="agenda_content_wrapper" class="col">';
    /* Lijst met agendaItems wordt opgehaald met behulp van Ajax */
    echo '</div>';
    echo divAnchor('', '<i class="fas fa-caret-down fa-2x"></i>', array('class' => 'scrollknop text-center', 'id' => 'volgendAgendaItem'));
}

function haalOpenInschrijvingenOp($wedstrijden)
{
    $stat = "";
    echo '<h2 class="startTitel">Openstaande Inschrijvingen</h2>';
    echo '<ul class="list-unstyled">';
    $dataSubmit = array('class' => 'btn btn-primary my-2 my-sm0', 'value' => 'Inschrijven');
    $attributen = array('id' => 'mijnFormulier',
        'class' => 'form-inline my2 my-lg0',
        'data-toggle' => 'validator',
        'role' => 'form');
    $i = 0;
    foreach ($wedstrijden as $wedstrijd) {
        $i++;
        echo '<li class="media inschrijving">';
        echo '<div class="row media-body">';
        echo '<div class="col-2 text-right">';
        echo '<h2><span class="badge badge-secondary">' . date('d', strtotime($wedstrijd->beginDatum)) . '</span></h2>';
        echo '<h4>' . strtoupper(date('M', strtotime($wedstrijd->beginDatum))) . '</h4>';
        echo '</div>';
        echo '<div class="col-8">';
        echo '<h5 class="mt-0 mb-1">' . $wedstrijd->naam . '</h5>';
        echo $wedstrijd->beginDatum . ' - ' . $wedstrijd->eindDatum;
        echo '</div>';
        echo '<div class="col-2">';
        echo form_open('Wedstrijd/inschrijven', 'class="form-group"', $attributen);
        if (isset($status)) {
            foreach ($status as $deel) {
                if (isset($deel->naam)) {
                    $stat = $deel->naam;
                }
            }
        }
        if ($stat == "open") {
            echo form_submit($dataSubmit);
        }
        echo form_close();
        echo '</div>';
        echo '</div>';
        echo '</li>';
        if ($i == 2) {
            break;
        }
    }
    echo '</ul>';
    echo anchor('wedstrijd/inschrijvingen', 'Alle openstaande inschrijvingen bekijken', 'class="scrollknop text-center"');
}

function haalPaginaInhoudOp($trainingscentrum, $gebruiker, $wedstrijden)
{
    $dt = new DateTime;
    $week = $dt->format('W');
    $jaar = $dt->format('Y');
    if ($gebruiker != null) {
        switch ($gebruiker->soort) {
            case 'zwemmer': // zwemmer
                echo '<div class="col-lg-8">';
                haalOpenInschrijvingenOp($wedstrijden);
                haalArtikelsOp();
                echo'</div>';
                break;
            case 'trainer': // trainer
                echo '<div class="col-lg-12">';
                echo '<h2 class="startTitel">Dashboard Trainer</h2>';
                echo '<div class="row">';
                echo '<div class="col-12 col-md-6 col-lg-4">';
                echo anchor('Nieuws/index', '<i class="far fa-newspaper fa-3x fa-fw"></i> Nieuws beheren', 'class="beheerknop"');
                echo '</div>';
                echo '<div class="col-12 col-md-6 col-lg-4">';
                echo anchor('wedstrijd/bekijkenWedstrijden/na', '<i class="fas fa-trophy fa-3x fa-fw"></i> Wedstrijden beheren', 'class="beheerknop"');
                echo '</div>';
                echo '<div class="col-12 col-md-6 col-lg-4">';
                echo anchor('gebruiker/toonZwemmers', '<i class="fas fa-users fa-3x fa-fw"></i> Zwemmers beheren', 'class="beheerknop"');
                echo '</div>';
                echo '<div class="col-12 col-md-6 col-lg-4">';
                echo anchor('activiteit/index/' . $week . '/' . $jaar, '<i class="far fa-calendar-alt fa-3x fa-fw"></i> Activiteiten beheren', 'class="beheerknop"');
                echo '</div>';
                echo '<div class="col-12 col-md-6 col-lg-4">';
                echo anchor('supplement/supplementenPerZwemmerTrainer', '<i class="fas fa-medkit fa-3x fa-fw"></i> Supplementen', 'class="beheerknop"');
                echo '</div>';
                echo '<div class="col-12 col-md-6 col-lg-4">';
                echo anchor('trainingscentrum/aanpassen', '<i class="fas fa-info fa-3x fa-fw"></i> Info aanpassen', 'class="beheerknop"');
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-lg-8">';
                haalArtikelsOp();
                echo'</div>';
                break;
        }
    } else {
        echo '<div class="col-lg-12"><h2 class="startTitel">Welkom</h2>';
        echo $trainingscentrum->beschrijvingWelkom;
        echo '</div>';
        echo '<div class="col-lg-8">';
        haalArtikelsOp();
        echo'</div>';
    }
}
?>
<div class="row">
    <?php
    haalPaginaInhoudOp($trainingscentrum, $gebruiker, $wedstrijden)
    ?>
    <div class="col-12 col-lg-4">
        <h2 class="startTitel">Agenda</h2>
        <?php

            haalAgendaOp($wedstrijden);
        if ($gebruiker != null) {
            if ($gebruiker->soort == "zwemmer") {
                echo '<div class="alert alert-dark" role="alert">
            <i class="far fa-question-circle fa-2x"></i><span class="tab">Nieuw hier? ' . anchor('home/demo', "Bekijk de demo", "") .
                '</div>';
            }
        }
        ?>
    </div>
</div>
