@extends('layouts.layout')

@section('content')
<h3>Delete Album - {{ $album->name }}</h3>
<p>The album contains <strong>{{ $album->photos->count() }} photos</strong>. What do you want to do?</p>

<form action="{{ route('albums.delete.confirmed', $album->id) }}" method="POST">
    @csrf
    @method('DELETE')

    <div class="form-group">
        <label for="action">Select an action:</label>
        <select name="action" id="action" class="form-control">
            <option value="delete_photos">Delete photos with the album</option>
            <option value="move_photos">Move photos to another album</option>
        </select>
    </div>

    <div id="move_to_album_section" style="display: none;">
        <label for="move_to_album">Move photos to:</label>
        <select name="move_to_album" id="move_to_album" class="form-control">
            @foreach ($otherAlbums as $otherAlbum)
            <option value="{{ $otherAlbum->id }}">{{ $otherAlbum->name }}</option>
            @endforeach

        </select>
    </div>
    <button type="submit" class="button">Confirm</button>
    <a href="{{ route('albums.index') }}" class="button">Cancel</a>
</form>

<script>
    const actionSelect = document.getElementById('action');
        const moveToSection = document.getElementById('move_to_album_section');

        actionSelect.addEventListener('change', () => {
            if (actionSelect.value === 'move_photos') {
                moveToSection.style.display = 'block';
            } else {
                moveToSection.style.display = 'none';
            }
        });
</script>

@endsection