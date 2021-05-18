@extends('base')
@section('content')
<div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Pengaturan master <i>bin</i></h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 text-right">
            <a href="" type="button" class="btn btn-success"
				data-toggle="modal" data-target="#addBinModal"><i class="fas fa-user-plus"></i> Tambah<i>Bin</i></a>
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
                            Daftar <i>bin</i> pada sistem monitoring gudang.
                        </p>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>Area</th>
                                    <th>Rak</th>
                                    <th><i>Bin Location</i></th>
                                    <th>Nama <i>Bin</i></th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $bins as $key => $value )
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <th>{{ $value->binlocation->rack->area->area_name }}</th>
                                    <th>{{ $value->binlocation->rack->rack_name }}</th>
                                    <th>{{ $value->binlocation->bin_location_name }}</th>
                                    <th>{{ $value->bin_name }}</th>
                                    <th>
                                        <a href="javascript:void(0)" onclick="editBin(<?= $value->id_bin ?>)"
                                            class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="javascript:void(0)" onclick="deleteBin(<?= $value->id_bin ?>)"
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
<div class="modal fade" id="addBinModal" tabindex="-1" role="dialog" aria-labelledby="addBinModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addBinModalLabel">Tambah <i>Bin</i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="storeBin">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
                        <div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for=""><i>Bin Location</i></label>
                                <select class="form-control" id="storeChooseBinLocation" name="bin_location_id">
                                    @foreach ($binlocations as $value)
                                        <option value="{{ $value->id_bin_location }}">{{ $value->bin_location_name }} ({{ $value->rack->rack_name }} - {{ $value->rack->area->area_name}})</option>
                                    @endforeach
                                </select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama <i>Bin</i></label>
                                <input id="bin_name" type="text" class="form-control" name="bin_name" required autofocus>
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
<div class="modal fade" id="editBinModal" tabindex="-1" role="dialog" aria-labelledby="editBinModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editBinModalLabel">Ubah <i>Bin</i></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="updateBin">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
                        <div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for=""><i>Bin Location</i></label>
                                <select class="form-control" id="updateChooseBinLocation" name="bin_location_id">
                                    @foreach ($binlocations as $value)
                                        <option value="{{ $value->id_bin_location }}">{{ $value->bin_location_name }} ({{ $value->rack->rack_name }} - {{ $value->rack->area->area_name}})</option>
                                    @endforeach
                                </select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama <i>Bin</i></label>
								<input type="text" class="form-control" id="namabin" name="bin_name">
								<input type="hidden" id="id_bin" name="id_bin">
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
    $('#storeChooseBinLocation').select2({
        dropdownParent: $('#addBinModal'),
    });

    $('#updateChooseBinLocation').select2({
        dropdownParent: $('#editBinModal'),
    });
    
    // tambah bin 
    $('#storeBin').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            $.ajax({
                url: "bin/",
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
                data: $('#storeBin').serialize(),
                dataType: "json",
                success: function (data) {
                    swal({
                        title: 'Berhasil!',
                        text: 'Berhasil menambahkan bin!',
                        icon: 'success'
                    }).then(function () {
                        $('#addBinModal').modal('hide');
                        window.location.href = "{{ route('bin.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e.responseJSON.message)
                    swal({
                        title: 'Gagal!',
                        text: 'Gagal menambahkan bin!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });

    // edit bin
    function editBin(id) {
        $.ajax({
            url: "bin/" +id+ "/edit",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#editBinModal').modal('show');
                $("#id_bin").val(data.id_bin);
                $("#updateChooseBinLocation").val(data.bin_location_id).change();
                $("#namabin").val(data.bin_name);
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }
    $('#updateBin').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id_bin').val()
            $.ajax({
                url: "bin/" + id,
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
                data: $('#updateBin').serialize(),
                dataType: "json",
                success: function (data) {
                    console.log(data.status)
                    swal({
                        title: 'Berhasil!',
                        text: 'Bin berhasil diperbarui!',
                        icon: 'success'
                    }).then(function () {
                        $('#editBinModal').modal('hide');
                        window.location.href = "{{ route('bin.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e)
                    swal({
                        title: 'Gagal!',
                        text: 'Bin gagal diperbarui!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });

    // hapus bin
    function deleteBin(id) {
		swal({
			title: "Apakah anda yakin ?",
			text: "Anda akan menghapus bin",
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
					swal("Bin aman");
					break;
				case 'delete':
					$.ajax({
						url: "bin/" + id,
                        type: "POST",
                        data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
						dataType: "json",
						success: function (data) {
							console.log(data)
							if (data == "error") {
								swal({
									title: 'Gagal menghapus bin!',
									text: 'Silahkan menghubungi IT',
									icon: 'error'
								})
							} else {
								swal("Bin berhasil dihapus", {
									icon: "success",
								}).then(function () {
									window.location.href = "{{ route('bin.index') }}";
								});
							}
						},
						error: function (e) {
                            if ( e.responseJSON.message == "item") {
                                swal({
                                    title: 'Gagal!',
                                    text: 'Gagal menghapus bin!, karena masih ada item',
                                    icon: 'error'
                                })    
                            } else {
                                swal({
                                    text: 'Bin gagal dihapus!',
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