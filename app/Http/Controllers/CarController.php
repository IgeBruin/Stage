<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarUpdateValidation;
use App\Http\Requests\CarStoreValidation;
use App\Http\Requests\CarSpecificationsValidation;
use App\Http\Requests\ContactStoreValidation;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Brand;
use App\Models\Type;
use App\Models\Fuel;
use App\Models\User;
use App\Models\Specification;
use App\Models\CarSpecification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Exports\CarsExport;
use App\Imports\CarsImport;
use Maatwebsite\Excel\Facades\Excel;

class CarController extends Controller
{
    public function overview()
    {
        $cars = Car::all();
        return view("cars.overview", compact('cars'));
    }

    public function index()
    {
        $cars = Car::orderBy('created_at', 'desc')->paginate(5);
        return view("cars.index", compact('cars'));
    }

    public function create()
    {
        $cars = Car::get();
        $brands = Brand::all();
        $types = Type::all();
        $fuels = Fuel::all();
        return view("cars.create", compact('cars', 'brands', 'types', 'fuels'));
    }

    public function store(CarStoreValidation $request)
    {
        $car = new Car();
        $car->title = $request->title;
        $car->description = $request->description;
        $car->brand_id = $request->brand_id;
        $car->type_id = $request->type_id;
        $car->fuel_id = $request->fuel_id;
        $car->year = $request->year;
        $car->mileage = $request->mileage;
        $car->mot = $request->mot;
        $car->price = $request->price;
        $car->user_id = auth()->user()->id;
        $car->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $car->id . '_' .  $image->getClientOriginalName();
                $image->storeAs('cars/' . $car->id, $imageName);

                $car->images()->create([
                    'image' => $imageName,
                ]);
            }
        }

        return redirect()->route("dashboard.cars.index")->with('success', 'Auto aangemaakt');
    }



    public function edit(Car $car)
    {
        $car = Car::with('images')->find($car->id);
        $brands = Brand::all();
        $types = Type::all();
        $fuels = Fuel::all();
        $specifications = Specification::all();
        return view("cars.edit", compact('car', 'brands', 'types', 'specifications', 'fuels'));
    }

    public function update(CarUpdateValidation $request, Car $car)
    {
        $car->title = $request->title;
        $car->description = $request->description;
        $car->brand_id = $request->brand_id;
        $car->type_id = $request->type_id;
        $car->fuel_id = $request->fuel_id;
        $car->year = $request->year;
        $car->mileage = $request->mileage;
        $car->mot = $request->mot;
        $car->price = $request->price;
        $car->user_id = auth()->user()->id;
        $car->save();


        if ($request->has('remove_images')) {
            $removedImages = $request->remove_images;

            if (!empty($removedImages)) {
                foreach ($removedImages as $imageId) {
                    $carImage = CarImage::find($imageId);

                    if ($carImage) {
                        $imagePath = "cars/{$car->id}/" . $carImage->image;
                        Storage::delete($imagePath);

                        $carImage->delete();
                    }
                }
            }
        }


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $car->id . '_' . $image->getClientOriginalName();
                $image->storeAs('cars/' . $car->id, $imageName);

                $car->images()->create([
                    'image' => $imageName,
                ]);
            }
        }


        return redirect()->route("dashboard.cars.index")->with('success', 'Auto aangepast');
    }


    public function destroy(Car $car)
    {
        Storage::deleteDirectory("cars/{$car->id}");
        $car->delete();

        return redirect(route("dashboard.cars.index"))->with('success', 'Auto verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $cars = Car::where('title', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("cars.index", ["cars" => $cars]);
    }
    
    public function saveSpecifications(CarSpecificationsValidation $request, Car $car)
    {
        $specifications = $request->input('specifications');

        foreach ($specifications as $specificationId => $value) {
            if ($value === null || $value === '') {
                $existingCarSpecification = CarSpecification::where('car_id', $car->id)
                    ->where('specification_id', $specificationId)->first();

                if ($existingCarSpecification) {
                    $existingCarSpecification->delete();
                }
                continue;
            }

            $existingCarSpecification = CarSpecification::where('car_id', $car->id)
                ->where('specification_id', $specificationId)->first();

            if ($existingCarSpecification) {
                $existingCarSpecification->update(['value' => $value]);
            } else {
                CarSpecification::create([
                    'car_id' => $car->id,
                    'specification_id' => $specificationId,
                    'value' => $value,
                ]);
            }
        }

        return redirect()->route('dashboard.cars.index')->with('success', 'Specificaties opgeslagen');
    }

    public function contactStore(ContactStoreValidation $request)
    {
        $carId = $request->input('car_id');
        $car = Car::findOrFail($carId);
        $carOwnerEmail = $car->user->email;

        Mail::to($carOwnerEmail)->send(new ContactMail([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
            'recipient' => 'owner',
            'car' => $car,
        ]));

        return redirect()->route('showCar', compact('car'))->with('success', 'Je reactie is verstuurd');
    }

    public function images(Request $request, Car $car)
    {
        if ($request->has('remove_images')) {
            $removedImages = $request->remove_images;

            if (!empty($removedImages)) {
                foreach ($removedImages as $imageId) {
                    $carImage = CarImage::find($imageId);

                    if ($carImage) {
                        $imagePath = "cars/{$car->id}/" . $carImage->image;
                        Storage::delete($imagePath);

                        $carImage->delete();
                    }
                }
            }
        }


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $car->id . '_' . $image->getClientOriginalName();
                $image->storeAs('cars/' . $car->id, $imageName);

                $car->images()->create([
                    'image' => $imageName,
                ]);
            }
        }
        return redirect()->route("dashboard.cars.index")->with('success', "Foto's aangepast");
    }

    public function carsExport()
    {
        return Excel::download(new CarsExport(), 'cars.csv');
    }

    public function carsImport()
    {
        Excel::import(new carsImport, request()->file('file'));
        return redirect()->route("dashboard.cars.index")->with('success', 'Auto\'s geimporteerd');
    }
}
