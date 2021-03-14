$(document).ready(function () {
	Clear();
	SearchForm();
	GetLowongan();
	EditorText("Pesan");
	
});

function SearchForm() {
	$('.select-category').select2({
		theme: "bootstrap",
		placeholder: 'Pilih Lowongan',
	});

	$('.select-category1').select2({
		theme: "bootstrap",
		placeholder: 'Pilih Keterangan',
	});
}

function GetLowongan(){
	$.ajax({
		type : "POST",
		url: "inc/KirimEmail/proses.php?proses=LoadData",
		data : "rule=getLowongan",
		beforeSend : function(){
			StartLoad();
		},
		success : function(r){
			var res = JSON.parse(r);
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

function CheckData(){
	var Tot = $("input.CheckData:checked").length;
	if(Tot > 0){
		$("#ChekAll").prop("checked",true);
		$("#BtnSubmit").show();
	}else{
		$("#ChekAll").prop("checked",false);
		$("#BtnSubmit").hide();
	}
}

$("#ChekAll").on("click",function(){
	if($("input#ChekAll").is(':checked')){
		$(".CheckData").prop("checked",true);
		CheckData();
	}else{
		$(".CheckData").prop("checked",false);
		CheckData();
	}
});

function LoadData() {
	var iData = $("#FormData").serialize();
	$.ajax({
		type: "POST",
		url: "inc/KirimEmail/proses.php?proses=DetailData",
		data: iData,
		beforeSend: function () {
			StartLoad();
		},
		success: function (res) {
			var result = JSON.parse(res);
			var html = "";
			if (result['total_data'] > 0) {
				$("#DetailData").show();
				for (var i = 0; i < result['data'].length; i++) {
					var r = result['data'][i];
					html += "<tr>";
					html += "<td class='text-center'>" + r['No'] + "</td>";
					html += "<td>" + r['Nama'] +"<br /><small>No KTP : "+r['NoKtp']+"</small></td>";
					html += "<td>" + r['JK'] +"</td>";
					html += "<td>" + r['TptLahir'] +"<br /><small>"+r['TglLahir']+"</small></td>";
					html += "<td>" + r['NoHp'] + "</td>";
					html += "<td>" + r['Pendidikan'] + "</td>";
					html += "<td>" + r['Usia'] + "</td>";
					html += "<td class='text-center'>" + r['Aksi'] + "</td>";
					html += "</tr>";
				}
			} else {
				$("#DetailData").show();
				html = "<tr><td class='text-center' colspan='7'>No data availible in table.</td></tr>";
			}
			$("#ShowData").html(html);
			
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
	$("#Title").html("Kirim Pesan Email");
	$("#close_modal").trigger('click');
	$("#FormData").show();
	$("#DetailData").hide();
	$("#BtnSubmit").hide();
	$("#aksi").val("insert");
	$(".proses, #ProsesCrud").html("");
	$(".FormInput").val("");
	$(".FormInput").prop("readonly", false);
	$(".FormInput").prop("disabled", false);
	$("#BtnControl").show();
	$(".select-category").val(null).trigger("change");
	$(".select-category1").val(null).trigger("change");
	$('div[for="Pesan"]').find('iframe').contents().find('.wysihtml5-editor').html(null);
	

}


function Validasi() {
	var aksi = $("#aksi").val();
	var iForm = ["IdLowongan", "Ket"];
	var KetiForm = ["Lowongan Pekerjaan belum dipilih!", "Hasil Seleksi belum dipilih!"];
	for (var i = 0; i < iForm.length; i++) {
		if (aksi != "delete") {
			if ($("#" + iForm[i]).val() == "") {
				Customerror("Kirim Pesan Email", "002", KetiForm[i], 'proses'); $("#" + iForm[i]).focus(); scrolltop(); return false; 
			}
		}
	}
}

function EditorText(Id){
	$('#'+Id).wysihtml5({
		toolbar: {
			"font-styles": true, // Font styling, e.g. h1, h2, etc.
			"emphasis": true, // Italics, bold, etc.
			"lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
			"html": false, // Button which allows you to edit the generated HTML.
			"link": false, // Button to insert a link.
			"image": false, // Button to insert an image.
			"color": false, // Button to change color of font
			"blockquote": true, // Blockquote
			"size": "sm"
		}
	});
}

function ValidasiKirim() {
	var aksi = $("#aksi").val();
	var iForm = ["IdLowongan", "Ket", 'Subjek',"Pesan"];
	var KetiForm = ["Lowongan Pekerjaan belum dipilih!", "Hasil Seleksi belum dipilih!","Subjek belum lengkap","Pesan belum lengkap"];
	for (var i = 0; i < iForm.length; i++) {
		if (aksi != "delete") {
			if ($("#" + iForm[i]).val() == "") {
				Customerror("Kirim Pesan Email", "002", KetiForm[i], 'proses'); $("#" + iForm[i]).focus(); scrolltop(); return false; 
			}
		}
	}
}

$("#FormData").submit(function (e) {
	e.preventDefault();
	if(Validasi() != false){
		LoadData();
	}

})


$("#BtnSubmit").on("click",function(){
	SubmitData();
});
function SubmitData() {
	if (ValidasiKirim() != false) {
		var data = $("#FormData").serialize();
		$.ajax({
			type: "POST",
			url: "inc/KirimEmail/proses.php?proses=Crud",
			data: data,
			beforeSend: function () {
				StartLoad();
			},
			success: function (result) {
				console.log(result)
				var res = JSON.parse(result);
				if (res['status'] == 'sukses') {
					Clear();
					Customsukses("Lowongan Pekerjaan", '002', res['pesan'], 'proses');
					LoadData();
					StopLoad();
				} else {
					Customerror("Lowongan Pekerjaan", "002", res['pesan'], 'proses');
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
