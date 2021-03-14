<?php

	function hari_indo($tgl) {
		$tanggal = $tgl;
		$day = date('D', strtotime($tanggal));
		$dayList = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu'
		);
		return $dayList[$day];
	}

	//====== FUNGSI JAM INDONESIA ===///
	function jam_indo($tgl){
		$timestamp = strtotime($tgl);
		return date("h.i A", $timestamp);
	}

	//====== FUNGSI TANGGAL INDONESIA ===///
	function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
	}

	function getBulan($bln){
	    switch ($bln){
	        case 1:
	          return "Januari";
	          break;
	        case 2:
	          return "Februari";
	          break;
	        case 3:
	          return "Maret";
	          break;
	        case 4:
	          return "April";
	          break;
	        case 5:
	          return "Mei";
	          break;
	        case 6:
	          return "Juni";
	          break;
	        case 7:
	          return "Juli";
	          break;
	        case 8:
	          return "Agustus";
	          break;
	        case 9:
	          return "September";
	          break;
	        case 10:
	          return "Oktober";
	          break;
	        case 11:
	          return "November";
	          break;
	        case 12:
	          return "Desember";
	          break;
	    }
	}


	function angka($str){
		$str = preg_replace( '/[^0-9]/', '', $str );
		return $str;
	}

	function Terbilang($anka){
		$x = abs($anka);
		$angka = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');
		$tep = " ";
		if($x < 12){
			$tep = " ". $angka[$x];
		} else if($x < 20){
			$tep = Terbilang($x - 10). " Belas";
		} else if($x < 100){
			$tep = Terbilang($x / 10). " Puluh". Terbilang($x % 10);	
		} else if($x < 200){
			$tep = " Seratus". Terbilang($x - 100);	
		} else if($x < 1000){
			$tep = Terbilang($x / 100). " Ratus". Terbilang($x % 100);	
		} else if($x < 2000){
			$tep = " Seribu". Terbilang($x - 100);	
		} else if($x < 1000000){
			$tep = Terbilang($x / 1000). " Ribu". Terbilang($x % 1000);	
		} else if($x < 1000000000){
			$tep = Terbilang($x / 1000000). " Juta". Terbilang($x % 1000000);	
		}

		return $tep;
	}

	function rupiah1($str,$prefix=null){
		$str = number_format($str,0,',','.');
		return $prefix." " .$str;
	}

	