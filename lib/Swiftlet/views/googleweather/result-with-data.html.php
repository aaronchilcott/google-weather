<?php
/**
 * This page displays the results of the users search if there was valid data. 
 * TODO: Make this template friendly to new versions of the API.
 */

// display the form
require 'form.html.php';
?>

<table id="forecast-conditions">
   
   <tbody>
      <?php $condition = $this->get('forecastInformation');?>
      <tr>
         <td colspan="2"><h2>Info</h2></td>
      </tr>
      <tr>
         <td colspan="2">
            City: <?php echo $condition['city']; ?><br />
            Post code: <?php echo $condition['postal_code']; ?><br />
            Latitude: <?php echo $condition['latitude_e6']; ?><br />
            Longitude: <?php echo $condition['longitude_e6']; ?><br />
            Forecast Date: <?php echo $condition['forecast_date']; ?><br />
            Current Date time: <?php echo $condition['current_date_time']; ?><br />
            Unit system: <?php echo $condition['unit_system']; ?>
         </td>
      </tr>
   </tbody>
   
   <tbody>
      <?php $condition = $this->get('currentConditions');?>
      <tr>
         <td colspan="2"><h2>Current conditions</h2></td>
      </tr>
      <tr>
         <td>
            Condition: <?php echo $condition['condition']; ?><br />
            Temp F: <?php echo $condition['temp_f']; ?><br />
            Temp C: <?php echo $condition['temp_c']; ?><br />
            <?php echo $condition['humidity']; ?><br />
            Wind condition: <?php echo $condition['wind_condition']; ?>
         </td>
         <td>
            <img src="<?php echo $this->get('imageBaseUrl') . $condition['icon']; ?>" />
         </td>
      </tr>
   </tbody>
   <tbody>
      <tr>
         <td colspan="2"><h2>Forecast</h2></td>
      </tr>
<?
foreach ($this->get('forecastConditions') as $condition)
{
?>
      <tr>
         <td>
            Day: <?php echo $condition['day_of_week']; ?><br />
            Low/High: <?php echo $condition['low']; ?>
               /<?php echo $condition['high']; ?><br />
            Condition: <?php echo $condition['condition']; ?>
         </td>
         <td>
            <img src="<?php echo $this->get('imageBaseUrl') . $condition['icon']; ?>" />
         </td>
      </tr>
      
<?php
}
?>
   </tbody>
</table>