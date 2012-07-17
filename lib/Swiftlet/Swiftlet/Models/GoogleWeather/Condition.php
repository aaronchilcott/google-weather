<?php
/**
 * A model representing weather forcast data returned by google. 
 */
namespace Swiftlet\Models\GoogleWeather;

class Condition extends \Swiftlet\Model
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
      $condition = new Condition($app);
      $condition->populate($element);
      return $condition;
   }
   
   /**
    * Populates a model object with data from an xml element.
    * 
    * <condition data="Clear"/>
<temp_f data="61"/>
<temp_c data="16"/>
<humidity data="Humidity: 55%"/>
<icon data="/ig/images/weather/sunny.gif"/>
<wind_condition data="Wind: NE at 9 mph"/>
    * @param \SimpleXMLElement $element 
    */
   protected function populate(\SimpleXMLElement $element)
   {
      // Specify a map of array elements to the variable names
      $map = array(
         'day_of_week' => 'day_of_week',
         'low' => 'low',
         'high' => 'high',
         'icon' => 'icon',
         'condition' => 'condition',
         'temp_f' => 'temp_f',
         'temp_c' => 'temp_c',
         'humidity' => 'humidity',
         'wind_condition' => 'wind_condition',
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
    * Converts an array of conditions to an array of associated arrays.
    * 
    * @param Condition[] $conditions 
    *    Am array or a Condition object
    * 
    * @return array[]
    */
   static public function convertToArray($conditions)
   {
      $result = array();
      
      foreach ($conditions as $condition)
      {
         $result[] = $condition->toArray();
      }
      
      return $result;
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