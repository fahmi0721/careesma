$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  
})

//$("#Tanggal,#tgl_lahir,#tgl_bayar,#tglawal,#tglakhir,#Tanggal1").datepicker({ "format": "yyyy-mm-dd", "autoclose": true });
function StopLoad(){
    $(".LoadingState").hide();
}

function StartLoad(){
    $(".LoadingState").show();
}

function sprintf(format) {
  var args = Array.prototype.slice.call(arguments, 1);
  var i = 0;
  return format.replace(/%s/g, function () {
    return args[i++];
  });
}

function sukses(aksi, modul, kode_modul) {
  if (aksi == 'insert' || aksi == '0') {
    var info_sukses = "SCS-"+kode_modul+".0 : Data "+modul+" Telah Tersimpan.";
  } else if (aksi == 'update' || aksi == 'aprovel' || aksi == '1') {
    var info_sukses = "SCS-"+kode_modul+".1 : Data "+modul+" Telah Diperbaharui.";
  } else if (aksi == 'delete' || aksi == '2') {
    var info_sukses = "SCS-"+kode_modul+".2 : Data "+modul+" Telah Di Hapus.";
  }
  $("#proses").html("<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> "+info_sukses+"</div>");
}

function error(kode_modul, no, catatan) {
  $("#proses").html("<div class='alert alert-warning'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ER-"+kode_modul+"."+no+" : "+catatan+"</div>");
}

function Customerror(kode_modul, no, catatan,id) {
  $("#"+id).html("<div class='alert alert-warning'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ER-"+kode_modul+"."+no+" : "+catatan+"</div>");
}

function Customsukses(kode_modul, no, catatan, id) {
  $("#" + id).html("<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> SCS-" + kode_modul + "." + no + " : " + catatan + "</div>");
}

function scrolltop(){
  $("html, body").animate({
          scrollTop: 0
      }, 600);
      return false;
}

function angka(objek) {
  a = objek.value;
  b = a.replace(/[^\d]/g,"");
  objek.value = b;
}

function decimal(objek) {
  a = objek.value;
  b = a.replace(/[^.-\d]/g, "");
  objek.value = b;
}

function AngkaDecimal(objek){
  separator = ".";
  a = objek.value;
  b = a.replace(/[^,-\d]/g, "");
  c = "";
  sisa = b.split(',');
  sisa0 = sisa[0];
  sisa1 = sisa[1] != undefined ? ","+sisa[1] : "";
  panjang = sisa0.length;
  j = 0;
  for (i = panjang; i > 0; i--) {
    j = j + 1;
    if (((j % 3) == 1) && (j != 1)) {
      c = sisa0.substr(i - 1, 1) + separator + c;
    } else {
      c = sisa0.substr(i - 1, 1) + c;
    }
  }
  objek.value = c + sisa1;;
}

function rupiah(objek) {
  separator = ".";
  a = objek.value;
  b = a.replace(/[^\d]/g,"");
  c = "";
  panjang = b.length; 
  j = 0; 
  for (i = panjang; i > 0; i--) {
    j = j + 1;
    if (((j % 3) == 1) && (j != 1)) {
      c = b.substr(i-1,1) + separator + c;
    } else {
      c = b.substr(i-1,1) + c;
    }
  }
  objek.value = c;
}


/* Fungsi formatRupiah */
function formatRupiah(angka, prefix){
  var number_string = angka.toString().replace(/[^,\d]/g, ''),
  
  split       = number_string.split(','),
  sisa        = split[0].length % 3,
  rupiah      = split[0].substr(0, sisa),
  ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if(ribuan){
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function formatRupiahLR(angka, prefix) {
  var number_string = angka.toString().replace(/[^,-\d]/g, ''),

    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function RupiahDecimal(angka, prefix){
  var number_string = angka.toString(),
  number_string = angka != null ? number_string : 0;
  split = number_string.split('.'),
  sisa  = split[0].length % 3,
  rupiah  = split[0].substr(0, sisa),
  ribuan  = split[0].substr(sisa).match(/\d{1,3}/gi);
    
  if (ribuan) {
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }
  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

  return  prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');;
}
