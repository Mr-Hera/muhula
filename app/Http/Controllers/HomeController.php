<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\Curriculum;
use App\Models\SchoolLevel;
use App\Models\NewsArticle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['school_levels'] = SchoolLevel::all();
        $data['curricula'] = Curriculum::all();
        $data['county'] = County::all();
        $data['news_articles'] = NewsArticle::all();

        // Retrieve total school counts per school type by name
        $schoolLevelCounts = SchoolLevel::whereIn('name', ['Nursery', 'Primary', 'Secondary', 'College'])
            ->withCount('schools')
            ->get()
            ->pluck('schools_count', 'name')
            ->mapWithKeys(function ($count, $name) {
                return [strtolower($name) => $count];
            });
        // dd($data["school_levels"]);

        // Add individual keys to data array
        $data = array_merge($data, $schoolLevelCounts->toArray());
        
        return view('home.index')->with([$data, $schoolLevelCounts]);
    }
}
