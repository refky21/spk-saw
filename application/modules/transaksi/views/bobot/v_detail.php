<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

    <table class="table table-striped table-bordered" cellspacing="0" id="datatables_ajax" width="100%">
        <thead >
            <tr>
            <th>Kriteria</th>
            <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data as $d) : ?>
        <tr>
            <td><?= $d['kriteria'];?></td>
            <td><?= $d['bobot'];?></td>
        </tr>
        <?php endforeach; ?>
                   
        </tbody>
    </table>
</div>
</div>
