<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\County;
use App\Models\Curriculum;
use App\Models\NewsArticle;
use App\Models\SchoolLevel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $school_levels = SchoolLevel::all();
        $curricula = Curriculum::withCount(['schools'])->get();
        $county = County::withCount('schools')->get();
        $news_articles = NewsArticle::all();
        $twoLeft  = Advert::where('slot','two_left')->where('is_active',1)->first();
        $twoRight = Advert::where('slot','two_right')->where('is_active',1)->first();
        $single   = Advert::where('slot','single')->where('is_active',1)->first();

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
            'schoolLevelCounts' => $schoolLevelCounts,
            'twoLeft' => $twoLeft,
            'twoRight' => $twoRight,
            'single' => $single,
        ]);
    }
}
