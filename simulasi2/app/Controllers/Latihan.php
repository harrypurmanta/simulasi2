<?php

namespace App\Controllers;
use App\Models\Soalmodel;
use App\Models\Latihanmodel;
class Latihan extends BaseController
{
    protected $soalmodel;
    protected $latihanmodel;
    protected $session;
    protected $db;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->soalmodel = new Soalmodel();
        $this->latihanmodel = new Latihanmodel();
        $this->db = \Config\Database::connect();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'group' => $this->latihanmodel->getGroupLatihan()->getResult(),
            ];
            return view('front/latihan/index',$data);
        }
        
    }

    public function jenis()
    {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $group_id = $request->getUri()->getSegment(3);
            $jenis = $this->latihanmodel->getJenisByGroupId($group_id)->getResult();
            $levels = [];
            if ($group_id == 2) {
                foreach ($jenis as $j) {
                    $levels[$j->jenis_id] = $this->latihanmodel->getLevelByJenisId($j->jenis_id)->getResult();
                }
            }
            $data = [
                'group_id' => $group_id,
                'jenis' => $jenis,
                'levels' => $levels,
            ];
            return view('front/latihan/jenis',$data);
        }
    }

    public function getlevel()
    {
        $jenis_id = $this->request->getPost('jenis_id') ?? $this->request->getGet('jenis_id');
        $res = $this->latihanmodel->getLevelByJenisId($jenis_id)->getResult();
        return $this->response->setJSON($res);
    }
    
    public function petunjuk()
    {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $group_id = $request->getUri()->getSegment(3);
            $jenis_id = $request->getUri()->getSegment(4);
            $level_id = $request->getUri()->getSegment(5);

            $level_nm = '';
            if (!empty($level_id)) {
                $lvlRow = $this->db->table('level_soal')->where('level_id', $level_id)->get()->getRow();
                if ($lvlRow) {
                    $level_nm = $lvlRow->level_nm;
                }
            }

            $data = [
                'group_id' => $group_id,
                'jenis_id' => $jenis_id,
                'level_id' => $level_id,
                'level_nm' => $level_nm,
                'group' => $this->soalmodel->getGroupByid($group_id)->getResult(),
                'jenis' => $this->latihanmodel->getJenisById($jenis_id)
            ];

            if ($group_id == 1) {
                return view('front/latihan/petunjukpasshand', $data);
            } else if ($group_id == 2) {
                return view('front/latihan/petunjukkecerdasan', $data);
            } else if ($group_id == 3) {
                return view('front/latihan/petunjukkepribadian', $data);
            } else {
                return view('front/latihan/petunjukpasshand', $data);
            }
        }
    }

    public function tryout()
    {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {

            $group_id = $request->getUri()->getSegment(3);
            $jenis_id = $request->getUri()->getSegment(4);
            $level_id = $request->getUri()->getSegment(5);

            if ($group_id == 2) {
                return $this->tryout_kecerdasan($jenis_id, $level_id);
            }

            $jenis_nm = $this->latihanmodel->getJenisById($jenis_id);
            return view('front/latihan/tryout', ['group_id' => $group_id, 'jenis_nm' => $jenis_nm, 'level_id' => $level_id]);
        }
    }

    public function tryout_kecerdasan($jenis_id = null, $level_id = null)
    {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		}

        $jenis_id = $jenis_id ?? $request->getUri()->getSegment(3);
        $level_id = $level_id ?? $request->getUri()->getSegment(4);

        if (empty($jenis_id) || $jenis_id == 2) {
            $jenis_id = $request->getUri()->getSegment(4);
        }
        if (empty($level_id)) {
            $level_id = $request->getUri()->getSegment(5);
        }

        $jenis_nm = $this->latihanmodel->getJenisById($jenis_id);
        $level_nm = '';
        if (!empty($level_id)) {
            $lvlRow = $this->db->table('level_soal')->where('level_id', $level_id)->get()->getRow();
            if ($lvlRow) {
                $level_nm = $lvlRow->level_nm;
            }
        }

        $data = [
            'group_id' => 2,
            'jenis_id' => $jenis_id,
            'level_id' => $level_id,
            'jenis_nm' => $jenis_nm,
            'level_nm' => $level_nm,
        ];
        return view('front/latihan/tryout_kecerdasan', $data);
    }

    public function startujian_kecerdasan() {
        if ($this->session->get("user_nm") == "") {
            return $this->response->setJSON(['status' => 'unauthorized']);
        }

        $soal_id    = $this->request->getPost("soal_id");
        $jawaban_id = $this->request->getPost("jawaban_id");
        $jenis_id   = $this->request->getPost("jenis_id");
        $level_id   = $this->request->getPost("level_id");
        $no_soal    = (int)($this->request->getPost("no_soal") ?: 1);
        $pilihan_nm = $this->request->getPost("pilihan_nm");
        $group_id   = 2;
        $materi     = 99;
        $proc       = $this->request->getPost("proc");
        $used       = $this->request->getPost("used");
        $waktu      = $this->request->getPost("waktu");
        $date       = date("Y-m-d H:i:s");

        // 1. Inisialisasi ujian (proc == 'start')
        if ($proc == "start") {
            $notes = $this->latihanmodel->getLastUsedKecerdasan($this->session->user_id, $jenis_id, $level_id);
            if ($notes) {
                $respon = $this->latihanmodel->getResponByUser($this->session->user_id, $jenis_id, $group_id, $materi, $notes->used)->getResult();
                if (count($respon) > 0) {
                    $used = $notes->used + 1;
                    $dataexam = [
                        "jenis_id" => $jenis_id,
                        "group_id" => $group_id,
                        "materi_id" => $materi,
                        "user_id" => $this->session->user_id,
                        "used" => $used,
                    ];
                    $this->latihanmodel->insertexam($dataexam);
                } else {
                    $used = $notes->used;
                }
            } else {
                $used = 1;
                $dataexam = [
                    "jenis_id" => $jenis_id,
                    "group_id" => $group_id,
                    "materi_id" => $materi,
                    "user_id" => $this->session->user_id,
                    "used" => $used,
                ];
                $this->latihanmodel->insertexam($dataexam);
            }
        }

        // 2. Simpan respon jawaban jika ada
        if ($jawaban_id == "null") {
            // Lewati
        } else if ($proc == "next" && $jawaban_id == "") {
            echo json_encode("jawaban_kosong");
            return;
        } else if ($proc != "prev" && $proc != "prevsoal" && $proc != "start" && $proc != "jump" && !empty($soal_id) && !empty($jawaban_id)) {
            $getResponByid = $this->latihanmodel->getResponByPrev($soal_id, $jenis_id, $materi, $this->session->user_id, $used)->getResult();
            if (count($getResponByid) > 0) {
                $data = [
                    "jawaban_id" => $jawaban_id,
                    "pilihan_nm" => $pilihan_nm,
                    "soal_id"    => $soal_id,
                    "no_soal"    => $no_soal,
                    "jenis_id"   => $jenis_id,
                    "materi"     => $materi,
                    "created_user_id" => $this->session->user_id,
                    "created_dttm"    => $date,
                    "used"       => $used,
                    "group_id"   => $group_id,
                ];
                $this->latihanmodel->updateResponPrev($soal_id, $jawaban_id, $jenis_id, $materi, $this->session->user_id, $used, $data);
            } else {
                $data = [
                    "jawaban_id" => $jawaban_id,
                    "pilihan_nm" => $pilihan_nm,
                    "soal_id"    => $soal_id,
                    "no_soal"    => $no_soal,
                    "jenis_id"   => $jenis_id,
                    "materi"     => $materi,
                    "used"       => $used,
                    "group_id"   => $group_id,
                    "created_user_id" => $this->session->user_id,
                    "created_dttm"    => $date,
                ];
                $this->latihanmodel->simpanRespon($data);
            }
        }

        // 3. Ambil total soal untuk level ini
        $res_ttlsoal = $this->latihanmodel->getTotalSoalKecerdasan($jenis_id, $level_id)->getResult();
        $total_soal  = count($res_ttlsoal);

        // 4. Hitung jumlah yang sudah dijawab
        $getjumlahjawab = $this->latihanmodel->getResponCountKecerdasan($jenis_id, $level_id, $this->session->user_id, $used)->getResult();
        $jumlahjawab = (count($getjumlahjawab) > 0) ? (int)$getjumlahjawab[0]->jumlah_jawab : 0;

        if ($proc == "selesai") {
            echo json_encode(array("proc" => "selesai", "used" => $used));
            return;
        }

        // 5. Geser nomor soal sesuai aksi
        if ($proc == "prevsoal") {
            $no_soal = max(1, $no_soal - 1);
        } else if ($proc == "next") {
            $no_soal = min($total_soal, $no_soal + 1);
        } else if ($proc == "jump") {
            $no_soal = max(1, min($total_soal, $no_soal));
        }

        // 6. Ambil data soal yang aktif
        $res = $this->latihanmodel->getSoalKecerdasan($no_soal, $jenis_id, $level_id)->getResult();
        $soal_nm = "";
        $img_soal = "";
        $jawaban_idx = "";
        $pilihan_nms = "";
        $pilihan_nmx = "";

        if (count($res) > 0) {
            $soal_nm  = $res[0]->soal_nm;
            $soal_id  = $res[0]->soal_id;
            $jenis_id = $res[0]->jenis_id;

            if (!empty($res[0]->soal_img)) {
                $img_soal = "<div class='col-sm-10' style='margin-top:10px;'>
                    <a href='".base_url()."/images/soal_latihan/jenis/".$res[0]->jenis_id."/".$res[0]->soal_img."' data-toggle='lightbox'>
                        <img style='max-width: 350px; max-height: 100%; border-radius: 6px;' src='".base_url()."/images/soal_latihan/jenis/".$res[0]->jenis_id."/".$res[0]->soal_img."' class='img-fluid'>
                    </a>
                </div>";
            }
        }

        // Cek jawaban tersimpan untuk soal ini
        if (!empty($soal_id)) {
            $curRespon = $this->latihanmodel->getResponBox($soal_id, $jenis_id, $materi, $this->session->user_id, $used, $group_id)->getResult();
            if (count($curRespon) > 0) {
                $pilihan_nmx = $curRespon[0]->pilihan_nm;
            }
        }

        // 7. Render box nomor soal (5 nomor per baris)
        $boxnomorsoal = "";
        $seq = 1;
        foreach ($res_ttlsoal as $boxsoal) {
            $getResponBox = $this->latihanmodel->getResponBox($boxsoal->soal_id, $jenis_id, $materi, $this->session->user_id, $used, $group_id)->getResult();
            $boxclick = "onclick='setboxsoal({$seq})'";
            $boxcursor = "cursor:pointer;";

            if (count($getResponBox) > 0) {
                $pilihan_label = " " . $getResponBox[0]->pilihan_nm;
                $style = "border:2px solid #3cce3c; height:38px; padding:2px; border-radius:6px; font-weight:600; background:#e8f8e8; color:#1e293b; $boxcursor";
                if ($seq == $no_soal) {
                    $style = "border:2px solid #2a5298; height:38px; padding:2px; border-radius:6px; font-weight:700; background:#d0e2ff; color:#1e293b; box-shadow: 0 0 6px rgba(42,82,152,0.5); $boxcursor";
                }
            } else {
                $pilihan_label = "";
                $style = "border:2px solid #f87171; height:38px; padding:2px; border-radius:6px; font-weight:600; background:#fff; color:#1e293b; $boxcursor";
                if ($seq == $no_soal) {
                    $style = "border:2px solid #2a5298; height:38px; padding:2px; border-radius:6px; font-weight:700; background:#d0e2ff; color:#1e293b; box-shadow: 0 0 6px rgba(42,82,152,0.5); $boxcursor";
                }
            }
            $boxnomorsoal .= "<div class='text-center box-no-item' style='$style font-size:12px; width:100%; display:flex; align-items:center; justify-content:center;' $boxclick>{$seq}{$pilihan_label}</div>";
            $seq++;
        }

        // 8. Render pilihan jawaban
        $jawaban = "";
        if (!empty($soal_id)) {
            $getjawaban = $this->latihanmodel->getjawaban($soal_id)->getResult();
            foreach ($getjawaban as $key) {
                if ($pilihan_nmx == $key->pilihan_nm) {
                    $jawaban_idx = $key->jawaban_id;
                    $pilihan_nms = $key->pilihan_nm;
                    $border = "border: 2px solid #00a65a; background-color: #d7f0db;";
                } else {
                    $border = "border: 1px solid #d2d6de; background-color: #f4f6f9;";
                }

                $img_jwb = "";
                if (!empty($key->jawaban_img)) {
                    $img_jwb = "<div style='margin-top:5px;'><img style='max-width:300px; max-height:150px; border-radius:4px;' src='".base_url()."/images/jawaban_latihan/jenis/".$jenis_id."/".$key->jawaban_img."'></div>";
                }

                $jawaban .= "<div id='dv_jawaban_".$key->jawaban_id."' onclick='selectJawaban(".$key->jawaban_id.",\"".$key->pilihan_nm."\")' class='col-md-12 jawaban_dv' style='display: block; padding: 12px 16px; margin-top: 8px; margin-bottom: 8px; border-radius: 8px; text-align: left; cursor: pointer; transition: all 0.2s; $border'>
                    <label style='cursor:pointer; font-size:15px; margin-bottom:0;'>
                        <strong style='color:#1e3c72; font-size:16px;'>".$key->pilihan_nm.".</strong> 
                        <span style='margin-left: 6px; font-weight: normal; color:#2c3e50;'>".esc($key->jawaban_nm)."</span>
                    </label>
                    $img_jwb
                </div>";
            }
        }

        // 9. Render Tombol Aksi (Previous, Next, Selesai)
        $is_cur_soal_answered = (!empty($pilihan_nmx));
        $sisa_soal = $total_soal - $jumlahjawab;

        // Tombol selesai tampil jika siswa sudah menjawab soal dan tersisa 1 soal lagi,
        // dan HANYA tampil di soal yang belum terjawab (atau jika semua sudah terjawab)
        $show_selesai = false;
        if ($total_soal > 0) {
            if ($jumlahjawab > 0 && $sisa_soal == 1 && !$is_cur_soal_answered) {
                $show_selesai = true;
            } else if ($jumlahjawab >= $total_soal) {
                $show_selesai = true;
            }
        }

        $button = "<div class='col-md-8' style='padding-left:0;'>";
        if ($no_soal > 1) {
            $button .= "<button type='button' onclick='startujian(\"prevsoal\")' style='font-size:15px; padding: 8px 24px; border-radius:6px; margin-right:8px;' class='btn btn-default'><i class='fa fa-arrow-left'></i> Previous</button>";
        }
        if ($no_soal < $total_soal) {
            $button .= "<button type='button' onclick='startujian(\"next\")' style='font-size:15px; padding: 8px 28px; border-radius:6px;' class='btn btn-primary'>Next <i class='fa fa-arrow-right'></i></button>";
        }
        $button .= "</div>";

        $button .= "<div class='col-md-4 text-right' style='padding-right:0;'>";
        if ($show_selesai) {
            $button .= "<button type='button' onclick='konfirmasiSelesai()' style='font-size:15px; padding: 8px 24px; border-radius:6px;' class='btn btn-success'><i class='fa fa-check-circle'></i> Selesai</button>";
        }
        $button .= "</div>";

        echo json_encode([
            "soal_id"      => $soal_id,
            "soal_nm"      => $soal_nm,
            "no_soal"      => $no_soal,
            "total_soal"   => $total_soal,
            "jenis_id"     => $jenis_id,
            "level_id"     => $level_id,
            "group_id"     => $group_id,
            "jawaban_nm"   => $jawaban,
            "boxnomorsoal" => $boxnomorsoal,
            "button"       => $button,
            "proc"         => $proc,
            "img_soal"     => $img_soal,
            "jawaban_idx"  => $jawaban_idx,
            "pilihan_nms"  => $pilihan_nms,
            "jumlah_jawab" => $jumlahjawab,
            "used"         => $used
        ]);
    }

    public function hasillatihan_kecerdasan() {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		}

        $materi   = $request->getUri()->getSegment(3) ?? 99;
        $jenis_id = $request->getUri()->getSegment(4);
        $level_id = $request->getUri()->getSegment(5);
        $used     = $request->getUri()->getSegment(6);

        $benar = 0;
        $salah = 0;
        $res = $this->latihanmodel->getResponLatihanKecerdasan($jenis_id, $level_id, $this->session->user_id, $used)->getResult();

        if (count($res) > 0) {
            foreach ($res as $k) {
                if ($k->kunci == $k->pilihan_respon) {
                    $benar++;
                } else {
                    $salah++;
                }
            }
        }

        $levelRow = $this->db->table('level_soal')->where('level_id', $level_id)->get()->getRow();
        $jenisRow = $this->latihanmodel->getJenisById($jenis_id);

        $data = [
            "benar"    => $benar,
            "salah"    => $salah,
            "total"    => count($res),
            "jenis_nm" => $jenisRow ? $jenisRow->jenis_nm : '',
            "level_nm" => $levelRow ? $levelRow->level_nm : '',
            "level_id" => $level_id,
            "jenis_id" => $jenis_id,
            "materi"   => $materi,
            "used"     => $used,
        ];
        return view('front/latihan/hasillatihan', $data);
    }


    public function startujian() {
        $request = \Config\Services::request();
        $soal_id = $this->request->getPost("soal_id");
        $jawaban_id = $this->request->getPost("jawaban_id");
        $jenis_id = $this->request->getPost("jenis_id");
        $level_id = $this->request->getPost("level_id");
        $no_soal = $this->request->getPost("no_soal");
        $pilihan_nm = $this->request->getPost("pilihan_nm");
        $group_id = $this->request->getPost("group_id");
        $materi = $this->request->getPost("materi");
        $proc = $this->request->getPost("proc");
        $used = $this->request->getPost("used");
        $waktu = $this->request->getPost("waktu");
        $date = date("Y-m-d H:i:s");
        $soal_nm = "";
        $jawaban = "";
        $boxnomorsoal = "";
        $res_ttlsoal = "";
        $sisawaktu = "";
       
            if ($proc == "start") {
                $notes = $this->latihanmodel->getLastUsed($this->session->user_id, $jenis_id, $group_id, $materi);
                if ($notes) {
                    $respon = $this->latihanmodel->getResponByUser($this->session->user_id,$jenis_id, $group_id, $materi, $notes->used)->getResult();
                
                    if (count($respon)>0) {
                        $used = $notes->used + 1;
                        $dataexam = [
                            "jenis_id" => $jenis_id,
                            "group_id" => $group_id,
                            "materi_id" => $materi,
                            "user_id" => $this->session->user_id,
                            "used" => $used,
                        ];
                        $insertexam = $this->latihanmodel->insertexam($dataexam);
                        
                    } else {
                        $used = $notes->used;
                    }
                } else {
                    $used = 1;
                    $dataexam = [
                        "jenis_id" => $jenis_id,
                        "group_id" => $group_id,
                        "materi_id" => $materi,
                        "user_id" => $this->session->user_id,
                        "used" => $used,
                    ];
                    $insertexam = $this->latihanmodel->insertexam($dataexam);
                }
               
                
            }
            
        if ($jawaban_id == "null") {

        } else if ($proc == "next" && $jawaban_id == "") {
            echo json_encode("jawaban_kosong");
        } else {
            if ($proc == "prev" || $proc == "prevsoal" || $proc == "start") {

            } else {
                $getResponByid = $this->latihanmodel->getResponByPrev($soal_id,$jenis_id,$materi,$this->session->user_id,$used)->getResult();
                if (count($getResponByid)>0) {
                    $data = [
                        "jawaban_id" => $jawaban_id,
                        "pilihan_nm" => $pilihan_nm,
                        "soal_id" => $soal_id,
                        "no_soal" => $no_soal,
                        "jenis_id" => $jenis_id,
                        "materi" => $materi,
                        "created_user_id" => $this->session->user_id,
                        "created_dttm" => $date,
                        "used" => $used,
                        "group_id" => $group_id,
                    ];
        
                    $updaterespon = $this->latihanmodel->updateResponPrev($soal_id,$jawaban_id,$jenis_id,$materi,$this->session->user_id,$used,$data);
                } else {
                    if ($jawaban_id !== "null" && isset($soal_id)) {
                        $data = [
                            "jawaban_id" => $jawaban_id,
                            "pilihan_nm" => $pilihan_nm,
                            "soal_id" => $soal_id,
                            "no_soal" => $no_soal,
                            "jenis_id" => $jenis_id,
                            "materi" => $materi,
                            "used" => $used,
                            "group_id" => $group_id,
                            "created_user_id" => $this->session->user_id,
                            "created_dttm" => $date,
                            // "session" => $this->session->session
                        ];
            
                        $respon_id = $this->latihanmodel->simpanRespon($data);
                    }
                }
            }
                $getjumlahjawab = $this->latihanmodel->getResponCountByLatihan($jenis_id, $group_id,$this->session->user_id,$used)->getResult();
                
                    if (count($getjumlahjawab)>0) {
                        $jumlahjawab = $getjumlahjawab[0]->jumlah_jawab;
                    } else {
                        $jumlahjawab = 0;
                    }

                $res_ttlsoal = $this->latihanmodel->getTotalSoalLatihan($jenis_id, $group_id, $level_id)->getResult();
                
                if ($jumlahjawab == count($res_ttlsoal)) {
                    $proc = "selesai";
                }
                
                
                if ($proc == "selesai") {
                    // $data = [
                    //     "remaining_time" => $waktu,
                    //     "date" => $date,
                    //     "status_cd" => "normal",
                    //     "isFinish" => "finish"
                    // ];
                    // $this->latihanmodel->updateRemainingTime($this->session->user_id,$materi,$data,"tryout");
                    echo json_encode(array("proc" => $proc));
                } else {
                    if ($proc == "prevsoal") {
                        $no_soal = $no_soal - 1;
                    } else if ($proc == "next") {
                        $no_soal = $no_soal + 1;
                    }
                    
                    $res = $this->latihanmodel->getSoal($no_soal,$jenis_id,$materi,$group_id, $level_id)->getResult();
                    
                    if (count($res)>0) {
                        $soal_nm = $res[0]->soal_nm;
                        $soal_id = $res[0]->soal_id;
                        $jenis_id = $res[0]->jenis_id;   
                        $group_id = $res[0]->group_id;
                    } 

                    
                    foreach ($res_ttlsoal as $boxsoal) {
                        $getResponBox = $this->latihanmodel->getResponBox($boxsoal->soal_id,$jenis_id,$materi,$this->session->user_id, $used, $group_id)->getResult();
                        if ($jenis_id == 99) {
                            $boxclick = "onclick='setboxsoal($boxsoal->no_soal)'";
                            $boxcursor = "cursor:pointer;";
                        } else {
                            $boxclick = "";
                            $boxcursor = "";
                        }

                        // if ($no_soal == count($res_ttlsoal)+1) {
                        //     $no_soal_belum[] = $boxsoal->no_soal;
                        //     if (count($no_soal_belum)>0 && $proc == "next" && $res_ttlsoal) {
                        //         $no_soal = $no_soal_belum[0];
                        //     } 
                        //     $res = $this->latihanmodel->getSoal($no_soal,$jenis_id,$materi,$group_id)->getResult();
                        // } 

                        if (count($getResponBox)>0) {
                            $pilihan_nm = " ".$getResponBox[0]->pilihan_nm;
                            $style="border:2px solid #3cce3c;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            if ($boxsoal->no_soal == $no_soal) {
                                $pilihan_nmx = $getResponBox[0]->pilihan_nm;
                                $style="border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            }
                        } else {
                            $pilihan_nm = "";
                            $style="border:2px solid red;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            if ($boxsoal->no_soal == $no_soal) {
                                $pilihan_nmx = $pilihan_nm;
                                $style="border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            }
                        }
                        $boxnomorsoal .= "<div class='col-md-2' style='$style font-size:12px;' $boxclick>".$boxsoal->no_soal."$pilihan_nm</div>";
                    }
                    

                    if ($res[0]->soal_img == "") {
                        $img_soal = "";
                    } else {
                        $img_soal = "<div class='col-sm-10'>
                        <a href='".base_url()."/images/soal/materi/".$res[0]->materi."/besar/".$res[0]->soal_img."' data-toggle='lightbox'>
                        <img style='max-width: 350px;max-height: 100%;' src='".base_url()."/images/soal/materi/".$res[0]->materi."/".$res[0]->soal_img."' class='img-fluid'>
                        </a>
                    </div>";
                    }
    
                    $getjawaban = $this->latihanmodel->getjawaban($res[0]->soal_id)->getResult();
                    $jawaban_idx = "";
                    $pilihan_nms = "";
                    foreach ($getjawaban as $key) {
                        if ($pilihan_nmx == $key->pilihan_nm) {
                            $jawaban_idx = $key->jawaban_id;
                            $pilihan_nms = $key->pilihan_nm;
                            $border = "margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align: left;border: thick solid rgb(0, 166, 90);";
                        } else {
                            $border = "";
                        }
                        
                        if ($key->jawaban_img == "") {
                            $img_jwb = "";
                        } else {
                            $img_jwb = "<img style='max-width:350px;height:100%;' src='".base_url()."/images/jawaban/materi/".$res[0]->materi."/".$key->jawaban_img.".jpg'>";
                        }
                        
                        $jawaban .= "<div id='dv_jawaban_".$key->jawaban_id."' onclick='selectJawaban(".$key->jawaban_id.",\"".$key->pilihan_nm."\")' class='p-10 col-md-12 jawaban_dv' style='display: flex; padding: 5px; margin-top: 10px; margin-bottom: 10px; background-color: #aeaebb;border-radius: 5px; text-align: left; cursor: pointer;'> <label for='pilihan_nm' style='margin-left:10px;'>".$key->pilihan_nm.". </label> <span style='margin-left: 5px;'>".$key->jawaban_nm."</span>
                        <div>$img_jwb</div>
                            </div>";
                    }
                    $button = "";
                    
                    
                    $button .= "<div class='col-md-9'>";
                    if ($jenis_id == 99) {
                        $button .= "<button onclick='startujian(\"prevsoal\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Previous</button> ";
                    }
                     $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                     $button .= "</div>";
                    //  if (count($res_ttlsoal) != $no_soal) {
                    //         $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                    // }
                    
                    if ($jumlahjawab == count($res_ttlsoal) - 1 || $jumlahjawab == count($res_ttlsoal)) {
                        $button .= "<div class='col-md-3'>";
                        $button .= "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                         $button .= "</div>";
                    }
                    
                    // $button .= "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-warning'>Selesai</button>";
                   
                   

                    // if (count($res_ttlsoal) == $no_soal) {
                    //     $group_id = $group_id + 1;
                    //     $button = "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                    // } else {
                        
                    // }
                    echo json_encode(array("soal_id"=>$soal_id, "soal_nm" => $soal_nm,"no_soal"=>$no_soal, "jenis_id"=>$jenis_id,"level_id"=>$level_id,"group_id"=>$group_id, "jawaban_nm" => $jawaban, "boxnomorsoal" => $boxnomorsoal, "button" => $button, "proc" => $proc, "img_soal"=>$img_soal,"jawaban_idx"=>$jawaban_idx,"pilihan_nms"=>$pilihan_nms,"jumlah_jawab"=>$jumlahjawab, "used" => $used));
                }
        }
        
    }

    public function updateFinishRespon() {
        $materi_id = $this->request->getPost("materi_id");
        $jenis_id = $this->request->getPost("jenis_id");
        $user_id = $this->session->user_id;

        $data = [
            "status_cd" => "finish"
        ];
        $reset = $this->latihanmodel->updateFinishRespon($materi_id,$jenis_id,$user_id,$used,$data);

        echo json_encode($reset);
    }

    public function hasillatihan() {
        $request = \Config\Services::request();
        // $jenis_id = $this->request->getPost('jenis_id');
        $materi = $request->getUri()->getSegment(3);
        $jenis_id = $request->getUri()->getSegment(4);
        $used = $request->getUri()->getSegment(5);
        $group_id = $request->getUri()->getSegment(6);
        // echo json_encode($jenis_id);exit;
        $benar  = 0;
        $salah  = 0;
        $res = $this->latihanmodel->getResponLatihan($jenis_id,$this->session->user_id,$used, $group_id)->getResult();
        // echo var_dump($res);exit;

        if (count($res)>0) {
            foreach ($res as $k) {
                if ($k->kunci == $k->pilihan_respon) {
                    $benar = $benar + 1;
                } else {
                    $salah = $salah + 1;
                }
            }
        }

        $data = [
            "benar" => $benar,
            "salah" => $salah
        ];
        
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            return view('front/latihan/hasillatihan', $data);
        }
    }

    public function pembahasan_latihan() {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {

            $group_id = $request->getUri()->getSegment(6);
            $jenis_id = $request->getUri()->getSegment(4);

            $jenis_nm = $this->latihanmodel->getJenisById($jenis_id);
            return view('front/pembahasan_latihan/tryout', ['group_id' => $group_id, 'jenis_nm' => $jenis_nm]);
        }
    }

    
    public function startujianpembahasan() {
        $request = \Config\Services::request();
        $soal_id = $this->request->getPost("soal_id");
        $jawaban_id = $this->request->getPost("jawaban_id");
        $jenis_id = $this->request->getPost("jenis_id");
        $no_soal = $this->request->getPost("no_soal");
        $pilihan_nm = $this->request->getPost("pilihan_nm");
        $group_id = $this->request->getPost("group_id");
        $materi = $this->request->getPost("materi");
        $proc = $this->request->getPost("proc");
        $used = $this->request->getPost("used");
        $waktu = $this->request->getPost("waktu");
        $date = date("Y-m-d H:i:s");
        $soal_nm = "";
        $jawaban = "";
        $boxnomorsoal = "";
        $res_ttlsoal = "";
        $sisawaktu = "";
       
            // if ($proc == "start") {
            //     $notes = $this->latihanmodel->getLastUsed($this->session->user_id,$jenis_id, $group_id, $materi);

            //     $respon = $this->latihanmodel->getResponByUser($this->session->user_id,$jenis_id, $group_id, $materi, $notes->used)->getResult();
                
            //     if (count($respon)>0) {
            //         if ($notes) {
            //             $used = $notes->used + 1;
            //         } else {
            //             $used = 1;
            //         }
            //         $dataexam = [
            //             "jenis_id" => $jenis_id,
            //             "group_id" => $group_id,
            //             "materi_id" => $materi,
            //             "user_id" => $this->session->user_id,
            //             "used" => $used,
            //         ];
            //         $insertexam = $this->latihanmodel->insertexam($dataexam);
            //     } else {
            //          if ($notes) {
            //             $used = $notes->used;
            //         } else {
            //             $used = 1;
            //         }
            //     }
            // }

            
        if ($jawaban_id == "null") {

        } else if ($proc == "next" && $jawaban_id == "") {
            echo json_encode("jawaban_kosong");
        } else {
            if ($proc == "prev" || $proc == "prevsoal" || $proc == "start") {

            } else {
                // $getResponByid = $this->latihanmodel->getResponByPrev($soal_id,$jenis_id,$materi,$this->session->user_id,$used)->getResult();
                // if (count($getResponByid)>0) {
                //     $data = [
                //         "jawaban_id" => $jawaban_id,
                //         "pilihan_nm" => $pilihan_nm,
                //         "soal_id" => $soal_id,
                //         "no_soal" => $no_soal,
                //         "jenis_id" => $jenis_id,
                //         "materi" => $materi,
                //         "created_user_id" => $this->session->user_id,
                //         "created_dttm" => $date,
                //         "used" => $used,
                //         "group_id" => $group_id,
                //     ];
        
                //     $updaterespon = $this->latihanmodel->updateResponPrev($soal_id,$jawaban_id,$jenis_id,$materi,$this->session->user_id,$used,$data);
                // } else {
                //     if ($jawaban_id !== "null" && isset($soal_id)) {
                //         $data = [
                //             "jawaban_id" => $jawaban_id,
                //             "pilihan_nm" => $pilihan_nm,
                //             "soal_id" => $soal_id,
                //             "no_soal" => $no_soal,
                //             "jenis_id" => $jenis_id,
                //             "materi" => $materi,
                //             "used" => $used,
                //             "group_id" => $group_id,
                //             "created_user_id" => $this->session->user_id,
                //             "created_dttm" => $date,
                //             // "session" => $this->session->session
                //         ];
            
                //         $respon_id = $this->latihanmodel->simpanRespon($data);
                //     }
                // }
            }
                $getjumlahjawab = $this->latihanmodel->getResponCountByLatihan($jenis_id, $group_id,$this->session->user_id,$used)->getResult();
                
                    if (count($getjumlahjawab)>0) {
                        $jumlahjawab = $getjumlahjawab[0]->jumlah_jawab;
                    } else {
                        $jumlahjawab = 0;
                    }

                $res_ttlsoal = $this->latihanmodel->getTotalSoalLatihan($jenis_id, $group_id)->getResult();
                
                if ($proc == "selesai") {
                    // $data = [
                    //     "remaining_time" => $waktu,
                    //     "date" => $date,
                    //     "status_cd" => "normal",
                    //     "isFinish" => "finish"
                    // ];
                    // $this->latihanmodel->updateRemainingTime($this->session->user_id,$materi,$data,"tryout");
                    echo json_encode(array("proc" => $proc));
                } else {
                    if ($proc == "prevsoal") {
                        $no_soal = $no_soal - 1;
                    } else if ($proc == "next") {
                        $no_soal = $no_soal + 1;
                    }
                    
                    $res = $this->latihanmodel->getSoal($no_soal,$jenis_id,$materi,$group_id)->getResult();
                    
                    if (count($res)>0) {
                        $soal_nm = $res[0]->soal_nm;
                        $soal_id = $res[0]->soal_id;
                        $jenis_id = $res[0]->jenis_id;   
                        $group_id = $res[0]->group_id;
                    } 

                    foreach ($res_ttlsoal as $boxsoal) {
                        $getResponBox = $this->latihanmodel->getResponBoxPembahasan($boxsoal->soal_id,$jenis_id,$materi,$this->session->user_id,$used)->getResult();
                        $boxclick = "onclick='setboxsoal($boxsoal->no_soal)'";
                        $boxcursor = "cursor:pointer;";

                        // if ($no_soal == count($res_ttlsoal)+1) {
                        //     $no_soal_belum[] = $boxsoal->no_soal;
                        //     if (count($no_soal_belum)>0 && $proc == "next" && $res_ttlsoal) {
                        //         $no_soal = $no_soal_belum[0];
                        //     } 
                        //     $res = $this->latihanmodel->getSoal($no_soal,$jenis_id,$materi,$group_id)->getResult();
                        // } 

                        if (count($getResponBox)>0) {
                            $pilihan_nm = " ".$getResponBox[0]->pilihan_nm;

                            if ($getResponBox[0]->pilihan_nm == $getResponBox[0]->kunci) {
                                $style="border:2px solid #3cce3c;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;cursor:pointer;";
                            } else {
                                $style="border:2px solid red;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;cursor:pointer;";
                            }
                            
                            if ($boxsoal->no_soal == $no_soal) {
                                $pilihan_nmx = $getResponBox[0]->pilihan_nm;
                                $style="border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            }
                        } else {
                            $pilihan_nm = "";
                            $style="border:2px solid red;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            if ($boxsoal->no_soal == $no_soal) {
                                $pilihan_nmx = $pilihan_nm;
                                $style="border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            }
                        }
                        $boxnomorsoal .= "<div class='col-md-2' style='$style font-size:12px;' $boxclick>".$boxsoal->no_soal."$pilihan_nm</div>";
                    }
                    

                    if ($res[0]->soal_img == "") {
                        $img_soal = "";
                    } else {
                        $img_soal = "<div class='col-sm-10'>
                        <a href='".base_url()."/images/soal/materi/".$res[0]->materi."/besar/".$res[0]->soal_img."' data-toggle='lightbox'>
                        <img style='max-width: 350px;max-height: 100%;' src='".base_url()."/images/soal/materi/".$res[0]->materi."/".$res[0]->soal_img."' class='img-fluid'>
                        </a>
                    </div>";
                    }
    
                    $getjawaban = $this->latihanmodel->getjawaban($res[0]->soal_id)->getResult();
                    $jawaban_idx = "";
                    $pilihan_nms = "";
                    foreach ($getjawaban as $key) {
                        if ($pilihan_nmx == $key->pilihan_nm) {
                            $jawaban_idx = $key->jawaban_id;
                            $pilihan_nms = $key->pilihan_nm;
                            $border = "margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align: left;border: thick solid rgb(0, 166, 90);";
                        } else {
                            $border = "";
                        }
                        
                        if ($key->jawaban_img == "") {
                            $img_jwb = "";
                        } else {
                            $img_jwb = "<img style='max-width:350px;height:100%;' src='".base_url()."/images/jawaban/materi/".$res[0]->materi."/".$key->jawaban_img.".jpg'>";
                        }
                        
                        $jawaban .= "<div id='dv_jawaban_".$key->jawaban_id."' class='p-10 col-md-12 jawaban_dv' style='display: flex; padding: 5px; margin-top: 10px; margin-bottom: 10px; background-color: #aeaebb;border-radius: 5px; text-align: left;'> <label for='pilihan_nm' style='margin-left:10px;'>".$key->pilihan_nm.". </label> <span style='margin-left: 5px;'>".$key->jawaban_nm."</span>
                        <div>$img_jwb</div>
                            </div>";
                    }

                    // PEMBAHASAN
                    

                    $button = "<div class='row'>";
                    $button .= "<div class='col-md-6'>";
                    $button .= "<button onclick='startujian(\"prevsoal\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Previous</button> ";
                    $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                    $button .= "</div>";

                    $button .= "<div class='col-md-6 text-right'>
                            <button onclick='if(document.getElementById(\"spoiler\") .style.display==\"none\") {document.getElementById(\"spoiler\") .style.display=\"\"}else{document.getElementById(\"spoiler\") .style.display=\"none\"}' style='margin-bottom:10px;' type='button' class='btn bg-gradient-secondary'>pembahasan</button><br>
                            <div id='spoiler' style='display:none;border: 1px solid black;background-color: #8fbc8f;border-radius:5px;'>";
                            if ($res[0]->pembahasan_img != "") {
                                $button .= "<img style='padding:10px;max-height:100%; max-width:100%;' src='/images/pembahasan_latihan/$group_id/$jenis_id/".$res[0]->pembahasan_img."'>";
                            } else {
                                $resjawaban_nm = $this->latihanmodel->getJawabannmPembahasan($res[0]->kunci,$res[0]->soal_id)->getResult();
                                $button .= "<div class='text-left' style='margin: 5px;background-color: white; padding: 10px;'><span>".$resjawaban_nm[0]->pilihan_nm.". ".$resjawaban_nm[0]->jawaban_nm."</span>
                                <br><p>".$res[0]->pembahasan."</p>
                                </div>";
                            }
                            
                    $button .= "</div></div>";
                    $button .= "</div>";

                    //  if (count($res_ttlsoal) != $no_soal) {
                    //         $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                    // }
                    
                    // if ($jumlahjawab == count($res_ttlsoal) - 1 || $jumlahjawab == count($res_ttlsoal)) {
                    //     $button .= "<div class='col-md-3'>";
                    //     $button .= "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                    //      $button .= "</div>";
                    // }
                    
                    // $button .= "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-warning'>Selesai</button>";
                   
                   

                    // if (count($res_ttlsoal) == $no_soal) {
                    //     $group_id = $group_id + 1;
                    //     $button = "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Selesai</button>";
                    // } else {
                        
                    // }
                    echo json_encode(array("soal_id"=>$soal_id, "soal_nm" => $soal_nm,"no_soal"=>$no_soal, "jenis_id"=>$jenis_id,"group_id"=>$group_id, "jawaban_nm" => $jawaban, "boxnomorsoal" => $boxnomorsoal, "button" => $button, "proc" => $proc, "img_soal"=>$img_soal,"jawaban_idx"=>$jawaban_idx,"pilihan_nms"=>$pilihan_nms,"jumlah_jawab"=>$jumlahjawab, "used" => $used));
                }
        }
        
    }

}