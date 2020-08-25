<?php

namespace App\Http\Controllers;

use App\Image;
use App\ReviewWriter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminReviewWritersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reviewWriters = ReviewWriter::where('deleted',0)->get();
        return view('admin.review-writers.index',compact('reviewWriters'));
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
            'description'=>'required',
            'image' => 'image|max:200',
        ];

        $messages=[

        ];

        $this->validate($request,$rules,$messages);

        $request['url_en_name']=strtolower($request['url_en_name']);
        $request['url_en_name'] = preg_replace('/\s+/', '_', $request['url_en_name']);

        $input=$request->all();

        if ($file = $request->file('image')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images',$name);
            $image = Image::Create(['path'=>$name]);
            $input['image_id']=$image->id;
        }

        ReviewWriter::create($input);
        return redirect(route('writer.index'));
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
        $writer=ReviewWriter::findOrFail($id);
        return view('admin.review-writers.edit',compact('writer'));
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
        $writer = ReviewWriter::findOrFail($id);
        $rules=[
            'name'=>'required|string|max:255',
            'url_en_name'=>'required|string|max:255',
            'description'=>'required',
            'image' => 'image|max:200',
        ];

        $messages=[

        ];

        $this->validate($request,$rules,$messages);

        $request['url_en_name']=strtolower($request['url_en_name']);
        $request['url_en_name'] = preg_replace('/\s+/', '_', $request['url_en_name']);

        $input=$request->all();


        if ($file = $request->file('image')){

            if ($writer->image) {
                if (file_exists(public_path() . $writer->image->path)) {unlink(public_path() . $writer->image->path);}
                $writer->image->delete();
            }
            $name = time() . $file->getClientOriginalName();
            $file->move('images',$name);
            $image = Image::create(['path'=>$name]);
            $input['image_id']=$image->id;
        }
        
        $writer->update($input);
        return redirect(route('writer.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $writer = ReviewWriter::findOrFail($id);
        $writer->update(['deleted'=>1]);
        return redirect(route('writer.index'));
    }
}
