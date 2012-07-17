<?php
/**
 * The form for capturing the user's desired weather location. TODO: Form error
 * display.
 */

?>
<p>Type a location in to the field below and click <em>Show weather</em>.</p>

<div id="form-container">
   <!-- Leave the form action as the default (current) URI -->
   <form method="post">
      <fieldset class="form-header">
         <?php
         /** TODO: Complete the output of form error display
         if ($this->get('form-input-error:location')) { ?>
         <div class="form-input-error">
         <?php echo $this->get('form-input-error-message:location'); ?> 
         </div>
         <?php } */?>
      </fieldset>
      
      <fieldset class="form-row">
         <div class="form-input-group"
            <label for="location-input">Location:</label>
            <input type="text" name="location" value="<?php echo $this->get('location') ?>" />
         </div>
         
         <?php
         /** TODO: Complete the output of form input error display
         if ($this->get('form-input-error:location')) { ?>
         <div class="form-input-error">
         <?php echo $this->get('form-input-error-message:location'); ?> 
         </div>
         <?php } */?>
      </fieldset>
      <fieldset class="form-footer">
         <button type="submit" name="show-weather" value="show-weather">Show weather</button>
      </fieldset>
   </form>
</div>