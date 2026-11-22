@extends('layouts.admin')

@section('content')
    <x-manage-settings 
        :settings="$settings ?? []" 
    />
@endsection
