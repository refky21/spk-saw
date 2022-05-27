<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

    <table class="table table-striped table-bordered" cellspacing="0" id="datatables_ajax" width="100%">
        <thead >
            <tr>
            <th width='1%'>No.</th>
            <th>Alat Kalibrasi</th>
            <th>Harga</th>
            <th>Jumlah Alat</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($alkes as $i => $alat):
        ?>
            <tr>
                <td><?= $i+1;?></td>
                <td><?= $alat['NamaAlkes'];?></td>
                <td>Rp. <?= format_rupiah($alat['Harga']);?></td>
                <td><?= $alat['JumlahAlat'];?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
</div>
