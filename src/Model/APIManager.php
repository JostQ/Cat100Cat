<?php


namespace App\Model;


class APIManager
{

    public function getAllEggs(String $resource, String $id = null)
    {

        $url = 'http://easteregg.wildcodeschool.fr/api/';

        $client = new \GuzzleHttp\Client([
            'base_uri' => $url
        ]);

        if ($id) {
            $resource = $resource . '/' . $id;
        }

        $response = $client->request('GET', $resource);

        $body = $response->getBody();
        $contents = $body->getContents();

        $data = json_decode($contents);

        return $data;
    }

}