@extends('base')
@section('content')
<div class="container-fluid">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
                <h6 class="h2 text-white d-inline-block mb-0">Pengaturan akses pengguna</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
            <a href="" type="button" class="btn btn-success"
				data-toggle="modal" data-target="#addUserModal"><i class="fas fa-user-plus"></i> Tambah Pengguna</a>
            </div>
        </div>
        <!-- Card stats -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Pengguna</h3>
                        <p class="text-sm mb-0">
                            Daftar akses pengguna sistem monitoring gudang.
                        </p>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>Nama</th>
                                    <th>E-mail</th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $users as $key => $value )
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    @if ( $value->is_admin == 1 )
                                        <th>{{ $value->name }} | <b>Administrator</b></th>
                                    @else
                                        <th>{{ $value->name }}</th>
                                    @endif
                                    <th>{{ $value->email }}</th>
                                    <th>
                                        <a href="javascript:void(0)" onclick="editUser(<?= $value->id ?>)"
                                            class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="javascript:void(0)" onclick="changePassword(<?= $value->id ?>)"
                                            class="btn btn-outline-warning btn-sm"><i class="fas fa-key"></i> Change Password</a>
                                        @if ( $value->is_admin != 1 )
                                            <a href="javascript:void(0)" onclick="deleteUser(<?= $value->id ?>)"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                        @endif
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
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="storeUser">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama</label>
                                <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for="">E-mail</label>
                                <input id="email" type="email" class="form-control" name="email" required autocomplete="email">
							</div>
						</div>
                    </div>
                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for="">Password</label>
                                <input id="password" type="password" class="form-control" minlength="8" name="password" required autocomplete="new-password">
							</div>
						</div>
                    </div>
                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for="">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editUserModalLabel">Ubah Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="updateUser">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama</label>
								<input type="text" class="form-control" id="name" name="name">
								<input type="hidden" id="id" name="id">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for="">E-mail</label>
                                <input type="email" class="form-control" name="email" id="email">
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
<!-- CHANGE PASSWORD -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="changePassword">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" id="id" name="id">
                                <label class="form-control-label" for="">Password</label>
                                <input id="password" type="password" class="form-control" minlength="8" name="password" required autocomplete="new-password">
							</div>
						</div>
                    </div>
                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
                                <label class="form-control-label" for="">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
    // tambah user
    $('#storeUser').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            $.ajax({
                url: "user/",
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
                data: $('#storeUser').serialize(),
                dataType: "json",
                success: function (data) {
                    swal({
                        title: 'Berhasil!',
                        text: 'Berhasil menambahkan user!',
                        icon: 'success'
                    }).then(function () {
                        $('#addUserModal').modal('hide');
                        window.location.href = "{{ route('user.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e.responseJSON.message)
                    if ( e.responseJSON.message == "email") {
                        swal({
                            title: 'Gagal!',
                            text: 'Gagal menambahkan user!, email sudah didaftarkan',
                            icon: 'error'
                        })    
                    } else if ( e.responseJSON.message == "password" ) {
                        swal({
                            title: 'Gagal!',
                            text: 'Gagal menambahkan user!, password tidak sama',
                            icon: 'error'
                        })
                    } else {
                        swal({
                            title: 'Gagal!',
                            text: 'Gagal menambahkan user!, silahkan menghubungi IT',
                            icon: 'error'
                        })
                    }
                }
            });
            return false;

        }
    });

    // edit user
    function editUser(id) {
        $.ajax({
            url: "user/" +id+ "/edit",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#editUserModal').modal('show');
                $("#id").val(data.id);
                $("#name").val(data.name);
                $("#email").val(data.email);
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }
    $('#updateUser').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id').val()
            $.ajax({
                url: "user/" + id,
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
                data: $('#updateUser').serialize(),
                dataType: "json",
                success: function (data) {
                    console.log(data.status)
                    swal({
                        title: 'Berhasil!',
                        text: 'User berhasil diperbarui!',
                        icon: 'success'
                    }).then(function () {
                        $('#editUserModal').modal('hide');
                        window.location.href = "{{ route('user.index') }}";
                    });
                },
                error: function (e) {
                    console.log(e)
                    swal({
                        title: 'Gagal!',
                        text: 'User gagal diperbarui!, silahkan menghubungi IT',
                        icon: 'error'
                    })
                }
            });
            return false;

        }
    });

    // ganti password
    function changePassword(id) {
        $.ajax({
            url: "user/" +id+ "/edit",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#changePasswordModal').modal('show');
                $("#id").val(data.id);
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }
    $('#changePassword').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id').val()
            $.ajax({
                url: "user/changepassword/" +id,
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
                data: $('#changePassword').serialize(),
                dataType: "json",
                success: function (data) {
                    swal({
                        title: 'Berhasil!',
                        text: 'Berhasil mengubah password!',
                        icon: 'success'
                    }).then(function () {
                        $('#changePasswordModal').modal('hide');
                        window.location.href = "{{ route('user.index') }}";
                    });
                },
                error: function (e) {
                    if ( e.responseJSON.message == "password" ) {
                        swal({
                            title: 'Gagal!',
                            text: 'Gagal mengubah password!, password tidak sama',
                            icon: 'error'
                        })
                    } else {
                        swal({
                            title: 'Gagal!',
                            text: 'Gagal mengubah password!, silahkan menghubungi IT',
                            icon: 'error'
                        })
                    }
                }
            });
            return false;

        }
    });

    // hapus user
    function deleteUser(id) {
		swal({
			title: "Apakah anda yakin ?",
			text: "Anda akan menghapus user",
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
					swal("User aman");
					break;
				case 'delete':
					$.ajax({
						url: "user/" + id,
                        type: "POST",
                        data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
						dataType: "json",
						success: function (data) {
							console.log(data)
							if (data == "error") {
								swal({
									title: 'Gagal menghapus user!',
									text: 'Silahkan menghubungi IT',
									icon: 'error'
								})
							} else {
								swal("User berhasil dihapus", {
									icon: "success",
								}).then(function () {
									window.location.href = "{{ route('user.index') }}";
								});
							}
						},
						error: function () {
							swal({
								text: 'User gagal dihapus!',
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