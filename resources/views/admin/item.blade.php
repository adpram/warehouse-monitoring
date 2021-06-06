@extends('base')
@section('content')
<div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Daftar Item</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Card stats -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Bin</h3>
                        <p class="text-sm mb-0">
                            Daftar Item pada sistem monitoring gudang.
                        </p>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>Kode</th>
                                    <th>Item</th>
                                    <th>Jumlah</th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $items as $key => $value )
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <th>{{ $value->item_code }}</th>
                                    <th>{{ $value->item_name }}</th>
                                    @php
                                        $total = 0;
                                        foreach ( $value->mutation as $mutation ) {
                                            $total += $mutation->qty;
                                        }
                                    @endphp
                                    <th>{{ $total }} {{ $value->unit }}</th>
                                    <th>
                                        <a href="/item/detail/{{ $value->id_item }}"
                                            class="btn btn-secondary btn-sm"><i class="fas fa-list"></i> Detail</a>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection