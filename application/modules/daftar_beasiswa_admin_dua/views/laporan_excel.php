<?php 
header("Content-type:application/octet-stream/");
header("Content-Disposition:attachment; filename=$title.xls");
header("Pragma: no-chace");
header("Expires: 0");
?>

<h3>Laporan Mahasiswa Yang sudah Mendaftar Beasiswa <?= $nama_beasiswa; ?></h3>
<h3>Periode <?= $periode; ?> <?= $tahun; ?></h3>
<table border="1" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Tahun Masuk</th>
            <th>Nama Mahasiswa</th>
            <th>JK</th>
            <th>Prodi</th>
            <th>Fakultas</th>
            <th>JJP</th>
            <th>IPK</th>
            <th>No HP</th>
            <th>Tempat Lahir</th>
            <th>Tgl Lahir</th>
            <th>Agama</th>
            <th>Admin Pendaftar</th>
            <th>Tanggal Daftar</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        foreach ($pendaftar_beasiswa as $pb) : ?>
        <tr>
            <td scope="row"><?= $no++; ?></td>
            <td><?= $pb['nim_mahasiswa']; ?></td>
            <td><?= $pb['tm_msk']; ?></td>
            <td><?= $pb['nama_mahasiswa']; ?></td>
            <td><?= $pb['jenis_kelamin']; ?></td>
            <td><?= $pb['prodi']; ?></td>
            <td><?= $pb['fakultas']; ?></td>
            <td><?= $pb['jjp']; ?></td>
            <td><?= $pb['ipk']; ?></td>
            <td><?= $pb['nohp']; ?></td>
            <td><?= $pb['tmp_lhr']; ?></td>
            <td><?= $pb['tgl_lhr']; ?></td>
            <td><?= $pb['agama']; ?></td>
            <td><?= $pb['admin_pendaftar']; ?></td>
            <td><?= $pb['tanggal_daftar']; ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>