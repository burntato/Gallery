<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $images = DB::table('image')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->select('id', 'name', 'file_name', DB::raw("DATE_FORMAT(created_at, '%d %M %Y') as created_at"))
            ->paginate(10);
        return view('image.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('image.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $images = new Image;
        $images->name = $request->input('name');
        if($request->hasFile('file_name')){
            $file = $request->file('file_name');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/images', $filename);
            $images->file_name = $filename;
        }

        $images->save();
        return redirect()->route('image.index')->with('status', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        $images = Image::find($image->id);
        return view('image.edit', compact('images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $images = Image::find($image->id);
        $images->name = $request->input('name');

        if($request->hasFile('file_name')) {

            $destination = 'uploads/images'.$image->file_name;

            if(File::exists($destination)) {

                File::delete($destination);
            }

            $file = $request->file('file_name');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/images', $filename);
            $images->file_name = $filename;
        }

        $images->update();
        return redirect()->back()->with('status', 'Data berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $images = Image::find($image->id);
        $destination = 'uploads/students/'.$image->file_name;

        if(File::exists($destination)) {

            File::delete($destination);
        }

        $images->delete();
        return redirect()->back()->with('status', 'Data berhasil dihapus');
    }
}
