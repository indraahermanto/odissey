<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ConvNumber{
    
    function rupiah($angka) {
        $rupiah = number_format($angka, 0, ',', '.');
        return $rupiah;
    }
 
    function terbilang($angka) {
        $angka      = (float) $angka;
        $bilangan   = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');
        switch ($angka) {
            case $angka < 12: return $bilangan[$angka]; break;
            case $angka < 20: return $bilangan[$angka-10].' Belas'; break;
            case $angka < 100: 
                $hasil_bagi = (int)($angka/10);
                $hasil_mod  = $angka%10;
                return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
                break;
            case $angka < 200: return sprintf('Seratus %s', $this->terbilang($angka-100)); break;
            case $angka < 1000:
                $hasil_bagi = (int)($angka/100);
                $hasil_mod  = $angka%100;
                return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], $this->terbilang($hasil_mod)));
                break;
            case $angka < 2000: return trim(sprintf('Seribu %s', $this->terbilang($angka-1000))); break;
            case $angka < 1000000:
                $hasil_bagi = (int)($angka/1000); 
                $hasil_mod  = $angka%1000;
                return sprintf('%s Ribu %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod));
                break;
            case $angka < 1000000000:
                $hasil_bagi = (int)($angka/1000000);
                $hasil_mod  = $angka%1000000;
                return trim(sprintf('%s Juta %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
                break;
            case $angka < 1000000000000:
                $hasil_bagi = (int)($angka/1000000000);
                $hasil_mod  = fmod($angka, 1000000000);
                return trim(sprintf('%s Milyar %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
                break;
            case $angka < 1000000000000000:
                $hasil_bagi = $angka/1000000000000;
                $hasil_mod = fmod($angka, 1000000000000);
                return trim(sprintf('%s Triliun %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
                break;
        }
    }

    function indonesian_date($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
        if (trim ($timestamp) == ''){
            $timestamp = time ();
        } elseif (!ctype_digit ($timestamp)){
            $timestamp = strtotime ($timestamp);
        }
        # remove S (st,nd,rd,th) there are no such things in indonesia :p
        $date_format = preg_replace ("/S/", "", $date_format);
        $pattern = array (
            '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
            '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
            '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
            '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
            '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
            '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
            '/April/','/June/','/July/','/August/','/September/','/October/',
            '/November/','/December/',
        );
        $replace = array ('Sen','Sel','Rab','Kam','Jum','Sab','Min',
            'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
            'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
            'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
            'Oktober','November','Desember',
        );
        $date = date ($date_format, $timestamp);
        $date = preg_replace ($pattern, $replace, $date);
        $date = "{$date}{$suffix}";
        return $date;
    }

    function indo_date_range($timestamp, $date_format = 'l, j F Y | H:i', $suffix = 'WIB', $separate = ' - ', $sep = ' s.d. '){
        $dates = explode($separate, $timestamp);
        $newDate = "";$cetak = 0;
        foreach ($dates as $date) {
            $newDate .= $this->indonesian_date($date, $date_format, $suffix);
            if($cetak == 0)
                $newDate .= $sep;
            $cetak++;
        }
        return $newDate;
    }

    function now($dateFormat, $timeFormat){
        return $this->indonesian_date(strtotime('now'), $dateFormat, $timeFormat);
    }
}
