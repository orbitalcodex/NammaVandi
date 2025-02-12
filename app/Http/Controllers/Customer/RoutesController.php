<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Bikes;
use App\Models\Blogs;
use App\Models\Cars;
use App\Models\Fundamentals;
use App\Models\Reviews;
use Illuminate\Http\Request;

class RoutesController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function index()
    {
        $blogs = Blogs::latest()->take(4)->get(); // Get latest 4 blogs

        $bikes = Bikes::where('bike_type', 'Scooty')->take(2)
            ->union(Bikes::where('bike_type', 'Gear')->take(2))
            ->get(); // Get 2 Scooty and 2 Gear bikes

        $cars = Cars::whereIn('car_type', ['5-seater', '7-seater'])
            ->orderBy('car_model', 'desc') // Get latest models first
            ->orderBy('car_id', 'desc') // Ensures latest entries if same model_year
            ->get()
            ->groupBy('car_type')
            ->map(fn($group) => $group->take(2))
            ->flatten();


        $reviews = [
            [
                'name' => 'Arun Kumar',
                'location' => 'Avinashi',
                'thoughts' => 'The car’s mileage is exceptional and very budget-friendly for long drives.',
                'ratings' => 5
            ],
            [
                'name' => 'Priya Shankar',
                'location' => 'Udumalpet',
                'thoughts' => 'Comfortable seating and ample storage space, perfect for family trips.',
                'ratings' => 5
            ],
            [
                'name' => 'Vignesh Raj',
                'location' => 'Palladam',
                'thoughts' => 'Smooth driving experience and good performance even on rough roads.',
                'ratings' => 5
            ],
            [
                'name' => 'Deepa Natarajan',
                'location' => 'Dharapuram',
                'thoughts' => 'Highly recommend this car for its modern design and fuel efficiency.',
                'ratings' => 5
            ]
        ];

        $fundamentals = Fundamentals::first();
        return view('Customer.index', compact('blogs', 'bikes', 'cars', 'reviews', 'fundamentals'));
    }

    public function contact()
    {
        return view('Customer.contact');
    }

    public function blogs()
    {
        $blogs = Blogs::all();
        return view('Customer.Blogs.index', compact('blogs'));
    }

    public function showblog($id)
    {
        $blog = Blogs::findOrFail($id);
        $recentBlogs = Blogs::latest()->where('id', '!=', $id)->get();
        return view('Customer.Blogs.show', compact('blog', 'recentBlogs'));
    }

    public function bikes()
    {
        $bikes = Bikes::all();
        return view('Customer.Bikes.index', compact('bikes'));
    }

    public function showbike($id)
    {
        $bike = Bikes::with('bikeDetails')->findOrFail($id);
        $bikeImages = json_decode($bike->bikeDetails->bike_images, true);

        $biketype = $bike->bike_type;
        $relatedBikes = Bikes::where('bike_type', $biketype)->where('id', '!=', $id)->get();

        $fundamentals = Fundamentals::first();

        return view('Customer.Bikes.show', compact('bike', 'bikeImages', 'relatedBikes', 'fundamentals'));
    }

    public function cars()
    {
        $cars = Cars::all();
        return view('Customer.Cars.index', compact('cars'));
    }

    public function showcar($id)
    {
        $car = Cars::with('carDetails')->findOrFail($id);

        $carImages = json_decode($car->carDetails->car_images, true);

        $cartype = $car->car_type;
        $relatedCars = Cars::where('car_type', $cartype)->where('id', '!=', $id)->get();

        $fundamentals = Fundamentals::first();

        return view('Customer.Cars.show', compact('car', 'carImages', 'relatedCars', 'fundamentals'));
    }

    public function filtercars(Request $request)
    {
        $type = $request->query('type');


        if ($type === 'all' || empty($type)) {
            $cars = Cars::all();
        } else {
            $cars = Cars::where('car_type', $type)->get();
        }

        return response()->json($cars);
    }

    public function filterbikes(Request $request)
    {
        $type = $request->query('type');


        if ($type === 'all' || empty($type)) {
            $bikes = Bikes::all();
        } else {
            $bikes = Bikes::where('bike_type', $type)->get();
        }

        return response()->json($bikes);
    }
}
