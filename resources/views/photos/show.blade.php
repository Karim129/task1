@extends('layouts.layout')

@section('content')
<h3>Title :{{ $photo->title }}</h3>
<p>Description:{{ $photo->description }}</p>
<a class="btn btn-secondary" href="/albums/{{ $photo->album_id }}">Return to Gallery</a>
<hr>
<img src="/storage/photos/{{ $photo->album_id }}/{{ $photo->photo }}" alt="{{ $photo->title }}">

<br>
<br>
<form action="{{ route('photos.destroy', $photo->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="button">Delete photo</button>
</form>
<small>Photo size: {{ $photo->size }}</small>
@endsection