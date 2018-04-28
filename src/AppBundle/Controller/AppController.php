<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('@App/page/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reservationAction()
    {
        return $this->render('@App/page/reservation.html.twig');
    }

    /**
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogListAction($page)
    {
        return $this->render('@App/page/blogList.html.twig', ['page' => $page]);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogPostAction($id)
    {
        return $this->render('@App/page/blogPost.html.twig', ['id' => $id]);
    }
}