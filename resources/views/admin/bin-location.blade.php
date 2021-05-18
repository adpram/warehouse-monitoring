@extends('base')
@section('content')
<div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Pengaturan master <i>bin location</i></h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 text-right">
            <a href="" type="button" class="btn btn-success"
				data-toggle="modal" data-target="#addBinLocationModal"><i class="fas fa-user-plus"></i> Tambah<i>Bin Location</i></a>
            </div>
        </div>
        <!-- Card stats -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Bin Location</h3>
                        <p class="text-sm mb-0">
                            Daftar <i>bin location</i> pada sistem monitoring gudang.
                        </p>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>Area</th>
                                    <th>Rak</th>
                                    <th>Nama <i>Bin Location</i></th>
                                    <th>Jumlah <i>Bin</i></th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $binlocations as $key => $value )
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <th>{{ $value->area_name }}</th>
                                    <th>{{ $value->rack_name }}</th>
                                    <th>{{ $value->bin_location_name }}</th>
                                    <th>{{ $value->jumlahbin }}</th>
                                    <th>
                                        <a href="javascript:void(0)" onclick="editBinLocation(<?= $value->id_bin_location ?>)"
                                            class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="javascript:void(0)" onclick="deleteBinLocation(<?= $value->id_bin_location ?>)"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
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
<!-- Modal -->
<!-- ADD -->
<div class="modal fade" id="addBinLocationModal" tabindex="-1" role="dialog" aria-labelledby="addBinLocationModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addBinLocationModalLabel">Tambah <i>Bin Location</i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="storeBinLocation">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
                        <div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for="">Rak</label>
                                <select class="form-control" id="storeChooseRack" name="rack_id">
                                    @foreach ($racks as $value)
                                        <option value="{{ $value->id_rack }}">{{ $value->rack_name }}</option>
                                    @endforeach
                                </select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama <i>Bin Location</i></label>
                                <input id="bin_location_name" type="text" class="form-control" name="bin_location_name" required autofocus>
							</div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Jumlah <i>Bin </i></label>
                                <input id="bin_qty" type="number" min="1" class="form-control" name="bin_qty" autofocus>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- EDIT -->
<div class="modal fade" id="editBinLocationModal" tabindex="-1" role="dialog" aria-labelledby="editBinLocationModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editBinLocationModalLabel">Ubah <i>Bin Location</i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="updateBinLocation">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
                        <div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for="">Rack</label>
                                <select class="form-control" id="updateChooseRack" name="rack_id">
                                    @foreach ($racks as $value)
                                        <option value="{{ $value->id_rack }}">{{ $value->rack_name }}</option>
                                    @endforeach
                                </select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama <i>Bin Location</i></label>
								<input type="text" class="form-control" id="namabinlocation" name="bin_location_name">
								<input type="hidden" id="id_bin_location" name="id_bin_location">
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
    $('#storeChooseRack').select2({
        dropdownParent: $('#addBinLocationModal'),
    });

    $('#updateChooseRack').select2({
        dropdownParent: $('#editBinLocationModal'),
    });
    
    // tambah bin location
    $('#storeBinLocation').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            $.ajax({
                url: "bin-location/",
                type: "POST",
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
                data: $('#storeBinLocation').serialize(),
                dataType: "json",
                success: function (data) {
                    swal({
                        title: 'Berhasil!',
                        text: 'Berhasil menambahkan bin-location!',
                        icon: 'success'
                    }).then(function () {
                        $('#addBinLocationModal').modal('hide');
                        window.location.href = "{{ route('bin-location.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e.responseJSON.message)
                    swal({
                        title: 'Gagal!',
                        text: 'Gagal menambahkan bin-location!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });

    // edit bin location
    function editBinLocation(id) {
        $.ajax({
            url: "bin-location/" +id+ "/edit",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#editBinLocationModal').modal('show');
                $("#id_bin_location").val(data.id_bin_location);
                $("#updateChooseRack").val(data.rack_id).change();
                $("#namabinlocation").val(data.bin_location_name);
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }
    $('#updateBinLocation').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id_bin_location').val()
            $.ajax({
                url: "bin-location/" + id,
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
                data: $('#updateBinLocation').serialize(),
                dataType: "json",
                success: function (data) {
                    console.log(data.status)
                    swal({
                        title: 'Berhasil!',
                        text: 'Bin Location berhasil diperbarui!',
                        icon: 'success'
                    }).then(function () {
                        $('#editBinLocationModal').modal('hide');
                        window.location.href = "{{ route('bin-location.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e)
                    swal({
                        title: 'Gagal!',
                        text: 'Bin Location gagal diperbarui!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });

    // hapus bin location
    function deleteBinLocation(id) {
		swal({
			title: "Apakah anda yakin ?",
			text: "Anda akan menghapus bin-location",
			icon: "warning",
			buttons: {
				canceled: {
					text: 'Cancel',
					value: 'cancel',
					className: 'swal-button btn-default'
				},
				deleted: {
					text: 'Delete',
					value: 'delete',
					className: 'swal-button btn-danger'
				}
			},
			dangerMode: true,
		}).then((willDelete) => {
			switch (willDelete) {
				default:
					swal("Bin Location aman");
					break;
				case 'delete':
					$.ajax({
						url: "bin-location/" + id,
                        type: "POST",
                        data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
						dataType: "json",
						success: function (data) {
							console.log(data)
							if (data == "error") {
								swal({
									title: 'Gagal menghapus bin-location!',
									text: 'Silahkan menghubungi IT',
									icon: 'error'
								})
							} else {
								swal("Bin Location berhasil dihapus", {
									icon: "success",
								}).then(function () {
									window.location.href = "{{ route('bin-location.index') }}";
								});
							}
						},
						error: function (e) {
                            if ( e.responseJSON.message == "bin") {
                                swal({
                                    title: 'Gagal!',
                                    text: 'Gagal menghapus bin-location!, karena masih ada bin',
                                    icon: 'error'
                                })    
                            } else {
                                swal({
                                    text: 'Bin Location gagal dihapus!',
                                    icon: 'error'
                                })
                            }
						}
					});
				break;
			}
		});
	}
</script>
@endsection