<?php

namespace App\Http\Controllers;

use App\Image;
use App\Review;
use App\ReviewCategory;
use App\ReviewWriter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reviews = Review::orderBy('id','desc')->get();
        return view('admin.reviews.index',compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = ReviewCategory::where('deleted',0)->get();
        $writers = ReviewWriter::where('deleted',0)->get();
        return view('admin.reviews.create',compact('categories','writers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     * @throws FileException
     */
    public function store(Request $request)
    {
        $rules=[
            'title'=>'required|string|max:255',
            'review_writer_id'=>'required|integer',
            'review_category_id'=>'required|integer',
            'published'=>'required|integer',
            'description'=>'required',
            'review_grid_image' => 'required|image|max:400',
            'review_detail_image' => 'required|image|max:400',
            'tags' =>'required|string|max:255',
            'is_tags_visible' =>'nullable',
            'publish_date' =>'requiredIf:published,==,0|string|max:255',
        ];

        $messages=[

        ];

        $this->validate($request,$rules,$messages);

        if ($request['is_tags_visible'] == "on"){$request['is_tags_visible']=1;}
        $request['publish_date']=Carbon::createFromFormat('Y-m-d H:i',  $request['publish_date']);

        $input=$request->all();

        if ($review_grid_image = $request->file('review_grid_image') AND $review_category_id = $request->file('review_detail_image')){
            $name = time() . $review_grid_image->getClientOriginalName();
            $review_grid_image->move('images/reviews/grid',$name);
            $review_category_id->move('images/reviews/detail',$name);
            $image = Image::Create(['path'=>$name]);
            $input['image_id']=$image->id;
        }

        Review::create($input);
        return redirect(route('review.index'));
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
        $review = Review::findOrFail($id);
        $review->tags = explode(',',$review->tags);
        $categories = ReviewCategory::all()->pluck('name','id');
        $writers  = ReviewWriter::all()->pluck('name','id');
        return view('admin.reviews.edit',compact('review','categories','writers'));
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
        $review=Review::findOrFail($id);
        $rules=[
            'title'=>'required|string|max:255',
            'review_writer_id'=>'required|integer',
            'review_category_id'=>'required|integer',
            'published'=>'required|integer',
            'description'=>'required',
            'review_grid_image' => 'required_with:review_detail_image|image|max:400',
            'review_detail_image' => 'required_with:review_grid_image|image|max:400',
            'tags' =>'required|string|max:255',
            'is_tags_visible' =>'nullable',
            'publish_date' =>'requiredIf:published,==,0|string|max:255',
        ];

        $messages=[

        ];

        $this->validate($request,$rules,$messages);

        if ($request['is_tags_visible'] AND $request['is_tags_visible'] == "on"){$request['is_tags_visible']=1;}else{$request['is_tags_visible']=0;}
        $request['publish_date']=Carbon::createFromFormat('Y-m-d H:i',  $request['publish_date']);

        $input=$request->all();

        if ($review_grid_image = $request->file('review_grid_image') AND $review_category_id = $request->file('review_detail_image')){

            if ($review->image) {
                if (file_exists(public_path() ."/images/reviews/grid/". $review->image->getOriginal('path'))) {unlink(public_path() ."/images/reviews/grid/". $review->image->getOriginal('path'));}
                if (file_exists(public_path() ."/images/reviews/detail/". $review->image->getOriginal('path'))) {unlink(public_path() ."/images/reviews/detail/". $review->image->getOriginal('path'));}
                $review->image->delete();
            }

            $name = time() . $review_grid_image->getClientOriginalName();
            $review_grid_image->move('images/reviews/grid',$name);
            $review_category_id->move('images/reviews/detail',$name);
            $image = Image::Create(['path'=>$name]);
            $input['image_id']=$image->id;
        }

        $review->update($input);
        return redirect(route('review.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $review =Review::findOrFail($id);
        if ($review->image) {
            if (file_exists(public_path() ."/images/reviews/grid/". $review->image->getOriginal('path'))) {unlink(public_path() ."/images/reviews/grid/". $review->image->getOriginal('path'));}
            if (file_exists(public_path() ."/images/reviews/detail/". $review->image->getOriginal('path'))) {unlink(public_path() ."/images/reviews/detail/". $review->image->getOriginal('path'));}
            $review->image->delete();
        }
        $review->delete();
        return redirect(route('review.index'));
    }
}
