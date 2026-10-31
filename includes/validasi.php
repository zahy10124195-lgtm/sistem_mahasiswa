<?php
/**
 * Validasi & sanitasi data mahasiswa.
 * Menggunakan if-else dan switch sesuai ketentuan tugas, serta
 * filter_var() dan htmlspecialchars() untuk sanitasi input.
 */
const DAFTAR_PRODI = [
    'Teknik Informatika',
    'Sistem Informasi',
    'Teknik Elektro',
    'Teknik Sipil',
    'Manajemen',
];

/**
 * @param array $input  biasanya $_POST
 * @return array [data_bersih, daftar_kunci_error]
 */
function validasi_mahasiswa(array $input): array
{
    // --- Sanitasi: rapikan spasi & bersihkan karakter berbahaya ---
    $data = [
        'nim'      => trim($input['nim'] ?? ''),
        'nama'     => trim(preg_replace('/\s+/', ' ', $input['nama'] ?? '')),
        'email'    => trim($input['email'] ?? ''),
        'prodi'    => trim($input['prodi'] ?? ''),
        'angkatan' => trim($input['angkatan'] ?? ''),
    ];
    $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

    $error = [];

    // --- Validasi kelengkapan (if-else) ---
    if ($data['nim'] === '' || $data['nama'] === '' || $data['email'] === ''
        || $data['prodi'] === '' || $data['angkatan'] === '') {
        $error[] = 'err_required';
        return [$data, $error];
    }

    // --- Validasi per kolom (switch) ---
    foreach (array_keys($data) as $kolom) {
        switch ($kolom) {
            case 'nim':
                if (!preg_match('/^[0-9]{8,12}$/', $data['nim'])) {
                    $error[] = 'err_nim';
                }
                break;

            case 'nama':
                if (!preg_match("/^[\\p{L} .']{3,100}$/u", $data['nama'])) {
                    $error[] = 'err_name';
                }
                break;

            case 'email':
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $error[] = 'err_email';
                }
                break;

            case 'prodi':
                if (!in_array($data['prodi'], DAFTAR_PRODI, true)) {
                    $error[] = 'err_major';
                }
                break;

            case 'angkatan':
                $th = filter_var($data['angkatan'], FILTER_VALIDATE_INT);
                if ($th === false || $th < 2000 || $th > (int)date('Y')) {
                    $error[] = 'err_year';
                }
                break;
        }
    }

    return [$data, $error];
}
