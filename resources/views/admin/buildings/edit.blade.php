@extends('layouts.admin')

@section('title', 'Edit Building - Pinjam Ruang')

@section('content')
    <h1>Edit {{ $building->building_name }}</h1>

    <form action="/admin/buildings/{{ $building->id }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="building_name">Building Name</label>

            <input
                type="text"
                id="building_name"
                name="building_name"
                placeholder="Building name..."
                value="{{ old('building_name', $building->building_name) }}"
            >

            @error('building_name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="major_id">Major</label>

            <select name="major_id" id="major_id">
                <option value="" @selected(old('major_id', $major?->id) == '')>
                    Universal
                </option>

                @foreach ($majors as $majorOption)
                    <option
                        value="{{ $majorOption->id }}"
                        @selected(old('major_id', $major?->id) == $majorOption->id)
                    >
                        {{ $majorOption->major }}
                    </option>
                @endforeach
            </select>

            @error('major_id')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit">Update Building</button>
        </div>
    </form>
@endsection
