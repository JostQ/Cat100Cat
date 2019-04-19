<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\UserManager;

/**
 * Class UserController
 *
 */
class UserController extends AbstractController
{
    /**
     * Display user creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function signup()
    {
        $data = [];
        $view = 'User/signup.html.twig';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            $userManager = new UserManager();

            $post = $this->pureRequestPost($_POST);

            if (!isset($post['nickname']) || empty($post['nickname'])) {
                $errors['nickname'] = 'Pseudo incorrect';
            }

            if (!isset($post['email']) || empty($post['email'])) {
                $errors['email'] = 'Email incorrect';
            } elseif (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Mauvais format d\'email';
            } elseif ($userManager->isEmailExist($post['email'])) {
                $errors['email'] = 'Email déjà utilisé';
            }

            if (!isset($post['password']) || empty($post['password'])) {
                $errors['password'] = 'Mot de passe incorrect';
            } elseif ($post['password'] !== $post['passwordConfirm']) {
                $errors['password'] = 'Les mots de passe de correspondent pas';
            }

            if (empty($errors)) {
                $user = [
                    'nickname' => $post['nickname'],
                    'email' => $post['email'],
                    'password' => password_hash($post['password'], PASSWORD_DEFAULT),
                ];
                $userManager->insert($user);

                $_SESSION['flash']['validate'] = 'Inscription réussi, vous pouvez vous connecter !';

                header('Location: /user/login');
            } else {
                $data['user'] = $post;
                $data['errors'] = $errors;
            }
        }
        return $this->twig->render($view, $data);
    }

    public function login()
    {
        $data = [];

        $view = 'User/login.html.twig';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            $errorSentence = 'Identifiants incorrects';

            $post = $this->pureRequestPost($_POST);

            foreach ($post as $key => $value) {
                if (empty($post[$key]) || !isset($post[$key])) {
                    $errors['login'] = $errorSentence;
                }
            }

            $userManager = new UserManager();
            $user = $userManager->selectUserByEmail($post['email']);

            if (!$user) {
                $errors['login'] = $errorSentence;
            } elseif (!password_verify($post['password'], $user['password'])) {
                $errors['login'] = $errorSentence;
            }

            if (empty($errors)) {
                $_SESSION = $user;
                header('Location: /');
            } else {
                $data['user'] = $post;
                $data['errors'] = $errors;
            }
        }

        $this->unsetSession();

        return $this->twig->render($view, $data);
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
}
