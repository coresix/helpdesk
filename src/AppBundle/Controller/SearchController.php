<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Ticket\Ticket;
use AppBundle\ResourceId\ResourceIdResolver;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SearchController extends Controller
{

    /**
     * {@inheritdoc}
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $value = $request->get('value');

        if (($redirect = $this->redirectViewHumanIdEntity($value)) instanceof RedirectResponse) {
            return $redirect;
        }



        throw $this->createNotFoundException();
    }

    /**
     * @param $value
     * @return bool|RedirectResponse
     */
    protected function redirectViewHumanIdEntity($value)
    {
        /** @var ResourceIdResolver $humanIdHelper */
        $humanIdHelper = $this->get('app.utils.human_id_helper');

        if ($humanIdHelper->isValidResourceId($value)) {
            switch ($humanIdHelper->getEntityTypeFromResourceId($value)){
                case Ticket::class:
                    return $this->redirectToRoute('view_ticket', ['id' => $value]);

            }
        }

        return false;
    }
}