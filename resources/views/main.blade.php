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
        width: 70%;
    }
    .modal-parent {
        justify-content: center;
    }

    .inputText {
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container central-store">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" class="btn btn-sm btn-primary">Central Store</a></li>&nbsp;
            <li><a href="#tab_2" data-toggle="tab" class="btn btn-sm btn-primary">Cari Item</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <br>
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
        <div class="tab-pane" id="tab_2">
            <br>
            <h5 class="title-cs text-center">Daftar Item</h5>
            <div class="row">
                <div class="col-md-3">
                    <p>Total : {{ count($items) }} Item</p>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-3">            
                    <input class="inputText form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari...">
                </div>
            </div>
            <table class="table" id="list-table">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 7%">#</th>
                        <th style="width: 30%">Item</th>
                        <th style="width: 23%">Jumlah</th>
                        <th style="width: 40%">Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $items as $key => $value )
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><b>{{ $value->item_name }}</b>  ( {{ $value->item_code }} )</td>
                        @php
                            $total = 0;
                            foreach ( $value->mutation as $mutation ) {
                                $total += $mutation->qty;
                            }
                        @endphp
                        <td>{{ $total }} {{ $value->unit }}</td>
                        <td>{{ $value->bin->binlocation->rack->area->area_name }} -> {{ $value->bin->binlocation->rack->rack_name }} -> {{ $value->bin->binlocation->bin_location_name }} -> {{ $value->bin->bin_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Add new -->
<div class="modal fade" id="addNewItemModal" tabindex="-1" role="dialog" aria-labelledby="addNewItemModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addNewItemModalLabel">Tambah Item Baru</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="storeNewItem">
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
            <div class="modal-footer" id="button-detail"></div>
		</div>
	</div>
</div>
<!-- add -->
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
			<form class="form-horizontal" id="addItem">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Kode Item</label>
                                <input id="add_item_code" type="text" class="form-control" name="item_code" readonly autofocus>
                                <input type="hidden" id="add_id_item" name="add_id_item">
                                @guest
                                    <input type="hidden" name="user_id" id="add_user_id" value="login">
                                @else
                                    <input type="hidden" name="user_id" id="add_user_id" value="{{ Auth::user()->id }}">
                                @endguest
							</div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama Item</label>
                                <input id="add_item_name" type="text" class="form-control" name="item_name" readonly autofocus>
							</div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Total</label>
                                <input id="add_total_info" type="text" class="form-control" readonly autofocus>
							</div>
                        </div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label" for="">Jumlah (+)</label>
                                <input id="add_qty" type="number" class="form-control" min="1" name="qty" required autofocus>
                                <input type="hidden" name="transtype" value="in">
							</div>
                        </div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label" for="">Satuan</label>
                                <input id="add_unit" type="text" class="form-control" name="unit" readonly autofocus>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-success">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Reduce -->
<div class="modal fade" id="reduceItemModal" tabindex="-1" role="dialog" aria-labelledby="reduceItemModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="reduceItemModalLabel">Kurangi Item</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" id="reduceItem">
				<div class="modal-body">
					<!-- Form groups used in grid -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Kode Item</label>
                                <input id="reduce_item_code" type="text" class="form-control" name="item_code" readonly autofocus>
                                <input type="hidden" id="reduce_id_item" name="reduce_id_item">
                                @guest
                                    <input type="hidden" name="user_id" id="reduce_user_id" value="login">
                                @else
                                    <input type="hidden" name="user_id" id="reduce_user_id" value="{{ Auth::user()->id }}">
                                @endguest
							</div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Nama Item</label>
                                <input id="reduce_item_name" type="text" class="form-control" name="item_name" readonly autofocus>
							</div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label" for="">Total</label>
                                <input id="reduce_total_info" type="text" class="form-control" readonly autofocus>
                                <input id="reduce_total" type="hidden">
							</div>
                        </div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label" for="">Jumlah (-)</label>
                                <input id="reduce_qty" type="number" class="form-control" min="1" name="qty" required autofocus>
                                <input type="hidden" name="transtype" value="out">
							</div>
                        </div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label" for="">Satuan</label>
                                <input id="reduce_unit" type="text" class="form-control" name="unit" readonly autofocus>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-danger">Kurangi</button>
				</div>
			</form>
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
                    if (data.length > 0) {
                        var i;
                        var html = '';
                        for(i=0; i<data.length; i++){
                            if ( data[i].id_item != null ) {
                                html += '<div class="col-md-2 mb-3 text-center"><a href="javascript:void(0)" onclick="infoItem('+data[i].id_bin+')" class="btn btn-warning item"><h2>'+data[i].bin_name+'</h2></a></div>';
                            } else {
                                html += '<div class="col-md-2 mb-3 text-center"><a href="javascript:void(0)" onclick="addNewItem('+data[i].id_bin+')" class="btn btn-outline-success item" data-toggle="tooltip" title="Tambah Item"><h2>'+data[i].bin_name+'</h2></a></div>';
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

    function addNewItem(id) {
        var user = $("#user_id").val()
        if ( user == 'login' ) {
            swal({
                title: 'Error!',
                text: 'Akses diperlukan, silahkan masuk terlebih dahulu',
                icon: 'error'
            })
        } else {
            $('#addNewItemModal').modal('show');
            $('#addNewItemModal form')[0].reset();
            $("#bin_id").val(id)
            $('#storeNewItem').on('submit', function (e) {
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
                        data: $('#storeNewItem').serialize(),
                        dataType: "json",
                        success: function (data) {
                            swal({
                                title: 'Berhasil!',
                                text: 'Berhasil menambahkan Item!',
                                icon: 'success'
                            }).then(function () {
                                $('#addNewItemModal').modal('hide');
                                $.ajaxSetup ({
                                    cache: false
                                });
                                searchBin();
                            });
                        },
                        error: function (e) {
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
        var html = '<a href="javascript:void(0)" onclick="addItem('+id+')" class="btn btn-success"><i class="fas fa-plus-circle"></i> Tambah</a><a href="javascript:void(0)" onclick="reduceItem('+id+')" class="btn btn-danger"><i class="fas fa-minus-circle"></i> Kurangi</a><button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>'
        $("#button-detail").html(html)
        $.ajax({
            url: "info/item/" +id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#infoItemModal').modal('show');
                $('#detail_item_code').html(data[0].item_code);
                $('#detail_item_name').html(data[0].item_name);
                $('#detail_item_area').html(data[0].area_name);
                $('#detail_item_rack').html(data[0].rack_name);
                $('#detail_item_bin_location').html(data[0].bin_location_name);
                $('#detail_item_bin').html(data[0].bin_name);
                var total = 0;
                for($i=0;$i<data.length;$i++){
                    total += data[$i].qty
                }
                $('#detail_item_qty_unit').html(total + " " + data[0].unit);
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }

    function addItem(id) {
        $('#infoItemModal').modal('hide');
        $.ajax({
            url: "info/item/" +id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                var user = $("#add_user_id").val()
                if ( user == 'login' ) {
                    swal({
                        title: 'Error!',
                        text: 'Akses diperlukan, silahkan masuk terlebih dahulu',
                        icon: 'error'
                    })
                } else {
                    $('#addItemModal').modal('show');
                    $('#addItemModal form')[0].reset();
                    $('#add_id_item').val(data[0].id_item);
                    $('#add_item_code').val(data[0].item_code);
                    $('#add_item_name').val(data[0].item_name);
                    $('#add_unit').val(data[0].unit);
                    var total = 0;
                    for($i=0;$i<data.length;$i++){
                        total += data[$i].qty
                    }
                    $('#add_total_info').val(total + " " + data[0].unit);
                    $('#addItem').on('submit', function (e) {
                        if (!e.isDefaultPrevented()) {
                            $.ajax({
                                url: "mutation/",
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
                                data: $('#addItem').serialize(),
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
                                    swal({
                                        title: 'Gagal!',
                                        text: 'Gagal menambahkan Item!, silahkan menghubungi IT',
                                        icon: 'error'
                                    })
                                }
                            });
                            return false;

                        }
                    });
                }
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }

    function reduceItem(id) {
        $('#infoItemModal').modal('hide');
        $.ajax({
            url: "info/item/" +id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                var user = $("#reduce_user_id").val()
                if ( user == 'login' ) {
                    swal({
                        title: 'Error!',
                        text: 'Akses diperlukan, silahkan masuk terlebih dahulu',
                        icon: 'error'
                    })
                } else {
                    $('#reduceItemModal').modal('show');
                    $('#reduceItemModal form')[0].reset();
                    $('#reduce_id_item').val(data[0].id_item);
                    $('#reduce_item_code').val(data[0].item_code);
                    $('#reduce_item_name').val(data[0].item_name);
                    $('#reduce_unit').val(data[0].unit);
                    var total = 0;
                    for($i=0;$i<data.length;$i++){
                        total += data[$i].qty
                    }
                    $('#reduce_total_info').val(total + " " + data[0].unit);
                    $('#reduce_total').val(total);
                    $("#reduce_qty").attr('max', total);
                    $('#reduceItem').on('submit', function (e) {
                        var maxtotal = $("#reduce_qty").val();
                        var newtotal = $("#reduce_total").val()
                        if ( parseInt(newtotal) - parseInt(maxtotal) == 0 ) {
                            var itemID = $('#reduce_id_item').val()
                            swal({
                                title: "Apakah anda yakin ?",
                                text: "Anda akan mengeluarkan item secara keseluruhan dan menghapusnya",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $.ajax({
                                        url: "/item/delete/" + itemID,
                                        type: "POST",
                                        data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
                                        dataType: "json",
                                        success: function (data) {
                                            swal("Item berhasil dikeluarkan seluruhnya dan dihapus", {
                                                icon: "success",
                                            }).then(function () {
                                                $('#reduceItemModal').modal('hide');
                                                $.ajaxSetup ({
                                                    cache: false
                                                });
                                                searchBin();
                                            });
                                        },
                                        error: function (e) {
                                            swal({
                                                text: 'Item gagal dihapus!, silahkan hubungi IT',
                                                icon: 'error'
                                            })
                                            $('#reduceItemModal').modal('hide');
                                            $.ajaxSetup ({
                                                cache: false
                                            });
                                            searchBin();
                                        }
                                    });      
                                } else {
                                    swal("Item aman");
                                    $('#reduceItemModal').modal('hide');
                                    $.ajaxSetup ({
                                        cache: false
                                    });
                                    searchBin();
                                }
                            });
                        } else {
                            console.log("kurangi")
                            if (!e.isDefaultPrevented()) {
                                $.ajax({
                                    url: "mutation/",
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
                                    data: $('#reduceItem').serialize(),
                                    dataType: "json",
                                    success: function (data) {
                                        swal({
                                            title: 'Berhasil!',
                                            text: 'Berhasil mengurangi Item!',
                                            icon: 'success'
                                        }).then(function () {
                                            $('#reduceItemModal').modal('hide');
                                            $.ajaxSetup ({
                                                cache: false
                                            });
                                            searchBin();
                                        });
                                    },
                                    error: function (e) {
                                        console.log(e.responseJSON.message)
                                        swal({
                                            title: 'Gagal!',
                                            text: 'Gagal mengurangi Item!, silahkan menghubungi IT',
                                            icon: 'error'
                                        })
                                    }
                                });
                            }                         
                        }
                        return false;
                    });
                }
            },
            error: function () {
                alert("Can not show the data!");
            }
        })
    }

    function myFunction() {

        // Declare variables 
        var input = document.getElementById("myInput");
        var filter = input.value.toUpperCase();
        var table = document.getElementById("list-table");
        var trs = table.tBodies[0].getElementsByTagName("tr");

        // Loop through first tbody's rows
        for (var i = 0; i < trs.length; i++) {

            // define the row's cells
            var tds = trs[i].getElementsByTagName("td");

            // hide the row
            trs[i].style.display = "none";

            // loop through row cells
            for (var i2 = 0; i2 < tds.length; i2++) {

                // if there's a match
                if (tds[i2].innerHTML.toUpperCase().indexOf(filter) > -1) {

                    // show the row
                    trs[i].style.display = "";

                    // skip to the next row
                    continue;

                }
            }
        }

    }
</script>
@endsection