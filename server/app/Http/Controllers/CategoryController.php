<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show'],
        ]);

        $this->middleware("role.admin", [
            "except" => ["index", "show"],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $qlimit = $request->query('limit', '');
        $qSearch = $request->query('search', '');
        $categories = Category::search($qSearch)
            ->latest()
            ->select(["id", "name"])
            ->paginate($qlimit ?? 15)
            ->withQueryString()
            ->onEachSide(1);

        return $this->httpOkResponse("Success get all category", compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
        ]);

        $category = Category::create($validated);

        return $this->httpOkResponse("Category created", compact("category"), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load("products");
        return $this->httpOkResponse("Success get category", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
        ]);

        $category->update($validated);

        return $this->httpOkResponse("Category updated", compact("category"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->httpOkResponse("Category deleted");
    }
}
