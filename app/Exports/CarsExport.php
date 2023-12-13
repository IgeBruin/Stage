<?php

namespace App\Exports;

use App\Models\Car;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CarsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $cars = Car::with('specifications')->get();

        $formattedData = $cars->map(function ($car) {
            return [
                'id' => $car->id,
                'title' => $car->title,
                'brand_id' => $car->brand_id,
                'type_id' => $car->type_id,
                'fuel_id' => $car->fuel_id,
                'description' => $car->description,
                'year' => $car->year,
                'mileage' => $car->mileage,
                'mot' => $car->mot,
                'price' => $car->price,
                'user_id' => $car->user_id,
                'created_at' => $car->created_at,
                'updated_at' => $car->updated_at,
                'specification_name' => $car->specifications->pluck('name')->toArray(),
                'specification_value' => $car->specifications->pluck('pivot.value')->toArray(),
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        return [
            'id',
            'title',
            'brand_id',
            'type_id',
            'fuel_id',
            'description',
            'year',
            'mileage',
            'mot',
            'price',
            'user_id',
            'created_at',
            'updated_at',
            'specification_name',
            'specification_value',
        ];
    }
}
