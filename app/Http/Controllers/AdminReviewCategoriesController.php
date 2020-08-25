<?php

namespace App\Http\Controllers;

use App\Image;
use App\ReviewCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminReviewCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = ReviewCategory::where('deleted',0)->get();
        return view('admin.review-categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     * @throws FileException
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required|string|max:255',
            'url_en_name'=>'required|string|max:255',
            'image' => 'image|max:200',
            'has_parent' => 'integer|required',
            'parent_id' => 'integer',
        ];

        $messages=[

        ];

        $this->validate($request,$rules,$messages);

        $request['url_en_name']=strtolower($request['url_en_name']);
        $request['url_en_name'] = preg_replace('/\s+/', '_', $request['url_en_name']);

        $input=$request->all();

        if ($input['has_parent'] == 0){
            $input['is_parent'] = 1;
        }else{
            $parentCategory=ReviewCategory::findOrFail($input['parent_id']);
            $parentCategory->update(['is_parent'=>1]);
        }

        if ($file = $request->file('image')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images',$name);
            $image = Image::Create(['path'=>$name]);
            $input['image_id']=$image->id;
        }

        ReviewCategory::create($input);
        return redirect(route('category.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $category=ReviewCategory::findOrFail($id);
        $categories=ReviewCategory::all()->pluck('name','id');
        return view('admin.review-categories.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws FileException
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $category=ReviewCategory::findOrFail($id);
        $rules=[
            'name'=>'required|string|max:255',
            'url_en_name'=>'required|string|max:255',
            'image' => 'image|max:200',
        ];

        $messages=[

        ];

        $this->validate($request,$rules,$messages);

        $request['url_en_name']=strtolower($request['url_en_name']);
        $request['url_en_name'] = preg_replace('/\s+/', '_', $request['url_en_name']);

        $input=$request->all();

        if ($file = $request->file('image')){

            if ($category->image) {
                if (file_exists(public_path() . $category->image->path)) {unlink(public_path() . $category->image->path);}
                $category->image->delete();
            }
            $name = time() . $file->getClientOriginalName();
            $file->move('images',$name);
            $image = Image::create(['path'=>$name]);
            $input['image_id']=$image->id;
        }

        $category->update($input);
        return redirect(route('category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
