@extends('layout.master-page')


@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table Expense --}}
        <div class="col-lg-6">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                <a href="{{ route('expense.show', $expenseDetail->expense_id) }}" class="d-none d-sm-inline-block btn btn-sm btn-default shadow-sm">
                    Kembali
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('expense-detail.update', ['expense_detail' => $expenseDetail->id]) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="wallet-input">Nama Dompet</label>
                            <select class="form-control select2 @error('wallet') is-invalid @enderror" name="wallet_id"
                            id="requested-by-select">
                            <option value="">-</option>
                            @foreach ($wallets as $wallet)
                                <option value="{{ $wallet->id }}" @if ($expenseDetail->wallet_id === $wallet->id) selected @endif>
                                    {{ $wallet->name }}
                                </option>
                            @endforeach
                            </select>
                            @error('wallet')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="item-name-input">Nama Barang</label>
                            <input type="text" class="form-control @error('item_name') is-invalid @enderror" name="item_name"
                                id="item-name-input" placeholder="" value="{{ $expenseDetail->item_name }}">
                            @error('item_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity-input">Kuantitas Barang</label>
                            <input type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                id="quantity-input" placeholder="" value="{{ $expenseDetail->quantity }}">
                            @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price-input">Harga Barang</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"
                                id="price-input" placeholder="" pattern="[0-9]+" value="{{ $expenseDetail->price }}">
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- END table Expense --}}
    </div>
    {{-- END ROW --}}

@endsection