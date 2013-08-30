<?php

/**
 * This file is part of the planetubuntu project.
 *
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Desarrolla2\Bundle\BlogBundle\Form\Frontend\Type\SearchType;
use Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model\SearchModel;

/**
 *
 * Description of SearchController
 *
 */
class SearchController extends Controller
{
    /**
     * @Route("/search", name="_search")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $items = array();
        $form = $this->createForm(new SearchType(), new SearchModel());
        if ($request->query->has('q')) {
            $form->submit($request);
            if ($form->isValid()) {
                $query = $form->getData()->getQuery();
                $search = $this->get('blog.search');
                $items = $search->search(
                    $query,
                    $request->query->get('page', 1)
                );
            }
        }

        return array(
            'form' => $form->createView(),
            'items' => $items,
            'query' => $query
        );
    }

}
