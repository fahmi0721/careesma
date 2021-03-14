$(document).ready(function () {
	Clear();
	// SearchForm();
	// getPendidikan();
	// getKtp();
	//LoadData();
	LoadData();
	

});


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
	$("#DetailData").html("");
	page = page == undefined ? 1 : page;
	Id = $("#IdJ").val();
	$.ajax({
		type: "POST",
		url: "inc/Applicanto/proses.php?proses=DetailData",
		data: "Page=" + page+"&Id="+Id,
		beforeSend: function () {
			StartLoad();
		},
		success: function (res) {
			var result = JSON.parse(res);
			var html = "<div class='row'>";
			console.log(result);
			if (result['total_data'] > 0) {
				for (var i = 0; i < result['data'].length; i++) {
					var r = result['data'][i];
					html += "<div class='col-md-3 col-sm-6 col-xs-12'>";
						html += "<div class='panel'>";
							html += "<div class='panel-body'>";
								html += "<div class='box-tk-utama'>";
									html += "<div class='box-image'><img class='img-responsive' src='"+r['Foto']+"'></div><hr>";
									html += "<div class='box-caption'>";
										html += "<h4 data-toggle='tooltip' title=''>" + r['Nama'] + "<br><small>[" + r['NoKtp']+"]</small></h4>";
										html += "<label class='label bg-teal' data-toggle='tooltip' title='Pendidikan Terakhir'><i class='fa fa-tag'></i> " + r['Pendidikan'] + "</label>";
										html += r['Tkdb'];
									html += "</div>";
									html += "<span class='clearfix'></span>";
                    			html += "</div>";
							html += "</div>";
							html += "<div class='box-button-detail'>";
								html += "<a href='index.php?page=ProfilData&Idx="+r['NoKtps']+"' class='btn btn-success btn-block btn-flat' data-toggle='tooltip' title='Detail Data Pelamar'><i class='fa fa-eye'></i> Lihat Detail</a>";
							html += "</div>";
						html += "</div>";
					html += "</div>";
					
				}
			} else {
				html = result['data'];
			}
			html += "</div>";
			$("#DetailData").html(html);
			// var PagingInfo = "Menampilkan " + result['data_new'] + " Ke " + result['data_last'] + " dari " + result['total_data'];
			// $("#PagingInfo").html(PagingInfo);
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
	$("#Title").html("Tampil Data Pelamar");
	$("#close_modal").trigger('click');
	$("#DetailData").show();
	$("#aksi").val("");
	$(".proses, #ProsesCrud").html("");
	$(".FormInput").val("");
	$(".FormInput").prop("readonly", false);
	$(".FormInput").prop("disabled", false);
	$("#BtnControl").show();

}
$("#FormData").submit(function (e) {
	e.preventDefault();
	LoadData(1);

})

function Export(){
	var iData = "IdJ=" + $("#IdJ").val();
	window.open("exp.php?" + iData, "MsgWindow", "width=200,height=100");
}


