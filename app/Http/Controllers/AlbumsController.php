<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
{
    public function index()
    {
        $albums = Album::with('Photos')->get();
        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $album = new Album($request->all());

        if ($request->hasFile('cover_image')) {
            $this->handleImageUpload($request, $album);
        }
        $album->save();


        return redirect('/albums')->with('success', 'Album created');
    }

    public function update(Request $request, Album $album)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $album->update($request->all());

        if ($request->hasFile('cover_image')) {
            $this->handleImageUpload($request, $album);
        }

        return redirect('/albums')->with('success', 'Album updated');
    }

    private function handleImageUpload(Request $request, Album $album)
    {
        $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('cover_image')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        $path = $request->file('cover_image')->storeAs('public/album_covers', $filenameToStore);

        // Update album cover image with the new filename
        $album->cover_image = $filenameToStore;
        $album->save();
    }




    public function show($id)
    {
        $album = Album::find($id);
        return view('albums.show', compact('album'));
    }
    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }



    public function destroy(Album $album)
    {
        if ($album->photos->count() > 0) {
            // User confirmation dialog
            return view('albums.delete_confirmation', compact('album'));
        } else {
            $album->delete();
            return redirect('/albums')->with('success', 'Album deleted');
        }
    }



    public function showDeleteConfirmation(Album $album)
    {
        $otherAlbums = Album::where('id', '!=', $album->id)->get();
        return view('albums.delete_confirmation', compact('album', 'otherAlbums'));
    }
    public function deleteConfirmed(Request $request, Album $album)
    {
        $action = $request->input('action');

        switch ($action) {
            case 'delete_photos':
                $album->photos()->delete();
                break;
            case 'move_photos':
                $targetAlbumId = $request->input('move_to_album');

                // Validate target album existence
                $targetAlbum = Album::find($targetAlbumId);

                if (!$targetAlbum) {
                    return redirect('/albums')->with('error', 'Target album not found');
                }

                $albumId = $album->id; // Replace with the actual album ID
                $targetDirectory = "photos/{$targetAlbumId}"; // Replace with the desired target directory within public storage

                $moved = $this->movePhotos($albumId, $targetDirectory);

                if ($moved) {
                    $album->photos()->update(['album_id' => $targetAlbumId]);

                    break;
                } else {
                    // Handle errors that might have occurred during the move process
                }


        }

        $album->delete();

        return redirect('/albums')->with('success', 'Album and associated photos deleted/moved');
    }



    public function movePhotos($albumId, $targetDirectory)
    {
        $sourceDirectory = "photos/{$albumId}";

        if (!Storage::disk('public')->exists($sourceDirectory)) {

            return false; // Or throw an exception
        }

        $files = Storage::disk('public')->allFiles($sourceDirectory);

        foreach ($files as $file) {
            $filename = basename($file); // Extract the filename without the full path
            $targetPath = $targetDirectory . "/" . $filename; // Construct the target path

            try {
                Storage::disk('public')->move($file, $targetPath);
            } catch (Exception $e) {

                return false;
            }
        }

        return true;
    }





}
