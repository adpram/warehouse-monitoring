@extends('base')
@section('content')
<div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Pengaturan master rak</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
            <a href="" type="button" class="btn btn-success"
				data-toggle="modal" data-target="#addRackModal"><i class="fas fa-user-plus"></i> Tambah Rak</a>
            </div>
        </div>
        <!-- Card stats -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Rak</h3>
                        <p class="text-sm mb-0">
                            Daftar rak pada sistem monitoring gudang.
                        </p>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>Area</th>
                                    <th>Nama Rak</th>
                                    <th>Jumlah <i>Bin Location</i></th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $racks as $key => $value )
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <th>{{ $value->area->area_name }}</th>
                                    <th>{{ $value->rack_name }}</th>
                                    <th></th>
                                    <th>
                                        <a href="javascript:void(0)" onclick="editRack(<?= $value->id_rack ?>)"
                                            class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="javascript:void(0)" onclick="deleteRack(<?= $value->id_rack ?>)"
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
<div class="modal fade" id="addRackModal" tabindex="-1" role="dialog" aria-labelledby="addRackModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRackModalLabel">Tambah Rak</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="storeRack">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
                        <div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for="">Area</label>
                                <select class="form-control" id="storeChooseArea" name="area_id">
                                    @foreach ($areas as $value)
                                        <option value="{{ $value->id_area }}">{{ $value->area_name }}</option>
                                    @endforeach
                                </select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama Rak</label>
                                <input id="rack_name" type="text" class="form-control" name="rack_name" required autocomplete="name" autofocus>
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
<div class="modal fade" id="editRackModal" tabindex="-1" role="dialog" aria-labelledby="editRackModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editRackModalLabel">Ubah Rak</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="updateRack">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
                        <div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for="">Area</label>
                                <select class="form-control" id="updateChooseArea" name="area_id">
                                    @foreach ($areas as $value)
                                        <option value="{{ $value->id_area }}">{{ $value->area_name }}</option>
                                    @endforeach
                                </select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama Rak</label>
								<input type="text" class="form-control" id="namarak" name="rack_name">
								<input type="hidden" id="id_rack" name="id_rack">
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
    $('#storeChooseArea').select2({
        dropdownParent: $('#addRackModal'),
    });

    $('#updateChooseArea').select2({
        dropdownParent: $('#editRackModal'),
    });
    
    // tambah rak
    $('#storeRack').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            $.ajax({
                url: "rack/",
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
                data: $('#storeRack').serialize(),
                dataType: "json",
                success: function (data) {
                    swal({
                        title: 'Berhasil!',
                        text: 'Berhasil menambahkan rak!',
                        icon: 'success'
                    }).then(function () {
                        $('#addRackModal').modal('hide');
                        window.location.href = "{{ route('rack.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e.responseJSON.message)
                    swal({
                        title: 'Gagal!',
                        text: 'Gagal menambahkan rak!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });

    // edit rak
    function editRack(id) {
        $.ajax({
            url: "rack/" +id+ "/edit",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#editRackModal').modal('show');
                $("#id_rack").val(data.id_rack);
                $("#updateChooseArea").val(data.area_id).change();
                $("#namarak").val(data.rack_name);
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }
    $('#updateRack').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id_rack').val()
            $.ajax({
                url: "rack/" + id,
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
                data: $('#updateRack').serialize(),
                dataType: "json",
                success: function (data) {
                    console.log(data.status)
                    swal({
                        title: 'Berhasil!',
                        text: 'Rak berhasil diperbarui!',
                        icon: 'success'
                    }).then(function () {
                        $('#editRackModal').modal('hide');
                        window.location.href = "{{ route('rack.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e)
                    swal({
                        title: 'Gagal!',
                        text: 'Rak gagal diperbarui!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });

    // hapus rak
    function deleteRack(id) {
		swal({
			title: "Apakah anda yakin ?",
			text: "Anda akan menghapus rak",
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
					swal("Rak aman");
					break;
				case 'delete':
					$.ajax({
						url: "rack/" + id,
                        type: "POST",
                        data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
						dataType: "json",
						success: function (data) {
							console.log(data)
							if (data == "error") {
								swal({
									title: 'Gagal menghapus rak!',
									text: 'Silahkan menghubungi IT',
									icon: 'error'
								})
							} else {
								swal("Rak berhasil dihapus", {
									icon: "success",
								}).then(function () {
									window.location.href = "{{ route('rack.index') }}";
								});
							}
						},
						error: function () {
							swal({
								text: 'Rak gagal dihapus!',
								icon: 'error'
							})
						}
					});
				break;
			}
		});
	}
</script>
@endsection