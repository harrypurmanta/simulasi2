<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Soalmodel;
use App\Models\Jawabanmodel;
use App\Models\Latihanmodel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Soallatihan extends BaseController
{
    protected $soalmodel;
    protected $jawabanmodel;
    protected $latihanmodel;
    protected $session;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->soalmodel = new Soalmodel();
        $this->jawabanmodel = new Jawabanmodel();
        $this->latihanmodel = new Latihanmodel();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'group' => $this->soalmodel->getGroupLatihan()->getResult()
            ];
            return view('admin/soallatihan/soal',$data);
        }
        
    }

    public function setSessionJenis()
    {
        $group_id = $this->request->getPost('group_id');
        $this->session->set('group_id', $group_id);

        $jenis_id = $this->request->getPost('jenis_id');
        $this->session->set('jenis_id', $jenis_id);

        $level_id = $this->request->getPost('level_id');
        if ($level_id !== null) {
            $this->session->set('level_id', $level_id);
        }

        echo json_encode(['group_id' => $group_id, 'jenis_id' => $jenis_id, 'level_id' => $level_id]);
    }

    public function setSessionLevel()
    {
        $level_id = $this->request->getPost('level_id');
        $this->session->set('level_id', $level_id);
        echo json_encode(['level_id' => $level_id]);
    }

    public function getJenis() {
        $group_id = $this->request->getPost('group_id');
        $this->session->set('group_id', $group_id);
        $res = $this->latihanmodel->getJenisByGroupId($group_id)->getResult();
        echo json_encode($res);
    }

    public function getLevel() {
        $jenis_id = $this->request->getPost('jenis_id');
        $res = $this->latihanmodel->getLevelByJenisId($jenis_id)->getResult();
        echo json_encode($res);
    }

    public function viewTambahsoal() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            if ($this->session->jenis_id == "" || $this->session->jenis_id == null ) {
                $jenis_id = 1;
            } else {
                $jenis_id = $this->session->jenis_id;
            }
    
            if ($this->session->group_id == "" || $this->session->group_id == null ) {
                $group_id = 1;
            } else {
                $group_id = $this->session->group_id;
            }

            $level = [];
            $level_id = $this->session->level_id;
            if ($group_id == 2) {
                $level = $this->latihanmodel->getLevelByJenisId($jenis_id)->getResult();
                if (empty($level_id) && count($level) > 0) {
                    $level_id = $level[0]->level_id;
                }
            }

            $data = [
                'no_soal' => $this->latihanmodel->getNoSoal($jenis_id, $group_id, $level_id)->getResult(),
                'jenis_soal' => $this->latihanmodel->getJenisByGroupId($group_id)->getResult(),
                'group' => $this->soalmodel->getGroupLatihan()->getResult(),
                'level' => $level,
                'level_id' => $level_id,
                'soal' => $this->showsoal()
            ];
            return view('admin/soallatihan/tambahsoal',$data);
        }
    }

    public function viewEditsoal() {
        $soal_id = $this->request->getUri()->getSegment(4);
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $soal = $this->latihanmodel->getSoalByid($soal_id)->getResult();
            
            if ($this->session->jenis_id == "") {
                $jenis_id = 1;
            } else {
                $jenis_id = $this->session->jenis_id;
            }
    
            if ($this->session->group_id == "") {
                $group_id = 1;
            } else {
                $group_id = $this->session->group_id;
            }

            $cur_group_id = count($soal) > 0 ? $soal[0]->group_id : $group_id;
            $cur_jenis_id = count($soal) > 0 ? $soal[0]->jenis_id : $jenis_id;
            $cur_level_id = count($soal) > 0 ? $soal[0]->level_id : null;

            $level = [];
            if ($cur_group_id == 2) {
                $level = $this->latihanmodel->getLevelByJenisId($cur_jenis_id)->getResult();
            }

            $data = [
                'no_soal' => $this->latihanmodel->getNoSoal($cur_jenis_id, $cur_group_id, $cur_level_id)->getResult(),
                'jenis_soal' => $this->latihanmodel->getJenisByGroupId($cur_group_id)->getResult(),
                'group' => $this->soalmodel->getGroupLatihan()->getResult(),
                'level' => $level,
                'level_id' => $cur_level_id,
                'soal' => $soal,
                'jawaban' => $this->latihanmodel->getJawabanBySoalId($soal_id)->getResult(),
                'soal_id' => $soal_id
            ];
            return view('admin/soallatihan/editsoal',$data);
        }
    }

    public function getNoSoal() {
        $group_id       = $this->request->getPost('group_id');
        $jenis_id      = $this->request->getPost('jenis_id');
        $level_id      = $this->request->getPost('level_id');
        $no_soal = 1;
        if (isset($group_id) && isset($jenis_id)) {
            $res_soal = $this->latihanmodel->getNoSoal($jenis_id, $group_id, $level_id)->getResult();
            if ($res_soal[0]->no_soal == null) {
                $no_soal = 1;
            } else {
                $no_soal = $res_soal[0]->no_soal + 1;
            }
        } 
        echo json_encode($no_soal);
    }

    public function showsoal() {
        $group_id   = $this->request->getPost('group_id');
        $jenis_id   = $this->request->getPost('jenis_id');
        $level_id   = $this->request->getPost('level_id');
        $res        = $this->latihanmodel->getSoalBygrJns($group_id, $jenis_id, $level_id)->getResult();
        echo json_encode($res);
    }

    public function hapusgambar() {
        $jawaban_id = $this->request->getPost('jawaban_id');
        $jawaban = $this->latihanmodel->getJawabanById($jawaban_id)->getResult();
        $data = [
            "jawaban_img" => NULL
        ];

        $update = $this->latihanmodel->hapusgambar($jawaban_id);
        if ($update) {
            unlink("../public/images/jawaban_latihan/jenis/".$jawaban[0]->jenis_id."/".$jawaban[0]->jawaban_img);
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function hapusgambarsoal() {
        $soal_id = $this->request->getPost('soal_id');
        $soal = $this->latihanmodel->getSoalByid($soal_id)->getResult();
        $data = [
            "soal_img" => NULL
        ];

        $update = $this->latihanmodel->hapusgambarsoal($soal_id);

        if ($update) {
            unlink("../public/images/soal_latihan/jenis/".$soal[0]->jenis_id."/".$soal[0]->soal_img);
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function hapusgambarpembsoal() {
        $soal_id = $this->request->getPost('soal_id');
        $data = [
            "pembahasan_img" => NULL
        ];
        $update = $this->soalmodel->hapusgambarpembsoal($soal_id);
        if ($update) {
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function simpansoal() {
        $soal_nm = $this->request->getPost('soal_nm');
        $jenis_id = $this->request->getPost('jenis_id');
        $kunci = $this->request->getPost('kunci');
        $group_id = $this->request->getPost('group_id');
        $no_soal = $this->request->getPost('no_soal');
        $pembahasan_nm = $this->request->getPost('pembahasan_nm');
        $level_id = $this->request->getPost('level_id');
        if ($group_id != 2 || empty($level_id)) {
            $level_id = null;
        }

        $jawaban_nm_A = $this->request->getPost('jawaban_nm_A');
        $jawaban_nm_B = $this->request->getPost('jawaban_nm_B');
        $jawaban_nm_C = $this->request->getPost('jawaban_nm_C');
        $jawaban_nm_D = $this->request->getPost('jawaban_nm_D');
        $jawaban_nm_E = $this->request->getPost('jawaban_nm_E');

        $this->session->set("group_id",$group_id);
        $this->session->set("jenis_id",$jenis_id);
        if ($level_id !== null) {
            $this->session->set("level_id", $level_id);
        }
        $imagefile = $this->request->getFiles();

        $newName = "";
        $pembahasan_img = "";
        if (isset($imagefile['soal_img'])) {
            foreach($imagefile['soal_img'] as $img){
               if ($img->isValid() && ! $img->hasMoved()){
                    $newName = $img->getClientName();
                    $img->move("../public/images/soal_latihan/jenis/$jenis_id", $newName);
                    copy("../public/images/soal_latihan/jenis/$jenis_id/$newName","../public/images/soal_latihan/jenis/$jenis_id/besar/$newName");
                   }
             }
        }

        if (isset($imagefile['pembahasan_img'])) {
             foreach($imagefile['pembahasan_img'] as $imgs){
                if ($imgs->isValid() && ! $imgs->hasMoved()){
                     $pembahasan_img = $imgs->getClientName();
                     $targetPath = "../public/images/pembahasan_latihan/$group_id/$jenis_id";

                    // cek jika folder belum ada, buat otomatis
                    if (!is_dir($targetPath)) {
                        mkdir($targetPath, 0777, true); // recursive = true supaya bisa buat berlapis
                    }
                    
                     $imgs->move("../public/images/pembahasan_latihan/$group_id/$jenis_id", $pembahasan_img);
                     //  $imgs->move("../public/images/pembahasan/materi/$materi_id/besar/level/$level_nm", $pembahasan_img);
                    }
              }
        }

        if (isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'materi' => 99,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'group_id' => $group_id,
                'level_id' => $level_id,
                'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'materi' => 99,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'group_id' => $group_id,
                'level_id' => $level_id,
                // 'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'materi' => 99,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'group_id' => $group_id,
                'level_id' => $level_id,
                'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'materi' => 99,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'group_id' => $group_id,
                'level_id' => $level_id,
                // 'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        }

      
        $soal_id = $this->latihanmodel->simpansoallatihan($data);
        if ($soal_id) {
            if (isset($imagefile['jawaban_img_A'])) {
                $imgA = $imagefile['jawaban_img_A'][0];
                if ($imgA->isValid() && ! $imgA->hasMoved()){
                     $jawaban_img_A = $imgA->getClientName();
                     $imgA->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_A);
                 }
                 $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'jawaban_img' => $jawaban_img_A,
                    'status_cd' => 'normal'
                ];
            } else {
                $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'status_cd' => 'normal'
                ];
            }
            $simpanA = $this->latihanmodel->simpanjawaban($dataA);

            if ($simpanA) {
                if (isset($imagefile['jawaban_img_B'])) {
                    $imgB = $imagefile['jawaban_img_B'][0];
                    if ($imgB->isValid() && ! $imgB->hasMoved()){
                         $jawaban_img_B = $imgB->getClientName();
                         $imgB->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_B);
                     }
                     $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'jawaban_img' => $jawaban_img_B,
                        'status_cd' => 'normal'
                    ];
                } else {
                    $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'status_cd' => 'normal'
                    ];
                }
                
                $simpanB = $this->latihanmodel->simpanjawaban($dataB);
                if ($simpanB) {
                    if (isset($imagefile['jawaban_img_C'])) {
                        $imgC = $imagefile['jawaban_img_C'][0];
                        if ($imgC->isValid() && ! $imgC->hasMoved()){
                             $jawaban_img_C = $imgC->getClientName();
                             $imgC->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_C);
                         }
                         $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'jawaban_img' => $jawaban_img_C,
                            'status_cd' => 'normal'
                        ];
                    } else {
                        $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'status_cd' => 'normal'
                        ];
                    }

                    $simpanC = $this->latihanmodel->simpanjawaban($dataC);
                    if ($simpanC) {
                        if (isset($imagefile['jawaban_img_D'])) {
                            $imgD = $imagefile['jawaban_img_D'][0];
                            if ($imgD->isValid() && ! $imgD->hasMoved()){
                                 $jawaban_img_D = $imgD->getClientName();
                                 $imgD->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_D);
                             }
                             $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'jawaban_img' => $jawaban_img_D,
                                'status_cd' => 'normal'
                            ];
                        } else {
                            $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'status_cd' => 'normal'
                            ];
                        }
                        
                        

                        $simpanD = $this->latihanmodel->simpanjawaban($dataD);
                        if ($simpanD) {
                            if (isset($imagefile['jawaban_img_E'])) {
                                $imgE = $imagefile['jawaban_img_E'][0];
                                if ($imgE->isValid() && ! $imgE->hasMoved()){
                                     $jawaban_img_E = $imgE->getClientName();
                                     $imgE->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_E);
                                 }
                                 $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'jawaban_img' => $jawaban_img_E,
                                    'status_cd' => 'normal'
                                ];
                                $simpanE = $this->latihanmodel->simpanjawaban($dataE);
                                if ($simpanE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else if ($jawaban_nm_E != "") {
                                $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'status_cd' => 'normal'
                                ];
                                $simpanE = $this->latihanmodel->simpanjawaban($dataE);
                                if ($simpanE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else {
                                $ret = "berhasil";
                            }

                        } else {
                            $ret = "gagalD";
                        }
                        
                    } else {
                        $ret = "gagaC";
                    }
                    
                } else {
                    $ret = "gagalB";
                }
                
            } else {
                $ret = "gagalA";
            }

        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
        // echo json_encode($group[0]->group_nm);
    }

    public function updatesoal() {
        $soal_id = $this->request->getPost('soal_id');
        $soal_nm = $this->request->getPost('soal_nm');
        $jenis_id = $this->request->getPost('jenis_id');
        $kunci = $this->request->getPost('kunci');
        $group_id = $this->request->getPost('group_id');
        $no_soal = $this->request->getPost('no_soal');
        $pembahasan_nm = $this->request->getPost('pembahasan_nm');
        $level_id = $this->request->getPost('level_id');
        if ($group_id != 2 || empty($level_id)) {
            $level_id = null;
        }
        $imagefile = $this->request->getFiles();

        $this->session->set("group_id",$group_id);
        $this->session->set("jenis_id",$jenis_id);
        if ($level_id !== null) {
            $this->session->set("level_id", $level_id);
        }

        $jawaban_id_A = $this->request->getPost('jawaban_id_A');
        $jawaban_id_B = $this->request->getPost('jawaban_id_B');
        $jawaban_id_C = $this->request->getPost('jawaban_id_C');
        $jawaban_id_D = $this->request->getPost('jawaban_id_D');
        $jawaban_id_E = $this->request->getPost('jawaban_id_E');

        $jawaban_nm_A = $this->request->getPost('jawaban_nm_A');
        $jawaban_nm_B = $this->request->getPost('jawaban_nm_B');
        $jawaban_nm_C = $this->request->getPost('jawaban_nm_C');
        $jawaban_nm_D = $this->request->getPost('jawaban_nm_D');
        $jawaban_nm_E = $this->request->getPost('jawaban_nm_E');

        $newName = "";
        if (isset($imagefile['soal_img'])) {
            foreach($imagefile['soal_img'] as $img){
               if ($img->isValid() && ! $img->hasMoved()){
                    $newName = $img->getClientName();
                    $img->move("../public/images/soal_latihan/jenis/$jenis_id", $newName);
                   }
             }
        }

        if (isset($imagefile['pembahasan_img'])) {
             foreach($imagefile['pembahasan_img'] as $imgs){
                if ($imgs->isValid() && ! $imgs->hasMoved()){
                     $pembahasan_img = $imgs->getClientName();
                     $imgs->move("../public/images/pembahasan_latihan/$group_id/$jenis_id", $pembahasan_img);
                    }
              }
        }

        if (isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'level_id' => $level_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'level_id' => $level_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                // 'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'level_id' => $level_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'level_id' => $level_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                // 'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        }
        
        $update = $this->latihanmodel->updatesoal($soal_id,$data);
        
        if ($update) {
            if (isset($imagefile['jawaban_img_A'])) {
                $imgA = $imagefile['jawaban_img_A'][0];
                if ($imgA->isValid() && ! $imgA->hasMoved()){
                     $jawaban_img_A = $imgA->getRandomName();
                     $imgA->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_A);
                 }
                 $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'jawaban_img' => $jawaban_img_A,
                    'status_cd' => 'normal'
                ];
            } else {
                $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'status_cd' => 'normal'
                ];
            }
            
            $updateA = $this->latihanmodel->updatejawaban($jawaban_id_A, $dataA);
            
            if ($updateA) {
                if (isset($imagefile['jawaban_img_B'])) {
                    $imgB = $imagefile['jawaban_img_B'][0];
                    if ($imgB->isValid() && ! $imgB->hasMoved()){
                         $jawaban_img_B = $imgB->getRandomName();
                         $imgB->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_B);
                     }
                     $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'jawaban_img' => $jawaban_img_B,
                        'status_cd' => 'normal'
                    ];
                } else {
                    $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'status_cd' => 'normal'
                    ];
                }
                
                $updateB = $this->latihanmodel->updatejawaban($jawaban_id_B,$dataB);
                if ($updateB) {
                    if (isset($imagefile['jawaban_img_C'])) {
                        $imgC = $imagefile['jawaban_img_C'][0];
                        if ($imgC->isValid() && ! $imgC->hasMoved()){
                             $jawaban_img_C = $imgC->getRandomName();
                             $imgC->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_C);
                         }
                         $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'jawaban_img' => $jawaban_img_C,
                            'status_cd' => 'normal'
                        ];
                    } else {
                        $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'status_cd' => 'normal'
                        ];
                    }
                    
                    $updateC = $this->latihanmodel->updatejawaban($jawaban_id_C,$dataC);
                    if ($updateC) {
                        if (isset($imagefile['jawaban_img_D'])) {
                            $imgD = $imagefile['jawaban_img_D'][0];
                            if ($imgD->isValid() && ! $imgD->hasMoved()){
                                 $jawaban_img_D = $imgD->getRandomName();
                                 $imgD->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_D);
                             }
                             $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'jawaban_img' => $jawaban_img_D,
                                'status_cd' => 'normal'
                            ];
                        } else {
                            $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'status_cd' => 'normal'
                            ];
                        }
                        
                        $updateD = $this->latihanmodel->updatejawaban($jawaban_id_D,$dataD);
                        if ($updateD) {
                            if (isset($imagefile['jawaban_img_E'])) {
                                $imgE = $imagefile['jawaban_img_E'][0];
                                if ($imgE->isValid() && ! $imgE->hasMoved()){
                                     $jawaban_img_E = $imgE->getRandomName();
                                     $imgE->move("../public/images/jawaban_latihan/jenis/$jenis_id", $jawaban_img_E);
                                 }
                                 $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'jawaban_img' => $jawaban_img_E,
                                    'status_cd' => 'normal'
                                ];
                                $updateE = $this->latihanmodel->updatejawaban($jawaban_id_E, $dataE);
                                if ($updateE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else if ($jawaban_nm_E != "") {
                                $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'status_cd' => 'normal'
                                ];
                                $updateE = $this->latihanmodel->updatejawaban($jawaban_id_E, $dataE);

                                if ($updateE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else {
                                $ret = "berhasil";
                            }
                        } else {
                            $ret = "gagalD";
                        }
                        
                    } else {
                        $ret = "gagaC";
                    }
                    
                } else {
                    $ret = "gagalB";
                }
                
            } else {
                $ret = "gagalA";
            }
        } else {
            $ret = "gagal";
        }
        
        echo json_encode($ret);
    }

    public function hapussoal() {
        $soal_id = $this->request->getPost('soal_id');
        
        $data = [
            'status_cd' => 'nullified'
        ];
        $this->latihanmodel->hapussoal($soal_id, $data);
        // echo json_encode(array("soal_id"=>$soal_id,"group_nm"=>$group[0]->group_nm));
        echo json_encode("sukses");
    }

    public function updatestatus() {
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $kolom_id = $this->request->getPost('kolom_id');
        $status_cd = $this->request->getPost('status_cd');
        $old_status = $this->request->getPost('old_status');

        $update = $this->latihanmodel->updatestatus($jawaban_nm,$kolom_id,$status_cd,$old_status);
        log_message("debug",$status_cd);
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Import Soal');

        // Headers
        $headers = [
            'A1' => 'No Soal',
            'B1' => 'Soal',
            'C1' => 'Pilihan A',
            'D1' => 'Pilihan B',
            'E1' => 'Pilihan C',
            'F1' => 'Pilihan D',
            'G1' => 'Pilihan E',
            'H1' => 'Kunci',
            'I1' => 'Pembahasan',
            'J1' => 'Level (Khusus Kecerdasan)'
        ];

        foreach ($headers as $cell => $val) {
            $sheet->setCellValue($cell, $val);
        }

        // Style header row
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1B3A57'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Sample data
        $samples = [
            [
                'no' => 1,
                'soal' => 'Apa fungsi utama dari protokol HTTP pada jaringan internet?',
                'a' => 'Mentransfer halaman web dari server ke browser',
                'b' => 'Mengirim pesan email antar server',
                'c' => 'Mengamankan koneksi remote terminal',
                'd' => 'Mengonversi nama domain menjadi alamat IP',
                'e' => 'Mengatur alamat fisik kartu jaringan',
                'kunci' => 'A',
                'pembahasan' => 'HTTP (Hypertext Transfer Protocol) adalah protokol untuk mentransfer dokumen web.',
                'level' => '1'
            ],
            [
                'no' => 2,
                'soal' => 'Perangkat jaringan yang berfungsi menghubungkan dua jaringan yang berbeda segmen disebut...',
                'a' => 'Switch',
                'b' => 'Hub',
                'c' => 'Router',
                'd' => 'Repeater',
                'e' => 'Bridge',
                'kunci' => 'C',
                'pembahasan' => 'Router menghubungkan beberapa jaringan yang memiliki segmen/subnet berbeda.',
                'level' => '1'
            ],
            [
                'no' => 1,
                'soal' => 'Contoh soal level 2: Manakah yang merupakan kepanjangan dari CPU?',
                'a' => 'Central Processing Unit',
                'b' => 'Computer Personal Unit',
                'c' => 'Control Program Unit',
                'd' => 'Core Processing Utility',
                'e' => 'Central Power Unit',
                'kunci' => 'A',
                'pembahasan' => 'CPU adalah singkatan dari Central Processing Unit.',
                'level' => '2'
            ]
        ];

        $rowIdx = 2;
        foreach ($samples as $sample) {
            $sheet->setCellValue('A' . $rowIdx, $sample['no']);
            $sheet->setCellValue('B' . $rowIdx, $sample['soal']);
            $sheet->setCellValue('C' . $rowIdx, $sample['a']);
            $sheet->setCellValue('D' . $rowIdx, $sample['b']);
            $sheet->setCellValue('E' . $rowIdx, $sample['c']);
            $sheet->setCellValue('F' . $rowIdx, $sample['d']);
            $sheet->setCellValue('G' . $rowIdx, $sample['e']);
            $sheet->setCellValue('H' . $rowIdx, $sample['kunci']);
            $sheet->setCellValue('I' . $rowIdx, $sample['pembahasan']);
            $sheet->setCellValue('J' . $rowIdx, $sample['level']);

            $sheet->getStyle("A{$rowIdx}:J{$rowIdx}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("A{$rowIdx}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("H{$rowIdx}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("J{$rowIdx}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $rowIdx++;
        }

        // Instructions note
        $noteStart = $rowIdx + 2;
        $sheet->setCellValue("A{$noteStart}", 'PETUNJUK PENGISIAN TEMPLATE IMPORT SOAL:');
        $sheet->getStyle("A{$noteStart}")->getFont()->setBold(true)->getColor()->setRGB('D9534F');

        $notes = [
            '1. Kolom "No Soal" opsional. Jika dikosongkan, nomor soal otomatis dibuat berurutan oleh sistem.',
            '2. Kolom "Soal" dan pilihan A s.d. D wajib diisi. Pilihan E opsional (boleh dikosongkan).',
            '3. Kolom "Kunci" wajib diisi salah satu huruf kapital: A, B, C, D, atau E.',
            '4. Kolom "Pembahasan" bersifat opsional untuk menjelaskan jawaban.',
            '5. Kolom "Level (Khusus Kecerdasan)": Isi angka 1 - 10 (contoh: 1, 2) atau teks seperti "Level 1".',
            '   Jika Anda memilih level tertentu pada form modal import, sistem akan memprioritaskan pilihan tersebut atau menggunakan nilai di kolom ini.',
            '   Untuk group selain Kecerdasan (misal Passhand / Kepribadian), kolom Level boleh dikosongkan.',
            '6. Simpan file dengan format .xlsx atau .xls, kemudian upload melalui modal Import Soal.'
        ];

        foreach ($notes as $idx => $note) {
            $currRow = $noteStart + 1 + $idx;
            $sheet->setCellValue("A{$currRow}", $note);
            $sheet->getStyle("A{$currRow}")->getFont()->setItalic(true)->setSize(9);
        }

        // Auto width
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(45);
        $sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(35);

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_import_soal_latihan.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function importsoal()
    {
        if ($this->session->get("user_nm") == "") {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Sesi login telah berakhir! Silakan login kembali.']);
        }

        $group_id = $this->request->getPost('group_id');
        $jenis_id = $this->request->getPost('jenis_id');
        $default_level_id = $this->request->getPost('level_id');
        $mode = $this->request->getPost('mode'); // 'append' or 'replace'

        if (empty($group_id) || empty($jenis_id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Group Soal dan Jenis Soal wajib dipilih!']);
        }

        $file = $this->request->getFile('file_excel');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File Excel tidak valid atau belum diunggah!']);
        }

        $ext = strtolower($file->getClientExtension());
        if (!in_array($ext, ['xlsx', 'xls', 'csv'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Format file tidak didukung! Harap unggah file .xlsx, .xls, atau .csv']);
        }

        try {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal membaca isi file: ' . $e->getMessage()]);
        }

        // Cache level_soal for Kecerdasan (group_id = 2)
        $levelMap = [];
        $levels = [];
        if ($group_id == 2) {
            $levels = $this->latihanmodel->getLevelByJenisId($jenis_id)->getResult();
            foreach ($levels as $lvl) {
                // map by level_id
                $levelMap[(int)$lvl->level_id] = $lvl->level_id;
                // map by lowercase level_nm
                $cleanNm = strtolower(trim($lvl->level_nm));
                $levelMap[$cleanNm] = $lvl->level_id;
                // map by digit only e.g. "1" => level_id
                preg_match('/\d+/', $cleanNm, $m);
                if (!empty($m[0])) {
                    $levelMap[(int)$m[0]] = $lvl->level_id;
                }
            }
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // If mode == 'replace', delete existing questions for this group + jenis (+ level if selected)
        if ($mode == 'replace') {
            $builder = $db->table('soal_latihan')->where('group_id', $group_id)->where('jenis_id', $jenis_id);
            if ($group_id == 2 && !empty($default_level_id) && is_numeric($default_level_id)) {
                $builder->where('level_id', $default_level_id);
            }
            $existing = $builder->get()->getResult();
            foreach ($existing as $ex) {
                $db->table('jawaban_latihan')->where('soal_id', $ex->soal_id)->delete();
            }
            $builderDelete = $db->table('soal_latihan')->where('group_id', $group_id)->where('jenis_id', $jenis_id);
            if ($group_id == 2 && !empty($default_level_id) && is_numeric($default_level_id)) {
                $builderDelete->where('level_id', $default_level_id);
            }
            $builderDelete->delete();
        }

        $importCount = 0;
        $maxNoSoalTracker = [];

        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex == 1) continue; // Skip header

            $soal_nm = trim($row['B'] ?? '');
            if (empty($soal_nm)) {
                continue; // Skip empty row
            }

            // If row contains instructions header, stop
            if (stripos($soal_nm, 'PETUNJUK') !== false || stripos($soal_nm, 'CATATAN') !== false) {
                continue;
            }

            $pilihanA = trim($row['C'] ?? '');
            $pilihanB = trim($row['D'] ?? '');
            $pilihanC = trim($row['E'] ?? '');
            $pilihanD = trim($row['F'] ?? '');
            $pilihanE = trim($row['G'] ?? '');
            $kunci = strtoupper(trim($row['H'] ?? 'A'));
            $pembahasan = trim($row['I'] ?? '');
            $rawLevel = trim($row['J'] ?? '');

            // Resolve level_id for Kecerdasan
            $target_level_id = null;
            if ($group_id == 2) {
                if (!empty($default_level_id) && is_numeric($default_level_id)) {
                    $target_level_id = $default_level_id;
                } else if (!empty($rawLevel)) {
                    $cleanRaw = strtolower($rawLevel);
                    preg_match('/\d+/', $cleanRaw, $digitMatch);
                    $digit = !empty($digitMatch[0]) ? (int)$digitMatch[0] : null;

                    if (isset($levelMap[$cleanRaw])) {
                        $target_level_id = $levelMap[$cleanRaw];
                    } else if ($digit !== null && isset($levelMap[$digit])) {
                        $target_level_id = $levelMap[$digit];
                    } else if (!empty($levels)) {
                        $target_level_id = $levels[0]->level_id;
                    }
                } else if (!empty($levels)) {
                    $target_level_id = $levels[0]->level_id;
                }
            }

            // Determine no_soal
            $trackerKey = ($group_id == 2) ? (string)$target_level_id : 'all';
            if (!isset($maxNoSoalTracker[$trackerKey])) {
                $cur_max = $this->latihanmodel->getNoSoal($jenis_id, $group_id, $target_level_id)->getRow();
                $maxNoSoalTracker[$trackerKey] = ($cur_max && $cur_max->no_soal) ? (int)$cur_max->no_soal : 0;
            }

            $rowNo = trim($row['A'] ?? '');
            if (!empty($rowNo) && is_numeric($rowNo) && $mode != 'replace') {
                $no_soal = (int)$rowNo;
                if ($no_soal > $maxNoSoalTracker[$trackerKey]) {
                    $maxNoSoalTracker[$trackerKey] = $no_soal;
                }
            } else {
                $maxNoSoalTracker[$trackerKey]++;
                $no_soal = $maxNoSoalTracker[$trackerKey];
            }

            // Validate key
            if (!in_array($kunci, ['A', 'B', 'C', 'D', 'E'])) {
                $kunci = 'A';
            }

            $dataSoal = [
                'soal_nm' => $soal_nm,
                'materi' => 99,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'jenis_id' => $jenis_id,
                'group_id' => $group_id,
                'level_id' => $target_level_id,
                'pembahasan' => $pembahasan,
                'status_cd' => 'normal'
            ];

            $soal_id = $this->latihanmodel->simpansoallatihan($dataSoal);
            if ($soal_id) {
                $pilihanList = [
                    'A' => $pilihanA,
                    'B' => $pilihanB,
                    'C' => $pilihanC,
                    'D' => $pilihanD,
                    'E' => $pilihanE,
                ];

                foreach ($pilihanList as $pilNm => $pilVal) {
                    if ($pilNm == 'E' && $pilVal === '') {
                        continue;
                    }
                    $this->latihanmodel->simpanjawaban([
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $pilVal,
                        'pilihan_nm' => $pilNm,
                        'status_cd' => 'normal'
                    ]);
                }
                $importCount++;
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kendala saat menyimpan data ke database. Silakan periksa kembali file Anda.'
            ]);
        }

        if ($importCount === 0) {
            return $this->response->setJSON([
                'status' => 'warning',
                'message' => 'Tidak ada soal yang berhasil diimpor. Pastikan format kolom file Excel sudah sesuai dengan template.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => "Alhamdulillah! Berhasil mengimpor {$importCount} soal ke dalam sistem.",
            'total' => $importCount
        ]);
    }

}