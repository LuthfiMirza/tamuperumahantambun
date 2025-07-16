
@extends('layouts.satpam')

@section('content')
<div>
<h2 class="text-2xl font-bold mb-4">Jadwal Jaga</h2>
<div class="overflow-x-auto bg-white rounded-xl shadow p-4 mb-4">
<table class="min-w-full text-sm">
<thead>
<tr class="bg-blue-900 text-white">
<th class="py-3 px-4 text-center">ID</th>
<th class="py-3 px-4 text-center">Nama</th>
<th class="py-3 px-4 text-center">Senin</th>
<th class="py-3 px-4 text-center">Selasa</th>
<th class="py-3 px-4 text-center">Rabu</th>
<th class="py-3 px-4 text-center">Kamis</th>
<th class="py-3 px-4 text-center">Jumat</th>
<th class="py-3 px-4 text-center">Sabtu</th>
<th class="py-3 px-4 text-center">Minggu</th>
</tr>
</thead>
<tbody>
@foreach($jadwals as $jadwal)
<tr>
<td class="py-2 px-4 text-center">{{ $jadwal->id }}</td>
<td class="py-2 px-4 text-center">{{ $jadwal->nama }}</td>
@foreach(['senin','selasa','rabu','kamis','jumat','sabtu','minggu'] as $hari)
<td class="py-2 px-4 text-center">
<span class="@if($jadwal->$hari == 'Pagi') bg-green-100 text-green-700 @elseif($jadwal->$hari == 'Malam') bg-yellow-100 text-yellow-700 @else bg-gray-200 text-gray-700 @endif px-2 py-1 rounded-full">
{{ $jadwal->$hari ?? 'OFF' }}
</span>
</td>
@endforeach
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="bg-blue-50 rounded-xl shadow p-4">
<div class="mb-2 font-semibold">SHIFT 1 (Pagi): <span class="font-normal">07:00 - 19:00</span></div>
<div class="mb-2 font-semibold">SHIFT 2 (Malam): <span class="font-normal">19:00 - 07:00</span></div>
<div class="mt-2">
<span class="font-semibold">NB :</span>
<ol class="list-decimal ml-6 mt-1 text-sm text-blue-900">
<li>Harap hadir 30 menit sebelum pergantian tugas jaga/shift</li>
<li>Tukar shift harus sepengetahuan Koordinator/Management</li>
<li>OFF = LIBUR</li>
</ol>
</div>
</div>
</div>
@endsection

<style>
@media (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    th, td {
        min-width: 100px;
    }
}
</style>