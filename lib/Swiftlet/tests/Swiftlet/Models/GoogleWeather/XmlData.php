<?php
namespace Swiftlet\Models\GoogleWeather;

/**
 * Provides some common XML data for test cases 
 */

class XmlData
{
   /**
    * Returns faux sample data.
    * 
    * @return string
    */
   static public function getZeroBytesXmlData()
   {
      return <<<XML
XML;
   }
   
   
   /**
    * Returns faux sample data.
    * 
    * @return string
    */
   static public function getValidResultsXmlData()
   {
      return <<<XML
<?xml version="1.0"?><xml_api_reply version="1"><weather module_id="0" tab_id="0" mobile_row="0" mobile_zipped="1" row="0" section="0" ><forecast_information><city data="Sydney, NSW"/><postal_code data="Sydney, NSW, Australia"/><latitude_e6 data=""/><longitude_e6 data=""/><forecast_date data="2012-07-17"/><current_date_time data="2012-07-18 02:00:00 +0000"/><unit_system data="US"/></forecast_information><current_conditions><condition data="Clear"/><temp_f data="59"/><temp_c data="15"/><humidity data="Humidity: 51%"/><icon data="/ig/images/weather/sunny.gif"/><wind_condition data="Wind: N at 10 mph"/></current_conditions><forecast_conditions><day_of_week data="Tue"/><low data="46"/><high data="66"/><icon data="/ig/images/weather/sunny.gif"/><condition data="Clear"/></forecast_conditions><forecast_conditions><day_of_week data="Wed"/><low data="48"/><high data="64"/><icon data="/ig/images/weather/mostly_sunny.gif"/><condition data="Mostly Sunny"/></forecast_conditions><forecast_conditions><day_of_week data="Thu"/><low data="46"/><high data="63"/><icon data="/ig/images/weather/chance_of_rain.gif"/><condition data="Chance of Rain"/></forecast_conditions><forecast_conditions><day_of_week data="Fri"/><low data="50"/><high data="63"/><icon data="/ig/images/weather/sunny.gif"/><condition data="Clear"/></forecast_conditions></weather></xml_api_reply>
XML;
   }
   
   
   /**
    * Returns faux sample data.
    * 
    * @return string
    */
   static public function getNoResultsXmlData()
   {
      return <<<XML
<?xml version="1.0"?><xml_api_reply version="1"><weather module_id="0" tab_id="0" mobile_row="0" mobile_zipped="1" row="0" section="0" ><problem_cause data=""/></weather></xml_api_reply>
XML;
   }
   
   
   /**
    * Returns faux sample data.
    * 
    * @return string
    */
   static public function getInvalidXmlData()
   {
      return <<<XML
  This is not XML data
XML;
   }
}