<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use App\Models\ProductsFiltersValue;
use App\Models\Section;
use Session;
use DB;

class FilterController extends Controller
{
    public function filters(){
        Session::put('page','filters');
        $filters =ProductsFilter::get()->toArray();
        //dd($filters);
        return view('admin.filters.filters')->with(compact('filters'));
    }

    public function filtersValues(){
        Session::put('page','filters');
        $filters_values =ProductsFiltersValue::get()->toArray();
        //dd($filters);
        return view('admin.filters.filters_values')->with(compact('filters_values'));
    }

    public function updateFilterStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsFilter::where('id',$data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }

    public function updateFilterValueStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsFiltersValue::where('id',$data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }

    public function addEditFilter(Request $request,$id=null){
        Session::put('page','filters');
        if($id==""){
            $title = "Thêm cột bộ lọc";
            $filter = new ProductsFilter;
            $message = "Thêm cột bộ lọc thành công !";
        }else{
            $title = "Sửa cột bộ lọc";
            $filter = ProductsFilter::find($id);
            $message = "Sửa cột bộ lọc thành công !";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $cat_ids =implode(',',$data['cat_ids']);
            //save filter
            $filter->cat_ids =$cat_ids;
            $filter->filter_name=$data['filter_name'];
            $filter->filter_column=$data['filter_column'];
            $filter->status =1;
            $filter->save();
            //add in product table
            DB::statement('ALTER TABLE products ADD '.$data['filter_column'].' VARCHAR(255) AFTER description');


            return redirect('admin/filters')->with('success_message',$message);

        }

        $categories = Section::with('categories')->get()->toArray();

        return view('admin.filters.add_edit_filter')->with(compact('title','categories','filter'));
    }

    public function addEditFilterValue(Request $request,$id=null){
        Session::put('page','filters');
        if($id==""){
            $title = "Thêm giá trị bộ lọc";
            $filter = new ProductsFiltersValue;
            $message = "Thêm giá trị bộ lọc thành công !";
        }else{
            $title = "Sửa giá trị bộ lọc";
            $filter = ProductsFiltersValue::find($id);
            $message = "Sửa giá trị bộ lọc thành công !";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

         
            //save filter
       
            $filter->filter_id=$data['filter_id'];
            $filter->filter_value=$data['filter_value'];
            $filter->status =1;
            $filter->save();
            //add in product table
            return redirect('admin/filters-values')->with('success_message',$message);

        }
        //get filters
        $filters = ProductsFilter::where('status',1)->get()->toArray();

        return view('admin.filters.add_edit_filter_value')->with(compact('title','filter','filters'));
    }

    public function categoryFilters(Request $request){
        if($request->ajax()){
            $data=$request->all();
            //echo "<pre>"; print_r($data);die;
            $category_id =$data['category_id'];
            return response()->json([
                'view'=>(String)View::make('admin.filters.category_filters')->with(compact('category_id'))
            ]);
        }
    }
}
