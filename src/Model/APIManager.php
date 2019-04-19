<?php


namespace App\Model;

use function GuzzleHttp\Promise\all;

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

    public function selectNCharacters(int $number): array
    {
        $allCharacters = $this->getAllEggs('characters');
        $characters = [];
        for ($i = 0; $i < $number; $i++) {
            $characters[$i] = $allCharacters[$i];
        }
        return $characters;
    }

    public function selectNineEggsForNCharacter(int $number): array
    {
        $characters = $this->selectNCharacters($number);
        $allEggs = $this->getAllEggs('eggs');
        $eggs = [];
        $step = 0;
        for ($i = 0; $i < $number; $i++) {
            for ($j = $step; $j < 9 + $step; $j++) {
                $eggs[$characters[$i]->id][] = $allEggs[$j];
            }
            $step += 9;
        }
        return $eggs;
    }
}
