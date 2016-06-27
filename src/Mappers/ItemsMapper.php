<?php

namespace Badou\Parser\Mappers;

use App\Models\CatalogItem;
use App\Models\CatalogCategory;

class ItemsMapper implements ItemsMapperInterface
{
    protected $model;

    public function __construct(CatalogItem $item)
    {
        $this->model = $item;
    }

    public function parse($import)
    {
        $this->model->truncate();
        foreach($import->Каталог->Товары->Товар as $item) {
            $categoryItem = CatalogCategory::where('code', $item->Группы->Ид)->first();

            $this->model->create([
                'title' => $item->Наименование,
                'category_id' => $categoryItem->id,
                'code' => $item->Ид,
                'published' => 1,
            ]);
        }
    }
}
