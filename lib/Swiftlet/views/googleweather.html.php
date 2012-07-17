<?php 
/**
 * This is base HTML template for the google weather api application.
 */
use \Swiftlet\Controllers\GoogleWeather;

require 'header.html.php' ?>

<h1><?php echo $this->get('pageTitle') ?></h1>

<?php
   $displayPage = '';
   
   switch ($this->get('state'))
   {
      case GoogleWeather::STATE_FIRST_VIEW:
         $displayPage = 'googleweather/first-view.html.php';
         break;
      
      case GoogleWeather::STATE_RESULT_HAS_DATA:
         $displayPage = 'googleweather/result-with-data.html.php';
         break;

      case GoogleWeather::STATE_NO_DATA:
         $displayPage = 'googleweather/result-without-data.html.php';
         break;
      
      // TODO: Impliment this functionality
      /*
      case GoogleWeather::STATE_ERROR:
         $displayPage = 'GoogleWeather/error.html.php';
         break;
       */
      default:
         throw new \Exception('Unsupported state: ' . $this->get('state'));
   }
   
   require $displayPage;

?>


<?php require 'footer.html.php' ?>
