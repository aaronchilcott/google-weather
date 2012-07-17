<?php
/**
 * Represents the Google weather XML Api reply data. 
 */

namespace Swiftlet\Models\GoogleWeather;

class XmlApiReply extends \Swiftlet\Model
{
   private $variables = array();
   
   private $forecastInformation;
   private $currentConditions;
   private $forecastConditions = array();
   
   /**
    * We may not change the signature of the constructor, so move the data 
    * load to a seperate method and protect it to enforce the use of the factory
    * method.
    * 
    * @see self::create()
    * 
    * @param \SimpleXMLElement $xmlElement 
    * @return void
    */
   protected function populate(\SimpleXMLElement $element)
   {
      $this->addForecastInformation($element->weather->forecast_information);
      $this->addCurrentConditions($element->weather->current_conditions);
      $this->addForecastConditions($element->weather->forecast_conditions);
   }
   
   /**
    * For adding forecast information
    * 
    * @param type $element 
    * @return void
    */
   protected function addForecastInformation(\SimpleXMLElement $element)
   {
      $this->forecastInformation = Information::create($this->app, $element);
   }
   
   /**
    * For adding forecast information
    * 
    * @param type $element 
    * @return void
    */
   protected function addCurrentConditions(\SimpleXMLElement $element)
   {
      $this->currentConditions = Condition::create($this->app, $element);
   }
   
   /**
    * For adding forecast information
    * 
    * @param type $element 
    * @return void
    */
   protected function addForecastConditions(\SimpleXMLElement $element)
   {
      foreach ($element as $condition)
      {
         $this->forecastConditions[] = Condition::create(
            $this->app, $condition);
      }
   }
   
   /**
    * Returns an array of forecast conditions
    * 
    * @return \Swiftlet\Models\GoogleWeather\Condition[]
    */
   public function getForecastConditions()
   {
      return $this->forecastConditions;
   }
   
   /**
    * Returns an array of forecast conditions
    * 
    * @return \Swiftlet\Models\GoogleWeather\Condition
    */
   public function getCurrentConditions()
   {
      return $this->currentConditions;
   }
   
   /**
    * Returns an array of forecast conditions
    * 
    * @return \Swiftlet\Models\GoogleWeather\Condition
    */
   public function getForecastInformation()
   {
      return $this->forecastInformation;
   }
   
   /**
    * Static factory method
    * 
    * @param \Swiftlet\Interfaces\App $app
    * @param \SimpleXMLElement $xmlElement
    * 
    * @return \Swiftlet\Models\GoogleWeather\XmlApiReply 
    */
   public static function create(
      \Swiftlet\Interfaces\App $app, \SimpleXMLElement $element)
   {
      // TODO: create xml_api_reply version handling.
      $xmlApiReply = new XmlApiReply($app);
      $xmlApiReply->populate($element);
         
      return $xmlApiReply;
   }

	/**
	 * Get a view variable
	 * @params string $variable
	 * @params bool $htmlEncode
	 * @return mixed
	 */
	public function get($variable, $htmlEncode = true)
	{
		if ( isset($this->variables[$variable]) ) {
			if ( $htmlEncode ) {
				return $this->htmlEncode($this->variables[$variable]);
			} else {
				return $this->variables[$variable];
			}
		}
	}

	/**
	 * Set a view variable
	 * @param string $variable
	 * @param mixed $value
	 */
	protected function set($variable, $value = null)
	{
		$this->variables[$variable] = $value;
	}
   
}
