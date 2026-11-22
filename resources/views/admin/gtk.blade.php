@extends('layouts.admin')

@section('content')
    <x-manage-gtk 
        :pegawais="$pegawais" 
        :unitKerjaList="$unitKerjaList ?? []" 
        :filterRoute="route('admin.gtk')" 
        :isSekolahRole="false" 
    />
@endsection
