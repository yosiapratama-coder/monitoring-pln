<?php
require_once "config/database.php";
$total = $conn->query("SELECT COUNT(*) c FROM assets")->fetch_assoc()['c'];
$bersertifikat = $conn->query("SELECT COUNT(*) c FROM assets WHERE jenis_dokumen_legal LIKE '%Sertipikat%'")->fetch_assoc()['c'];
$luas = $conn->query("SELECT COALESCE(SUM(luas_m2),0) c FROM assets")->fetch_assoc()['c'];
$berjalan = $conn->query("SELECT COUNT(*) c FROM progress_sertifikasi WHERE status='Berjalan'")->fetch_assoc()['c'];
$selesai = $conn->query("SELECT COUNT(*) c FROM progress_sertifikasi WHERE status='Selesai'")->fetch_assoc()['c'];
$rows = $conn->query("SELECT a.*, p.status FROM assets a LEFT JOIN progress_sertifikasi p ON p.asset_id=a.id ORDER BY a.id DESC LIMIT 10");
?>
<!doctype html>
<html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>e-Sertipikat | UIP3B Sumatera</title>
<link rel="stylesheet" href="assets/style.css">
</head><body>
<aside class="sidebar">
  <div class="brand"><div class="logo">⚡</div><div><b>e-Sertipikat</b><small>UIP3B SUMATERA</small></div></div>
  <nav>
    <a class="active" href="index.php">▦ Dashboard</a>
    <a href="assets.php">▤ Data Aset</a>
    <a href="asset_form.php">＋ Tambah Aset</a>
    <a href="progress.php">◔ Progress Sertifikasi</a>
    <a href="laporan.php">▥ Laporan</a>
  </nav>
  <div class="side-footer">Rancang Bangun Sistem Informasi<br>Pengolahan & Monitoring Data e-Sertipikat</div>
</aside>
<main class="main">
<header class="topbar"><div><h1>Dashboard</h1><p>Monitoring Data e-Sertipikat • PT PLN (Persero) UIP3B Sumatera</p></div><div class="user">Administrator ▾</div></header>
<section class="cards">
 <div class="card"><span>Total Aset</span><strong><?= number_format($total) ?></strong><em>Data aset terdaftar</em></div>
 <div class="card"><span>Sudah Sertipikat</span><strong><?= number_format($bersertifikat) ?></strong><em>Dokumen legal</em></div>
 <div class="card"><span>Luas Aset</span><strong><?= number_format($luas,0,',','.') ?> <small>m²</small></strong><em>Total luas tercatat</em></div>
 <div class="card"><span>Progress Berjalan</span><strong><?= number_format($berjalan) ?></strong><em>Proses sertifikasi</em></div>
</section>
<section class="panel">
 <div class="panel-head"><h2>Data Aset</h2><a class="btn" href="asset_form.php">+ Tambah Data</a></div>
 <div class="table-wrap"><table><thead><tr><th>NO</th><th>UNIT INDUK</th><th>UNIT PELAKSANA</th><th>NOMOR ASET (SAP)</th><th>NAMA ASET</th><th>LUAS (m²)</th><th>DOKUMEN LEGAL</th><th>STATUS</th></tr></thead><tbody>
 <?php while($r=$rows->fetch_assoc()): ?>
 <tr><td><?=htmlspecialchars($r['no_aset'])?></td><td><?=htmlspecialchars($r['unit_induk'])?></td><td><?=htmlspecialchars($r['unit_pelaksana'])?></td><td><?=htmlspecialchars($r['nomor_aset_sap'])?></td><td><?=htmlspecialchars($r['nama_aset'])?></td><td><?=number_format($r['luas_m2'],2,',','.')?></td><td><?=htmlspecialchars($r['jenis_dokumen_legal'])?></td><td><span class="badge <?=strtolower(str_replace(' ','-',$r['status']??'Belum Mulai'))?>"><?=htmlspecialchars($r['status']??'Belum Mulai')?></span></td></tr>
 <?php endwhile; ?>
 </tbody></table></div>
</section>
</main></body></html>