$(document).ready(function () {
	ReloadWaktu();
	Clear();
	LoadData();
});


function Clear(){
	$("#KodeText").hide();
	$("#NomorS").html("");
}

function ReloadWaktu(){
	setInterval(LoadWaktu, 1000);
}

function LoadTombolRagu(IdJ){
	$.ajax({
		type: "POST",
		url: "inc/UjianTkdb/proses.php?proses=TombolSelesai",
		data: "IdJ="+IdJ,
		success: function (res) {
			var r = JSON.parse(res);
			console.log(r);
			if (r['status'] == "OK") {
				$("#Ragu").html("<center><a class='btn btn-success btn-sm' href='javascript:void(0);' onclick=\"Selesai();\"><i class='fa fa-check-square'></i> Selesai</a></center>");
			} else {
				$("#Ragu").html("");
			}
		},
		error: function (er) {
			console.log(er);
		}
	});
}

function LoadPage(JumlahSoal,Posisi){
	var IdJ = $("#IdJ").val();
	newPosisi = Posisi + 1;
	$("#After").html("<span class='pull-right'><a class='btn btn-success btn-sm' href='javascript:void(0);' onclick=\"Selesai();\"><i class='fa fa-check-square'></i> Selesai</a></span>");
	if(Posisi == 0 && newPosisi < JumlahSoal){
		$("#Before").html("");
		$("#After").html("<span class='pull-right'><a href='javascript:void(0)' onclick='LoadData("+newPosisi+")' class='btn btn-primary btn-sm'><i class='fa fa-mail-forward'></i> Selanjutnya</a><span><span class='clearfix'></span>");
		LoadTombolRagu(IdJ);
	} else if (Posisi > 0 && newPosisi < JumlahSoal){
		oldPosisi = Posisi - 1;
		$("#After").html("<span class='pull-right'><a href='javascript:void(0)' onclick=\"LoadData(" + newPosisi + ")\" class='btn btn-primary btn-sm'><i class='fa fa-mail-forward'></i> Selanjutnya</a><span><span class='clearfix'></span>");
		$("#Before").html("<a href='javascript:void(0)' onclick='LoadData(" + oldPosisi + ")' class='btn btn-primary btn-sm'><i class='fa fa-mail-reply'></i> Sebelumnya</a>");
		LoadTombolRagu(IdJ);
	}else{
		oldPosisi = Posisi - 1;
		$("#Ragu").html("");
		$("#After").html("<span class='pull-right'><a class='btn btn-success btn-sm' href='javascript:void(0);' onclick=\"Selesai();\"><i class='fa fa-check-square'></i> Selesai</a></span>");
		$("#Before").html("<a href='javascript:void(0)' onclick='LoadData(" + oldPosisi + ")' class='btn btn-primary btn-sm'><i class='fa fa-mail-reply'></i> Sebelumnya</a>");
	}
}

function LoadWaktu() {
	var IdJ = $("#IdJ").val();
	$.ajax({
		type: "POST",
		url: "inc/UjianTkdb/proses.php?proses=LoadWaktu",
		data: "IdJ=" + IdJ,
		success: function (res) {
			var r = JSON.parse(res);
			$("#SisahWaktu").html(r['jam']+":"+r['menit']+":"+r['detik']);
			console.log(r);
			if(r['Waktu'] > 0){
				$("#SisahWaktu").html("00:00:00");
				SubmitSelesaiPaksa();
			}
		},
		error: function (er) {
			console.log(er);
		}
	})
}

function LoadData(Posisi){
	Posisi = Posisi != undefined ? Posisi : 0;
	var IdJ = $("#IdJ").val();
	$.ajax({
		type : "POST",
		url: "inc/UjianTkdb/proses.php?proses=LoadSoal",
		data : "Posisi="+Posisi+"&IdJ="+IdJ,
		beforeSend : function(){
			StartLoad();
		},
		success : function(res){
			var r = JSON.parse(res);
			console.log(r);
			$("#NoSoal").html(r['NoSoal']);
			CekText(r['KodeText']);
			$("#Soal").html(r['Soal']);
			var Key = ["A","B","C","D"];
			var Pilihan = "";
			for(var i=0; i < Key.length; i++){
				var selc = r['Jawaban'] == Key[i] ? "checked" : "";
				Pilihan += "<div class='input-group' style='margin-bottom:5px'>";
				Pilihan += "<span class='input-group-addon'><b>" + Key[i] + "</b></span>";
				Pilihan += "<div class='form-control' style='height: 100%; width: 100%; object-fit: contain'>" + r['PilihanJawaban'][Key[i]]+"</div>";
				Pilihan += "<span class='input-group-addon'><input " + selc +" type='radio' class='OptJawaban' value='" + Key[i] +"' name='Jawaban' onclick=\"JawabPertanyaan('"+r['Kode']+"',this.value)\"></span>";
				Pilihan += "</div>";
			}
			$("#Pilihan").html(Pilihan);
			LoadPage(r['JumlahSoal'], Posisi, r['Kode']);
			LoadNomorSoal(r['JumlahSoal'], r['JawabanRagu'], r['JawabanTerjawab']);
			StopLoad();
			$("[data-toggle='tolltip']").tooltip();
		},
		error : function(er){
			console.log(er);
		}
	})
}

function JawabPertanyaan(KodeSoal, Jawaban){
	var IdJ = $("#IdJ").val();
	$.ajax({
		type : "POST",
		url : "inc/UjianTkdb/proses.php?proses=JawabPertanyaan",
		data : "KodeSoal="+KodeSoal+"&Jawaban="+Jawaban+"&IdJ="+IdJ,
		success : function(res){
			var r = JSON.parse(res);
			if(r['status'] == "sukses"){
				console.log(r['message']);
			}else{
				console.log(r['message']);
			}
		},
		error : function(er){
			console.log(er);
		}
	});
}

function LoadNomorSoal(JumSoal,Ragu,Terjawab){
	var No = 1;
	var Obj = "";
	for (var i = 0; i < JumSoal; i++) {
		var cek = No.toString();
		if (Ragu['Row'] > 0 && Ragu['Data'].includes(cek)){
			Obj += "<div class='col-sm-2 col-xs-2' data-toggle='tolltip' title='Soal Nomor " + MySprintf(No) + "' href='javascript:void(0)' onclick='LoadData(" + i + ")' style='margin-bottom:10px'><center><a class='btn btn-warning btn-sm' style='padding:8px'>" + MySprintf(No) + "</a></center></div>";
		} else if (Terjawab['Row'] > 0 && Terjawab['Data'].includes(cek)) {
			Obj += "<div class='col-sm-2 col-xs-2' data-toggle='tolltip' title='Soal Nomor " + MySprintf(No) + "' href='javascript:void(0)' onclick='LoadData(" + i + ")' style='margin-bottom:10px'><center><a class='btn btn-success btn-sm' style='padding:8px'>" + MySprintf(No) + "</a></center></div>";
		}else{
			Obj += "<div class='col-sm-2 col-xs-2' data-toggle='tolltip' title='Soal Nomor " + MySprintf(No) + "' href='javascript:void(0)' onclick='LoadData(" + i + ")' style='margin-bottom:10px'><center><a class='btn btn-default btn-sm' style='padding:8px'>" + MySprintf(No) + "</a></center></div>";
		}
		
		No++;
	}
	$("#NomorS").html(Obj);
}

function MySprintf(angka){
	if(angka < 10){
		return "0"+angka;
	}else{
		return angka;
	}
}

function CekText(data){
	if(data['Row'] > 0){
		$("#KodeText").show();
		var title = "<h4>" + data['Judul'] + "</h4>";
		var IsiText = data['IsiText'];
		$("#KodeText").html(title+IsiText);
	}else{
		Clear();
		$("#KodeText").html("");
	}
}

function ClearModal(){
	$("#close_modal").trigger("click");
	$("#proses_modal").html("");
	$(".modal-title").html("");
	$("#KetModal").html("");
}

function Selesai(){
	var IdJ = $("#IdJ").val();
	ClearModal();
	$("#modal").modal("show", { backdrop : "static"});
	$(".modal-title").html("Daftar Jawaban TKDB Anda");
	LoadDataTerjawab();
}

function SubmitSelesaiPaksa() {
	var IdJ = $("#IdJ").val();
	$.ajax({
		type: "POST",
		url: "inc/UjianTkdb/proses.php?proses=GenerateHasil",
		data: "IdJ=" + IdJ,
		success: function (res) {
			r = JSON.parse(res);
			if (r['status'] == "sukses") {
				alert("Waktu anda telah habis terima kasih telah mengikuti TKDB ini.");
				window.location = 'index.php?page=Lamaranku';
			} else {
				alert("maaf terjadi kesalahan sistem. :" + r['message']);
			}
		},
		error: function (er) {
			console.log(er);
		}
	})
}

function SubmitSelesai(){
	var IdJ = $("#IdJ").val();
	$.ajax({
		type : "POST",
		url : "inc/UjianTkdb/proses.php?proses=GenerateHasil",
		data : "IdJ="+IdJ,
		success: function(res){
			r = JSON.parse(res);
			if(r['status'] == "sukses"){
				alert("terima kasih mengikuti tes TKDB ini.. silahkan lihat nilai anda.");
				window.location = 'index.php?page=Lamaranku';
			}else{
				alert("maaf terjadi kesalahan sistem. :"+r['message']);
			}
		},
		error : function(er){
			console.log(er);
		}
	})
}

function LoadDataTerjawab(){
	var IdJ = $("#IdJ").val();
	$.ajax({
		type : "POST",
		url : "inc/UjianTkdb/proses.php?proses=LoadDataJawaban",
		data  : "IdJ="+IdJ,
		success : function(res){
			var r = JSON.parse(res);
			var KetModal = "<div class='callout callout-info'><h4><i class='fa fa-info'></i> INFORMASI</h4><p>Pastikan semua soal terjawab untuk menampilkan tombol <button type='button' class='btn btn-xs btn-primary'><i class='fa fa-check-square'></i> Submit</button></p></div>";
			KetModal += "<p>Jumlah Soal  : <label class='label label-info'><i class='fa fa-book'></i> " + r['JumlahSoal'] + "</label></p>";
			KetModal += "<p>Yang Terjawab : <label class='label label-success'><i class='fa fa-check'></i> " + r['Terjawab'] + "</label></p>";
			KetModal += "<p>Belum Terjawab : <label class='label label-danger'><i class='fa fa-times'></i> " + r['Belum']+"</label></p>";
			var html = "<table class='table table-striped table-hover table-bordered'>";
			html += "<thead>";
			html += "<tr>";
			html += "<th width='20%'>NO SOAL</th>";
			html += "<th>JAWABAN ANDA</th>";
			html += "</tr>";
			html += "</thead>";
			html += "<tbody>";
			for(var i =0; i < r['data'].length; i++){
				var iData = r['data'][i];
				var cek = iData['Jawaban'] != "belum dijawab" ? "" : "class='danger'"
				html += "<tr "+cek+">";
				html += "<td><center>" + MySprintf(iData['No']) + "</center></td>";
				html += "<td>" + iData['Jawaban']+"</td>";
				html += "</tr>";
			}
			html += "<tbody>";
			html += "</table>";
			$("#KetModal").html(KetModal);
			$("#proses_modal").html(html);
			if (r['Terjawab'] == r['JumlahSoal']){
				$("#BtnSubmitSelsesai").html("<button type='button' class='btn btn-sm btn-primary' onclick=\"SubmitSelesai('" + IdJ+"')\"><i class='fa fa-check-square'></i> &nbsp;Submit</button>");
			}else{
				$("#BtnSubmitSelsesai").html("");
			}
		},
		error : function(er){
			console.log(er);
		}

	})
}