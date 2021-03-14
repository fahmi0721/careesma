$(document).ready(function () {
	$("#TglLahir,#TglPerolehan,#TglExpire,#TglMasuk,#TglKeluar").datepicker({ dateFormat : "yy-mm-dd", autoclose : true })
	$("[data-toogle='tooltip']").tooltip();

});


function ViewNilai(IdJ){
	jQuery("#modal").modal('show', { backdrop: 'static' });
	$.ajax({
		type : "POST",
		url : "inc/Lamaranku/proses.php?proses=getNilai",
		data : "IdJ="+IdJ,
		success: function(res){
			var r = JSON.parse(res);
			if(r['status'] == "sukses"){
				var html = "";
				if(r['data'] > 90){
					html += "<p class='text-center text-success' style='font-size:50px'>" + r['data'] + "</p>";
					html += "<p class='text-center' style='font-size:20px; font-weight:bold'>DISARANKAN</p>"; 
				}else if(r['data'] >= 45 && r['data'] <= 89){
					html += "<p class='text-center text-warning' style='font-size:50px'>" + r['data'] + "</p>";
					html += "<p class='text-center' style='font-size:20px; font-weight:bold'>DIPERTIMBANGKAN</p>"; 
				}else{
					html += "<p class='text-center text-danger' style='font-size:50px'>" + r['data'] + "</p>";
					html += "<p class='text-center' style='font-size:20px; font-weight:bold'>TIDAK DISARANKAN</p>";
				}
				$("#Results").html(html);
			}else{
				$("#Results").html(r['data']);
			}
		},
		error : function(er){
			console.log(er);
		}
	})
}
