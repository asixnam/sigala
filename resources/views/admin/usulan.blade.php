@extends('layouts.admin')

@section('content')
    <x-manage-usulan 
        :usulans="$usulans" 
        :pegawais="$pegawais ?? []" 
        :filterRoute="route('admin.usulan')" 
        :isSekolahRole="false" 
    />
@endsection
