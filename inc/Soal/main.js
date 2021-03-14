$(document).ready(function () {
	Clear();
	LoadData();
	LoadEditor();
	LoadSearchForm();
	getText();
	// $("#Tgl").datepicker({ 'format': "yyyy-mm-dd", autoclose: true });
});

function LoadEditor(){
	var iData = ['Soal','A',"B","C","D"];
	for(var i=0; i < iData.length; i++){
		EditorText(iData[i]);
	}
}

function LoadSearchForm() {
	var iData = 
			[
				{ 
					"Id": ".select-kode-text",
					"Str": "Pilih Text Kode"
				},
				{
					"Id": ".select-no-soal",
					"Str": "Pilih No Soal"
				},
				{
					"Id": ".select-kunci",
					"Str": "Pilih Kunci Jawaban"
				},
			];
			
			
	for (var i = 0; i < iData.length; i++) {
		SearchForm(iData[i]['Id'],iData[i]['Str']);
	}
}

function ChangeS(){
	var iData = ['.select-kode-text','.select-kunci'];
	for (var i = 0; i < iData.length; i++) {
		$(iData[i]).trigger("change");
	}
}

function ClearChangeS() {
	var iData = ['.select-kode-text','.select-no-soal', '.select-kunci'];
	for (var i = 0; i < iData.length; i++) {
		$(iData[i]).val(null).trigger("change");
	}
}


function SearchForm(Id,Str) {
	$(Id).select2({
		theme: "bootstrap",
		allowClear: true,
		ballowClear: true,
		placeholder: Str,
	});
}

function EditorText(Id) {
	$('#' + Id).wysihtml5({
		toolbar: {
			"font-styles": true, // Font styling, e.g. h1, h2, etc.
			"emphasis": true, // Italics, bold, etc.
			"lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
			"html": true, // Button which allows you to edit the generated HTML.
			"link": false, // Button to insert a link.
			"image": true, // Button to insert an image.
			"color": false, // Button to change color of font
			"blockquote": true, // Blockquote
			"size": "sm",
			"format-code": true 
		}
	});
}

function getText() {
	$.ajax({
		type: "POST",
		url: "inc/Soal/proses.php?proses=LoadData",
		data: "rule=getText",
		success: function (r) {
			var rs = JSON.parse(r);
			var html = "<option value=''>Pilih Text</option>";
			for (var i = 0; i < rs.length; i++) {
				html += "<option value='" + rs[i]['Kode'] + "'>" + rs[i]['Kode'] + " - "+ rs[i]['Judul'] + "</option>";
			}
			$("#KodeText").html(html);
		},
		error: function (er) {
			console.log(er);
		}
	})
}

function NomorSoal(aksi,Id){
	$.ajax({
		type : "POST",
		url : "inc/Soal/proses.php?proses=LoadData",
		data : "rule=NoSoal&aksi="+aksi,
		success : function(r){
			var rs = JSON.parse(r);
			console.log(rs);
			var html = "<option value=''>Pilih Nomor Soal</option>";
			if(aksi != "insert"){
				for (var i = 0; i < rs.length; i++){
					html += "<option value='" + rs[i]['No'] + "'>" + rs[i]['Nos']+"</option>";
					console.log(rs[i]['No']);
				}
				$("#NoSoal").html(html);
				
				$(".select-no-soal").val(Id);
				$(".select-no-soal").trigger("change");
			}else{
				html += "<option value='" + rs['No'] + "'>" + rs['Nos'] + "</option>";
				$("#NoSoal").html(html);
				
			}
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
	page = page == undefined ? 1 : page;
	var RowPage = $("#RowPage").val();
	var Search = $("#Search").val();
	$.ajax({
		type: "POST",
		url: "inc/Soal/proses.php?proses=DetailData",
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
					html += "<td>" + r['Kode'] + "</td>";
					html += "<td>" + r['NoSoal'] + "</td>";
					html += "<td>" + r['KodeText'] + "</td>";
					html += "<td>" + r['Soal'] + "</td>";
					html += "<td>" + r['KunciJawaban'] + "</td>";
					html += "<td>" + r['Bobot'] + "</td>";
					html += "<td>" + r['PilihanJawaban'] + "</td>";
					html += "<td class='text-center'>" + r['Aksi'] + "</td>";
					html += "</tr>";
				}
			} else {
				html = "<tr><td class='text-center' colspan='9'>No data availible in table.</td></tr>";
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
	$("#Title").html("Tampil Data Soal");
	$("#close_modal").trigger('click');
	$("#FormData").hide();
	$("#DetailData").show();
	$("#aksi").val("");
	$(".proses, #ProsesCrud").html("");
	$(".FormInput").val("");
	$(".FormInput").prop("readonly", false);
	$(".FormInput").prop("disabled", false);
	$("#BtnControl").show();
	var iData = ['Soal', 'A', "B", "C", "D"];
	for(var i=0; i < iData.length; i++){
		$('div[for="'+iData[i]+'"]').find('iframe').contents().find('.wysihtml5-editor').html(null);
	}
	ClearChangeS();
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
		if (Status == "ubah") {
			
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "inc/Soal/proses.php?proses=ShowData",
				data: "Id=" + Id,
				beforeSend: function (data) {
					StartLoad();
				},
				success: function (data) {
					console.log(data);
					$("#Title").html("Ubah Data Soal");
					$("#FormData").show();
					$("#DetailData").hide();
					$("#BtnControl").hide();
					$("#aksi").val("update");
					var iForm = ['Id', 'KodeText', 'NoSoal', 'Soal',"A","B","C","D","KunciJawaban","Bobot"];
					for (var i = 0; i < iForm.length; i++) {
						if (iForm[i] == "Soal" || iForm[i] == "A" || iForm[i] == "B" || iForm[i] == "C" || iForm[i] == "D"){
							$('div[for="' + iForm[i] + '"]').find('iframe').contents().find('.wysihtml5-editor').html(data[iForm[i]]);
						}else{
							$("#" + iForm[i]).val(data[iForm[i]]);
						}
					}
					NomorSoal("update", data['NoSoal']);
					//$(".select-kunci").trigger("change");
					
					ChangeS();
					StopLoad();
				},
				error: function (er) {
					console.log(er);
				}
			})
		} else if(Status == "PilihanJawaban"){
			var IsiText = atob(Id);
			IsiText = JSON.parse(IsiText);
			var html = "";
			html += "A. " + IsiText['A']+"<br>";
			html += "B. "+IsiText['B']+"<br>";
			html += "C. "+IsiText['C']+"<br>";
			html += "D. " + IsiText['D']+"<br>";
			ClearModal();
			jQuery("#modal").modal('show', { backdrop: 'static' });
			$(".modal-title").html("Detail Pilihan Jawaban");
			$("#proses_modal").html(html);
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
		NomorSoal("insert");
		$("#Title").html("Tambah Data Soal");
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
	var iForm = ["NoSoal", "Soal", "A", "B", "C", "D", "KunciJawaban","Bobot"];
	var KetiForm = ["No Soal belum dipilih!", "Soal belum lengkap!", "Pilihan jawaban A belum dipilih!", "Pilihan jawaban B belum dipilih!", "Pilihan jawaban C belum dipilih!", "Pilihan jawaban D belum dipilih!", "Kunci Jawaban belum dipilih!", "Bobot belum lengkap!"];
	for (var i = 0; i < iForm.length; i++) {
		if (aksi != "delete") {
			if ($("#" + iForm[i]).val() == "" || $("#" + iForm[i]).val() == null) {
				Customerror("Soal", "002", KetiForm[i], 'proses'); $("#" + iForm[i]).focus(); scrolltop(); return false; 
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
			url: "inc/Soal/proses.php?proses=Crud",
			data: data,
			beforeSend: function () {
				StartLoad();
			},
			success: function (result) {
				var res = JSON.parse(result);
				console.log(result);
				if (res['status'] == 'sukses') {
					Clear();
					Customsukses("Pesan", '002', res['pesan'], 'proses');
					LoadData();
					StopLoad();
				} else {
					Customerror("Pesan", "002", res['pesan'], 'proses');
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
