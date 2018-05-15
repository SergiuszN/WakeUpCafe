<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
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
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->getDoctrine()->getRepository(Post::class)->getUserListQuery(),
            $page,
            $this->getParameter('admin_list_per_page')
        );

        return $this->render('@App/page/blogList.html.twig', array('pagination' => $pagination, 'page' => $page));
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