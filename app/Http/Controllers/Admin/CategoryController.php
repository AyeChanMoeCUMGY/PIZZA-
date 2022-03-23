<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct add category page
    public function addCategory() {
        return view('admin.category.addCategory');
    }

    public function createCategory(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back( )
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = [
            'category_name' => $request->name
        ];

        Category::create($data);

        return redirect()->route('admin#category')->with(['categorySuccess' => 'Category Added...']);
    }


    //direct Catgeory
    public function category() {

        if(Session::has('CATEGORY_SEARCH')){
            Session::forget('CATEGORY_SEARCH');
        }

        // $response = Category::distinct()->get();
        $data = Category::select('categories.*' , DB::raw('COUNT(pizzas.category_id) as count'))
                        ->leftJoin('pizzas' , 'pizzas.category_id' , 'categories.category_id')
                        ->groupBy('categories.category_id')
                        ->paginate(7) ;

        // dd($data->toArray());
        return view('admin.category.list')->with(['category' => $data]);
    }

    //delete Category
    public function deleteCategory($id) {
       Category::where('category_id' , $id )->delete();
       return back()->with(['deleteSuccess' => 'Category Deleted....']);
    }

    //edit category
    public function editCategory($id){
        $data =  Category::where('category_id' , $id )->first();

        return view('admin.category.update')->with(['category' => $data ]);
    }

    // update Category
    public function updateCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back( )
                        ->withErrors($validator)
                        ->withInput();
        }

        $updateData = [
            'category_name' => $request->name
        ];

        Category::where('category_id' , $request->id)->update($updateData);
        return redirect()->route('admin#category')->with(['updateSuccess'=> 'Category Updated...']);

    }

      //search Category
    // 'category_name','like','%ay%'
    public function searchCategory(Request $request){

        $data = Category::select('categories.*' , DB::raw('COUNT(pizzas.category_id) as count'))
        ->leftJoin('pizzas' , 'pizzas.category_id' , 'categories.category_id')
        ->where('categories.category_name' , 'like' , '%' . $request->searchData . '%')
        ->groupBy('categories.category_id')
        ->paginate(7) ;

        Session::put('CATEGORY_SEARCH' , $request->searchData );

        $data->appends($request->all());
        return view('admin.category.list')->with(['category'=>$data]);

    }

    // category Download
    public function categoryDownload(){
        // $category = Category::get();        //data get

        if(Session::has('CATEGORY_SEARCH')){

            $category = Category::select('categories.*' , DB::raw('COUNT(pizzas.category_id) as count'))
            ->leftJoin('pizzas' , 'pizzas.category_id' , 'categories.category_id')
            ->where('categories.category_name' , 'like' , '%' . Session::get('CATEGORY_SEARCH') . '%')
            ->groupBy('categories.category_id')
            ->get() ;


        }else{

            $category = Category::select('categories.*' , DB::raw('COUNT(pizzas.category_id) as count'))
                                ->leftJoin('pizzas' , 'pizzas.category_id' , 'categories.category_id')
                                ->groupBy('categories.category_id')
                                ->get() ;

        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build ( $category, [
                'category_id' => 'ID',
                'category_name' => 'Name',
                'count'         => 'Product Count' ,
                'created_at' => 'Created at',
                'updated_at' => 'Update at',
            ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'categoryList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

}
