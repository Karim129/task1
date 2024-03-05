<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function create($album_id)
    {
        return view('photos.create', compact('album_id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'photo' => 'image|max:1999'
        ]);

        $filenameWithExt = $request->file('photo')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $extension = $request->file('photo')->getClientOriginalExtension();

        $filenametoStore = $filename . '_' . time() . '.' . $extension;

        $path = $request->file('photo')->storeAs('public/photos/' . $request->album_id, $filenametoStore);


        $photo = new Photo($request->all());

        $photo->photo = $filenametoStore;

        $photo->size = $request->file('photo')->getSize();

        $photo->save();

        return redirect('/albums/' . $request->album_id)->with('success', 'Photo saved');
    }

    public function show($id)
    {
        $photo = Photo::find($id);

        return view('photos.show', compact('photo'));
    }

    public function destroy($id)
    {
        $photo = Photo::find($id);

        if (Storage::delete('public/photos/' . $photo->album_id . '/' . $photo->photo)) {
            $photo->delete();
            return redirect('/')->with('success', 'deleted Photo');
        }

        return redirect('/')->with('alert', 'The photo has not been deleted');
    }
}