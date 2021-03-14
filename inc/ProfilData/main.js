$(document).ready(function () {
	Clear();
	//$("#TglLahir,#TglPerolehan,#TglExpire,#TglMasuk,#TglKeluar").datepicker({ dateFormat : "yy-mm-dd", autoclose : true })
	$("[data-toogle='tooltip']").tooltip();
	LoadDataKiri();
	
});

function LoadDataKiri(){
	$.ajax({
		type : "POST",
		url: "inc/ProfilData/proses.php?proses=LoadData",
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




function Clear(){
	$("#FormDataSertifikasi").hide();
	$("#DetailSertifikasi").show();
	$("#FormDataKerja").hide();
	$("#DetailKerja").show();
	$(".FormInput").prop("readonly",true);
	$("#Agama").prop("disabled",true);
}

