<?php
/**
 * Black box test case for Swiftlet/Models/GoogleWeather/XmlApiReply
 * 
 */

namespace Swiftlet\Models\GoogleWeather;

require dirname(__FILE__) . '/XmlData.php';
require dirname(__FILE__) . '/../../../../Swiftlet/Interfaces/App.php';
require dirname(__FILE__) . '/../../../../Swiftlet/App.php';

require dirname(__FILE__) . '/../../../../Swiftlet/Interfaces/Model.php';
require dirname(__FILE__) . '/../../../../Swiftlet/Model.php';

require dirname(__FILE__) . '/../../../../Swiftlet/Models/GoogleWeather/XmlApiReply.php';
require dirname(__FILE__) . '/../../../../Swiftlet/Models/GoogleWeather/Information.php';
require dirname(__FILE__) . '/../../../../Swiftlet/Models/GoogleWeather/Condition.php';

class XmlApiReplyTest extends \PHPUnit_Framework_TestCase
{
	protected 
      $app,
      $validXmlString,
      $xmlApiReply,
      $validSimpleXmlElement;
   
	public function setUp()
	{
  		$this->app = new \Swiftlet\App();
      
		set_error_handler(array($this->app, 'error'), E_ALL | E_STRICT);

		spl_autoload_register(array($this->app, 'autoload'));
      
      $this->validXmlString = XmlData::getValidResultsXmlData();
      $this->validSimpleXmlElement = new \SimpleXMLElement(
         $this->validXmlString);
      $this->xmlApiReply =  XmlApiReply::create(
         $this->app, $this->validSimpleXmlElement);
      
	}
   
   /**
    * Test the input test data for correctness. 
    */
   public function testValidXmlString()
   {
      $this->assertInternalType(
         'string', 
         $this->validXmlString);
   }
   
   /**
    * Test the input test data for correctness. 
    */
   public function testValidSimpleXmlElement()
   {
      $this->assertInstanceOf(
         'SimpleXmlElement', 
         $this->validSimpleXmlElement);
   }
   
   /**
    * Test successful use of the create method 
    */
   public function testValidCreate()
   {
      $this->assertInstanceOf(
         'Swiftlet\Models\GoogleWeather\XmlApiReply', $this->xmlApiReply);
   }
   
   /**
    * Test sucessful use of the getCurrentConditions 
    */
   public function testValidGetCurrentConditions()
   {
      $this->assertInstanceOf(
         'Swiftlet\Models\GoogleWeather\Condition', 
         $this->xmlApiReply->getCurrentConditions());
   }
   
   /**
    * Test sucessful use of the getForecastInformation 
    */
   public function testValidGetForecastInformation()
   {
      $this->assertInstanceOf(
         'Swiftlet\Models\GoogleWeather\Information', 
         $this->xmlApiReply->getForecastInformation());
   }
   
   /**
    * Test sucessful use of the getForecastConditions 
    */
   public function testValidGetForecastConditions()
   {
      $this->assertInternalType(
         'array', 
         $this->xmlApiReply->getForecastConditions());
      
      foreach ($this->xmlApiReply->getForecastConditions() as $condition)
      {
         $this->assertInstanceOf(
            'Swiftlet\Models\GoogleWeather\Condition', 
            $condition);
      }
   }
   
   /**
    * Testing an invalid app opject being passed to the method.
    * 
    * @expectedException InvalidArgumentException
    * 
    * TODO: Throw some specialized exceptions, as PHP no longer allows 
    * generic exceptions to be tested.
    
   public function testInvalidAppVarOnCreateException()
   {
      $this->xmlApiReply =  XmlApiReply::create(
         null, $this->validSimpleXmlElement);
   }
    * 
    */
}