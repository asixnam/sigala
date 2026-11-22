@extends('layouts.admin')

@section('content')
    <x-manage-sekolah 
        :schools="$schools" 
        :filterRoute="route('admin.sekolah')" 
    />
@endsection
