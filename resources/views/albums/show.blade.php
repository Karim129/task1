@extends('layouts.layout')
@section('content')
<h1>{{$album->name}}</h1>
<a href="/" class="button secondary">Return</a>
<a href="/photos/create/{{$album->id}}" class="button">Add photo to Album</a>
<a href="{{ route('albums.edit', $album->id) }}" class="button">update</a>

<div class="card">
    <a href="{{ route('albums.delete.confirmation', $album->id) }}" class="button">Delete Album</a>
</div>

<hr>
@if(count($album->photos) > 0)
<?php
        $colcount = count($album->photos);
        $i = 1;
        ?>
<div class="albums">
    <div class="row text-center">
        @foreach($album->photos as $photo)
        @if($i == $colcount)
        <div class="medium-4 columns end">
            <a href="/photos/{{ $photo->id }}">
                <img src="/storage/photos/{{ $photo->album_id }}/{{ $photo->photo }}" alt="{{ $photo->title }}"
                    style="width:200px;height:200px" class="thumbnail">
            </a>
            <br />
            <h4>{{ $photo->title }}</h4>
            @else
            <div class="medium-4 columns">
                <a href="/albums/{{ $photo->id }}">
                    <img src="/storage/photos/{{ $photo->album_id }}/{{ $photo->photo }}" alt="{{ $photo->title }}"
                        style="width:200px;height:200px" class="thumbnail">
                </a>
                <br />
                <h4>{{ $photo->title }}</h4>
                @endif
                @if($i % 3 == 0)
                <div>
                    <div class="row text-center">

                    </div>
                </div>
                @else
            </div>
            @endif
            <?php $i++ ?>
            @endforeach
        </div>
    </div>
    @else
    <p>No Albums</p>
    @endif
    @endsection