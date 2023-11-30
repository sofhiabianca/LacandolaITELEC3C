<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::latest()->paginate('5');
        $trashCat = Category::onlyTrashed()->latest()->paginate('5');
        return view('admin.category.category', compact('categories', 'trashCat'));
    }

    public function AddCat(Request $request) {

        $validated = $request->validate([
            'category_name' => 'required|max:255',
        ]);

        Category::create([

            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);


        return redirect()->back()->with('success','Category Inserted Successfully');
    }

    
public function Edit($id){

    $categories = Category::find($id);
    return view('admin.category.edit', compact('categories'));

}

public function Update(Request $request, $id) {

    $update = Category::find($id)->update([
        'category_name'=> $request->category_name,
        'user_id' => Auth::user()->id
    ]);

    return Redirect()->route('AllCat')->with('success', 'Updated Successfully');
}


public function RemoveCat($id){

    $remove = Category::find($id)->delete();
    return redirect()->back()->with('success','Category Removed Successfully');
}

public function RestoreCat($id){

    $restore = Category::withTrashed()->find($id)->restore();
    return redirect()->back()->with('success','Category Restored Successfully');
}

public function DeleteCat($id){

    $delete = Category::onlyTrashed()->find($id)->forceDelete();
    return redirect()->back()->with('success','Category Deleted Successfully');
}


}