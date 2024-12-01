<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title><?= $title_pdf;?></title>
         
        <style>
            .line-title {
                border: 0;
                border-style: unset;
                border-top: 4px solid #000;
                margin-bottom: -5px;
            }
            .line-title-two {
                border: 0;
                border-style: unset;
                border-top: 1px solid #000;
            }
            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #table td, #table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #table tr:nth-child(even){background-color: #f2f2f2;}

            #table tr:hover {background-color: #ddd;}

            #table th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: center;
                background-color: #4CAF50;
                color: white;
            }
        </style>

       
    </head>
    <body>
        <img src="<?= base_url('template/assets/img/unpkopsuratm.jpg'); ?>" style="width: 90px; height: 90px; position: absolute;">
        <table style="width: 100%;">
            <tr>
                <td align="center">
                    <span style="line-height: 1.4; font-weight: bold; font-size: 1.5rem;">
                        KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI<br>
                        UNIVERSITAS NEGERI PADANG<br>
                    </span>
                    <span style="line-height: 1.1; font-size: 1rem; font-style: italic;">
                        Alamat : Jalan Prof. Dr. Hamka Air Tawar Padang 25131<br>
                        Tlp : (0751) 7051260 Fax : (0751) 7055628<br>
                        Website http://www.unp.ac.id Email : kemahasiswaan@unp.ac.id
                    </span>
                </td>
            </tr>
        </table>
        <hr class="line-title">
        <hr class="line-title-two">
        <div style="text-align:center">
            <h2> Daftar Nama Mahasiswa Penerima Beasiswa <?= $nama_beasiswa; ?></h2>
            <h2 style="margin-top: -15px;"> Semester <?= $periode; ?> tahun <?= $tahun; ?></h2>
        </div>
        <table id="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Prodi</th>
                    <th>Fakultas</th>
                    <th>Status Beasiswa</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($master_beasiswa as $mb) : ?>
                <tr>
                    <td scope="row"><?= $no++; ?></td>
                    <td><?= $mb['nim_mahasiswa']; ?></td>
                    <td><?= $mb['nama_mahasiswa']; ?></td>
                    <td><?= $mb['prodi']; ?></td>
                    <td><?= $mb['fakultas']; ?></td>
                    <td><?= $mb['status_beasiswa'] == '3' ? 'Penerima' : ($mb['status_beasiswa'] == '4' ? 'Dibatalkan' : ($mb['status_beasiswa'] == '5' ? 'Selesai' : null )); ?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </body>
</html>