<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function get() {
        $articles = Article::get();
        return response()->json(
            [
                "status" => true,
                "data" => [
                    "articles" => $articles
                ],
                "message" => "Articles found"
            ]
        );
    }

    public function save(Request $request) {
        $this->validate(
            $request,
            [
                "name" => "required",
                "description" => "required",
                "header_image" => "required|image"
            ]
        );


        $headerFile = $request->file("header_image");
        $imageName =  Carbon::now()->timestamp . "." . $headerFile->extension();
        $path = "articles\\";
        $headerFile->storeAs($path, $imageName, ["disk" => "public"]);        

        $article = Article::create(
            [
                "name" => $request->name,
                "description" => $request->description,
                "header_image" => $imageName
            ]
        );

        return response()->json(
            [
                "status" => true,
                "data" => [
                    "article" => $article
                ],
                "message" => "Article has been created successfully"
            ]
        );
    }

    public function update(Request $request, $id) {
        $this->validate(
            $request,
            [
                "name" => "required",
                "description" => "required",
            ]
        );

        $article = Article::find($id);

        if ($article == null)
        return response()->json([
            "status" => false,
            "data" => [],
            "message" => "Can't find the article for update"
        ]);

        $article->update(
            [
                "name" => $request->name,
                "description" => $request->description,
            ]
        );

        return response()->json(
            [
                "status" => true,
                "data" => [
                    "article" => $article
                ],
                "message" => "Article has been updated successfully"
            ]
        );
    }

}
