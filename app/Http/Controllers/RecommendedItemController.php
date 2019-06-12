<?php

namespace App\Http\Controllers;

use App\EntityFactory;

class RecommendedItemController extends Controller
{
    protected $entityFactory;

    /**
     * RecommendedItemController constructor.
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

        $items = $entity->getRecommended();

        return $items;
    }
}
