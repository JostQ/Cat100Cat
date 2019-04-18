<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 15:38
 * PHP version 7
 */

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 *
 */
abstract class AbstractController
{
    /**
     * @var Environment
     */
    protected $twig;


    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => !APP_DEV,
                'debug' => APP_DEV,
            ]
        );

        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }

        $flash = $_SESSION['flash'];

        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('flash', $flash);
        $this->twig->addExtension(new DebugExtension());
    }

    public function unsetSession(): void
    {
        foreach ($_SESSION['flash'] as $key => $flash) {
            unset($_SESSION['flash'][$key]);
        }
    }

    public function pureRequestPost(array $data): array
    {
        $post = [];
        foreach ($data as $key => $datum) {
            $post[$key] = trim($datum);
        }
        return $post;
    }
}
