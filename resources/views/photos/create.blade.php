@extends('layouts.layout')

@section('content')
<h3>Add a new photo</h3>

<form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">Photo Title</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Photo Title" required>
    </div>

    <div class="form-group">
        <label for="description">Photo Description</label>
        <textarea name="description" id="description" class="form-control" placeholder="Photo Description"
            rows="3"></textarea>
    </div>

    <input type="hidden" name="album_id" id="album_id" value="{{ $album_id }}">

    <div class="form-group">
        <label for="photo">Select Image</label>
        <input type="file" name="photo" id="photo" class="form-control" accept="image/jpeg,image/png" required>
    </div>

    <button type="submit" class="button">ADD photo</button>
</form>

@endsection