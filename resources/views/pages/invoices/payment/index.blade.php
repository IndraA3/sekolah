@extends('layout.master-page')


@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table academy years --}}
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                <a href="{{ route('invoices.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-default shadow-sm">
                    Daftar Invoice
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('invoice-details.store', $invoice->getKey()) }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="note">Deskripsi</label>
                                    <input type="text" class="form-control" id="note" aria-describedby="note"
                                        value="{{ old('note', $invoice->note) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoice_date">Tanggal Invoice</label>
                                    <input type="text" class="form-control" id="invoice_date"
                                        aria-describedby="invoice_date"
                                        value="{{ old('invoice_date', Laraindo\TanggalFormat::DateIndo($invoice->invoice_date)) }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="due_date">Jatuh Tempo</label>
                                    <input type="text" class="form-control" id="due_date" aria-describedby="due_date"
                                        value="{{ old('due_date', Laraindo\TanggalFormat::DateIndo($invoice->due_date)) }}"
                                        readonly>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-primary text-light">
                    Baris Invoice
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('invoices.payment', $invoice->getKey()) }}" method="post">
                        @csrf
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10%">No</th>
                                    <th>Nama Barang</th>
                                    <th style="width: 30%">Harga</th>
                                    <th style="width: 20%">Metode Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @forelse ($details as $key => $detail)
                                    @php
                                        $total += $detail->price;
                                    @endphp
                                    <input type="hidden" name="invoice_detail_id[]" value="{{ $detail->getKey() }}">
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $detail->item_name }}</td>
                                        <td>Rp. {{ number_format($detail->price, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control select2" name="wallet_id[]" id="wallet_id"
                                                    required>
                                                    <option value="">Pilih metode...</option>
                                                    @foreach ($wallets as $keys => $wallet)
                                                        <option value="{{ $wallet->getKey() }}">{{ $wallet->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center font-weight-bold" colspan="4">Data masih kosong</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right font-weight-bold">Total Harga</td>
                                    <td class="font-weight-bolder text-primary">Rp.
                                        {{ number_format($total, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-group float-right">
                                            <button type="submit" class="btn btn-primary">Bayar</button>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>

        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}
@endsection
