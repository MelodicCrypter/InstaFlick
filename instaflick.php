<?php
/*
* Developer: Hugh Caluscusin - a.k.a Melodic Crypter
* App: InstaFlick
* About: InstaFlick is a simple app that fetches images from Instagram and Flickr through APIs
* URL: http://www.melodiccrypter.com/apps/instaflick/
* Year: 2017
* Version 1
* */

class InstaFlick
{
    // Required Properties
    protected static $tag;
    public static $err;
    protected $lat;
    protected $lng;
    protected $insta_id = 'YOUR_INSTAGRAM_ID';
    protected $insta_token = 'YOUR_INSTAGRAM_TOKEN';
    protected $flickr_key = 'YOUR_FLICKER_KEY';
    
    // Main function
    public static function search($query) 
    {
        if(empty($query) || $query === '') {
            self::$err = '<div id="err">Please type a parameter</div>';
        }
        else {
            self::$tag = urlencode($query);

        }
    }
    
    // Google
    public function googleMapAPI()
    {
        // Google API
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . self::$tag;
        $response = json_decode(file_get_contents($url), true);
        // Set lat and lng properties
        $this->lat = $response['results'][0]['geometry']['location']['lat'];
        $this->lng = $response['results'][0]['geometry']['location']['lng'];
        return $location = ['lat' => $this->lat, 'lng' => $this->lng];
    }

    // Instagram Geolocation API
    public function instaGeoAPI()
    {
        $this->googleMapAPI();
        $url = 'https://api.instagram.com/v1/media/search?lat=' . $this->lat . '&lng=' . $this->lng . '&access_token=' . $this->insta_token . '&count=100';
        return $response = json_decode(file_get_contents($url), TRUE);
    }

    // Instagram Tags API
    public function instaTagAPI()
    {
        $url = 'https://api.instagram.com/v1/tags/' . self::$tag . '/media/recent?access_token=' . $this->insta_token . '&count=100';
        return $response = json_decode(file_get_contents($url), TRUE);
    }

    // Instagram User API
    public function instaUserAPI()
    {
        $url = 'https://api.instagram.com/v1/users/search?q=' . self::$tag . '&access_token=' . $this->insta_token . '&count=100';
        return $response = json_decode(file_get_contents($url), TRUE);
    }

    // Flickr Photo Search API
    public function flickrPhotoAPI()
    {
        $url = 'https://api.flickr.com/services/rest/?format=json&method=flickr.photos.search&api_key=' . $this->flickr_key . '&tags=' . self::$tag . '&nojsoncallback=1&per_page=300';
        return $response = json_decode(file_get_contents($url), TRUE);
    }

}