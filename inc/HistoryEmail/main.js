$(document).ready(function () {
	Clear();
	SearchForm();
	GetLowongan();
	
	
});

function SearchForm() {
	$('.select-category').select2({
		theme: "bootstrap",
		placeholder: 'Pilih Lowongan',
	});
}

function GetLowongan(){
	$.ajax({
		type : "POST",
		url: "inc/HistoryEmail/proses.php?proses=LoadData",
		data : "rule=getLowongan",
		beforeSend : function(){
			StartLoad();
		},
		success : function(r){
			var res = JSON.parse(r);
			console.log(res);
			var html = "<option value=''></option>";
			if(res['data'].length > 0){
				for (var i = 0; i < res['data'].length; i++ ){
					var iData = res['data'][i];
					html += "<option value='"+iData['Id']+"'>"+iData['Judul']+"</option>";
				}
			}
			$("#IdLowongan").html(html);
			StopLoad();
		},
		error : function(er){
			console.log(er);
		}
	})
}

function pagination(page_num, total_page) {
	page_num = parseInt(page_num);
	total_page = parseInt(total_page);
	var paging = "<ul class='pagination btn-sm'>";
	if (page_num > 1) {
		var prev = page_num - 1;
		paging += "<li><a href='javascript:void(0);' onclick='LoadData(" + prev + ")'>Prev</a></li>";
	} else {
		paging += "<li class='disabled'><a>Prev</a></li>";
	}
	var show_page = 0;
	for (var page = 1; page <= total_page; page++) {
		if (((page >= page_num - 3) && (page <= page_num + 3)) || (page == 1) || page == total_page) {
			if ((show_page == 1) && (page != 2)) {
				paging += "<li class='disabled'><a>...</a></li>";
			}
			if ((show_page != (total_page - 1)) && (page == total_page)) {
				paging += "<li class='disabled'><a>...</a></li>";
			}

			if (page == page_num) {
				var aktif = formatRupiah(page);
				paging += "<li class='active'><a>" + aktif + "</a></li>";
			} else {
				var aktif = formatRupiah(page);
				paging += "<li class='javascript:void(0)'><a onclick='LoadData(" + page + ")'>" + aktif + "</a></li>";
			}
			show_page = page;
		}
	}

	if (page_num < total_page) {
		var next = page_num + 1;
		paging += "<li><a href='javascript:void(0)' onclick='LoadData(" + next + ")'>Next</a></li>";
	} else {
		paging += "<li class='disabled'><a>Next</a></li>";
	}
	$("#Paging").html(paging);
}

function LoadData(page) {
	if($("#IdLowongan").val() == ""){ Customerror("Seleksi Berkas", "002", "Lowongan belum dipilih", 'proses'); $("#IdLowongan").focus(); scrolltop(); return false;  }
	page = page == undefined ? 1 : page;
	var RowPage = $("#RowPage").val();
	var Search = $("#Search").val();
	var IdLowongan = $("#IdLowongan").val();
	$.ajax({
		type: "POST",
		url: "inc/HistoryEmail/proses.php?proses=DetailData",
		data: "Search=" + Search + "&RowPage=" + RowPage + "&Page=" + page+"&IdLowongan="+IdLowongan,
		beforeSend: function () {
			StartLoad();
		},
		success: function (res) {
			var result = JSON.parse(res);
			console.log(res);
			var html = "";
			if (result['total_data'] > 0) {
				$("#DetailData").show();
				for (var i = 0; i < result['data'].length; i++) {
					var r = result['data'][i];
					html += "<tr>";
					html += "<td class='text-center'>" + r['No'] + "</td>";
					html += "<td>" + r['Nama'] +"<br /><small>No KTP : "+r['NoKtp']+"</small></td>";
					html += "<td>" + r['JK'] +"</td>";
					html += "<td>" + r['Tgl'] + "</td>";
					html += "<td>" + r['Pesan'] + "</td>";
					html += "</tr>";
				}
			} else {
				$("#DetailData").show();
				html = "<tr><td class='text-center' colspan='7'>No data availible in table.</td></tr>";
			}
			$("#ShowData").html(html);
			var PagingInfo = "Menampilkan " + result['data_new'] + " Ke " + result['data_last'] + " dari " + result['total_data'];
			$("#PagingInfo").html(PagingInfo);
			pagination(page, result['total_page']);
			$("[data-toggle='tooltip']").tooltip();
			StopLoad();
		},
		error: function (er) {
			$("#proses").html(er['responseText']);
			StopLoad();
		}
	})

}


function Clear() {
	$("#Title").html("Histori Pengiriman Email");
	$("#close_modal").trigger('click');
	$("#FormData").show();
	$("#DetailData").hide();
	$("#aksi").val("");
	$(".proses, #ProsesCrud").html("");
	$(".FormInput").val("");
	$(".FormInput").prop("readonly", false);
	$(".FormInput").prop("disabled", false);
	$("#BtnControl").show();
	$(".select-category").val(null).trigger("change");

}

$("#FormData").submit(function (e) {
	e.preventDefault();
	LoadData();

})