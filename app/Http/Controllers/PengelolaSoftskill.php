<?php

namespace App\Http\Controllers;

use App\Models\Kemahasiswaan;

class PengelolaSoftskill extends Controller
{
    protected $kemahasiswaan;

    public function __construct(Kemahasiswaan $kemahasiswaan)
    {
        $this->kemahasiswaan = $kemahasiswaan;
    }

    public function index()
    {
        $organisasi = $this->kemahasiswaan->dapatkanOrganisasi();
        $kepanitiaan = $this->kemahasiswaan->dapatkanKepanitiaan();
        $lomba = $this->kemahasiswaan->dapatkanLomba();

        $dataMahasiswa = $this->kemahasiswaan->dapatkanData();
        $softskills = [];

        if (!empty($dataMahasiswa['Organization'])) {
            foreach ($dataMahasiswa['Organization'] as $orgUser) {
                foreach ($organisasi as $orgFirebase) {
                    if (
                        strtolower(trim($orgUser['title'])) ===
                        strtolower(trim($orgFirebase['nama']))
                    ) {
                        foreach ($orgFirebase['softskill'] as $skill) {
                            $softskills[$skill][] = $orgFirebase['nama'];
                        }
                    }
                }
            }
        }

        if (!empty($dataMahasiswa['Volunteer'])) {
            foreach ($dataMahasiswa['Volunteer'] as $volUser) {
                foreach ($kepanitiaan as $volFirebase) {
                    if (
                        strtolower(trim($volUser['name'])) ===
                        strtolower(trim($volFirebase['nama']))
                    ) {
                        foreach ($volFirebase['softskill'] as $skill) {
                            $softskills[$skill][] = $volFirebase['nama'];
                        }
                    }
                }
            }
        }

        foreach ($softskills as $skill => $sumber) {
            $softskills[$skill] = array_unique($sumber);
        }

        return view('softskill', [
            'randomOrganisasi' => $this->kemahasiswaan->dapatkanAcak($organisasi),
            'randomKepanitiaan' => $this->kemahasiswaan->dapatkanAcak($kepanitiaan),
            'randomLomba' => $this->kemahasiswaan->dapatkanAcak($lomba),
            'softskills' => $softskills
        ]);
    }

}
