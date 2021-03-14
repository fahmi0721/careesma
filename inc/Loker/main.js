$(document).ready(function () {
	$("#TglLahir,#TglPerolehan,#TglExpire,#TglMasuk,#TglKeluar").datepicker({ dateFormat : "yy-mm-dd", autoclose : true })
	$("[data-toogle='tooltip']").tooltip();

});

$("#FormData").submit(function(e){
	e.preventDefault();
	MasukkanLamaran();
});

function Information() {
	jQuery("#modal").modal('show', { backdrop: 'static' });
	$("#Results").html("<div class='alert alert-warning'>Lengkapi data anda terlebih dahulu?</div>");
}

function MasukkanLamaran(){
	if ($("#Alasan").val() == ""){
		Customerror("Lamaran", "002", "Masukan alasan anda", 'proses'); $("#Alasan").focus(); scrolltop(); return false; 
	}else{
		var iData = $("#FormData").serialize();
		$.ajax({
			type : "POST",
			url : "inc/Lamar/proses.php?proses=Lamar",
			data : iData,
			beforeSend: function(){
				StartLoad();
			},
			success : function(res){
				var r = JSON.parse(res);
				console.log(r);
				if(r['status'] == "sukses"){
					alert(r['pesan']);
					window.location='index.php?page=DataLamaranKu';
				}else{
					alert(r['pesan']);
					window.location = 'index.php?page=Loker';
				}
			},
			error : function(er){
				console.log(er);
			}
		})
	}
}
