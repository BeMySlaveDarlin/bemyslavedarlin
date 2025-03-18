<?php

declare(strict_types=1);

namespace App\Component\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function indexAction(): Response
    {
        return $this->render('index.html.twig');
    }
}
