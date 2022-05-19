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
        $category =  Category::where(DB::raw('lower(name)'), str_replace('-',' ', $slug))->with('courses')->first();

        if($category->courses) {
            foreach($category->courses as $cc) {
                $cc->host = Host::where('id', $cc->host)->first();
            }
        }

//        @TODO adaugare logica sa aducem si host pe curs
//        foreach($category->courses as $key => $c) {
//            $category->courses[$key] = Course::where('id', $c->id)->with()
//        }
        



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
}
