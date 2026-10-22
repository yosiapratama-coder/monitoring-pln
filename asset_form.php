<?php
require_once "config/database.php";
$id=(int)($_GET['id']??0);
$data=array_fill_keys(['no_aset','unit_induk','unit_pelaksana','nomor_aset_sap','nama_aset','luas_m2','jenis_dokumen_legal','berlaku_awal','berlaku_akhir','alamat','desa_kelurahan','kecamatan','kabupaten_kota','provinsi','kantah','kanwil','harga_perolehan','kondisi_aset','tahun_perolehan','nilai_saat_ini','tahun_penilaian','aplikasi'],'');
if($id){$x=$conn->query("SELECT * FROM assets WHERE id=$id")->fetch_assoc(); if($x)$data=array_merge($data,$x);}
if($_SERVER['REQUEST_METHOD']==='POST'){
 $fields=array_keys($data); $vals=[]; foreach($fields as $f)$vals[$f]=trim($_POST[$f]??'');
 if($id){
  $set=implode(',',array_map(fn($f)=>"$f=?", $fields)); $types=str_repeat('s',count($fields)); $stmt=$conn->prepare("UPDATE assets SET $set WHERE id=?"); $types.='i'; $vals[]=$id; $stmt->bind_param($types,...$vals); $stmt->execute();
 }else{
  $cols=implode(',',$fields); $marks=implode(',',array_fill(0,count($fields),'?')); $stmt=$conn->prepare("INSERT INTO assets ($cols) VALUES ($marks)"); $stmt->bind_param(str_repeat('s',count($fields)),...$vals); $stmt->execute(); $id=$stmt->insert_id; $conn->query("INSERT INTO progress_sertifikasi(asset_id) VALUES($id)");
 }
 header("Location: assets.php"); exit;
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Form Data Aset</title><link rel="stylesheet" href="assets/style.css"></head><body>
<aside class="sidebar"><div class="brand"><div class="logo">⚡</div><div><b>e-Sertipikat</b><small>UIP3B SUMATERA</small></div></div><nav><a href="index.php">▦ Dashboard</a><a href="assets.php">▤ Data Aset</a><a class="active" href="asset_form.php">＋ Tambah Aset</a><a href="progress.php">◔ Progress Sertifikasi</a><a href="laporan.php">▥ Laporan</a></nav></aside>
<main class="main"><header class="topbar"><div><h1><?= $id?'Edit':'Tambah' ?> Data Aset</h1><p>Lengkapi data sesuai format monitoring e-Sertipikat</p></div></header>
<form method="post" class="form-grid">
<?php $groups=[['Identitas Aset',['no_aset','unit_induk','unit_pelaksana','nomor_aset_sap','nama_aset','luas_m2','jenis_dokumen_legal']],['Dokumen Legal / Masa Berlaku',['berlaku_awal','berlaku_akhir','aplikasi']],['Lokasi',['alamat','desa_kelurahan','kecamatan','kabupaten_kota','provinsi','kantah','kanwil']],['Nilai Aset',['harga_perolehan','kondisi_aset','tahun_perolehan','nilai_saat_ini','tahun_penilaian']]]; foreach($groups as [$title,$names]): ?>
<section class="form-panel"><h2><?=$title?></h2><?php foreach($names as $f): ?><label><?=ucwords(str_replace('_',' ',$f))?><input name="<?=$f?>" value="<?=htmlspecialchars($data[$f]??'')?>" <?=in_array($f,['berlaku_awal','berlaku_akhir'])?'type="date"':''?>></label><?php endforeach; ?></section>
<?php endforeach; ?><div class="form-actions"><a class="btn secondary" href="assets.php">Batal</a><button class="btn">Simpan Data</button></div></form></main></body></html>