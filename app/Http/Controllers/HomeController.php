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
        $school_levels = SchoolLevel::all();
        $curricula = Curriculum::withCount(['schools'])->get();
        $county = County::withCount('schools')->get();
        $news_articles = NewsArticle::all();

        // Retrieve total school counts per school type by name
        $schoolLevelCounts = SchoolLevel::whereIn('name', ['Nursery', 'Primary', 'Secondary', 'College'])
            ->withCount('schools')
            ->get()
            ->pluck('schools_count', 'name')
            ->mapWithKeys(function ($count, $name) {
                return [strtolower($name) => $count];
            });
        // dd($curricula);

        // Add individual keys to data array
        // $data = array_merge($data, $schoolLevelCounts->toArray());
        
        return view('home.index')->with([
            'school_levels' => $school_levels,
            'curricula' => $curricula,
            'county' => $county,
            'news_articles' => $news_articles,
            'schoolLevelCounts' => $schoolLevelCounts
        ]);
    }
}
