<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

// ---------------- E N T I T Y ---------------- //
use App\Entity\Room;
// --------------------------------------------- //

// ----------- R E P O S I O R Y --------------- //
use App\Repository\RoomRepository;
// --------------------------------------------- //

/**
 * @Route("/owner/room")
 * @author Louis
 *
 */
class RoomController extends AbstractController
{
    private $rR;
    public function __construct(RoomRepository $rR){
        $this->rR = $rR;       
    }
    /**
     * @Route("/list", name="room_index")
     */
    public function index(): Response
    {
        $listeRooms = $this->rR->findAll();
        return $this->render('room/index.html.twig', [
            'listeRooms' => $listeRooms,
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
