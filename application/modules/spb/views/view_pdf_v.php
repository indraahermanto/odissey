<?php
class PDF extends FPDF{
	public $invoice;
	public function setData($invoice){
    $this->invoice = $invoice;
	}

	//Page header
	function Header(){
		$this->SetMargins(30,30,30);
    $this->setFont('Times','',18);
    $this->setFillColor(255,255,255);
    $this->cell(190,6," ",0,1,'C',1);
    // $this->setFont('Times','',12);
    $this->setFont('Times','',16);
    $this->cell(150,6,"SURAT PERINTAH BAYAR",0,1,'C',1);
    $this->setFont('Times','',14);
    $this->cell(150,6,"LAYANAN ".strtoupper($this->invoice->name),0,1,'C',1);
    $this->setFont('Times','',12);
    $this->cell(150,6,"Antara PT Telekomunikasi Indonesia, Tbk dengan ".ucwords($this->invoice->partner_name),0,1,'C',1);
    $this->cell(150,6,"Nomor: ".$this->invoice->spb_number,0,1,'C',1);
    $this->cell(150,6,"Tanggal: ".$this->invoice->created,0,1,'C',1);
    $line = 180;
    for ($i=0.1; $i <= 0.6; $i=$i+0.1) { 
    	$line_a = 50+$i;
    	$line_b = 50+$i;
    	$this->Line($line,$line_a,30,$line_b);
    	// $this->cell(150,6,$line." ".$lines,0,1,'C',1);
    }
	}

	var $col = 0;

	function SetCol($col){
    // Move position to a column
    $this->col = $col;
    $x = 10+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
	}

	function AcceptPageBreak(){
    if($this->col<2){
      // Go to next column
      $this->SetCol($this->col+1);
      $this->SetY(10);
      return false;
    }else{
      // Go back to first column and issue page break
      $this->SetCol(0);
      return true;
    }
	}

	function LoadData($file){
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
			$data[] = explode(';',trim($line));
    return $data;
	}

	function Content(){
		$this->Ln(10);
		$this->setFont('Times','',11);
		$this->setFillColor(255,255,255);
		$this->SetLeftMargin(40);
		$this->MultiCell(130,6,"Kepada Manager Finance harap dibayarkan uang sejumlah Rp.".number_format($this->invoice->inv_amount, 0, ',', '.')." (".$this->invoice->terbilang." Rupiah) sebagai tindak lanjut rekonsiliasi atas transaksi ".strtoupper($this->invoice->name)." terhadap invoice dibawah ini:",0,'J');

		$this->Ln(5);
		$this->SetLeftMargin(45);
		$this->setFont('Times','B',10);
		// $header = array('Nama Publisher', 'Penjualan', 'Share');
		$this->Table();

		$this->SetLeftMargin(40);
		// $this->Cell(5,6,"",1,1,'L',1);
		$this->Ln(5);

		$this->setFont('Times','',11);
		$this->MultiCell(130,6,"Dibebankan kepada:",0,'J');
		$this->SetLeftMargin(45);
		$this->setFont('Times','I',11);
		$this->MultiCell(130,6,"Bank ".ucwords($this->invoice->pbank_name)."\r\n".strtoupper($this->invoice->pbank_rekening)." - A/N ".strtoupper($this->invoice->pbank_an),0,'J');
		$this->SetLeftMargin(40);
		$this->Ln(1);
		$this->setFont('Times','',11);
		$this->MultiCell(130,6,"Demikian Surat Perintah Bayar ini dibuat untuk digunakan sebagai dasar pembayaran oleh Telkom kepada ".ucwords($this->invoice->partner_name)." dan apabila dikemudian hari ditemukan kekeliruan dalam perhitungan data ini, maka akan dilakukan perbaikan pada settlement berikutnya.",0,'J');
		// ""
		// foreach ($data as $key) {
		// 	$this->setFont('Arial','',10);
		// 	$this->setFillColor(255,255,255);
		// 	$this->cell(10,10,$no,1,0,'L',1);
		// 	$this->cell(105,10,$key->namalengkap,1,0,'L',1);
		// 	$this->cell(30,10,$key->nohp,1,0,'L',1);
		// 	$this->cell(50,10,$key->kelamin,1,1,'L',1);
		// 	$ya = $ya + $rw;
		// 	$no++;
  //   }
	}

	// Simple table
	function Table(){
    // Header
    // $header = array('Nama Publisher', 'Penjualan', 'Share');
    $this->SetLeftMargin(35);
		$this->Ln(1);
    $this->Cell(10,6,"No ",1,0,'C',1);
    $this->Cell(50,6,"Nomor Invoice",1,0,'C',1);
    // $this->Cell(50,6,"Share",1,1,'C',1);
    // $this->SetLeftMargin(75);
    $this->Cell(40,6,"Nilai Transaksi",1,0,"C",1);
    $this->Cell(40,6,"Periode",1,1,'C',1);
    // $this->Cell(25,6,"Telkom ".$this->Invoice->partner_name."%",1,0,'C',1);
    // $this->Cell(25,6,"Mitra ".$this->partner->pks_mitra_share."%",1,1,'C',1);
    $this->SetLeftMargin(35);
    $this->Ln(0);
    $this->MultiCell(10,12,1,1,'C');
    $this->SetLeftMargin(45);
    $this->Ln(-12);
    $this->MultiCell(50,12,strtoupper($this->invoice->inv_number),1,'C');
    $this->SetLeftMargin(95);
    $this->Ln(-12);
    $this->MultiCell(40,12,number_format($this->invoice->inv_amount, 0, ',', '.'),1,'C');
    $this->SetLeftMargin(135);
    $this->Ln(-12);
    $this->MultiCell(40,6,$this->invoice->periode,1,'C');
    $this->SetLeftMargin(175);
    // $this->MultiCell(25,6,number_format($this->invoice->mitra_share, 0, ',', '.'),1,'C');

    $this->SetLeftMargin(45);
    // $this->Ln(5);

    // Data
   //  foreach($data as $row){
			// foreach($row as $col)
			// 	$this->Cell(40,6,$col,1);
			// $this->Ln();
   //  }
	}

	function Approval($mgr_st){
		// $this->SetLeftMargin(50/);
		$this->Ln(15);
		$this->setFont('Times','B',10);
		$this->MultiCell(60,6,"Lunas Bayar",0,'C');
		$this->MultiCell(60,6,"Mgr. Finance Service DSC",0,'C');
		// $this->SetCol(2);
		$this->Ln(-18);
		$this->SetLeftMargin(110);
		$this->MultiCell(60,6,"Jakarta, ".$this->invoice->created,0,'C');
		$this->MultiCell(60,6,"Kuasa Rekonsiliasi & Settlement",0,'C');
		$this->MultiCell(60,6,"Mgr. Settlement & Business Analyst",0,'C');
		
		$this->SetLeftMargin(40);
		$this->setFont('Times','UB',10);
		$this->Ln(30);
		$this->MultiCell(60,6,strtoupper("Suahmadi"),0,'C');
		$this->setFont('Times','B',10);
		$this->MultiCell(60,6,"NIK. 123456",0,'C');
		$this->Ln(-12);
		$this->SetLeftMargin(110);
		$this->setFont('Times','UB',10);
		$this->MultiCell(60,6,strtoupper($mgr_st->first_name." ".$mgr_st->last_name),0,'C');
		$this->setFont('Times','B',10);
		$this->MultiCell(60,6,"NIK. 654321",0,'C');
	}

	function Footer(){
		// //atur posisi 1.5 cm dari bawah
		// $this->SetY(-15);
		// //buat garis horizontal
		// $this->Line(10,$this->GetY(),210,$this->GetY());
		// //Arial italic 9
		// $this->SetFont('Arial','I',9);
  //   $this->Cell(0,10,'copyright gubugkoding.com Semarang ' . date('Y'),0,0,'L');
		// //nomor halaman
		// $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}
 
$pdf = new PDF();
$period 	= explode(' - ', $invoice->ba_periode);
$invoice->created 		= $this->convnumber->indonesian_date(strtotime($invoice->spb_created), 'd F Y','');
$invoice->hari_body 	= $this->convnumber->indonesian_date(strtotime($invoice->ba_created), 'l','');
$invoice->bulan_body	= $this->convnumber->indonesian_date(strtotime($invoice->ba_created), 'F','');
// $invoice->periode 		= $this->convnumber->indonesian_date(strtotime($period[0]), 'd F Y', '')." sampai ".$this->convnumber->indonesian_date(strtotime($period[1]), 'd F Y', '');
// $invoice->telkom_share = $invoice->ba_amount*($partner->pks_telkom_share/100);
// $invoice->mitra_share  = $invoice->ba_amount*($partner->pks_mitra_share/100);
// $invoice->total        = $invoice->ba_amount-$invoice->telkom_share;
$invoice->terbilang 	= $this->convnumber->terbilang($invoice->inv_amount);
$invoice->periode 		= $periode;
// $invoice->orders			= $orders;
// echo $invoice->created;
$pdf->SetTitle("SURAT PERINTAH BAYAR ".$invoice->spb_number);
// $pdf->SetSubject("SURAT PERINTAH BAYAR ".$invoice->number);
$pdf->setData($invoice);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
// $pdf->ChapterBody('ASDASDASDASDASDASSKASDJASDIJASLDKASMDKASDASKDHAJSDHASDASDHJASDHASGDAJHASKDASDKASJDAKSDASDAJSDKASDASJDHASDKASJDAHSDASDKADASDHASDASDKSAASDHASDKAJDLasdasdassdasdasdasdasasdassdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasddddddddddddddMASDJLA ASLDJASO  SDHASKDJASHD ASKDJS aaaaaasdikahsdkajSHGDBAKSD.LASDKAJNSZDHASDBA,SDEAMKSJXDHGAVSDTYASIDLASDMNASZDHASYDAINSDMAKSDJADNASDYGAHSDABDASDASGDHADASDASDJASDHASHDAJDSSIDUHSDKFKNSDFGSDFKFSDFJSIDFHFSDHFSDGFUBADJFASIDFSAKDJASDASDYADSYYGASDGSDHGAJDSBASDUASDBASJDHASDJASHDJNASDHASDJ');
// $pdf->ChapterBody('HASDJ');
$pdf->Approval($mgr_st);
$pdf->Output("I","SPB ".$invoice->spb_number.".pdf");
// $this->fpdf->fpdf("P","cm","A4"); 
// // kita set marginnya dimulai dari kiri, atas, kanan. jika tidak diset, defaultnya 1 cm 
// $this->fpdf->SetMargins(1,1,1); 
// /* AliasNbPages() merupakan fungsi untuk menampilkan total halaman di footer, nanti kita akan membuat page number dengan format : number page / total page */ 
// $this->fpdf->AliasNbPages(); 
// // AddPage merupakan fungsi untuk membuat halaman baru 
// $this->fpdf->AddPage(); 
// // Setting Font : String Family, String Style, Font size 
// $this->fpdf->SetFont('Times','B',14); 
// /* Kita akan membuat header dari halaman pdf yang kita buat -------------- Header Halaman dimulai dari baris ini ----------------------------- */ 
// $this->fpdf->Cell(19,0.7,'Judul',0,0,'C'); 
// // fungsi Ln untuk membuat baris baru 
// $this->fpdf->Ln(); $this->fpdf->Ln(); /* Setting ulang Font : String Family, String Style, Font size kenapa disetting ulang ??? jika tidak disetting ulang, ukuran font akan mengikuti settingan sebelumnya. tetapi karena kita menginginkan settingan untuk penulisan alamatnya berbeda, maka kita harus mensetting ulang Font nya. jika diatas settingannya : helvetica, 'B', '12' khusus untuk penulisan alamat, kita setting : helvetica, '', 10 yang artinya string stylenya normal / tidak Bold dan ukurannya 10 */ 
// $this->fpdf->SetFont('helvetica','',10); 
// $this->fpdf->Cell(19,0.5,'Sub judul',0,0,'C'); 
// $this->fpdf->Ln(); 
// $this->fpdf->Cell(19,0.5,'subtitle',0,0,'C'); /* Fungsi Line untuk membuat garis */ 
// $this->fpdf->Line(1,3.5,20,3.5); $this->fpdf->Line(1,3.55,20,3.55); /* -------------- Header Halaman selesai ------------------------------------------------*/ 
// $this->fpdf->Ln(1);
// $this->fpdf->SetFont('Times','B',12);
// $this->fpdf->Cell(19,1,'Header',0,0,'C'); /* setting header table */ 
// $this->fpdf->Ln(1);
// $this->fpdf->SetFont('Times','B',12); 
// $this->fpdf->Cell(6 , 1, 'ID Lokasi' , 1, 'LR', 'L'); 
// $this->fpdf->Cell(5 , 1, 'Latitude' , 1, 'LR', 'L'); 
// $this->fpdf->Cell(5 , 1, 'Longitude' , 1, 'LR', 'L'); 
// $this->fpdf->Cell(3 , 1, 'Hasil' , 1, 'LR', 'L'); /* generate hasil query disini */ 

// /*
// foreach($hasil as $data) { 
// 	$this->fpdf->Ln(); 
// 	$this->fpdf->SetFont('Times','',12); 
// 	$this->fpdf->Cell(6 , 0.7, $data->id , 1, 'LR', 'L'); 
// 	$this->fpdf->Cell(5 , 0.7, $data->lati , 1, 'LR', 'L'); 
// 	$this->fpdf->Cell(5 , 0.7, $data->longi , 1, 'LR', 'L'); 
// 	$this->fpdf->Cell(10 , 0.7, $data->alamat , 1, 'LR', 'L'); 
// 	$this->fpdf->Cell(3 , 0.7, $data->nilai , 1, 'LR', 'L'); 
// } /* setting posisi footer 3 cm dari bawah */

// $this->fpdf->SetY(-3); /* setting font untuk footer */ 
// $this->fpdf->SetFont('Times','',10); /* setting cell untuk waktu pencetakan */ 
// $this->fpdf->Cell(9.5, 0.5, 'Printed on : '.date('d/m/Y H:i').' | Created by : M. Fadli Prathama',0,'LR','L'); /* setting cell untuk page number */ 
// $this->fpdf->Cell(9.5, 0.5, 'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'R'); /* generate pdf jika semua konstruktor, data yang akan ditampilkan, dll sudah selesai */ 
// $this->fpdf->Output("laporan_seleksi_calok_atm.pdf","I"); 

?>