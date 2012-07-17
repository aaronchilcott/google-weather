<?php
/**
 * A model representing weather forcast Info returned by google. 
 */
namespace Swiftlet\Models\GoogleWeather;

class Information extends \Swiftlet\Model
{
   private $variables = array();
   
   /**
    * Static factory method
    * 
    * @param \Swiftlet\Interfaces\App $app
    * @param \SimpleXMLElement $xmlElement
    * @return \Swiftlet\Models\GoogleWeather\XmlApiReply 
    */
   public static function create(
      \Swiftlet\Interfaces\App $app, \SimpleXMLElement $element)
   {
      $forecast = new Information($app);
      $forecast->populate($element);
      return $forecast;
   }
   
   /**
    * Populates a model object with data from an xml element.
    * 
    * @param \SimpleXMLElement $element 
    */
   protected function populate(\SimpleXMLElement $element)
   {
      // Specify a map of array elements to the variable names
      $map = array(
         'city' => 'city',
         'postal_code' => 'postal_code',
         'latitude_e6' => 'latitude_e6',
         'longitude_e6' => 'longitude_e6',
         'forecast_date' => 'forecast_date',
         'current_date_time' => 'current_date_time',
         'unit_system' => 'unit_system',
      );
      
      if ($element->count() > 0)
      {
         foreach ($map as $name => $variable)
         {
            if (gettype($element->$name) == 'object')
            {
               $child = $element->$name;
               $this->set($variable, (string) $child['data']);
            }
            else
            {
               $this->set($variable, '');
            }
            
         }
      }
   }
   
   /**
    * Converts condition to an associative array.
    * 
    * @return array()
    */
   public function toArray()
   {
      return $this->variables;
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