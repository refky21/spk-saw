<h3>Matriks Keputusan</h3>
<table class="table table-striped table-bordered" width="100%">
<thead>
            <tr>
                <th rowspan="2" class="text-center">Alternative</th>
                <th colspan="<?php echo $totalKriteria ?>" class="text-center">Kriteria</th>
            </tr>
            <tr>
                <?php
                foreach ($getKriteria as $key) {
                    ?>
                 <th  class="text-center"><?= $key['nama'];?></th>
                <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($getAlternatif as $key) {
             echo "<tr id='data'>";
                echo "<td>".$key['nama']."</td>";
                $no=0;
                foreach (getNilaiMatriks($key['id_pem'], $key['id']) as $data) {
                    echo "<td class='text-center'>$data[nilai]</td>";
                }
                echo "</tr>";
            }
        ?>
        </tbody>
</table>

<hr>
<h3>Normalisasi Matriks Keputusan</h3>
<table class="table table-striped table-bordered" width="100%">
<thead>
            <tr>
                <th rowspan="2" class="text-center">Alternative</th>
                <th colspan="<?php echo $totalKriteria ?>" class="text-center">Kriteria</th>
            </tr>
            <tr>
                <?php
                foreach ($getKriteria as $key) {
                    ?>
                 <th  class="text-center"><?= $key['nama'];?></th>
                <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            //foreach data supplier
            foreach ($getAlternatif as $key) {
             echo "<tr id='data'>";
                echo "<td>".$key['nama']."</td>";
                $no=0;
                //foreach nilai supplier
                foreach (getNilaiMatriks($key['id_pem'], $key['id']) as $data) {
                    //menghitung normalisasi
                    $hasil=normalisasi(getArrayNilai($data['id_kriteria'], $key['id_pem']),$data['sifat'],$data['nilai']);
                    echo "<td>$hasil</td>";
                    $hitungbobot[$key['id']][$no]=$hasil*getBobot($key['id_pem'],$data['id_kriteria']);
                    // $inBobot= getBobot($key['id_pem'],$data['id_kriteria']);
                    // $hitungbobot=getBobot($key['id_pem'],$data['id_kriteria']);
                    
                    $no++;
                }
                echo "</tr>";
            }
            ?>
        </tbody>

</table>
<hr>
<h3>Perangkingan</h3>
<table class="table table-striped table-bordered" width="100%">
<thead>
            <tr>
                <th rowspan="2" class="text-center">Alternative</th>
                <th colspan="<?php echo $totalKriteria ?>" class="text-center">Kriteria</th>
                <th rowspan="2">Hasil</th>
            </tr>
            <tr>
                <?php
                foreach ($getKriteria as $key) {
                    ?>
                 <th  class="text-center"><?= $key['nama'];?></th>
                <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
        // echo "<pre>";
        // print_r($hitungbobot);
        // echo "</pre>";
            //foreach data supplier
            foreach ($getAlternatif as $key) {
             echo "<tr id='data'>";
                echo "<td>".$key['nama']."</td>";
                $no=0;
                $hasil = 0;
                //foreach nilai supplier
                foreach ($hitungbobot[$key['id']] as $data) {
                    echo "<td>$data</td>";
                    //menjumlahkan
                    $hasil+=$data;
                }
                simpanHasil($key['id'],$hasil,$key['id_pem']);
                echo "<td>".$hasil."</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
</table>

<hr>
<?= $getHasil;?>