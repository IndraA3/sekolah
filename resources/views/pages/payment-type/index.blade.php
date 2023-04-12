@extends('layout.master-page')



@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table tuituion type --}}
        <div class="col-lg-10">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                <a href="{{ route('payment-type.create') }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah {{ $title }}</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <x-datatable :tableId="'payment-type-table'" :tableHeaders="['Sekolah', 'Tipe Pembayaran', 'Aksi']" :tableColumns="[
                        ['data' => 'school.school_name', 'name' => 'name'],
                        ['data' => 'name'],
                        ['data' => 'action'],
                    ]" :getDataUrl="route('datatable.payment-type')" />
                </div>
            </div>
        </div>
        {{-- END table tuituion type --}}
    </div>
    {{-- END ROW --}}
@endsection