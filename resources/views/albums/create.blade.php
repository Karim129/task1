@extends('layouts.layout')

@section('content')
<h3>Create New Album</h3>

<form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Album name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Album name" required>
    </div>

    <div class="form-group">
        <label for="description">Description of Album</label>
        <textarea name="description" id="description" class="form-control" placeholder="Description of Album"
            rows="3"></textarea>
    </div>

    <div class="form-group">
        <label for="cover_image">cover_image</label>
        <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/jpeg,image/png">
    </div>

    <button type="submit" class="button">create Album</button>
</form>

@endsection