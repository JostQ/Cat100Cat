<?php


namespace App\Controller;

use App\Model\APIManager;

class DetailsController extends AbstractController
{
    public function show(string $id)
    {
        $eggsManager = new APIManager();
        $egg = $eggsManager->getAllEggs('eggs', $id);
        return $this->twig->render('Details/details.html.twig', ['egg'=>$egg]);
    }
    public function index()
    {
        $eggsManager = new APIManager();
        $eggs = $eggsManager->getAllEggs('eggs');
        return $this->twig->render('Details/eggCards.html.twig', ['eggs'=>$eggs]);
    }
}

