<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bench;
use AppBundle\Entity\Post;
use AppBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    public function reservationRequestAction(\DateTime $date)
    {
        $em = $this->getDoctrine()->getManager();
        $benchRepository = $em->getRepository(Bench::class);

        $serializer = $this->get('jms_serializer');

        $bench = [];
        $free = $benchRepository->getFreeBenchForDate(null, $date);
        $busy = $benchRepository->getBusyBenchForDate($date);

        foreach ($free as $one) {
            $one->setState(Bench::STATE_EMPTY);
            $bench[] = $one;
        }

        foreach ($busy as $one) {
            $one->setState(Bench::STATE_BUSY);
            $bench[] = $one;
        }

        usort($bench, function ($a, $b) {
            return $a->getId() > $b->getId();
        });

        return new Response($serializer->serialize($bench, 'json'), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @param string $name
     * @param \DateTime $date
     * @param int $table
     * @return JsonResponse
     */
    public function createReservationAction($name, \DateTime $date, $table)
    {
        $em = $this->getDoctrine()->getManager();
        $bench = $em->getRepository(Bench::class)->find($table);

        $reservation = new Reservation();
        $reservation->setAuthor($this->getUser());
        $reservation->setState(true);
        $reservation->setName($name);
        $reservation->setBench($bench);
        $reservation->setDate($date);
        $reservation->setNumberOfPerson($bench->getNumberOfPerson());

        $em->persist($reservation);
        $em->flush();

        return new JsonResponse(['state' => 'ok']);
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
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogPostAction(Post $post)
    {
        return $this->render('@App/page/blogPost.html.twig', ['post' => $post]);
    }

    /**
     * @param $page
     * @return Response
     */
    public function viewReservationsAction($page)
    {
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->getDoctrine()->getRepository(Reservation::class)->getUserListQuery($this->getUser()),
            $page,
            $this->getParameter('user_list_per_page')
        );

        return $this->render('@App/page/viewReservations.html.twig', ['pagination' => $pagination]);
    }

}