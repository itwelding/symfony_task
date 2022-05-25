<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\BHP;
use App\Entity\BHPParticipant;
use App\Form\BHPFormType;
use App\Form\BHPParticipantFormType;

class BHPController extends AbstractController
{
    #[Route('/bhp/index', name: 'bhp_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {        
        $bhps = $entityManager->getRepository(BHP::class)->findAll();
        return $this->render('bhp/index.html.twig', [
            'bhps' => $bhps,
        ]);
    }

    #[Route('/bhp/add', name: 'bhp_add')]
    public function add(EntityManagerInterface $entityManager): Response
    {        
        return $this->render('bhp/add.html.twig');        
    }

    #[Route('/bhp/store', name: 'bhp_store')]
    public function store(EntityManagerInterface $entityManager, Request $request): Response
    {   
        $bhp = new BHP();
        $bhp->setName($request->request->get('name'));                
        for($i=0; $request->request->get('participant_name_'.$i); ++$i) {
            $participant = new BHPParticipant();
            $participant->setName($request->request->get('participant_name_'.$i));            
            $participant->setCompany($request->request->get('participant_company_'.$i));
            $entityManager->persist($participant);
            $bhp->addBHPParticipant($participant);
        }
        $entityManager->persist($bhp);
        $entityManager->flush();                
        return $this->redirectToRoute('bhp_index');            
    }

    #[Route('/bhp/edit/{bhp_id}', name: 'bhp_edit')]
    public function edit(EntityManagerInterface $entityManager, $bhp_id): Response
    {
        $bhp = $entityManager->getRepository(BHP::class)->find($bhp_id);
        $participants = $bhp->getBHPParticipants();
        return $this->render('bhp/edit.html.twig', [
            'bhp' => $bhp,
            'participants' => $participants,
        ]);
    }            

    #[Route('/bhp/update/{bhp_id}', name: 'bhp_update')]
    public function update(EntityManagerInterface $entityManager, Request $request, $bhp_id): Response
    {        
        $bhp = $entityManager->getRepository(BHP::class)->find($bhp_id);
        $bhp->setName($request->request->get('name'));                
        $participants_size = $bhp->getBHPParticipants()->count();
        for($i=0; $request->request->get('participant_name_'.$i); ++$i) {
            if($i < $participants_size) {
                $participant = $bhp->getBHPParticipants()->get($i);
                $participant->setName($request->request->get('participant_name_'.$i));            
                $participant->setCompany($request->request->get('participant_company_'.$i));
            } else {
                $participant = new BHPParticipant();
                $participant->setName($request->request->get('participant_name_'.$i));            
                $participant->setCompany($request->request->get('participant_company_'.$i));
                $entityManager->persist($participant);
                $bhp->addBHPParticipant($participant);
            }
        }
        $entityManager->persist($bhp);
        $entityManager->flush();                
        return $this->redirectToRoute('bhp_edit', ['bhp_id' => $bhp->getId()]);            
    }            

    #[Route('/bhp/delete/{bhp_id}', name: 'bhp_delete')]
    public function delete(EntityManagerInterface $entityManager, $bhp_id): Response
    {
        $bhp = $entityManager->getRepository(BHP::class)->find($bhp_id);
        $entityManager->remove($bhp);
        $entityManager->flush();
        return $this->redirectToRoute('bhp_index');
    }

    #[Route('/bhp/save_signature', name: 'bhp_save_signature')]
    public function signature(EntityManagerInterface $entityManager, Request $request): Response
    {                
        $participant_id = $request->request->get('participant_id');
        $participant_id = intval($participant_id);
        $participant = $entityManager->getRepository(BHPParticipant::class)->find($participant_id);                                

        // save signature as text in db
        $participant->setSignature($request->request->get('signature'));
        // or decode and save as image
        // $encoded_image = explode(",", $request->request->get('signature'))[1];
        // $decoded_image = base64_decode($encoded_image);        
        // $file_name = 'signature_'.$participant_id.'.svg';
        

        $entityManager->persist($participant);
        $entityManager->flush();
        $bhp = $participant->getBHP();                                            
        return $this->redirectToRoute('bhp_edit', ['bhp_id' => $bhp->getId()]);            
    }
}
