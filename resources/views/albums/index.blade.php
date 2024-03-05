@extends('layouts.layout')
@section('content')
@if (count($albums) > 0)
<?php

$colcount = count($albums);
$i = 1;
?>
<div class="albums">
    <div class="row text-center">
        @foreach ($albums as $album)
        @if ($i == $colcount)
        <div class="medium-4 columns end">
            <a href="/albums/{{ $album->id }}">
                <img src="/storage/album_covers/{{ $album->cover_image }}" alt="{{ $album->name }}" class="thumbnail"
                    style="width:200px;height:200px">
            </a>
            <br />
            <h4>{{ $album->name }}</h4>
            @else
            <div class="medium-4 columns">
                <a href="/albums/{{ $album->id }}">
                    <img src="/storage/album_covers/{{ $album->cover_image }}" alt="{{ $album->name }}"
                        style="width:200px;height:200px" class="thumbnail">
                </a>
                <br />
                <h4>{{ $album->name }}</h4>
                @endif
                @if ($i % 3 == 0)
                <div>
                    <div class="row text-center">

                    </div>
                </div>
                @else
            </div>
            @endif
            <?php $i++; ?>
            @endforeach
        </div>
    </div>
    @else
    <p>There are no albums to show</p>
    @endif
    @endsection