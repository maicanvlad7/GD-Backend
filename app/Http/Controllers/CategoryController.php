<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Host;
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

        if($category->courses) {
            foreach($category->courses as $cc) {
                $cc->host = Host::where('id', $cc->host)->first();
            }
        }

        if($category) {
            return response()->json([
                "success" => true,
                "message" => "Am gasit categoria",
                "category" => $category,
                "courses" => $category->courses
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
