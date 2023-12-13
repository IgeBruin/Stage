<?php

namespace App\Imports;

use App\Models\Car;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CarsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public function model(array $row)
    {
        $user = auth()->id();

        $existingCar = Car::where([
        'title' => $row['title'],
        'brand_id' => $row['brand_id'],
        'type_id' => $row['type_id'],
        'fuel_id' => $row['fuel_id'],
        ])->first();

        if ($existingCar) {
            return null;
        }

        $car = new Car([
        'title' => $row['title'],
        'brand_id' => $row['brand_id'],
        'type_id' => $row['type_id'],
        'fuel_id' => $row['fuel_id'],
        'description' => $row['description'],
        'year' => $row['year'],
        'mileage' => $row['mileage'],
        'mot' => $row['mot'],
        'price' => $row['price'],
        'user_id' => $user,
        ]);

        $car->save();

        return $car;
    }
}
