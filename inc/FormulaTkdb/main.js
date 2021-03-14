$(document).ready(function () {
	Clear();
	LoadData();
	SearchForm();
	getLoker();
	// $("#Tgl").datepicker({ 'format': "yyyy-mm-dd", autoclose: true });
});

function SearchForm() {
	$("#IdJobVacancy").select2({
		theme: "bootstrap",
		allowClear: true,
		ballowClear: true,
		placeholder: 'Pilih Lowongan Pekerjaan',
	});
}

function getLoker(){
	$.ajax({
		type : "POST",
		url: "inc/FormulaTkdb/proses.php?proses=LoadData",
		data : "rule=getLoker",
		success : function(r){
			var res = JSON.parse(r);
			var opt = "<option value=''>Pilih Lowongan Pekerjaan</option>";
			for(var i=0; i < res.length; i++){
				opt += "<option value='"+res[i]['Id']+"'>"+res[i]['Judul']+"</option>";
			}
			$("#IdJobVacancy").html(opt);
		},
		error: function(er){
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
	page = page == undefined ? 1 : page;
	var RowPage = $("#RowPage").val();
	var Search = $("#Search").val();
	$.ajax({
		type: "POST",
		url: "inc/FormulaTkdb/proses.php?proses=DetailData",
		data: "Search=" + Search + "&RowPage=" + RowPage + "&Page=" + page,
		beforeSend: function () {
			StartLoad();
		},
		success: function (res) {
			var result = JSON.parse(res);
			var html = "";
			if (result['total_data'] > 0) {
				for (var i = 0; i < result['data'].length; i++) {
					var r = result['data'][i];
					html += "<tr>";
					html += "<td class='text-center'>" + r['No'] + "</td>";
					html += "<td>" + r['Kode'] +"</td>";
					html += "<td>" + r['Judul'] + "</td>";
					html += "<td>" + r['Soal'] + "</td>";
					html += "<td class='text-center'>" + r['Aksi'] + "</td>";
					html += "</tr>";
				}
			} else {
				html = "<tr><td class='text-center' colspan='5'>No data availible in table.</td></tr>";
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
	$("#Title").html("Tampil Data Formula TKDB");
	$("#close_modal").trigger('click');
	$("#FormData").hide();
	$("#DetailData").show();
	$("#aksi").val("");
	$(".proses, #ProsesCrud").html("");
	$(".FormInput").val("");
	$(".FormInput").prop("readonly", false);
	$(".FormInput").prop("disabled", false);
	$("#BtnControl").show();
	ClearModal();

}

function ClearModal(){
	$(".modal-title").html("");
	$("#proses_modal").html("");
	$(".modal-footer").hide();

}

function Crud(Id, Status) {
	Clear();
	$("#proses").html("");
	if (Id) {
		if(Status == "Soal"){
			var IsiText = atob(Id);
			ClearModal();
			jQuery("#modal").modal('show', { backdrop: 'static' });
			$(".modal-title").html("Detail Isi Text");
			$("#proses_modal").html(IsiText);
		} else {
			ClearModal();
			jQuery("#modal").modal('show', { backdrop: 'static' });
			$("#aksi").val('delete');
			$(".modal-title").html("Konfirmasi Delete");
			$("#Id").val(Id)
			$("#proses_modal").html("<div class='alert alert-danger'>Apakah anda yakin ingin menghapus data ini ?</div>");
			$(".modal-footer").show();
		}
	} else {
		$("#Title").html("Tambah Data Formula TKDB");
		$("#FormData").show();
		$("#DetailData").hide();
		$("#proses").html("");
		$("#Judul").focus();
		$("#BtnControl").hide()
		$("#aksi").val("insert");

	}

}

function Validasi() {
	var aksi = $("#aksi").val();
	var iForm = ["IdJobVacancy"];
	var KetiForm = ["Lowongan Pekerjaan belum dipilih!"];
	for (var i = 0; i < iForm.length; i++) {
		if (aksi != "delete") {
			if ($("#" + iForm[i]).val() == "" || $("#" + iForm[i]).val() == null) {
				Customerror("Formula TKDB", "002", KetiForm[i], 'proses'); $("#" + iForm[i]).focus(); scrolltop(); return false; 
			}
		}
	}

	
}

$("#FormData").submit(function (e) {
	e.preventDefault();
	SubmitData();

})

function SubmitData() {
	if (Validasi() != false) {
		var data = $("#FormData").serialize();
		$.ajax({
			type: "POST",
			url: "inc/FormulaTkdb/proses.php?proses=Crud",
			data: data,
			beforeSend: function () {
				StartLoad();
			},
			success: function (result) {
				var res = JSON.parse(result);
				if (res['status'] == 'sukses') {
					Clear();
					Customsukses("Formula TKDB", '002', res['pesan'], 'proses');
					LoadData();
					StopLoad();
				} else {
					Customerror("Formula TKDB", "002", res['pesan'], 'proses');
					StopLoad();
				}
			},
			error: function (er) {
				$("#proses").html(er['responseText']);
				StopLoad();
			}
		});
	}
}
