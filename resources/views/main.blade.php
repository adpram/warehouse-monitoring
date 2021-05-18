@extends('layouts.app')

@section('style')
<style>
    .central-store {
        border: 1px solid #95a5a6;
        border-radius: 5px;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .title-cs {
        padding-bottom: 30px;
    }

    .item {
        padding: 20px 25px 15px;
        border-radius: 8px;
    }
    
    .modal-button {
        justify-content: center
    }
    .modal-div { 
        width: 50%;
    }
    .modal-parent {
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="container central-store">
    <h5 class="title-cs text-center">CENTRAL STORE</h5>
    <div class="row justify-content-center">
        <div class="col-md-3 mb-2">
            <select class="form-control" id="selectArea">
                <option value=""></option>
                @foreach ( $areas as $value )
                    <option value="{{ $value->id_area }}">{{ $value->area_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <select class="form-control" id="selectRack" disabled></select>
        </div>
        <div class="col-md-3 mb-2">
            <select class="form-control" id="selectBinLocation" disabled></select>
        </div>
        <div class="col-md-1 mb-2 text-right">
            <a href="javascript:void(0)" onclick="searchBin()" class="btn btn-primary"><i class="fas fa-search"></i> Cari</a>
        </div>
    </div>
    <div class="row justify-content-center mt-4" id="bin-list"></div>
</div>
<!-- Modal -->
<!-- ADD -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addItemModalLabel">Tambah Item</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="storeItem">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Kode Item</label>
                                <input id="item_code" type="text" class="form-control" name="item_code" required autofocus>
                                <input type="hidden" id="bin_id" name="bin_id">
                                @guest
                                    <input type="hidden" name="user_id" id="user_id" value="login">
                                @else
                                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                                @endguest
							</div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama Item</label>
                                <input id="item_name" type="text" class="form-control" name="item_name" required autofocus>
							</div>
                        </div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label" for="">Jumlah</label>
                                <input id="qty" type="number" class="form-control" min="1" name="qty" required autofocus>
							</div>
                        </div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label" for="">Satuan</label>
                                <input id="unit" type="text" class="form-control" name="unit" required autofocus>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Tambahkan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- info or reduce item -->
<div class="modal fade" id="infoOrReduceItemModal" tabindex="-1" role="dialog" aria-labelledby="infoOrReduceItemModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-parent" role="document">
		<div class="modal-content modal-div"> 
            <div class="modal-footer modal-button" id="infoReduceItem"></div>
		</div>
	</div>
</div>
<!-- Info item -->
<div class="modal fade" id="infoItemModal" tabindex="-1" role="dialog" aria-labelledby="infoItemModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="infoItemModalLabel">Detail Item</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <th width="20%">Kode</th>
                        <th class="text-center">:</th>
                        <td id="detail_item_code"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <th class="text-center">:</th>
                        <td id="detail_item_name"></td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <th class="text-center">:</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th class="text-right">Area</th>
                        <th class="text-center">:</th>
                        <td id="detail_item_area"></td>
                    </tr>
                    <tr>
                        <th class="text-right">Rak</th>
                        <th class="text-center">:</th>
                        <td id="detail_item_rack"></td>
                    </tr>
                    <tr>
                        <th class="text-right">Bin-Location</th>
                        <th class="text-center">:</th>
                        <td id="detail_item_bin_location"></td>
                    </tr>
                    <tr>
                        <th class="text-right">Bin</th>
                        <th class="text-center">:</th>
                        <td id="detail_item_bin"></td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <th class="text-center">:</th>
                        <td id="detail_item_qty_unit"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#selectArea').select2({
            placeholder: "Pilih Area",
            allowClear: true
        });

        $('#selectRack').select2({
            placeholder: "Pilih Rak",
            allowClear: true
        });
        $('#selectBinLocation').select2({
            placeholder: "Pilih Bin Location",
            allowClear: true
        });

        $("#selectArea").on('change', function() {
            var area = $( "#selectArea option:selected" ).val()
            if ( area ) {
                $.ajax({
                    url: "main/rack/" + area,
                    type: "GET",
                    dataType: "JSON",
                    success: function (data) {
                        $('#selectRack').prop('disabled', false);
                        console.log(data);
                        var i;
                        var html = '<option value=""></option>';
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+data[i].id_rack+'">'+data[i].rack_name+'</option>';
                        }
                        $('#selectRack').html(html);
                    },
                    error: function () {
                        alert("Can not show the data!");
                    }
                })
            } 
        })

        $("#selectRack").on('change', function() {
            var rack = $( "#selectRack option:selected" ).val()
            if ( rack ) {
                $.ajax({
                    url: "main/bin-location/" + rack,
                    type: "GET",
                    dataType: "JSON",
                    success: function (data) {
                        $('#selectBinLocation').prop('disabled', false);
                        console.log(data);
                        var i;
                        var html = '<option value=""></option>';
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+data[i].id_bin_location+'">'+data[i].bin_location_name+'</option>';
                        }
                        $('#selectBinLocation').html(html);
                    },
                    error: function () {
                        alert("Can not show the data!");
                    }
                })
            } 
        })    
    });

    function searchBin() {
        if ($( "#selectArea option:selected" ).val() == ''){
            swal({
                title: 'Gagal!',
                text: 'Gagal mencari data!, silahkan pilih Area terlebih dahulu',
                icon: 'error'
            })
        } else if ($( "#selectBinLocation option:selected" ).val() == '') {
            swal({
                title: 'Gagal!',
                text: 'Gagal mencari data!, silahkan pilih Bin-Location terlebih dahulu',
                icon: 'error'
            })
        } else {
            var binlocation = $( "#selectBinLocation option:selected" ).val()
            $.ajax({
                url: "main/bin/" + binlocation,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    if (data.length > 0) {
                        var i;
                        var html = '';
                        for(i=0; i<data.length; i++){
                            if ( data[i].id_item != null ) {
                                html += '<div class="col-md-2 mb-3 text-center"><a href="javascript:void(0)" onclick="infoOrReduceItem('+data[i].id_bin+')" class="btn btn-warning item"><h2>'+data[i].bin_name+'</h2></a></div>';
                            } else {
                                html += '<div class="col-md-2 mb-3 text-center"><a href="javascript:void(0)" onclick="addItem('+data[i].id_bin+')" class="btn btn-outline-success item" data-toggle="tooltip" title="Tambah Item"><h2>'+data[i].bin_name+'</h2></a></div>';
                            }
                        }
                    } else {
                        var html = '<div class="col-md-12 mb-3 text-center"><h6>Belum ada data</h6></div>';
                    }
                    $('#bin-list').html(html);
                },
                error: function () {
                    alert("Can not show the data!");
                }
            })
        }
    }

    function infoOrReduceItem(id) {
        $('#infoOrReduceItemModal').modal('show');
        var html = '<a href="javascript:void(0)" onclick="infoItem('+id+')" class="btn btn-secondary"><i class="fas fa-info-circle"></i> Info</a><a href="javascript:void(0)" onclick="reduceItem('+id+')" class="btn btn-danger"><i class="fas fa-minus-circle"></i> Kurangi</a>'
        $("#infoReduceItem").html(html)
    }

    function addItem(id) {
        var user = $("#user_id").val()
        if ( user == 'login' ) {
            swal({
                title: 'Error!',
                text: 'Akses diperlukan, silahkan masuk terlebih dahulu',
                icon: 'error'
            })
        } else {
            $('#addItemModal').modal('show');
            $('#addItemModal form')[0].reset();
            $("#bin_id").val(id)
            $('#storeItem').on('submit', function (e) {
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: "item/",
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
                        data: $('#storeItem').serialize(),
                        dataType: "json",
                        success: function (data) {
                            swal({
                                title: 'Berhasil!',
                                text: 'Berhasil menambahkan Item!',
                                icon: 'success'
                            }).then(function () {
                                $('#addItemModal').modal('hide');
                                $.ajaxSetup ({
                                    cache: false
                                });
                                searchBin();
                            });
                        },
                        error: function (e) {
                            console.log(e.responseJSON.message)
                            if ( e.responseJSON.message == "kode") {
                                swal({
                                    title: 'Gagal!',
                                    text: 'Gagal menambahkan Item!, karena kode sama atau item sudah ditambahkan',
                                    icon: 'error'
                                })    
                            } else {
                                swal({
                                    title: 'Gagal!',
                                    text: 'Gagal menambahkan Item!, silahkan menghubungi IT',
                                    icon: 'error'
                                })
                            }
                        }
                    });
                    return false;

                }
            });
        }
    }

    function infoItem(id) {
        $('#infoOrReduceItemModal').modal('hide');
        $.ajax({
            url: "info/item/" +id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $('#infoItemModal').modal('show');
                $('#detail_item_code').html(data[0].item_code);
                $('#detail_item_name').html(data[0].item_name);
                $('#detail_item_area').html(data[0].area_name);
                $('#detail_item_rack').html(data[0].rack_name);
                $('#detail_item_bin_location').html(data[0].bin_location_name);
                $('#detail_item_bin').html(data[0].bin_name);
                $('#detail_item_qty_unit').html(data[0].qty + " " + data[0].unit);
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }

    function reduceItem(id) {
        alert(id)
    }
</script>
@endsection