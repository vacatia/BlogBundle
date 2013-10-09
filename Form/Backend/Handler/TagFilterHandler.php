<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of TagFilterHandler
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @file : PostHandler.php , UTF-8
 * @date : Aug 22, 2012 , 5:03:37 PM
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;

class TagFilterHandler
{

    /**
     * @var  \Symfony\Component\Form\Form
     */
    protected $form;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qb;

    /**
     *
     * @param \Symfony\Component\Form\Form              $form
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\QueryBuilder                $qb
     */
    public function __construct(Form $form, Request $request, QueryBuilder $qb)
    {
        $this->form = $form;
        $this->request = $request;
        $this->qb = $qb;
    }

    /**
     *
     * @return boolean
     */
    public function process()
    {
        $this->form->submit($this->request);
        if ($this->form->isValid()) {
            $formData = $this->form->getData();
            if ($name = (string) $formData->name) {
                $this->qb->andWhere($this->qb->expr()->like('t.name', ':name'))
                        ->setParameter('name', '%' . $name . '%');
            }

            return true;
        }

        return false;
    }

    /**
     *
     * @return \Symfony\Component\Form\Form
     */
    public function getFilter()
    {
        return $this->form;
    }

    /**
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQuery()
    {
        return $this->qb->getQuery();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->form->getData();
    }

}
