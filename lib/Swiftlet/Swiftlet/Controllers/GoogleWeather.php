<?php
/**
 * Root Controller for the google weather API test project.
 */

namespace Swiftlet\Controllers;

class GoogleWeather extends \Swiftlet\Controller
{
   // State constants, these indicate the current state of the search process.
   /**
    * The first time the page is displayed to a user, no search has been 
    * performed.
    */
   const STATE_FIRST_VIEW = 'FIRST_VIEW';
   
   /**
    * When a search has be performed and there is a result.
    */
   const STATE_RESULT_HAS_DATA = 'RESULT_HAS_DATA';
   
   /**
    * When a search has be performed and there is no result. 
    */
   const STATE_NO_DATA = 'NO_DATA';
   
   /**
    * When there is an error. 
    */
   const STATE_ERROR = 'ERROR';
   
   /**
    * A parameter used in the views for the name of the location input.
    */
   const PARAMETER_LOCATION = 'location';
   
   /**
    * Provides a base URL for images and search queries
    */
   const URL_BASE_GOOGLE_WEATHER_API = 'http://www.google.com';
   
   /**
    * URI for search queries 
    */
   const URI_GOOGLE_WEATHER_API = '/ig/api?weather=';
   
   /**
    * @see \Swiftlet\Controller
    * @var string 
    */
	protected $title = 'Google Weather API test';
   
	/**
	 * Constructor
	 * @param object $app
	 * @param object $view
	 */
	public function __construct(
      \Swiftlet\Interfaces\App $app, \Swiftlet\Interfaces\View $view)
	{
      // Discard the default view and use a specialized sub-class instead.
      //$view = new \Swiftlet\Views\GoogleWeather(
         //$app, strtolower('GoogleWeather'));
      parent::__construct($app, $view);
	}

	/**
	 * Default action
    * @see \Swiftlet\Controller
    * @return void;
	 */
	public function index()
	{
      // Set the view's page page title variable
      $this->view->set('pageTitle', $this->title);
      
      // Check to see if we have a post variable, this tells us that the form
      // has been posted.
      if (!isset($_POST['location']))
      {
         // No data has been sent through
         $this->view->set('state', self::STATE_FIRST_VIEW);
         // Early return
         return;
      }
      
      // Attempt to retrieve some XML data from google.
      $xmlData = $this->getXmlDataByLocation($_POST['location']);
      
      // Set the view's variable 'location'
      $this->view->set('location', htmlspecialchars($_POST['location']));
      
      // Sanity check
      if (empty($xmlData))
      {
         // Error condition, expected some data.
         $this->view->set('state', self::STATE_ERROR);
         // TODO: put some helpful debugging output here
         // Early return
         return;
      }
      
      // Attempt a transform in to SimpleXml
      $simpleXml = $this->getSimpleXml($xmlData);
      
      // More santiy checking
      if ($simpleXml === false)
      {
         // Parsing issues
         $this->view->set('state', self::STATE_ERROR);
         // TODO: put some helpful debugging output here
         // Early return
         return;
      }
      
      // Check if there were any results, there will be exactly one elelment if
      // there are no results.
      if ($simpleXml->weather->children()->count() === 1)
      {
         // Parsing issues
         $this->view->set('state', self::STATE_NO_DATA);
         // TODO: put some helpful debugging output here
         // Early return
         return;
      }
      
      // If we go this var, lets assume we have valid data
      $this->view->set('state', self::STATE_RESULT_HAS_DATA);
      
      // A variable for images
      $this->view->set('imageBaseUrl', self::URL_BASE_GOOGLE_WEATHER_API);
      
      // Further transform (just for show, we could skip using the models)
      $xmlApiReply = \Swiftlet\Models\GoogleWeather\XmlApiReply
         ::create($this->app, $simpleXml);
      
      // Set the view's Forcast conditions
      $this->view->set(
         'forecastConditions', 
         \Swiftlet\Models\GoogleWeather\Condition::convertToArray(
            $xmlApiReply->getForecastConditions()));
      
      // And for the current conditions
      $this->view->set(
         'currentConditions', 
            $xmlApiReply->getCurrentConditions()->toArray());
      
      // And a bit for search info
      $this->view->set(
         'forecastInformation', 
            $xmlApiReply->getForecastInformation()->toArray());
      
	}
   
   /**
    * Providing a descrete testable method for the extract function.
    * 
    * @param type $location
    * @return type 
    */
   protected function getXmlDataByLocation($location)
   {
      return file_get_contents(
         self::URL_BASE_GOOGLE_WEATHER_API . 
         self::URI_GOOGLE_WEATHER_API . urlencode($location));
   }
   
   /**
    * Providing a testable method for the XML conversion.
    * 
    * @param type $xmlString
    * @return boolean|\SimpleXMLElement 
    */
   protected function getSimpleXml($xmlString)
   {
      try
      {
         $xml = new \SimpleXMLElement($xmlString);
      }
      catch (\Exception $e)
      {
         // Todo: add error logging
         return false;
      }
      
      return $xml;
   }
}
