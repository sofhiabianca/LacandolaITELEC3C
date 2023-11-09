<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::latest()->paginate('5');
        return view('admin.category.category', compact('categories'));
    }

    public function AddCat(Request $request){
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ]);

        Category::create([
            'category_name'=> $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }

    public function Edit($id){
        $categories = Category::find($id);
        return view('admin.category.edit', compact('categories'));
    }

    public function Update(Request $request, $id){
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        return Redirect()->route('AllCat')->with('success', 'Update Successfully');
    }

    public function Delete($id){
        $category = Category::find($id);
        $category->delete();

        return Redirect()->back();
    }
}
