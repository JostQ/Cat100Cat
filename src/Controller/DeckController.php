<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\DeckManager;

/**
 * Class DeckController
 *
 */
class DeckController extends AbstractController
{


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
        $data = [];

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
                $deck = [
                    'name' => $post['name'],
                    'lord' => $post['lord'],
                    'user_id' => $_SESSION['id']
                ];
                $id = $deckManager->insert($deck);
                header('Location:/deck/show/' . $id);
            } else {
                $data['deck'] = $post;
                $data['errors'] = $errors;
            }
        }

        return $this->twig->render('Deck/add.html.twig', $data);
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
