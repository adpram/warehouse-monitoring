@extends('base')
@section('content')
<div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Pengaturan master area</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
            <a href="" type="button" class="btn btn-success"
				data-toggle="modal" data-target="#addAreaModal"><i class="fas fa-user-plus"></i> Tambah Area</a>
            </div>
        </div>
        <!-- Card stats -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Area</h3>
                        <p class="text-sm mb-0">
                            Daftar area pada sistem monitoring gudang.
                        </p>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>Nama Area</th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $areas as $key => $value )
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <th>{{ $value->area_name }}</th>
                                    <th>
                                        <a href="javascript:void(0)" onclick="editArea(<?= $value->id_area ?>)"
                                            class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="javascript:void(0)" onclick="deleteArea(<?= $value->id_area ?>)"
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
<div class="modal fade" id="addAreaModal" tabindex="-1" role="dialog" aria-labelledby="addAreaModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addAreaModalLabel">Tambah Area</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="storeArea">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama Area</label>
                                <input id="area_name" type="text" class="form-control" name="area_name" required autocomplete="name" autofocus>
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
<div class="modal fade" id="editAreaModal" tabindex="-1" role="dialog" aria-labelledby="editAreaModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editAreaModalLabel">Ubah Area</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="updateArea">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama Area</label>
								<input type="text" class="form-control" id="namaarea" name="area_name">
								<input type="hidden" id="id_area" name="id_area">
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
<script>
    // tambah area
    $('#storeArea').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            $.ajax({
                url: "area/",
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
                data: $('#storeArea').serialize(),
                dataType: "json",
                success: function (data) {
                    swal({
                        title: 'Berhasil!',
                        text: 'Berhasil menambahkan area!',
                        icon: 'success'
                    }).then(function () {
                        $('#addAreaModal').modal('hide');
                        window.location.href = "{{ route('area.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e.responseJSON.message)
                    swal({
                        title: 'Gagal!',
                        text: 'Gagal menambahkan area!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });

    // edit area
    function editArea(id) {
        $.ajax({
            url: "area/" +id+ "/edit",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#editAreaModal').modal('show');
                $("#id_area").val(data.id_area);
                $("#namaarea").val(data.area_name);
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }
    $('#updateArea').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id_area').val()
            $.ajax({
                url: "area/" + id,
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
                data: $('#updateArea').serialize(),
                dataType: "json",
                success: function (data) {
                    console.log(data.status)
                    swal({
                        title: 'Berhasil!',
                        text: 'Area berhasil diperbarui!',
                        icon: 'success'
                    }).then(function () {
                        $('#editAreaModal').modal('hide');
                        window.location.href = "{{ route('area.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e)
                    swal({
                        title: 'Gagal!',
                        text: 'Area gagal diperbarui!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });

    // hapus area
    function deleteArea(id) {
		swal({
			title: "Apakah anda yakin ?",
			text: "Anda akan menghapus area",
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
					swal("Area aman");
					break;
				case 'delete':
					$.ajax({
						url: "area/" + id,
                        type: "POST",
                        data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
						dataType: "json",
						success: function (data) {
                            swal("Area berhasil dihapus", {
                                icon: "success",
                            }).then(function () {
                                window.location.href = "{{ route('area.index') }}";
                            });
						},
						error: function (e) {
                            if ( e.responseJSON.message == "rak") {
                                swal({
                                    title: 'Gagal!',
                                    text: 'Gagal menghapus area!, karena masih ada rak',
                                    icon: 'error'
                                })    
                            } else {
                                swal({
                                    text: 'Area gagal dihapus!',
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