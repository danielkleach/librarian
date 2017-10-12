<?php

namespace App\Http\Controllers;

use App\EntityFactory;

class PopularItemController extends Controller
{
    protected $entityFactory;

    /**
     * PopularItemController constructor.
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

        $items = $entity->getPopular();

        return $items;
    }
}
