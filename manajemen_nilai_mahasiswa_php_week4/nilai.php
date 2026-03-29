<?php
$mahasiswa = [
    [
        "nama"         => "Axandio",
        "nim"          => "2410100179",
        "nilai_tugas"  => 99,
        "nilai_uts"    => 99,
        "nilai_uas"    => 98,
    ],
    [
        "nama"         => "Biyanatul",
        "nim"          => "2410100180",
        "nilai_tugas"  => 80,
        "nilai_uts"    => 45,
        "nilai_uas"    => 50,
    ],
    [
        "nama"         => "Lizan",
        "nim"          => "241010181",
        "nilai_tugas"  => 62,
        "nilai_uts"    => 88,
        "nilai_uas"    => 85,
    ],
    [
        "nama"         => "Liya",
        "nim"          => "241010182",
        "nilai_tugas"  => 95,
        "nilai_uts"    => 90,
        "nilai_uas"    => 98,
    ],
    [
        "nama"         => "khoirunnisa",
        "nim"          => "24101183",
        "nilai_tugas"  => 98,
        "nilai_uts"    => 40,
        "nilai_uas"    => 65,
    ],
];

function hitungNilaiAkhir($tugas, $uts, $uas) {
    $nilai_akhir = ($tugas * 0.30) + ($uts * 0.35) + ($uas * 0.35);
    return round($nilai_akhir, 2);
}

function tentukanGrade($nilai) {
    if ($nilai >= 85) {
        return "A";
    } elseif ($nilai >= 75) {
        return "B";
    } elseif ($nilai >= 65) {
        return "C";
    } elseif ($nilai >= 55) {
        return "D";
    } else {
        return "E";
    }
}

function tentukanStatus($nilai) {
    if ($nilai >= 65) {
        return "LULUS";
    } else {
        return "TIDAK LULUS";
    }
}

$total_nilai   = 0;
$nilai_tertinggi = 0;
$nama_tertinggi  = "";

foreach ($mahasiswa as $mhs) {
    $na = hitungNilaiAkhir($mhs["nilai_tugas"], $mhs["nilai_uts"], $mhs["nilai_uas"]);


    $total_nilai += $na;
    if ($na > $nilai_tertinggi) {
        $nilai_tertinggi = $na;
        $nama_tertinggi  = $mhs["nama"];
    }
}

$jumlah_mahasiswa = count($mahasiswa);
$rata_rata        = round($total_nilai / $jumlah_mahasiswa, 2);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Axandio - Data Nilai Mahasiswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            padding: 30px 20px;
            color: #333;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #1e3a5f, #2e86de);
            color: white;
            border-radius: 12px;
            padding: 28px 32px;
            margin-bottom: 28px;
            box-shadow: 0 4px 15px rgba(30, 58, 95, 0.3);
        }

        .header h1 {
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 0.9rem;
            opacity: 0.85;
        }

        .table-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 28px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.92rem;
        }

        thead tr {
            background: #1e3a5f;
            color: white;
        }

        thead th {
            padding: 14px 16px;
            text-align: center;
            font-weight: 600;
            letter-spacing: 0.4px;
        }

        tbody tr {
            border-bottom: 1px solid #eef0f3;
            transition: background 0.15s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #f5f8ff;
        }

        tbody td {
            padding: 13px 16px;
            text-align: center;
        }

        tbody td:nth-child(2) {
            text-align: left;
            font-weight: 500;
        }

        .grade {
            display: inline-block;
            width: 34px;
            height: 34px;
            line-height: 34px;
            border-radius: 50%;
            font-weight: 700;
            font-size: 0.95rem;
            color: white;
        }

        .grade-A { background: #27ae60; }
        .grade-B { background: #2980b9; }
        .grade-C { background: #f39c12; }
        .grade-D { background: #e67e22; }
        .grade-E { background: #e74c3c; }

        /* BADGE STATUS */
        .status {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .status-lulus {
            background: #d4edda;
            color: #155724;
        }

        .status-tidak {
            background: #f8d7da;
            color: #721c24;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 22px 26px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            border-left: 5px solid;
        }

        .stat-card.rata { border-color: #2e86de; }
        .stat-card.tertinggi { border-color: #27ae60; }

        .stat-card .label {
            font-size: 0.8rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-card .value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e3a5f;
        }

        .stat-card .sub {
            font-size: 0.85rem;
            color: #555;
            margin-top: 4px;
        }

        .info-box {
            background: white;
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            font-size: 0.88rem;
            color: #555;
        }

        .info-box h3 {
            font-size: 0.95rem;
            color: #1e3a5f;
            margin-bottom: 10px;
        }

        .info-box ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 10px 24px;
        }

        .info-box ul li::before {
            content: "▸ ";
            color: #2e86de;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: #aaa;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>📋 Data Nilai Mahasiswa - 2311102179 - Axandio</h1>
        <p>Rekap Nilai Akhir &amp; Status Kelulusan — Semester Genap 2025/2026</p>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Tugas (30%)</th>
                    <th>UTS (35%)</th>
                    <th>UAS (35%)</th>
                    <th>Nilai Akhir</th>
                    <th>Grade</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($mahasiswa as $mhs) :
                    $na     = hitungNilaiAkhir($mhs["nilai_tugas"], $mhs["nilai_uts"], $mhs["nilai_uas"]);
                    $grade  = tentukanGrade($na);
                    $status = tentukanStatus($na);
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($mhs["nama"]) ?></td>
                    <td><?= htmlspecialchars($mhs["nim"]) ?></td>
                    <td><?= $mhs["nilai_tugas"] ?></td>
                    <td><?= $mhs["nilai_uts"] ?></td>
                    <td><?= $mhs["nilai_uas"] ?></td>
                    <td><strong><?= $na ?></strong></td>
                    <td>
                        <span class="grade grade-<?= $grade ?>">
                            <?= $grade ?>
                        </span>
                    </td>
                    <td>
                        <span class="status <?= $status === 'LULUS' ? 'status-lulus' : 'status-tidak' ?>">
                            <?= $status ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- STATISTIK KELAS -->
    <div class="stats-grid">
        <div class="stat-card rata">
            <div class="label">📊 Rata-rata Kelas</div>
            <div class="value"><?= $rata_rata ?></div>
            <div class="sub">dari <?= $jumlah_mahasiswa ?> mahasiswa</div>
        </div>
        <div class="stat-card tertinggi">
            <div class="label">🏆 Nilai Tertinggi</div>
            <div class="value"><?= $nilai_tertinggi ?></div>
            <div class="sub"><?= htmlspecialchars($nama_tertinggi) ?></div>
        </div>
    </div>

    <div class="info-box">
        <h3>📌 Keterangan</h3>
        <ul>
            <li>Tugas 30% + UTS 35% + UAS 35%</li>
            <li>A ≥ 85 &nbsp;|&nbsp; B ≥ 75 &nbsp;|&nbsp; C ≥ 65 &nbsp;|&nbsp; D ≥ 55 &nbsp;|&nbsp; E &lt; 55</li>
            <li>Lulus jika Nilai Akhir ≥ 65</li>
        </ul>
    </div>

    <div class="footer">Axandio-2311102179 &copy; 2026</div>
</div>
</body>
</html>