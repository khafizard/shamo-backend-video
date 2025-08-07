<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = ProductCategory::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '<a class="inline-block px-2 py-1 m-1 text-white transition duration-500 bg-gray-700 border border-gray-700 rounded-md select-none ease hover:bg-gray-800 focus:outline-none focus:shadow-outline" href="' . route('dashboard.category.edit', $item->id) . '">Edit</a>
                    <form action="' . route('dashboard.category.destroy', $item->id) . '" method="POST" class="inline-block">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="inline-block px-2 py-1 m-1 text-white transition duration-500 bg-red-700 border border-red-700 rounded-md select-none ease hover:bg-red-800 focus:outline-none focus:shadow-outline">Hapus</button>
                    ';
                })
                ->rawColumns(['action']) // WAJIB: agar HTML dirender
                ->make();
        }

        return view('pages.dashboard.category.index');
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request)
    {
        $data = $request->all();
        ProductCategory::create($data);

        return redirect()->route('dashboard.category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category)
    {
        return view('pages.dashboard.category.edit', [
            'item' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        $data = $request->all();
        $category->update($data);

        return redirect()->route('dashboard.category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return redirect()->route('dashboard.category.index')->with('success', 'Category deleted successfully.');
    }
}
