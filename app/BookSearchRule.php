<?php

namespace App;

use ScoutElastic\SearchRule;

class BookSearchRule extends SearchRule
{
    public function buildQueryPayload()
    {
        $query = $this->builder->query;

        return [
            'should' => [
                [
                    'match' => [
                        'title' => [
                            'query' => $query,
                            'boost' => 3
                        ]
                    ]
                ],
                [
                    'match' => [
                        'isbn' => [
                            'query' => $query,
                            'boost' => 2
                        ]
                    ]
                ],
                [
                    'match' => [
                        'description' => [
                            'query' => $query,
                            'boost' => 1
                        ]
                    ]
                ],
                [
                    'match' => [
                        'publication_year' => [
                            'query' => $query,
                            'boost' => 1
                        ]
                    ]
                ]
            ]
        ];
    }
}