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

    public function mulai_kecerdasan($jenis_id = null, $level_id = null)
    {
        if ($this->session->get("user_nm") == "") {
            return redirect('/');
        }

        $request = \Config\Services::request();
        $jenis_id = $jenis_id ?? $request->getUri()->getSegment(3);
        $level_id = $level_id ?? $request->getUri()->getSegment(4);

        if (empty($jenis_id) || $jenis_id == 2) {
            $jenis_id = $request->getUri()->getSegment(4);
        }
        if (empty($level_id)) {
            $level_id = $request->getUri()->getSegment(5);
        }

        $notes = $this->latihanmodel->getLastUsedKecerdasan($this->session->user_id, $jenis_id, $level_id);
        if ($notes) {
            $used = $notes->used + 1;
        } else {
            $used = 1;
        }

        $dataexam = [
            "jenis_id"  => $jenis_id,
            "group_id"  => 2,
            "materi_id" => 99,
            "user_id"   => $this->session->user_id,
            "used"      => $used,
        ];
        $this->latihanmodel->insertexam($dataexam);

        return redirect()->to(base_url('latihan/tryout_kecerdasan/' . $jenis_id . (!empty($level_id) ? '/' . $level_id : '')));
    }

    public function mulai_tryout($group_id = null, $jenis_id = null, $level_id = null)
    {
        if ($this->session->get("user_nm") == "") {
            return redirect('/');
        }

        $request = \Config\Services::request();
        $group_id = $group_id ?? $request->getUri()->getSegment(3);
        $jenis_id = $jenis_id ?? $request->getUri()->getSegment(4);
        $level_id = $level_id ?? $request->getUri()->getSegment(5);

        if ($group_id == 2) {
            return $this->mulai_kecerdasan($jenis_id, $level_id);
        }

        $materi = 99;
        $notes = $this->latihanmodel->getLastUsed($this->session->user_id, $jenis_id, $group_id, $materi);
        if ($notes) {
            $used = $notes->used + 1;
        } else {
            $used = 1;
        }

        $dataexam = [
            "jenis_id"  => $jenis_id,
            "group_id"  => $group_id,
            "materi_id" => $materi,
            "user_id"   => $this->session->user_id,
            "used"      => $used,
        ];
        $this->latihanmodel->insertexam($dataexam);

        return redirect()->to(base_url('latihan/tryout/' . $group_id . '/' . $jenis_id . (!empty($level_id) ? '/' . $level_id : '')));
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

        $notes = $this->latihanmodel->getLastUsedKecerdasan($this->session->user_id, $jenis_id, $level_id);
        if ($notes) {
            $used = $notes->used;
        } else {
            $used = 1;
            $this->latihanmodel->insertexam([
                "jenis_id"  => $jenis_id,
                "group_id"  => 2,
                "materi_id" => 99,
                "user_id"   => $this->session->user_id,
                "used"      => 1,
            ]);
        }

        $data = [
            'group_id' => 2,
            'jenis_id' => $jenis_id,
            'level_id' => $level_id,
            'jenis_nm' => $jenis_nm,
            'level_nm' => $level_nm,
            'used'     => $used,
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
            if (empty($used)) {
                $notes = $this->latihanmodel->getLastUsedKecerdasan($this->session->user_id, $jenis_id, $level_id);
                if ($notes) {
                    $used = $notes->used;
                } else {
                    $used = 1;
                    $dataexam = [
                        "jenis_id"  => $jenis_id,
                        "group_id"  => $group_id,
                        "materi_id" => $materi,
                        "user_id"   => $this->session->user_id,
                        "used"      => 1,
                    ];
                    $this->latihanmodel->insertexam($dataexam);
                }
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
                $imgUrl = base_url()."/images/soal_latihan/jenis/".$res[0]->jenis_id."/".$res[0]->soal_img;
                $img_soal = "<div class='col-sm-10 mx-auto my-2 text-center'>
                    <a href='".$imgUrl."' data-toggle='lightbox' data-large-src='".$imgUrl."' data-fallback-src='".$imgUrl."'>
                        <img style='max-width: 350px; max-height: 100%; cursor: zoom-in; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);' src='".$imgUrl."' class='img-fluid popup-img-trigger' title='Klik untuk memperbesar gambar'>
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
                if ($pilihan_nmx !== "" && $pilihan_nmx == $key->pilihan_nm) {
                    $jawaban_idx = $key->jawaban_id;
                    $pilihan_nms = $key->pilihan_nm;
                    $selectedClass = "selected-jawaban";
                } else {
                    $selectedClass = "";
                }

                $img_jwb = "";
                if (!empty($key->jawaban_img)) {
                    $jwbUrl = base_url()."/images/jawaban_latihan/jenis/".$jenis_id."/".$key->jawaban_img;
                    $img_jwb = "<div class='d-inline-flex align-items-center'><img style='max-width:350px; height:100%; cursor:zoom-in; border-radius:6px;' src='".$jwbUrl."' data-large-src='".$jwbUrl."' data-fallback-src='".$jwbUrl."' class='jawaban-img popup-img-trigger' title='Klik untuk memperbesar gambar'></div>";
                }

                $jawaban_text_html = ($key->jawaban_nm !== "" && $key->jawaban_nm !== null)
                    ? "<span class='jawaban-text' style='color:#1e293b;'>".esc($key->jawaban_nm)."</span>"
                    : "";

                $jawaban .= "
                    <div id='dv_jawaban_" . $key->jawaban_id . "' 
                        onclick='selectJawaban(" . $key->jawaban_id . ", \"" . $key->pilihan_nm . "\")' 
                        class='btn col-12 jawaban_dv " . $selectedClass . "'>
                        <strong class='pilihan-label'>" . $key->pilihan_nm . ".</strong> 
                        " . $jawaban_text_html . "
                        " . $img_jwb . "
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

        $button = "<div class='d-flex align-items-center gap-2'>";
        if ($no_soal > 1) {
            $button .= "<button type='button' onclick='startujian(\"prevsoal\")' class='btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold'><i class='fa fa-arrow-left me-1'></i> Sebelumnya</button>";
        }
        if ($no_soal < $total_soal) {
            $button .= "<button type='button' onclick='startujian(\"next\")' class='btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm'>Selanjutnya <i class='fa fa-arrow-right ms-1'></i></button>";
        }
        $button .= "</div>";

        $button .= "<div>";
        if ($show_selesai) {
            $button .= "<button type='button' onclick='konfirmasiSelesai()' class='btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm'><i class='fa fa-check-circle me-1'></i> Selesai Latihan</button>";
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
                if (empty($used)) {
                    $notes = $this->latihanmodel->getLastUsed($this->session->user_id, $jenis_id, $group_id, $materi);
                    if ($notes) {
                        $used = $notes->used;
                    } else {
                        $used = 1;
                        $dataexam = [
                            "jenis_id"  => $jenis_id,
                            "group_id"  => $group_id,
                            "materi_id" => $materi,
                            "user_id"   => $this->session->user_id,
                            "used"      => 1,
                        ];
                        $this->latihanmodel->insertexam($dataexam);
                    }
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
                    $button = "<div class='d-flex justify-content-between align-items-center w-100 flex-wrap gap-2'>";
                    $button .= "<div class='d-flex align-items-center gap-2'>";
                    if ($no_soal > 1) {
                        $button .= "<button type='button' onclick='startujian(\"prevsoal\")' class='btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold'><i class='fa fa-arrow-left me-1'></i> Sebelumnya</button>";
                    }
                    if ($no_soal < count($res_ttlsoal)) {
                        $button .= "<button type='button' onclick='startujian(\"next\")' class='btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm'>Selanjutnya <i class='fa fa-arrow-right ms-1'></i></button>";
                    }
                    $button .= "</div>";

                    $button .= "<div class='ms-auto'>";
                    if ($jumlahjawab == count($res_ttlsoal) - 1 || $jumlahjawab == count($res_ttlsoal)) {
                        $button .= "<button type='button' onclick='konfirmasiSelesai()' class='btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm'><i class='fa fa-check-circle me-1'></i> Selesai Latihan</button>";
                    }
                    $button .= "</div>";
                    $button .= "</div>";
                    
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

            $materi   = $request->getUri()->getSegment(3) ?? 99;
            $jenis_id = $request->getUri()->getSegment(4);
            $used     = $request->getUri()->getSegment(5) ?? 1;
            $group_id = $request->getUri()->getSegment(6) ?? 1;

            $jenis_nm = $this->latihanmodel->getJenisById($jenis_id);
            return view('front/pembahasan_latihan/tryout', [
                'materi'   => $materi,
                'group_id' => $group_id,
                'jenis_id' => $jenis_id,
                'used'     => $used,
                'jenis_nm' => $jenis_nm,
            ]);
        }
    }

    public function pembahasan_kecerdasan($materi = 99, $jenis_id = null, $level_id = null, $used = null)
    {
        $request = \Config\Services::request();
        if ($this->session->get("user_nm") == "") {
            return redirect('/');
        }

        $materi   = $materi   ?? $request->getUri()->getSegment(3) ?? 99;
        $jenis_id = $jenis_id ?? $request->getUri()->getSegment(4);
        $level_id = $level_id ?? $request->getUri()->getSegment(5);
        $used     = $used     ?? $request->getUri()->getSegment(6);

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
            'materi'   => $materi,
            'jenis_id' => $jenis_id,
            'level_id' => $level_id,
            'used'     => $used,
            'jenis_nm' => $jenis_nm,
            'level_nm' => $level_nm,
        ];
        return view('front/pembahasan_latihan/tryout_kecerdasan', $data);
    }

    public function startujianpembahasan_kecerdasan() {
        if ($this->session->get("user_nm") == "") {
            return $this->response->setJSON(['status' => 'unauthorized']);
        }

        $soal_id    = $this->request->getPost("soal_id");
        $jenis_id   = $this->request->getPost("jenis_id");
        $level_id   = $this->request->getPost("level_id");
        $no_soal    = (int)($this->request->getPost("no_soal") ?: 1);
        $group_id   = 2;
        $materi     = 99;
        $proc       = $this->request->getPost("proc");
        $used       = $this->request->getPost("used");

        // 1. Total soal
        $res_ttlsoal = $this->latihanmodel->getTotalSoalKecerdasan($jenis_id, $level_id)->getResult();
        $total_soal  = count($res_ttlsoal);

        // 2. Navigasi nomor soal
        if ($proc == "prevsoal") {
            $no_soal = max(1, $no_soal - 1);
        } else if ($proc == "next") {
            $no_soal = min($total_soal, $no_soal + 1);
        } else if ($proc == "jump") {
            $no_soal = max(1, min($total_soal, $no_soal));
        }

        // 3. Ambil data soal
        $res = $this->latihanmodel->getSoalKecerdasan($no_soal, $jenis_id, $level_id)->getResult();
        $soal_nm = "";
        $img_soal = "";
        $pembahasan_html = "";
        $kunci_soal = "";

        if (count($res) > 0) {
            $soal_nm    = $res[0]->soal_nm;
            $soal_id    = $res[0]->soal_id;
            $kunci_soal = trim($res[0]->kunci ?? '');

            if (!empty($res[0]->soal_img)) {
                $imgUrl = base_url()."/images/soal_latihan/jenis/".$res[0]->jenis_id."/".$res[0]->soal_img;
                $img_soal = "<div class='col-sm-10 mx-auto my-2 text-center'>
                    <a href='".$imgUrl."' data-toggle='lightbox' data-large-src='".$imgUrl."' data-fallback-src='".$imgUrl."'>
                        <img style='max-width: 350px; max-height: 100%; cursor: zoom-in; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);' src='".$imgUrl."' class='img-fluid popup-img-trigger' title='Klik untuk memperbesar gambar'>
                    </a>
                </div>";
            }

            // Render Pembahasan
            $pembahasan_body = "";
            if (!empty($res[0]->pembahasan_img)) {
                $pembahasanImgUrl = base_url() . "/images/pembahasan_latihan/2/" . $jenis_id . "/" . $res[0]->pembahasan_img;
                $pembahasan_body .= "<div class='text-center my-2'><img style='max-width: 100%; border-radius: 8px;' src='" . $pembahasanImgUrl . "' class='img-fluid'></div>";
            }
            if (!empty($res[0]->pembahasan)) {
                $pembahasan_body .= "<div class='pembahasan-text mt-2' style='line-height: 1.6; color: #1e293b;'>" . nl2br($res[0]->pembahasan) . "</div>";
            }
            if (empty($pembahasan_body)) {
                $pembahasan_body = "<p class='text-muted mb-0 fst-italic'>Tidak ada penjelasan tertulis untuk soal ini.</p>";
            }

            $pembahasan_html = "<div class='pembahasan-card mt-3 p-3 rounded-3' style='background: #f0fdf4; border: 1.5px solid #86efac;'>
                <div class='d-flex align-items-center justify-content-between mb-2'>
                    <span class='badge bg-success px-3 py-1 rounded-pill fw-bold'>
                        <i class='fas fa-key me-1'></i> Kunci Jawaban: " . esc($kunci_soal) . "
                    </span>
                </div>
                " . $pembahasan_body . "
            </div>";
        }

        // 4. Cek respon user untuk soal ini
        $user_jawaban = "";
        if (!empty($soal_id)) {
            $curRespon = $this->latihanmodel->getResponBox($soal_id, $jenis_id, $materi, $this->session->user_id, $used, $group_id)->getResult();
            if (count($curRespon) > 0) {
                $user_jawaban = trim($curRespon[0]->pilihan_nm ?? '');
            }
        }

        // 5. Render box nomor soal (5 kolom kebawah)
        $boxnomorsoal = "";
        $seq = 1;

        foreach ($res_ttlsoal as $boxsoal) {
            $getResponBox = $this->latihanmodel->getResponBox($boxsoal->soal_id, $jenis_id, $materi, $this->session->user_id, $used, $group_id)->getResult();
            $boxclick = "onclick='setboxsoal({$seq})'";
            $boxcursor = "cursor:pointer;";
            $kunciItem = trim($boxsoal->kunci ?? '');

            if (count($getResponBox) > 0) {
                $pilihan_label = " " . $getResponBox[0]->pilihan_nm;
                $userAns = trim($getResponBox[0]->pilihan_nm);

                if ($userAns == $kunciItem) {
                    $style = "border:2px solid #22c55e; height:35px; padding:2px; border-radius:6px; font-weight:700; background:#f0fdf4; color:#15803d; $boxcursor";
                } else {
                    $style = "border:2px solid #ef4444; height:35px; padding:2px; border-radius:6px; font-weight:700; background:#fef2f2; color:#b91c1c; $boxcursor";
                }

                if ($seq == $no_soal) {
                    $style = "border:2.5px solid #2563eb; height:35px; padding:2px; border-radius:6px; font-weight:800; background:#eff6ff; color:#1d4ed8; box-shadow: 0 0 0 2px rgba(37,99,235,0.3); $boxcursor";
                }
            } else {
                $pilihan_label = "";
                $style = "border:2px dashed #94a3b8; height:35px; padding:2px; border-radius:6px; font-weight:600; background:#f8fafc; color:#64748b; $boxcursor";
                if ($seq == $no_soal) {
                    $style = "border:2.5px solid #2563eb; height:35px; padding:2px; border-radius:6px; font-weight:800; background:#eff6ff; color:#1d4ed8; box-shadow: 0 0 0 2px rgba(37,99,235,0.3); $boxcursor";
                }
            }

            $boxnomorsoal .= "<div class='text-center box-no-item' style='$style font-size:12px; width:100%; display:flex; align-items:center; justify-content:center;' $boxclick>{$seq}{$pilihan_label}</div>";
            $seq++;
        }

        // 6. Render pilihan jawaban
        $jawaban = "";
        if (!empty($soal_id)) {
            $getjawaban = $this->latihanmodel->getjawaban($soal_id)->getResult();
            foreach ($getjawaban as $key) {
                $pilihan = trim($key->pilihan_nm);
                $isUserChoice = ($user_jawaban === $pilihan);
                $isKeyChoice  = ($kunci_soal === $pilihan);

                $itemClass = "jawaban_dv";
                $badgeInfo = "";

                if ($isKeyChoice && $isUserChoice) {
                    $itemClass .= " border-success bg-success bg-opacity-10 text-success fw-semibold";
                    $badgeInfo = "<span class='badge bg-success ms-auto'><i class='fas fa-check-circle me-1'></i> Jawaban Anda (Benar)</span>";
                } else if ($isKeyChoice) {
                    $itemClass .= " border-success bg-success bg-opacity-10 text-success fw-semibold";
                    $badgeInfo = "<span class='badge bg-success ms-auto'><i class='fas fa-key me-1'></i> Kunci Jawaban</span>";
                } else if ($isUserChoice) {
                    $itemClass .= " border-danger bg-danger bg-opacity-10 text-danger fw-semibold";
                    $badgeInfo = "<span class='badge bg-danger ms-auto'><i class='fas fa-times-circle me-1'></i> Jawaban Anda (Salah)</span>";
                }

                $img_jwb = "";
                if (!empty($key->jawaban_img)) {
                    $jwbUrl = base_url() . "/images/jawaban_latihan/jenis/" . $jenis_id . "/" . $key->jawaban_img . ".jpg";
                    $img_jwb = "<div class='my-1'><img style='max-width:350px;height:100%;cursor:zoom-in;border-radius:6px;' src='" . $jwbUrl . "' class='jawaban-img popup-img-trigger'></div>";
                }

                $jawaban .= "<div class='{$itemClass} p-3 rounded-3 d-flex align-items-center mb-2' style='border: 1.5px solid;'>
                    <strong class='pilihan-label me-2' style='font-size:1.05rem;'>{$key->pilihan_nm}.</strong>
                    <span class='flex-grow-1'>{$key->jawaban_nm}</span>
                    {$img_jwb}
                    {$badgeInfo}
                </div>";
            }
        }

        // 7. Tombol Aksi
        $button = "<div class='d-flex align-items-center gap-2'>";
        if ($no_soal > 1) {
            $button .= "<button type='button' onclick='setboxsoal(" . ($no_soal - 1) . ")' class='btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold'><i class='fa fa-arrow-left me-1'></i> Sebelumnya</button>";
        }
        if ($no_soal < $total_soal) {
            $button .= "<button type='button' onclick='setboxsoal(" . ($no_soal + 1) . ")' class='btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm'>Selanjutnya <i class='fa fa-arrow-right ms-1'></i></button>";
        }
        $button .= "</div>";

        $button .= "<div class='ms-auto'>";
        $button .= "<a href='" . base_url('latihan/hasillatihan_kecerdasan/' . $materi . '/' . $jenis_id . '/' . $level_id . '/' . $used) . "' class='btn btn-outline-primary rounded-pill px-4 py-2 fw-bold shadow-xs'><i class='fas fa-poll me-1'></i> Kembali ke Hasil</a>";
        $button .= "</div>";

        echo json_encode([
            "soal_id"         => $soal_id,
            "soal_nm"         => $soal_nm,
            "no_soal"         => $no_soal,
            "total_soal"      => $total_soal,
            "jenis_id"        => $jenis_id,
            "level_id"        => $level_id,
            "group_id"        => $group_id,
            "jawaban_nm"      => $jawaban,
            "boxnomorsoal"    => $boxnomorsoal,
            "button"          => $button,
            "pembahasan_html" => $pembahasan_html,
            "img_soal"        => $img_soal,
            "kunci_soal"      => $kunci_soal,
            "user_jawaban"    => $user_jawaban,
            "used"            => $used,
        ]);
    }

    
    public function startujianpembahasan() {
        if ($this->session->get("user_nm") == "") {
            return $this->response->setJSON(['status' => 'unauthorized']);
        }

        $soal_id    = $this->request->getPost("soal_id");
        $jenis_id   = $this->request->getPost("jenis_id");
        $no_soal    = (int)($this->request->getPost("no_soal") ?: 1);
        $group_id   = $this->request->getPost("group_id") ?: 1;
        $materi     = $this->request->getPost("materi") ?: 99;
        $proc       = $this->request->getPost("proc");
        $used       = $this->request->getPost("used") ?: 1;

        // 1. Total Soal
        $res_ttlsoal = $this->latihanmodel->getTotalSoalLatihan($jenis_id, $group_id)->getResult();
        $total_soal  = count($res_ttlsoal);

        // 2. Navigasi Soal
        if ($proc == "prevsoal" || $proc == "prev") {
            $no_soal = max(1, $no_soal - 1);
        } else if ($proc == "next") {
            $no_soal = min($total_soal, $no_soal + 1);
        } else if ($proc == "jump") {
            $no_soal = max(1, min($total_soal, $no_soal));
        } else {
            $no_soal = max(1, min($total_soal, $no_soal));
        }

        // 3. Ambil data soal
        $res = $this->latihanmodel->getSoal($no_soal, $jenis_id, $materi, $group_id)->getResult();
        $soal_nm = "";
        $img_soal = "";
        $kunci_soal = "";
        $pembahasan_html = "";

        if (count($res) > 0) {
            $soal_nm    = $res[0]->soal_nm;
            $soal_id    = $res[0]->soal_id;
            $jenis_id   = $res[0]->jenis_id;
            $group_id   = $res[0]->group_id;
            $kunci_soal = trim($res[0]->kunci ?? '');

            if (!empty($res[0]->soal_img)) {
                $imgUrl = base_url() . "/images/soal/materi/" . $res[0]->materi . "/" . $res[0]->soal_img;
                $imgLargeUrl = base_url() . "/images/soal/materi/" . $res[0]->materi . "/besar/" . $res[0]->soal_img;
                $img_soal = "<div class='col-sm-10 mx-auto text-center my-2'>
                    <a href='" . $imgLargeUrl . "' data-toggle='lightbox' data-large-src='" . $imgLargeUrl . "' data-fallback-src='" . $imgUrl . "'>
                        <img style='max-width: 350px; max-height: 100%; border-radius: 8px; cursor: zoom-in; box-shadow: 0 4px 12px rgba(0,0,0,0.08);' src='" . $imgUrl . "' class='img-fluid popup-img-trigger' title='Klik untuk memperbesar gambar'>
                    </a>
                </div>";
            }

            // Render Pembahasan Body
            $pembahasan_body = "";
            if (!empty($res[0]->pembahasan_img)) {
                $pembahasanImgUrl = base_url() . "/images/pembahasan_latihan/" . $group_id . "/" . $jenis_id . "/" . $res[0]->pembahasan_img;
                $pembahasan_body .= "<div class='text-center my-2'><img style='max-width: 100%; border-radius: 8px;' src='" . $pembahasanImgUrl . "' class='img-fluid popup-img-trigger'></div>";
            } else {
                $resjawaban_nm = $this->latihanmodel->getJawabannmPembahasan($res[0]->kunci, $res[0]->soal_id)->getResult();
                $kunciDesc = "";
                if (count($resjawaban_nm) > 0) {
                    $kunciDesc = esc($resjawaban_nm[0]->pilihan_nm) . ". " . esc($resjawaban_nm[0]->jawaban_nm);
                }
                $pembahasan_body .= "<div class='p-3 bg-white rounded-3 border mb-2'>
                    <div class='fw-bold text-success mb-1'><i class='fas fa-check-circle me-1'></i> " . $kunciDesc . "</div>
                    <div style='line-height: 1.6; color: #334155;'>" . nl2br($res[0]->pembahasan ?? '') . "</div>
                </div>";
            }

            $pembahasan_html = "<div id='spoiler' style='display:none; border: 2px solid #86efac; background-color: #f0fdf4; border-radius: 12px; padding: 16px; margin-top: 15px;'>
                <div class='d-flex align-items-center justify-content-between mb-2'>
                    <span class='badge bg-success px-3 py-1 rounded-pill fw-bold'>
                        <i class='fas fa-lightbulb me-1'></i> Pembahasan Soal no. " . $no_soal . "
                    </span>
                    <span class='badge bg-white text-success border border-success border-opacity-25 px-2 py-1 small rounded-pill'>
                        Kunci: " . esc($kunci_soal) . "
                    </span>
                </div>
                " . $pembahasan_body . "
            </div>";
        }

        // 4. Render Box Nomor Soal (5 Kolom) & Dapatkan User Answer untuk Soal Aktif
        $boxnomorsoal = "";
        $pilihan_nmx  = "";

        foreach ($res_ttlsoal as $boxsoal) {
            $getResponBox = $this->latihanmodel->getResponBoxPembahasan($boxsoal->soal_id, $jenis_id, $materi, $this->session->user_id, $used)->getResult();
            $boxclick  = "onclick='setboxsoal({$boxsoal->no_soal})'";
            $boxcursor = "cursor:pointer;";
            $kunciItem = trim($boxsoal->kunci ?? '');

            if (count($getResponBox) > 0) {
                $userAns       = trim($getResponBox[0]->pilihan_nm);
                $pilihan_label = " " . $userAns;
                $kunciItem     = trim($getResponBox[0]->kunci ?? $kunciItem);

                if ($userAns == $kunciItem) {
                    $style = "border:2px solid #22c55e; height:35px; padding:2px; border-radius:6px; font-weight:700; background:#f0fdf4; color:#15803d; $boxcursor";
                } else {
                    $style = "border:2px solid #ef4444; height:35px; padding:2px; border-radius:6px; font-weight:700; background:#fef2f2; color:#b91c1c; $boxcursor";
                }

                if ($boxsoal->no_soal == $no_soal) {
                    $pilihan_nmx = $userAns;
                    $style = "border:2.5px solid #2563eb; height:35px; padding:2px; border-radius:6px; font-weight:800; background:#eff6ff; color:#1d4ed8; box-shadow: 0 0 0 2px rgba(37,99,235,0.3); $boxcursor";
                }
            } else {
                $pilihan_label = "";
                $style = "border:2px dashed #94a3b8; height:35px; padding:2px; border-radius:6px; font-weight:600; background:#f8fafc; color:#64748b; $boxcursor";
                if ($boxsoal->no_soal == $no_soal) {
                    $style = "border:2.5px solid #2563eb; height:35px; padding:2px; border-radius:6px; font-weight:800; background:#eff6ff; color:#1d4ed8; box-shadow: 0 0 0 2px rgba(37,99,235,0.3); $boxcursor";
                }
            }

            $boxnomorsoal .= "<div class='text-center box-no-item' style='$style font-size:12px; width:100%; display:flex; align-items:center; justify-content:center;' $boxclick>{$boxsoal->no_soal}{$pilihan_label}</div>";
        }

        // 5. Render Pilihan Jawaban
        $jawaban = "";
        if (!empty($soal_id)) {
            $getjawaban = $this->latihanmodel->getjawaban($soal_id)->getResult();
            foreach ($getjawaban as $key) {
                $pilihan = trim($key->pilihan_nm);
                $isUserChoice = (!empty($pilihan_nmx) && $pilihan_nmx === $pilihan);
                $isKeyChoice  = (!empty($kunci_soal) && $kunci_soal === $pilihan);

                $cardClass = "jawaban_dv";
                $badgeInfo = "";
                $cardStyle = "background-color: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 12px 18px; margin-bottom: 8px; display: flex; align-items: center; flex-wrap: wrap; gap: 10px; width: 100%; transition: all 0.2s;";

                if ($isKeyChoice && $isUserChoice) {
                    $cardStyle = "background-color: #f0fdf4; border: 2px solid #22c55e; color: #15803d; border-radius: 10px; padding: 12px 18px; margin-bottom: 8px; display: flex; align-items: center; flex-wrap: wrap; gap: 10px; width: 100%;";
                    $badgeInfo = "<span class='badge bg-success ms-auto'><i class='fas fa-check-circle me-1'></i> Jawaban Anda (Benar)</span>";
                } else if ($isKeyChoice) {
                    $cardStyle = "background-color: #f0fdf4; border: 2px solid #22c55e; color: #15803d; border-radius: 10px; padding: 12px 18px; margin-bottom: 8px; display: flex; align-items: center; flex-wrap: wrap; gap: 10px; width: 100%;";
                    $badgeInfo = "<span class='badge bg-success ms-auto'><i class='fas fa-key me-1'></i> Kunci Jawaban</span>";
                } else if ($isUserChoice) {
                    $cardStyle = "background-color: #fef2f2; border: 2px solid #ef4444; color: #b91c1c; border-radius: 10px; padding: 12px 18px; margin-bottom: 8px; display: flex; align-items: center; flex-wrap: wrap; gap: 10px; width: 100%;";
                    $badgeInfo = "<span class='badge bg-danger ms-auto'><i class='fas fa-times-circle me-1'></i> Jawaban Anda (Salah)</span>";
                }

                $img_jwb = "";
                if (!empty($key->jawaban_img)) {
                    $img_jwb = "<div class='my-1'><img style='max-width:350px; height:100%; cursor:zoom-in; border-radius:6px;' src='" . base_url() . "/images/jawaban/materi/" . ($res[0]->materi ?? $materi) . "/" . $key->jawaban_img . ".jpg' class='popup-img-trigger'></div>";
                }

                $jawaban .= "<div id='dv_jawaban_" . $key->jawaban_id . "' class='{$cardClass}' style='{$cardStyle}'>
                    <strong style='font-size:1.05rem; min-width:24px;'>" . esc($key->pilihan_nm) . ".</strong>
                    <span class='flex-grow-1' style='font-size:1rem; font-weight:500;'>" . esc($key->jawaban_nm) . "</span>
                    {$img_jwb}
                    {$badgeInfo}
                </div>";
            }
        }

        // 6. Tombol Navigasi & Aksi (Neat, unstacked flex row)
        $button = "<div class='d-flex flex-wrap align-items-center justify-content-between w-100 gap-2'>";
        $button .= "<div class='d-flex align-items-center gap-2'>";
        $prevDisabled = ($no_soal <= 1) ? "disabled" : "";
        $nextDisabled = ($no_soal >= $total_soal) ? "disabled" : "";

        $button .= '<button type="button" onclick="startujian(\'prevsoal\')" class="btn btn-outline-secondary rounded-pill px-3 py-2 fw-semibold" ' . $prevDisabled . '><i class="fas fa-arrow-left me-1"></i> Sebelumnya</button>';
        $button .= '<button type="button" onclick="startujian(\'next\')" class="btn btn-primary rounded-pill px-3 py-2 fw-semibold shadow-xs" ' . $nextDisabled . '>Selanjutnya <i class="fas fa-arrow-right ms-1"></i></button>';
        $button .= "</div>";

        $button .= "<div class='d-flex align-items-center gap-2 ms-auto'>";
        $button .= '<button type="button" onclick="togglePembahasan()" class="btn btn-warning rounded-pill px-3 py-2 fw-bold text-dark shadow-xs"><i class="fas fa-lightbulb me-1 text-primary"></i> Lihat Pembahasan</button>';
        $button .= '<a href="' . base_url('latihan/hasillatihan/' . $materi . '/' . $jenis_id . '/' . $used . '/' . $group_id) . '" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold"><i class="fas fa-poll me-1"></i> Kembali ke Hasil</a>';
        $button .= "</div>";
        $button .= "</div>";

        echo json_encode([
            "soal_id"         => $soal_id,
            "soal_nm"         => $soal_nm,
            "no_soal"         => $no_soal,
            "total_soal"      => $total_soal,
            "jenis_id"        => $jenis_id,
            "group_id"        => $group_id,
            "jawaban_nm"      => $jawaban,
            "boxnomorsoal"    => $boxnomorsoal,
            "button"          => $button,
            "pembahasan_html" => $pembahasan_html,
            "img_soal"        => $img_soal,
            "user_jawaban"    => $pilihan_nmx,
            "kunci_soal"      => $kunci_soal,
            "used"            => $used,
            "proc"            => $proc
        ]);
    }
}
