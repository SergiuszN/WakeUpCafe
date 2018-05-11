<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return $this->render('@App/admin/dashboard.html.twig');
    }

    /**
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogListAction($page)
    {
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->getDoctrine()->getRepository(Post::class)->getAdminListQuery(),
            $page,
            $this->getParameter('admin_list_per_page')
        );

        // parameters to template
        return $this->render('@App/admin/blogList.html.twig', array('pagination' => $pagination));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function blogAddAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostForm::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Post $post */
            $post = $form->getData();
            if ($post->getContent() === null) {
                $post->setContent('');
            }
            $post->setAuthor($this->getUser());
            $post->setDate((new \DateTime()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('add_admin_blog_list');
        }

        return $this->render('@App/admin/blogAdd.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function blogEditAction(Request $request, Post $post)
    {
        $form = $this->createForm(PostForm::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('add_admin_blog_list');
        }

        return $this->render('@App/admin/blogEdit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function blogSwitchStatusAction(Post $post)
    {
        $post->setStatus(!$post->getStatus());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('add_admin_blog_list');
    }

    /**
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function blogDeleteAction(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('add_admin_blog_list');
    }
}