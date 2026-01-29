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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                    $actions .= '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-info change-status-btn" data-id="' . $row->id . '" data-status="' . $row->status_umkm . '" title="Ubah Status">
                        <i class="ki-duotone ki-arrows-circle fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>';

                    $actions .= '<a href="' . route('master.umkm.edit', $row->id) . '" class="btn btn-sm btn-icon btn-light btn-active-light-primary" title="Edit">
                        <i class="ki-duotone ki-pencil fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>';
                }
                if ($user && $user->can('umkm_delete')) {
                    $actions .= '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-danger delete-btn" data-id="' . $row->id . '" title="Delete">
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

                return '<span class="badge ' . $badge . ' fs-7 fw-bold">' . $row->source_input . '</span>';
            })
            ->addColumn('status_badge', function ($row) {
                $badges = [
                    'DRAFT' => 'badge-light-warning',
                    'REGISTERED' => 'badge-light-info',
                    'ACTIVE' => 'badge-light-success',
                    'INACTIVE' => 'badge-light-danger',
                ];
                $badge = $badges[$row->status_umkm] ?? 'badge-light-gray';

                return '<span class="badge ' . $badge . ' fs-7 fw-bold">' . $row->status_umkm . '</span>';
            })
            ->addColumn('created_by_name', function ($row) {
                return $row->creator ? $row->creator->name : '-';
            })
            ->filterColumn('created_by', function ($query, $keyword) {
                $query->whereHas('createdBy', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
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
        if (!auth()->user()?->can('umkm_create')) {
            abort(403, 'Unauthorized');
        }

        return view('umkm.create');
    }

    public function store(UmkmStoreRequest $request)
    {
        $data = $request->validated();
        $data['umkm_code'] = Umkm::generateUmkmCode();
        $data['created_by'] = Auth::id();
        $data['source_input'] = 'MANUAL';

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
        $data = Umkm::with(['province', 'city', 'district', 'village'])->findOrFail($id);

        return view('umkm.edit', compact('data'));
    }

    public function update(UmkmUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $umkm = Umkm::findOrFail($id);
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
        if (in_array($request->status_umkm, ['ACTIVE', 'REGISTERED']) && !$umkm->verified_by) {
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
        try {
            $file = $request->file('file');
            $import = new UmkmImport;

            Excel::import($import, $file);

            $log = UmkmImportLog::create([
                'file_name' => $file->getClientOriginalName(),
                'total_row' => $import->getTotalRow(),
                'success_row' => $import->getSuccessRow(),
                'failed_row' => $import->getFailedRow(),
                'imported_by' => Auth::id(),
                'imported_at' => now(),
                'note' => $import->getErrors() ? implode(', ', $import->getErrors()) : null,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Import UMKM berhasil',
                'data' => [
                    'total' => $import->getTotalRow(),
                    'success' => $import->getSuccessRow(),
                    'failed' => $import->getFailedRow(),
                    'errors' => $import->getErrors(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat import: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new UmkmTemplateExport, 'template_import_umkm.xlsx');
    }
}
