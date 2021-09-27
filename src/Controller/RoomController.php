<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Room;

/**
 * @Route("/room")
 * @author Louis
 *
 */
class RoomController extends AbstractController
{
    /**
     * @Route("/list", name="room_index")
     */
    public function index(): Response
    {
        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }
    
    /**
     * @Route("/new", name="room_new")
     */
    public function new(Request $request)
    {
        
    }
    /**
     * @Route("/{id}", name="room_show")
     */
    public function show(Request $request, Room $romm){
        
    }
    /**
     * @Route("/{id}/edit", name="room_edit")
     */
    public function edit(Request $request, Room $romm){
        
    }
    /**
     * @Route("/{id}/delete", name="room_delete")
     */
    public function delete(Request $request, Room $romm){
        
    }
}
