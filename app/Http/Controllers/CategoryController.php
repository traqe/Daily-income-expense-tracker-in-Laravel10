<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(){
        $user = Auth::user();
        
        $categories= Category::where('user_id',$user->id)->paginate(10);

        $category = Category::where('user_id',$user->id)->get();
        $categoryCount = count($category);
        return view('frontend.category.index',compact('categories','categoryCount'));
    }

    public function create(){
        return view('frontend.category.create');
    }

    public function store(Request $request){
       $data = $request->validate([
            "name"=>"required"
        ]);

        $user = Auth::user();
        Category::create([
            "name"=>$data['name'],
            "user_id"=>$user->id,
        ]);
        
        return redirect()->route('categories');
    }

    public function edit($id){
        $category = Category::find($id);
        return view('frontend.category.edit',compact('category'));
    }

    public function update(Request $request, $id){ 
        $data =$request->validate([
            "name"=>"required"
        ]);

        $category = Category::find($id);
        $category->name = $data['name'];
        $category->save();

        if($category->save()){
            return redirect()->route('categories');
        }
    }

    public function delete($id){
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories');
    }

    public function viewTransaction($id){
        $transactions = Transaction::where('category_id',$id)->latest()->get();
        $category = Category::find($id);
        return view('frontend.category.view-transaction',compact('transactions','category'));
    }
}
