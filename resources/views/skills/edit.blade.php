@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Skill</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('skills.update', $skill->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nama Skill</label><br>
            <input type="text" name="name" value="{{ old('name', $skill->name) }}">
        </div>
        <div>
            <label>Level (%)</label><br>
            <input type="number" name="level" value="{{ old('level', $skill->level) }}">
        </div>
        <button type="submit">Update</button>
    </form>
</div>
@endsection
