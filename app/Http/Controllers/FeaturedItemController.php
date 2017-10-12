<?php

namespace App\Http\Controllers;

use App\EntityFactory;

class FeaturedItemController extends Controller
{
    protected $entityFactory;

    /**
     * FeaturedController constructor.
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

        $items = $entity->getFeatured();

        return $items;
    }
}
