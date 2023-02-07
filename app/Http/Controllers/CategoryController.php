<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Host;
use App\Models\secondary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //

    public function getCoursesByCategorySlug($slug)
    {
        $category =  Category::where('slug', $slug)->with(['courses' => function($query) {
            $query->orderBy('score', 'desc');
        }])->first();

        if($category->id) {
            $secondaries = secondary::where('id_category',$category->id)->with('course')->get();

            foreach($secondaries as $s) {
                $category->courses->push($s->course);
            }
        }

        if($category->courses) {
            foreach($category->courses as $cc) {
                if($cc->host){
                    $cc->host = Host::where('id', $cc->host)->first();
                }
            }
        }

        $unsorted = collect($category->courses);
        $sorted = $unsorted->sortByDesc('score')->values()->all();

        if($category) {
            return response()->json([
                "success" => true,
                "message" => "Am gasit categoria",
                "category" => $category,
                "courses" => $sorted
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Categoria nu exista"
            ], 200);
        }

    }

    public function getAllCategories()
    {
        $categories = Category::all();

        return response()->json([
            "success" => true,
            "message" => "Fetched categories",
            "categories" => $categories,
        ], 200);
    }
}
