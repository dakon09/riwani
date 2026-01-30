<?php

namespace App\Http\Controllers\Master;

use App\Exports\UmkmTemplateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UmkmImportRequest;
use App\Http\Requests\UmkmStoreRequest;
use App\Http\Requests\UmkmUpdateRequest;
use App\Imports\UmkmImport;
use App\Models\Umkm;
use App\Models\UmkmImportLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class UmkmController extends Controller
{
    public function index()
    {
        return view('umkm.index');
    }

    public function datatable(Request $request)
    {
        $data = Umkm::select('umkm.*')
            ->leftJoin('users as creator', 'umkm.created_by', '=', 'creator.id')
            ->with(['verifiedBy', 'province', 'city', 'district', 'village']);

        return DataTables::of($data)
            ->addColumn('DT_RowIndex', function ($row) {
                static $index = 0;

                return ++$index;
            })
            ->addColumn('action', function ($row) {
                $actions = '';
                $user = Auth::user();
                if ($user && $user->can('umkm_edit')) {
                    $actions .= '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-info change-status-btn" data-id="'.$row->id.'" data-status="'.$row->status_umkm.'" title="Ubah Status">
                        <i class="ki-duotone ki-arrows-circle fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>';

                    $actions .= '<a href="'.route('master.umkm.edit', $row->id).'" class="btn btn-sm btn-icon btn-light btn-active-light-primary" title="Edit">
                        <i class="ki-duotone ki-pencil fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>';
                }
                if ($user && $user->can('umkm_delete')) {
                    $actions .= '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-danger delete-btn" data-id="'.$row->id.'" title="Delete">
                        <i class="ki-duotone ki-trash fs-2">
                             <span class="path1"></span>
                             <span class="path2"></span>
                             <span class="path3"></span>
                             <span class="path4"></span>
                             <span class="path5"></span>
                        </i>
                    </button>';
                }

                return $actions;
            })
            ->addColumn('provinsi', function ($row) {
                return $row->province->name ?? '-';
            })
            ->addColumn('kabupaten', function ($row) {
                return $row->city->name ?? '-';
            })
            ->addColumn('kecamatan', function ($row) {
                return $row->district->name ?? '-';
            })
            ->addColumn('kelurahan', function ($row) {
                return $row->village->name ?? '-';
            })
            ->addColumn('source_badge', function ($row) {
                $badge = $row->source_input === 'MANUAL'
                    ? 'badge-light-primary'
                    : 'badge-light-success';

                return '<span class="badge '.$badge.' fs-7 fw-bold">'.$row->source_input.'</span>';
            })
            ->addColumn('status_badge', function ($row) {
                $badges = [
                    'DRAFT' => 'badge-light-warning',
                    'REGISTERED' => 'badge-light-info',
                    'ACTIVE' => 'badge-light-success',
                    'INACTIVE' => 'badge-light-danger',
                ];
                $badge = $badges[$row->status_umkm] ?? 'badge-light-gray';

                return '<span class="badge '.$badge.' fs-7 fw-bold">'.$row->status_umkm.'</span>';
            })
            ->addColumn('created_by_name', function ($row) {
                return $row->creator ? $row->creator->name : '-';
            })
            ->filterColumn('created_by', function ($query, $keyword) {
                $query->whereHas('createdBy', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%'.$keyword.'%');
                });
            })
            ->orderColumn('created_by', function ($query, $order) {
                $query->orderBy('creator.name', $order);
            })
            ->rawColumns(['action', 'source_badge', 'status_badge'])
            ->make(true);
    }

    public function create()
    {
        if (! auth()->user()?->can('umkm_create')) {
            abort(403, 'Unauthorized');
        }

        return view('umkm.create');
    }

    public function store(UmkmStoreRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['nama_pemilik'] ?? $data['nama_usaha'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $data['umkm_code'] = Umkm::generateUmkmCode();
        $data['created_by'] = Auth::id();
        $data['source_input'] = 'MANUAL';
        $data['user_id'] = $user->id;
        unset($data['username'], $data['password']);

        Umkm::create($data);

        return redirect()
            ->route('master.umkm.index')
            ->with('success', 'Data UMKM berhasil disimpan');
    }

    public function show($id)
    {
        $data = Umkm::with(['createdBy', 'verifiedBy', 'user', 'province', 'city', 'district', 'village'])->findOrFail($id);

        return view('umkm.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Umkm::with(['province', 'city', 'district', 'village', 'user'])->findOrFail($id);

        return view('umkm.edit', compact('data'));
    }

    public function update(UmkmUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $umkm = Umkm::findOrFail($id);
        $user = $umkm->user;

        if ($user) {
            $user->name = $data['nama_pemilik'] ?? $data['nama_usaha'];
            $user->username = $data['username'];
            $user->email = $data['email'];
            if (! empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            $user->save();
        } else {
            if (empty($data['password'])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['password' => 'Password wajib diisi untuk membuat akun UMKM.']);
            }
            $user = User::create([
                'name' => $data['nama_pemilik'] ?? $data['nama_usaha'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $data['user_id'] = $user->id;
        }

        unset($data['username'], $data['password']);
        $umkm->update($data);

        return redirect()
            ->route('master.umkm.index')
            ->with('success', 'Data UMKM berhasil diupdate');
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status_umkm' => 'required|in:DRAFT,REGISTERED,ACTIVE,INACTIVE',
        ]);

        $umkm = Umkm::findOrFail($id);
        $umkm->status_umkm = $request->status_umkm;

        // Update verification info if status becomes ACTIVE or REGISTERED
        if (in_array($request->status_umkm, ['ACTIVE', 'REGISTERED']) && ! $umkm->verified_by) {
            $umkm->verified_by = Auth::id();
        }

        $umkm->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status UMKM berhasil diupdate',
        ]);
    }

    public function destroy($id)
    {
        $data = Umkm::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data UMKM berhasil dihapus',
        ]);
    }

    public function import()
    {
        return view('umkm.import');
    }

    public function processImport(UmkmImportRequest $request)
    {
        $file = $request->file('file');

        // Use Import class just to get array, or use direct ToArray
        // UmkmImport class has no logic now effectively if we bypass it, but maybe safer to use it for heading row concern?
        // Let's use generic ToArray with HeadingRow
        $array = Excel::toArray(new UmkmImport, $file);

        $validRows = [];
        $invalidRows = [];
        $errorsLog = [];

        // Sheet 1
        $rows = $array[0] ?? [];

        foreach ($rows as $index => $row) {
            $rowNum = $index + 2; // +2 for heading + 0-index
            $validation = $this->validateAndMapRow($row);

            if ($validation['status'] === 'valid') {
                $validRows[] = $validation['data'];
            } else {
                $invalidRows[] = [
                    'row' => $rowNum,
                    'data' => $row,
                    'errors' => $validation['errors'],
                ];
                $errorsLog[] = "Row {$rowNum}: ".implode('; ', array_column($validation['errors'], 'message'));
            }
        }

        if (count($invalidRows) > 0) {
            // Return Preview View
            // Pass validRows as hidden data?
            // Warning: If validRows is huge, this might be an issue. But typically imports are < 1000 rows.
            return view('umkm.import_preview', [
                'validRows' => $validRows,
                'invalidRows' => $invalidRows,
            ]);
        }

        // Check if no rows
        if (count($validRows) === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'File kosong atau format salah.',
            ], 400);
        }

        // All Valid -> Insert
        foreach ($validRows as $data) {
            Umkm::create($data);
        }

        UmkmImportLog::create([
            'file_name' => $file->getClientOriginalName(),
            'total_row' => count($rows),
            'success_row' => count($validRows),
            'failed_row' => 0,
            'imported_by' => Auth::id(),
            'imported_at' => now(),
            'note' => 'Success via Strict Import',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Import UMKM berhasil ('.count($validRows).' baris)',
        ]);
    }

    public function storeImportFix(Request $request)
    {
        $validRows = json_decode($request->valid_rows, true) ?? [];
        $fixes = $request->fixes ?? [];

        // Process fixes
        foreach ($fixes as $fix) {
            // $fix['data'] is the original row JSON string, decode it
            $originalData = json_decode($fix['data'], true);

            // Merge fixed regions
            $mergedRow = array_merge($originalData, [
                'provinsi_id' => $fix['provinsi_id'],
                'kabupaten_id' => $fix['kabupaten_id'],
                'kecamatan_id' => $fix['kecamatan_id'],
                'kelurahan_id' => $fix['kelurahan_id'],
            ]);

            // Re-map other fields (like umkm_code)
            // We need a mapper that accepts IDs directly now
            // The validatesAndMapRow expected Names.
            // Here we basically manually construct the model data
            $modelData = $this->mapDirectRow($mergedRow, $originalData);

            $validRows[] = $modelData;
        }

        // Bulk Insert
        $count = 0;
        foreach ($validRows as $data) {
            Umkm::create($data);
            $count++;
        }

        return redirect()->route('master.umkm.index')->with('success', "Import berhasil! {$count} data tersimpan.");
    }

    private function validateAndMapRow($row)
    {
        $errors = [];

        // Basic Fields
        $namaUsaha = $row['nama_usaha'] ?? null;
        if (! $namaUsaha) {
            $errors[] = ['message' => 'Nama Usaha wajib diisi'];
        }

        $noHp = $row['no_hp'] ?? null;
        if (! $noHp) {
            $errors[] = ['message' => 'No HP wajib diisi'];
        }

        // Strict Regional Validation
        $province = Province::where('name', $row['provinsi'])->first();
        if (! $province) {
            $errors[] = ['message' => "Provinsi '{$row['provinsi']}' tidak ditemukan."];
        }

        $city = null;
        if ($province) {
            $city = City::where('province_code', $province->code)->where('name', $row['kabupaten'])->first();
            if (! $city) {
                $errors[] = ['message' => "Kabupaten '{$row['kabupaten']}' tidak sesuai dengan Provinsi '{$province->name}'."];
            }
        }

        $district = null;
        if ($city) {
            $district = District::where('city_code', $city->code)->where('name', $row['kecamatan'])->first();
            if (! $district) {
                $errors[] = ['message' => "Kecamatan '{$row['kecamatan']}' tidak sesuai dengan Kabupaten '{$city->name}'."];
            }
        }

        $village = null;
        if ($district) {
            $village = Village::where('district_code', $district->code)->where('name', $row['kelurahan'])->first();
            if (! $village) {
                $errors[] = ['message' => "Kelurahan '{$row['kelurahan']}' tidak sesuai dengan Kecamatan '{$district->name}'."];
            }
        }

        if (count($errors) > 0) {
            return ['status' => 'invalid', 'errors' => $errors];
        }

        // Map to Model
        $modelData = [
            'umkm_code' => Umkm::generateUmkmCode(),
            'nama_usaha' => $namaUsaha,
            'jenis_usaha' => $row['jenis_usaha'] ?? null,
            'sektor_usaha' => $row['sektor_usaha'] ?? null,
            'tahun_berdiri' => $row['tahun_berdiri'] ?? null,
            'alamat_usaha' => $row['alamat_usaha'] ?? null,
            'provinsi_id' => $province->code,
            'kabupaten_id' => $city->code,
            'kecamatan_id' => $district->code,
            'kelurahan_id' => $village->code,
            'kode_pos' => $row['kode_pos'] ?? null,
            'status_umkm' => 'REGISTERED',
            'source_input' => 'IMPORT',
            'nama_pemilik' => $row['nama_pemilik'] ?? null,
            'nik_pemilik' => $row['nik_pemilik'] ?? null,
            'no_hp' => $noHp,
            'email' => $row['email'] ?? null,
            'alamat_pemilik' => $row['alamat_pemilik'] ?? null,
            'bentuk_badan_usaha' => $row['bentuk_badan_usaha'] ?? 'Perorangan',
            'npwp' => $row['npwp'] ?? null,
            'nib' => $row['nib'] ?? null,
            'izin_usaha' => $row['izin_usaha'] ?? null,
            'status_legalitas' => 'BELUM',
            'user_id' => null,
            'created_by' => Auth::id(),
        ];

        return ['status' => 'valid', 'data' => $modelData];
    }

    private function mapDirectRow($mergedRow, $originalRow)
    {
        // This is used when we HAVE IDs from the Fix Form
        return [
            'umkm_code' => Umkm::generateUmkmCode(),
            'nama_usaha' => $originalRow['nama_usaha'],
            'jenis_usaha' => $originalRow['jenis_usaha'] ?? null,
            'sektor_usaha' => $originalRow['sektor_usaha'] ?? null,
            'tahun_berdiri' => $originalRow['tahun_berdiri'] ?? null,
            'alamat_usaha' => $originalRow['alamat_usaha'] ?? null,
            'provinsi_id' => $mergedRow['provinsi_id'],
            'kabupaten_id' => $mergedRow['kabupaten_id'],
            'kecamatan_id' => $mergedRow['kecamatan_id'],
            'kelurahan_id' => $mergedRow['kelurahan_id'],
            'kode_pos' => $originalRow['kode_pos'] ?? null,
            'status_umkm' => 'REGISTERED',
            'source_input' => 'IMPORT',
            'nama_pemilik' => $originalRow['nama_pemilik'] ?? null,
            'nik_pemilik' => $originalRow['nik_pemilik'] ?? null,
            'no_hp' => $originalRow['no_hp'],
            'email' => $originalRow['email'] ?? null,
            'alamat_pemilik' => $originalRow['alamat_pemilik'] ?? null,
            'bentuk_badan_usaha' => $originalRow['bentuk_badan_usaha'] ?? 'Perorangan',
            'npwp' => $originalRow['npwp'] ?? null,
            'nib' => $originalRow['nib'] ?? null,
            'izin_usaha' => $originalRow['izin_usaha'] ?? null,
            'status_legalitas' => 'BELUM',
            'user_id' => null,
            'created_by' => Auth::id(),
        ];
    }

    public function downloadTemplate()
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        return Excel::download(new UmkmTemplateExport, 'template_import_umkm.xlsx');
    }
}
