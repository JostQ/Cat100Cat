<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\APIManager;
use App\Model\CardManager;
use App\Model\DeckManager;

/**
 * Class DeckController
 *
 */
class DeckController extends AbstractController
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->isConnected()) {
            header('Location: /user/login');
        }
    }

    /**
     * Display deck listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $deckManager = new DeckManager();
        $decks = $deckManager->selectAllByUserId();

        $apiManager = new APIManager();

        for ($i = 0; $i < count($decks); $i++) {
            $decks[$i]['lord'] = $apiManager->getAllEggs('characters', $decks[$i]['lord_id']);
        }

        return $this->twig->render('Deck/index.html.twig', ['decks' => $decks]);
    }


    /**
     * Display deck informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $deckManager = new DeckManager();
        $deck = $deckManager->selectOneByIdAndByUser($id);

        return $this->twig->render('Deck/show.html.twig', ['deck' => $deck]);
    }

    /**
     * Display deck creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $apiManager = new APIManager();

        $nbCharacters = 5;

        $characters = $apiManager->selectNCharacters($nbCharacters);

        $eggsPerCharacter = $apiManager->selectNineEggsForNCharacter($nbCharacters);

        $data = ['characters' => $characters,
            'eggsPerCharacter' => $eggsPerCharacter,
            ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            $post = $this->pureRequestPost($_POST);

            if (!isset($post['name']) || empty($post['name'])) {
                $errors['name'] = 'Le nom du deck est incorrect';
            }

            if (!isset($post['lord']) || empty($post['lord'])) {
                $errors['lord'] = 'Le lord est invalide';
            }

            if (empty($errors)) {
                $deckManager = new DeckManager();
                $cardManager = new CardManager();

                $deck = [
                    'name' => $post['name'],
                    'lord' => $post['lord'],
                    'user_id' => $_SESSION['id']
                ];
                $id = $deckManager->insert($deck);

                $card = [];

                foreach ($eggsPerCharacter as $key => $cards) {
                    if ($key === $post['lord']) {
                        foreach ($cards as $selfCard) {
                            $card['egg'] = $selfCard->id;
                            $card['deck'] = $id;
                            $cardManager->insert($card);
                        }
                    }
                }

                header('Location:/deck/addcards/' . $id);
            } else {
                $data['deck'] = $post;
                $data['errors'] = $errors;
            }
        }

        return $this->twig->render('Deck/add.html.twig', $data);
    }

    public function addcards(int $deckId)
    {
        $cardManager = new CardManager();
        $apiManager = new APIManager();

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            $post = $this->pureRequestPost($_POST);

            if (count($post) < 6 || count($post) > 6) {
                $errors['cards'] = 'Vous devez sélectionner 5 cartes';
            }

            if (empty($errors)) {
                $id = $post['deckId'];

                foreach ($post as $key => $egg) {
                    if ($key !== 'deckID') {
                        $cardManager->updateSelected($egg, $id);
                    }
                }

                header('Location: /deck/index');
            } else {
                $data['errors'] = $errors;
            }
        }

        $cards = $cardManager->selectAllByDeckId($deckId);

        $eggs = [];
        foreach ($cards as $card) {
            $eggs[] = $apiManager->getAllEggs('eggs', $card['egg_id']);
        }

        $data['deckId'] = $deckId;

        $data['cards'] = $eggs;

        return $this->twig->render('Deck/addcards.html.twig', $data);
    }


    /**
     * Handle deck deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $deckManager = new DeckManager();
        $deckManager->delete($id);
        header('Location:/deck/index');
    }
}
