@extends('layouts.layout')

@section('content')
<h3>Update Album</h3>

<form action="{{route('albums.update',$album->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Album name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $album->name) }}" required>
    </div>

    <div class="form-group">
        <label for="description">Description of Album</label>
        <textarea name="description" id="description" class="form-control" rows="3">{{$album->description}}</textarea>
    </div>

    <div class="form-group">
        <label for="cover_image">cover_image</label>
        <img src="/storage/album_covers/{{ $album->cover_image }}" alt="{{ $album->cover_image }}"
            style="max-width:200px;" class="thumbnail">
        <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/jpeg,image/png">
    </div>

    <button type="submit" class="button">update Album</button>
</form>

@endsection