<?php
class MySoup
{
    protected $url ;

    function testSoup($url)
    {if ($url) 
        {
            $this->url= $url;
            $client = new SoapClient($this->url, array("trace" => 1, "exception" => 0)); 
            return  $client; 
        }
        else
        {
            die(ERR_URL);
        }
 
    }

    function testCurl($url)
    {
        if ($url) 
        {

            // xml post structure

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                        <soap:Body>
                            <ListOfCountryNamesByCode xmlns="http://www.oorsprong.org/websamples.countryinfo">
                            </ListOfCountryNamesByCode>
                        </soap:Body>
                        </soap:Envelope>';  

        $headers = array(

                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Content-length: ".strlen($xml_post_string),
                        "POST /websamples.countryinfo/CountryInfoService.wso HTTP/1.1",
                        "Host: webservices.oorsprong.org",
                        "Accept: text/xml");
            
                // PHP cURL  for https connection with auth
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
                // converting
                $response = curl_exec($ch); 
                curl_close($ch);
    
                // converting
                $response1 = str_replace("<soap:Body>","",$response);
                $response2 = str_replace("</soap:Body>","",$response1);
    
                // convertingc to XML
                
                 //$parser = simplexml_load_string($response2);
            $response3 = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response2);
              $xml = new SimpleXMLElement($response3);
              $array = json_decode(json_encode((array)$xml), TRUE);
              return $array;
                                

        }
        else
        {
            die(ERR_URL);
        }

    }


    function testCurlParams($url, $Params)
    {
        if ($url && $Params) 
        {

            // xml post structure

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                        <soap:Body>
                        <CountryName xmlns="http://www.oorsprong.org/websamples.countryinfo">
                            <sCountryISOCode>' . $Params . '</sCountryISOCode>
                        </CountryName>
                        </soap:Body>
                        </soap:Envelope>';  

        $headers = array(

                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Content-length: ".strlen($xml_post_string),
                        "POST /websamples.countryinfo/CountryInfoService.wso HTTP/1.1",
                        "Host: webservices.oorsprong.org",
                        "Accept: text/xml");

                // PHP cURL  for https connection with auth
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
                // converting
                $response = curl_exec($ch); 
                curl_close($ch);
    
                // converting
                $response1 = str_replace("<soap:Body>","",$response);
                $response2 = str_replace("</soap:Body>","",$response1);
    
                // convertingc to XML
                
                 //$parser = simplexml_load_string($response2);
            $response3 = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response2);
              $xml = new SimpleXMLElement($response3);
              $array = json_decode(json_encode((array)$xml), TRUE);
              return $array;
                                

        }

    }
}