<?php
/**
 *\file Supplement/form.php
 *
 * View waarin men een supplement kan aanmaken
 */

if(isset($supplement)) {
    echo "<h2 class=\"paginaTitel\">Supplement aanpassen</h2>";
    $dataInputNaam = array('class' => 'form-control mr-sm-2', 'type' => 'text', 'name' => 'naam', 'id' => 'naam', 'placeholder' => 'Naam supplement', 'aria-label' => 'Naam', 'size' => '30', 'value' => $supplement->naam);
    $dataInputBeschrijving = array('class' => 'form-control mr-sm-2', 'name' => 'beschrijving', 'id' => 'beschrijving', 'placeholder' => 'Beschrijving supplement', 'aria-label' => 'beschrijving', 'size' => '30', 'value' => $supplement->beschrijving);
}
else {
  echo "<h2 class=\"paginaTitel\">Supplement toevoegen</h2>";
    $dataInputNaam = array('class' => 'form-control mr-sm-2', 'type' => 'text', 'name' => 'naam', 'id' => 'naam', 'placeholder' => 'Naam', 'aria-label' => 'Naam', 'size' => '30');
$dataInputBeschrijving = array('class' => 'form-control mr-sm-2', 'name' => 'beschrijving', 'id' => 'beschrijving', 'placeholder' => 'Beschrijving supplement', 'aria-label' => 'beschrijving', 'size' => '30');

}
$dataSubmit = array('class' => 'btn btn-primary my-2 my-sm0', 'value' => 'Opslaan');

echo form_open('Supplement/registreer', 'class="form-group"');
echo "<div class='form-group'>";
echo form_label("Naam", 'naam') . "\n";
echo form_input($dataInputNaam) . "\n";
echo "</div>";
echo "<div class='form-group'>";
echo form_label("Beschrijving", 'beschrijving') . "\n";
echo form_textarea($dataInputBeschrijving) . "\n";
echo "</div>";
if(isset($supplement)){
    echo form_hidden('id', $supplement->id);
}
echo form_submit($dataSubmit) . "";
echo anchor('Supplement/beheerSupplementen', "Terug", "Class='btn btn-primary my-2 my-sm0'");
echo form_close();
