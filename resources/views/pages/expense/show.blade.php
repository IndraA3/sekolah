@extends('layout.master-page')


@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table expense detail --}}
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                <a href="{{ route('expense.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-default shadow-sm">
                    Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="expense-number-input">No Pengeluaran Biaya<span
                                        class="text-small text-danger">*</span></label>
                                <input type="text" class="form-control  @error('expense_number') is-invalid @enderror"
                                    name="expense_number" value="{{ $expense->expense_number }}" id="expense-number-input"
                                    placeholder="" disabled>
                                @error('expense_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="expense-date-input">Tanggal Pengeluaran Biaya<span
                                        class="text-small text-danger">*</span></label>
                                <input type="date" class="form-control @error('expense_date') is-invalid @enderror"
                                    name="expense_date" id="expense-date-input" placeholder=""
                                    value="{{ $expense->expense_date }}" disabled>
                                @error('expense_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>    
                </div>
    
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="note-input">Dibuat Oleh</label>
                                <input type="text" class="form-control @error('note') is-invalid @enderror" name="note"
                                    id="note-input" placeholder="" value="{{ $requestedBy->name }}" disabled>
                                @error('note')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="note-input">Catatan</label>
                                <input type="text" class="form-control @error('note') is-invalid @enderror" name="note"
                                    id="note-input" placeholder="" value="{{ $expense->note }}" disabled>
                                @error('note')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header bg-primary text-light">
                    Detail Barang
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Dompet</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Harga Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $jumlahBarang = 0;
                                $totalHarga = 0;
                            @endphp
                            @foreach ($expenseDetails as $expenseDetail)
                                <tr>
                                    <td>{{ $expenseDetail->wallet->name }}</td>
                                    <td>{{ $expenseDetail->item_name }}</td>
                                    <td>{{ number_format($expenseDetail->quantity, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($expenseDetail->price, 0, ',', '.') }}</td>
                                </tr>
                                @php
                                    $jumlahBarang += $expenseDetail->quantity;
                                    $totalHarga += $expenseDetail->price * $expenseDetail->quantity;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right text-primary font-weight-bold">Total</td>
                                <td class="text-primary font-weight-bold">{{ number_format($jumlahBarang, 0, ',', '.') }}
                                </td>
                                <td class="text-primary font-weight-bold">Rp. {{ number_format($totalHarga, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- END table expense detail --}}
    </div>
    {{-- END ROW --}}
@endsection

@push('js')
    <script>
        function softDelete(e) {

            const url = $(e).data('url')
            const name = $(e).data('name') ?? ''
            const redirect = $(e).data('redirect')

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Untuk menghapus data ' + name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    cancelButton: 'btn btn-light waves-effect',
                    confirmButton: 'btn btn-primary waves-effect waves-light'
                },
                preConfirm: (e) => {
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            resolve();
                        }, 50);
                    });
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            _method: "DELETE"
                        },
                        url: url,
                        success: function(response) {
                            toastMessage("success", response.msg)
                            setTimeout(function() {
                                window.location = redirect;
                            }, 1000)
                        },
                        error: function(xhr, status, error) {
                            toastMessage("error", err.msg)
                        }
                    })
                }
            })
        }



        function toastMessage(status, msg) {
            Swal.fire({
                "title": msg,
                "text": "",
                "timer": 5000,
                "width": "32rem",
                "padding": "1.25rem",
                "showConfirmButton": false,
                "showCloseButton": true,
                "timerProgressBar": false,
                "customClass": {
                    "container": null,
                    "popup": null,
                    "header": null,
                    "title": null,
                    "closeButton": null,
                    "icon": null,
                    "image": null,
                    "content": null,
                    "input": null,
                    "actions": null,
                    "confirmButton": null,
                    "cancelButton": null,
                    "footer": null
                },
                "toast": true,
                "icon": status,
                "position": "top-end"
            })

        }
    </script>
@endpush

@push('js')
    <script>
        formatAngka('#price-input')
        formatAngka('#quantity-input')
    </script>
@endpush
