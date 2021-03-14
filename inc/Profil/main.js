$(document).ready(function () {
	Clear();
	$("#TglLahir,#TglPerolehan,#TglExpire,#TglMasuk,#TglKeluar").datepicker({ dateFormat : "yy-mm-dd", autoclose : true })
	$("[data-toogle='tooltip']").tooltip();
	LoadDataKiri();
	LoadPedidikan();
});

function LoadDataKiri(){
	$.ajax({
		type : "POST",
		url : "inc/Profil/proses.php?proses=LoadData",
		data : "rule=CountData",
		success : function(r){
			var res = JSON.parse(r);
			console.log(res);
			if(res['status'] == "OK"){
				$("#SertifikasiJum").html(res['data']['SertifikasiJum']);
				$("#PkJum").html(res['data']['PkJum']);
			}else{
				$("#SertifikasiJum").html(0);
				$("#PkJum").html(0);
			}
		},
		error : function(er){
			console.log(er);
		}
	})
}

function LoadPedidikan(){
	$("#Pendidikan").autocomplete({
		source: "load.php?proses=getDataPendidikan",
		select: function (event, ui) {
			console.log(ui.item.label);
			$("#Pendidikan").val(ui.item.label);
		}
	})
	.autocomplete("instance")._renderItem = function (ul, item) { return $("<li>").append("<div>" + item.label + "</div>").appendTo(ul); };
}

$("#FormDataPribadi").submit(function(e){
	e.preventDefault();
	UpdateDataPribadi();
});

function ValidasiDataPribadi(){
	var iForm = [ "TptLahir", "TglLahir", "Pendidikan", "NoHp","Email","Agama","Alamat","FileIjazah","FileKtp"];
	var iKet = ["Tempat lahir belum lengkap", "Taggal lahir belum lengkap", "Pendidikan belum lengkap","No Hp belum lengkap", "Email belum lengkap","Agama belum lengkap", "Alamat belum legkap","File Ijzah belum legkap","Foto Ktp belum legkap"];
	for(var i=0; i < iForm.length; i++){
		if($("#"+iForm[i]).val() == ""){
			Customerror("Profil", "002", iKet[i], 'proses_data_diri'); $("#" + iForm[i]).focus(); scrolltop(); return false; 
		}
	}
}

function UpdateDataPribadi(){
	if(ValidasiDataPribadi() != false){
		var iData = new FormData($("#FormDataPribadi")[0]);
		$.ajax({
			type : "POST",
			url : "inc/Profil/proses.php?proses=UpdateDataDiri",
			data : iData,
			chace: false,
			processData : false,
			contentType : false,
			beforeSend : function(e){
				StartLoad();
			},
			success: function(r){
				console.log(r);
				var res = JSON.parse(r);
				if (res['status'] == "sukses"){
					Customsukses("Profil", '002', "data berhasil diperbaharui", 'proses_data_diri'); scrolltop();
				}
					setTimeout(function(){
						location.reload();
					},3000)
			},
			error: function(er){
				console.log(er);
				Customerror("Profil", "002", er['responseText'], 'proses_data_diri');
			}
		});
	}
}

$("#FormUpdateFoto").submit(function (e) {
	e.preventDefault();
	UpdateFoto();
});
function UpdateFoto() {
	if ($("#Foto").val() != "") {
		var iData = new FormData($("#FormUpdateFoto")[0]);
		$.ajax({
			type: "POST",
			url: "inc/Profil/proses.php?proses=UpdateFoto",
			processData: false,
			contentType: false,
			chace: false,
			data: iData,
			beforeSend: function (e) {
				StartLoad();
			},
			success: function (r) {
				var res = JSON.parse(r);
				if (res['status'] == "sukses") {
					Customsukses("Profil", '002', "data berhasil diperbaharui", 'proses_data_diri'); scrolltop();
					setTimeout(function(){
						location.reload();
					},3000)
					
				}
			},
			error: function (er) {
				console.log(er);
				Customerror("Profil", "002", er['responseText'], 'proses_data_diri');
			}
		});
	}else{
		Customerror("Profil", "002", "File belum dipilih", 'ProsesFoto'); $("#Foto").focus(); scrolltop(); $("#Foto").focus();
	}
}


$("#FormDataSertifikasi").submit(function(e){
	e.preventDefault();
	SubmitDataSertifikasi();
	LoadDataKiri();
})

function ValidasiDataSertifikasi() {
	var iForm = ["NamaSertifikasi", "TglPerolehan", "TglExpire", "File"];
	var iKet = ["Nama Sertifikasi belum lengkap", "Taggal Perolehan belum lengkap", "Tanggal Expired belum lengkap", "File belum lengkap"];
	for (var i = 0; i < iForm.length; i++) {
		if ($("#" + iForm[i]).val() == "") {
			Customerror("Profil", "002", iKet[i], 'proses_sertifikasi'); $("#" + iForm[i]).focus(); scrolltop(); return false;
		}
	}
}

function SubmitDataSertifikasi(){
	if (ValidasiDataSertifikasi() != false){
		var iData = new FormData($("#FormDataSertifikasi")[0]);
		$.ajax({
			type: "POST",
			url: "inc/Profil/proses.php?proses=TambahSertifiksai",
			processData: false,
			contentType: false,
			chace: false,
			data: iData,
			beforeSend: function (e) {
				
			},
			success: function (r) {
				var res = JSON.parse(r);
				console.log(res);
				if (res['status'] == "sukses") {
					Customsukses("Profil", '002', "Sertifikasi berhasil di tambah", 'proses_sertifikasi'); scrolltop();
					setTimeout(function (e) {
						window.location = 'index.php?page=Profil&aksi=Sertifikasi';
						Clear();
					}, 3000)

				}
			},
			error: function (er) {
				console.log(er);
				Customerror("Profil", "002", er['responseText'], 'proses_sertifikasi');
			}
		});
	}
}

$("#FormDataKerja").submit(function (e) {
	e.preventDefault();
	SubmitDataKerja();
	LoadDataKiri();
})

function ValidasiDataKerja() {
	var iForm = ["Instansi", "TglMasuk", "TglKeluar", "Upah","Files"];
	var iKet = ["Nama Instansi / Perusahaan belum lengkap", "Taggal Masuk belum lengkap", "Tanggal Keluar belum lengkap", "Upah belum lengkap", "File belum lengkap"];
	for (var i = 0; i < iForm.length; i++) {
		if ($("#" + iForm[i]).val() == "") {
			Customerror("Profil", "002", iKet[i], 'proses_kerja'); $("#" + iForm[i]).focus(); scrolltop(); return false;
		}
	}
}

function SubmitDataKerja() {
	if (ValidasiDataKerja() != false) {
		var iData = new FormData($("#FormDataKerja")[0]);
		$.ajax({
			type: "POST",
			url: "inc/Profil/proses.php?proses=TambahKerja",
			processData: false,
			contentType: false,
			chace: false,
			data: iData,
			beforeSend: function (e) {

			},
			success: function (r) {
				var res = JSON.parse(r);
				console.log(res);
				if (res['status'] == "sukses") {
					Customsukses("Profil", '002', "Pengalaman Kerja berhasil di tambah", 'proses_kerja'); scrolltop();
					setTimeout(function (e) {
						window.location = 'index.php?page=Profil&aksi=PengalamanKerja';
						Clear();
					}, 3000)

				}
			},
			error: function (er) {
				console.log(er);
				Customerror("Profil", "002", er['responseText'], 'proses_kerja');
			}
		});
	}
}

function Clear(){
	$("#FormDataSertifikasi").hide();
	$("#DetailSertifikasi").show();
	$("#FormDataKerja").hide();
	$("#DetailKerja").show();
}

function Crud(st){
	Clear();
	if (st == "Sertifikasi"){
		$("#FormDataSertifikasi").show();
		$("#DetailSertifikasi").hide();
		
	} else if (st == "Kerja"){
		$("#FormDataKerja").show();
		$("#DetailKerja").hide();
	}
}
