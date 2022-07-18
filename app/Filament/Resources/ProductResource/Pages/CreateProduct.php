<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void {
        $category = $this->record->categories()->first();
        $this->record->update([
            'product_code' => $category->category_code.'-0'.$this->record['id']
        ]);
    }
}
