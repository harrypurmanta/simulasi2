<?php

namespace App\Controllers;
use App\Models\Soalmodel;
use App\Models\Latihanmodel;


class Sikapkerja extends BaseController
{

	protected $session;
	protected $soalmodel;
	protected $latihanmodel;
	public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->soalmodel = new Soalmodel();
        $this->latihanmodel = new Latihanmodel();
	}

    public function index()
    {
        $request = \Config\Services::request();
        $materi_id = $request->getUri()->getSegment(2);
        $data['group'] = $this->latihanmodel->getSKgroup()->getResult();
        return view('front/sikapkerja/sikapkerja',$data);
    }

    public function pilihansk() {
        $request = \Config\Services::request();
        $data['sk_group_id'] = $request->getUri()->getSegment(3);
        return view('front/sikapkerja/petunjuksoal',$data);
    }

    public function ujian() {
        $request = \Config\Services::request();
        $data['sk_group_id'] = $request->getUri()->getSegment(3);
        return view('front/sikapkerja/ujian',$data);
    }

	

    public function sikapkerjaujian() {
        $request = \Config\Services::request();
        $proc = $this->request->getPost("proc");
        $soal_id = $this->request->getPost("soal_id");
        $jawaban_id = $this->request->getPost("jawaban_id");
        $group_id = $this->request->getPost("group_id");
        $no_soal = $this->request->getPost("no_soal");
        $pilihan_nm = $this->request->getPost("pilihan_nm");
        $kolom_id = $this->request->getPost("kolom_id");
        $materi = $this->request->getPost("materi");
        $sk_group_id = $this->request->getPost("sk_group_id");
        $date = date("Y-m-d H:i:s");
        if ($proc == "start") {
            $getUsed = $this->soalmodel->getResponByMateriId($this->session->user_id,$sk_group_id)->getResult();
            if (count($getUsed)>0) {
                $used = $getUsed[0]->used + 1;
                $this->session->set("used",$used);
              } else {
                $used = 1;
                $this->session->set("used",$used);
              }
        } else if (empty($this->session->used)) {
            $getUsed = $this->soalmodel->getResponByMateriId($this->session->user_id,$sk_group_id)->getResult();
            $used = (count($getUsed)>0) ? $getUsed[0]->used : 1;
            $this->session->set("used",$used);
        }
        
        if ($jawaban_id != "") {
            $data = [
                "jawaban_id" => $jawaban_id,
                "pilihan_nm" => $pilihan_nm,
                "soal_id" => $soal_id,
                "no_soal" => $no_soal,
                "group_id" => $group_id,
                "materi" => $materi,
                "used" => $this->session->used,
                "kolom_id" => $kolom_id,
                "created_user_id" => $this->session->user_id,
                "created_dttm" => $date,
                "session" => $this->session->session
            ];
            $respon_id = $this->soalmodel->simpanResponSK($data);
        }
        $no_soal = $no_soal + 1;
        // if ($proc == "start") {
        //     $kolom_id = $kolom_id + 1;
        // } 

        if ($proc == "persiapan") {
            echo json_encode(array("ret"=>"persiapan", "kolom"=>$kolom_id));
        } else if ($no_soal == 51 && $group_id == 4 && $kolom_id <= 10) {
            echo json_encode(array("ret"=>"persiapan", "kolom"=>$kolom_id));
        } else if ($group_id == 4 && $kolom_id == 11) {
            echo json_encode(array("ret"=>"selesai"));
        } else {
            // print_r($request->getUri()->getSegment(2));exit;
            $res = $this->soalmodel->getSoalSK($no_soal,4,98,$kolom_id,$sk_group_id)->getResult();
            
            if (count($res)>0) {
                $ret = "<div class='col-md-12'>
                    <table border='0' style='margin: 0 auto;'>
                        <tbody>
                            <tr style='font-size: 75px; font-weight: bold; text-align: center;'>";
                            if ($res[0]->typesoal == "gambar") {
                                $getjawaban = $this->soalmodel->getjawaban($res[0]->soal_id)->getResult();
                                foreach ($getjawaban as $key) {
                                    $jawaban_nm = explode('|', $key->jawaban_nm);
                                    foreach ($jawaban_nm as $jwb_nm) {
                                        $src = base_url("images/soalsk/kolom/$kolom_id/sk_group/$sk_group_id/$jwb_nm");
                                        $ret .= "<td width='70'><img src='$src' style='height: 100px; width: 100px; margin: 5px;'></td>";
                                    }
                                }
                            } else {
                                $getjawaban = $this->soalmodel->getjawaban($res[0]->soal_id)->getResult();
                                foreach ($getjawaban as $key) {
                                    $jawaban_nm = str_split($key->jawaban_nm,1);
                                    foreach ($jawaban_nm as $jwb_nm) {
                                        $ret .= "<td width='70'>$jwb_nm</td>";
                                    }
                                }
                            }
                            
                        $ret .= "</tr>
                            <tr style='font-size:35px;font-weight:normal;text-align:center;'>
                                <td>A</td>
                                <td>B</td>
                                <td>C</td>
                                <td>D</td>
                                <td>E</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class='sk-soal-jawaban-wrapper' style='width: 100%; max-width: 560px; margin: 25px auto 0;'>
                    <div style='font-size: 20px; font-weight: 600; margin-bottom: 10px; color: #1e293b; text-align: center;'>Pertanyaan ".$no_soal."</div>
                    <div class='sk-soal-boxes' style='display: flex; width: 100%; gap: 16px; margin-bottom: 15px;'>";
                    if ($res[0]->typesoal == "gambar") {
                        foreach ($res as $keySoal) {
                            $soal_nm = explode('|', $keySoal->soal_nm);
                            foreach ($soal_nm as $jwb_nm) {
                                $src = base_url("images/soalsk/kolom/$kolom_id/sk_group/$sk_group_id/$jwb_nm");
                                $ret .= "<div style='flex: 1; height: 90px; display: flex; align-items: center; justify-content: center; background-color: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 8px;'><img src='$src' style='max-height: 80px; max-width: 80px; object-fit: contain;'></div>";
                            }
                        }
                    } else {
                        foreach ($res as $keySoal) {
                            $soal_nm = str_split($keySoal->soal_nm,1);
                            foreach ($soal_nm as $jwb_nm) {
                                $ret .= "<div style='flex: 1; background-color: grey; height: 85px; font-size: 60px; font-weight: bold; text-align: center; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #212529;'>".$jwb_nm."</div>";
                            }
                        }
                    }
                        
                $ret .= "</div>
                    <div class='sk-pilihan-container' style='display: flex; width: 100%; gap: 8px;'>";
                    foreach ($getjawaban as $k) {
                        $jawaban_id = $k->jawaban_id;
                        $ret .= "<button onclick='startujian(\"next\",\"A\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='flex:1; margin:0; font-weight:bold; font-size:20px; height:50px; border-radius:8px;'
                        class='btn btn-outline-success'>A</button>
                    <button onclick='startujian(\"next\",\"B\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='flex:1; margin:0; font-weight:bold; font-size:20px; height:50px; border-radius:8px;'
                        class='btn btn-outline-success'>B</button>
                    <button onclick='startujian(\"next\",\"C\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='flex:1; margin:0; font-weight:bold; font-size:20px; height:50px; border-radius:8px;'
                        class='btn btn-outline-success'>C</button>
                    <button onclick='startujian(\"next\",\"D\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='flex:1; margin:0; font-weight:bold; font-size:20px; height:50px; border-radius:8px;'
                        class='btn btn-outline-success'>D</button>
                    <button onclick='startujian(\"next\",\"E\",".$jawaban_id.",".$res[0]->soal_id.",$group_id,$no_soal,$kolom_id,$materi)' style='flex:1; margin:0; font-weight:bold; font-size:20px; height:50px; border-radius:8px;'
                        class='btn btn-outline-success'>E</button>";
                    }
                        
                $ret .= "</div>
                </div>";
                echo json_encode(array("ret"=>$ret, "kolom"=>$kolom_id,"group_id"=>$group_id,"no_soal"=>$no_soal));
            } else {
                $ret = "soal_tidak_ada";
                echo json_encode(array("ret"=>$ret));
            }
        }
    }

    public function hasiltryout() {
        $request = \Config\Services::request();
        $user_id = $this->session->user_id;
        $materi_id = $request->getUri()->getSegment(3);
        $klm = $this->soalmodel->getKolomSoal()->getResult();
 
                $data = [
                    "kolom" => $klm
                ];
        return view('front/sikapkerja/hasiltryout',$data);
    }

    public function showresult() {
        $materi = $this->request->getPost('materi_id');
        $benar_passhand = 0;
            $salah_passhand = 0;
            $benar_kec = 0;
            $salah_kec = 0;
            $benar_keb = 0;
            $salah_keb = 0;
            $benar_sk  = 0;
            $salah_sk  = 0;
            $total_skor  = 0;
            $passhandskor = $this->soalmodel->getPasshandSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($passhandskor as $key) {
                if ($key->kunci == $key->pilihan_nm) {
                    $benar_passhand = $benar_passhand + 1;
                } else {
                    $salah_passhand = $salah_passhand + 1;
                }
            }

            $kecerdasanskor = $this->soalmodel->getKecerdasanSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($kecerdasanskor as $kec) {
                if ($kec->kunci == $kec->pilihan_nm) {
                    $benar_kec = $benar_kec + 1;
                } else {
                    $salah_kec = $salah_kec + 1;
                }
            }

            $kepskor = $this->soalmodel->getKepribadianSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($kepskor as $kep) {
                if ($kep->kunci == $kep->pilihan_nm) {
                    $benar_keb = $benar_keb + 1;
                } else {
                    $salah_keb = $salah_keb + 1;
                }
            }

            $sikapkerjaskor = $this->soalmodel->getSikapKerjaSkor($this->session->user_id,$this->session->session,$materi)->getResult();
            foreach ($sikapkerjaskor as $sk) {
                if ($sk->kunci == $sk->pilihan_nm) {
                    $benar_sk = $benar_sk + 1;
                } else {
                    $salah_sk = $salah_sk + 1;
                }
            }

            $total_skor = $benar_passhand + $benar_kec + $benar_keb + $benar_sk;
            if ($total_skor >= 61) {
                $styletotalskor = "color:green;";
                $syarat = "(Memenuhi Syarat - MS)";
            } else {
                $styletotalskor = "color:red;";
                $syarat = "(Tidak Memenuhi Syarat - TMS)";
            }
            $ret = "<div class='col-lg-12'>
                    <a href='".base_url()."/home'><button class='btn btn-primary'>Menu Utama</button></a>
                        <div style='width:100%;text-align:center;'>
                            <h1 style='margin:10px;'>SELAMAT !</h1>
                            <h1 style='margin:10px;'>SKOR ANDA</h1>
                            <h1 style='margin:10px;$styletotalskor'>$total_skor $syarat</h1>
                        </div>
                        <div>
                            <ul>
                            <li>Passhand skor <label>$benar_passhand</label></li>
                            <li>Kecerdasan skor <label>$benar_kec</label></li>
                            <li>Kepribadian skor <label>$benar_keb</label></li>
                            <li>Sikap Kerja skor <label>$benar_sk</label></li>
                            </ul>
                        </div>";
            $ret .= "</div>";
        echo json_encode($ret);
    }
    
}