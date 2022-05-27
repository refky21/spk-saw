
<html>
<head>
<title>Label</title>

<style type="text/css">
.style2 {font-size: 3px}
</style>
</head>
<body>
<style>@media print {
    footer {page-break-after: always;}
}
</style>
<?php
$BatasAwal = 20;
$jumlahData = sizeof($data);
$jumlahn = 10;
$n = ceil($jumlahData/$jumlahn);



for($i=1;$i<=$n;$i++){
$mulai = $i-1;
$batas = ($mulai*$jumlahn);
$startawal = $batas;
$batasakhir = $batas+$jumlahn;
$alatId = $data;
?>

<table width="100%" border="0" style="margin-top:8px;">
        <tr>
            <td><?php if($startawal+1<=$jumlahData){kartu($startawal+1,$alatId);} ?></td>
            <td><?php if($startawal+2<=$jumlahData){kartu($startawal+2,$alatId);} ?></td>
        </tr>
        <tr>
            <td><?php if($startawal+3<=$jumlahData){kartu($startawal+3,$alatId);} ?></td>
            <td><?php if($startawal+4<=$jumlahData){kartu($startawal+4,$alatId);} ?></td>
        </tr>
        <tr>
            <td><?php if($startawal+5<=$jumlahData){kartu($startawal+5,$alatId);} ?></td>
            <td><?php if($startawal+6<=$jumlahData){kartu($startawal+6,$alatId);} ?></td>
        </tr>
        <tr>
            <td><?php if($startawal+7<=$jumlahData){kartu($startawal+7,$alatId);} ?></td>
            <td><?php if($startawal+8<=$jumlahData){kartu($startawal+8,$alatId);} ?></td>
        </tr>
        <tr>
            <td><?php if($startawal+9<=$jumlahData){kartu($startawal+9,$alatId);} ?></td>
            <td><?php if($startawal+10<=$jumlahData){kartu($startawal+10,$alatId);} ?></td>
        </tr>        
</table>

<?php


}
?>

</body>
</html>