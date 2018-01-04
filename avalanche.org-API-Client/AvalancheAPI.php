<?php
/**
 * A client to interact with the Avalanche.org API
 * For the use of avalanche forecast centers to share information
 */
class AvalancheAPI
{
    private $baseURL;
    private $version;

    public function __construct($baseURL = null)
    {
        if(!empty($baseURL))
        {
            $this->baseURL = $baseURL;
        }
        else
        {
            $this->baseURL = "https://api.avalanche.org";
        }

        $this->version = "v1";
    }

    /**
     * Description: A function to process a curl request
     * @param $url string the url to run the curl for
     * @param $data optional array of post data
     *
     * @return $output varying the result of the url which was run
    */
    private function curl($route, $data = null)
    {
        $url = $this->baseURL . "/" . $this->version . "/" . $route;

        // create curl resource 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // post data
        if($data)
        {
            $postString = http_build_query($data);
            curl_setopt($ch,CURLOPT_POST, count($data));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $postString);
        }

        // $output contains the output string 
        $output = curl_exec($ch); 
        // close curl resource to free up system resources 
        curl_close($ch); 

        return $output;
    }

    /**
    *   Description: Get's the embedded map for the given avalanche center including the zones and danger ratings
    *   @param - $centerID the abbreviation ex. CAIC
    *   @param - $options - (optional) an array of options as key/value pairs
    *       basemap_color = 'bw', 'lightColor', 'color'
    *       zoom_level = int 4 - 12
    *       map_height = int in pixels
    *       danger_scale = 'top', 'bottom', 'none' (defaults to none)
    *       example: ['basemap_color' => 'lightColor', 'zoom_level'=>8, 'danger_scale' => 'top', 'map_height' => 500]
    *   @return $output - a google map in html/javascript
    */
    public function getMap($centerID, $options = null) 
    {
        //Avalanche Center ID
        $post = ['avalanche_center' => $centerID]; 

        //Optional map configurations
        if($options)
        {
            $post['options'] = $options;
        }
        // $output from API call
        return $this->curl("forecast/get-embedded-map/", $post); 
    }

    /**
    *   Description: Updates the forecast on avalanche.org for all zones 
    *   affiliated with the avalnche center. Used for the national map 
    *   and the embedded map. Used for both creating and updating
    *   @param - $centerID the abbreviation ex. CAIC
    *   @return $output - the results of the import
    */
    public function updateForecast($centerID) 
    {
        // $output from API call
        return json_decode($this->curl("forecast/import-data/$centerID")); 
    }

}