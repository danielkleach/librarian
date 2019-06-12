<?php

namespace App\Http\Controllers;


use App\EntityFactory;

class NewItemController extends Controller
{
    protected $entityFactory;

    /**
     * NewItemController constructor.
     *
     * @param EntityFactory $entityFactory
     */
    public function __construct(EntityFactory $entityFactory)
    {
        $this->entityFactory = $entityFactory;
    }

    public function index($itemType)
    {
        $entity = $this->entityFactory->translate($itemType);

        $items = $entity->getNew();

        return $items;
    }
}
