@extends('base')
@section('content')
<div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Detail Item</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('item.list-index') }}" type="button" class="btn btn-secondary btn-sm"><i class="fas fa-backward"></i> Kembali</a>
            </div>
        </div>
        <!-- Card stats -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <table width="50%">
                            <tr>
                                <th width="25%">Kode</th>
                                <th class="text-center" width="10%">:</th>
                                <td>{{ $item[0]->item_code }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <th class="text-center">:</th>
                                <td>{{ $item[0]->item_name }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <th class="text-center">:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-right">Area</td>
                                <th class="text-center">:</th>
                                <td>{{ $item[0]->area_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">Rak</td>
                                <th class="text-center">:</th>
                                <td>{{ $item[0]->rack_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">Bin-Location</td>
                                <th class="text-center">:</th>
                                <td>{{ $item[0]->bin_location_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">Bin</td>
                                <th class="text-center">:</th>
                                <td>{{ $item[0]->bin_name }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <th class="text-center">:</th>
                                @php
                                    $total = 0;
                                    foreach($item as $value){
                                        $total += $value->qty;
                                    }
                                @endphp
                                <td>{{ $total }} {{ $item[0]->unit }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="pt-2">
                                    <a href="javascript:void(0)" onclick="editItem(<?= $item[0]->id_item ?>)" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>Tanggal</th>
                                    <th>User</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $item as $key => $value )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($value->tanggalmutasi)->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $value->name }}</td>
                                    @if ( $value->transtype == 'in' )
                                        <td><i class="fas fa-arrow-right text-green"></i> {{ $value->qty }} Masuk</td>
                                    @else
                                        <td><i class="fas fa-arrow-left text-red"></i> {{ $value->qty * -1 }} Keluar</td>
                                    @endif
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
<!-- MODAL -->
<!-- EDIT -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editItemModalLabel">Ubah Item</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="updateItem">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Kode Item</label>
								<input type="text" class="form-control" id="kodeitem" name="item_code">
								<input type="hidden" id="id_item" name="id_item">
							</div>
						</div>
                    </div>
                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama Item</label>
								<input type="text" class="form-control" id="namaitem" name="item_name">
							</div>
						</div>
                    </div>
                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Satuan Item</label>
								<input type="text" class="form-control" id="unititem" name="unit">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Perbarui</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    // edit item
    function editItem(id) {
        $.ajax({
            url: "/item/edit/" +id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#editItemModal').modal('show');
                $("#id_item").val(data.id_item);
                $("#kodeitem").val(data.item_code);
                $("#namaitem").val(data.item_name);
                $("#unititem").val(data.unit);
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }
    $('#updateItem').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id_item').val()
            $.ajax({
                url: "/item/update/" + id,
                type: "PUT",
                beforeSend: function () {
                    swal({
                        title: 'Menunggu',
                        html: 'Memproses data',
                        onOpen: () => {
                            swal.showLoading()
                        }
                    })
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#updateItem').serialize(),
                dataType: "json",
                success: function (data) {
                    console.log(data.status)
                    swal({
                        title: 'Berhasil!',
                        text: 'Item berhasil diperbarui!',
                        icon: 'success'
                    }).then(function () {
                        $('#editItemModal').modal('hide');
                        window.location.href = "/item/detail/" + id;
                    });
                },
                error: function (e) {
                    console.log(e)
                    swal({
                        title: 'Gagal!',
                        text: 'Item gagal diperbarui!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });
</script>
@endsection