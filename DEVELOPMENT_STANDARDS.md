# STANDAR PENGEMBANGAN FITUR BARU
## BoilerPlate Harma - Laravel 12 Admin Dashboard

---

## 1. TEKNOLOGI STACK (MANDATORY)

### Backend
- **Framework**: Laravel 12.0
- **Language**: PHP 8.2+
- **Database**: MySQL
- **Authentication**: Laravel Fortify + Jetstream (Livewire stack)
- **Authorization**: Spatie Laravel Permission v6.24+
- **API**: Laravel Sanctum v4.0+

### Frontend
- **Build Tool**: Vite 7.0+
- **CSS Framework**: Tailwind CSS 3.4+
- **JavaScript**: Vanilla JS + Axios 1.11.0+
- **Reactive**: Livewire 3.6.4+ untuk komponen dinamis
- **UI Template**: Metronic (Keenthemes)

---

## 2. NAMING CONVENTIONS (STANDARD)

| Type | Convention | Example |
|------|-----------|---------|
| Classes | PascalCase | `ProductController`, `OrderService` |
| Methods | camelCase | `insertProduct`, `updateOrderStatus` |
| Variables | camelCase | `$productName`, `$orderStatus` |
| Database Tables | snake_case | `product_categories`, `order_items` |
| Routes | kebab-case | `products.index`, `orders.update` |
| Views | kebab-case | `products/index.blade.php`, `orders/detail.blade.php` |
| Migrations | YYYY_MM_DD_HHMMSS_description.php | `2026_01_29_120000_create_products_table.php` |
| Models | Singular PascalCase | `Product`, `OrderItem` |

---

## 3. STRUKTUR DIREKTORI

### Controllers
```
app/Http/Controllers/
├── [FeatureName]Controller.php
├── Master/
│   ├── [Entity]Controller.php  # Untuk CRUD master data
└── Api/
    └── [Entity]Controller.php  # Untuk API endpoints
```

### Models
```
app/Models/
├── [Entity].php
└── [RelatedEntity].php
```

### Views
```
resources/views/
├── [feature-name]/
│   ├── index.blade.php       # List view dengan DataTables
│   ├── create.blade.php      # Form create
│   ├── edit.blade.php        # Form edit
│   └── show.blade.php        # Detail view
├── layouts/
│   └── main_layout.blade.php # Layout utama Metronic
└── components/
    └── [feature-name]/       # Reusable Blade components
```

### JavaScript
```
public/assets/js/
├── master/
│   └── [entity].js           # DataTables & CRUD logic
├── custom/
│   └── [feature].js          # Custom feature logic
└── [feature]/
    └── [module].js           # Module-specific JS
```

### Migrations
```
database/migrations/
└── YYYY_MM_DD_HHMMSS_create_[entity]s_table.php
```

---

## 4. MODEL REQUIREMENTS

### Struktur Model Dasar
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class [Entity] extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // List fillable fields
    ];

    protected $hidden = [
        // Hidden fields (password, tokens, etc.)
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function relationName()
    {
        return $this->belongsTo(RelatedModel::class);
    }
}
```

### Wajib Menggunakan
- **SoftDeletes** untuk semua model yang membutuhkan soft delete
- **Casts** untuk datetime fields
- **Relationship methods** dengan nama deskriptif
- **Fillable** untuk mass assignment

---

## 5. CONTROLLER REQUIREMENTS

### Struktur Controller CRUD
```php
<?php

namespace App\Http\Controllers;

use App\Models\[Entity];
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class [Entity]Controller extends Controller
{
    public function index()
    {
        return view('[entity].index');
    }

    public function datatable(Request $request)
    {
        $data = [Entity]::query();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                // Action buttons
            })
            ->make(true);
    }

    public function create()
    {
        return view('[entity].create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Validation rules
        ]);

        [Entity]::create($request->all());

        return redirect()
            ->route('[entity].index')
            ->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $data = [Entity]::findOrFail($id);
        return view('[entity].edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // Validation rules
        ]);

        $data = [Entity]::findOrFail($id);
        $data->update($request->all());

        return redirect()
            ->route('[entity].index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = [Entity]::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
```

### Wajib Menggunakan
- **DataTables** untuk list view
- **Validation** pada store dan update
- **Redirect dengan flash message**
- **JSON response** untuk AJAX delete
- **findOrFail** untuk single record retrieval
- **Sanitasi & validasi** mengikuti pola di bawah ini (Validator + Elegant Sanitizer):
  ```php
  $validator = Validator::make($request->all(), [
      'name' => 'required|unique:users,name',
      'email' => 'required|unique:users,email',
      'username' => 'required|unique:users,username',
      'password' => 'required|confirmed',
      'role' => 'required',
  ]);

  if ($validator->fails()) {
      return response()->json([
          'status' => false,
          'data' => $this->validationErrorsToString($validator->errors()),
      ], 200);
  }

  $filters = [
      'name' => 'trim|escape|capitalize',
      'email' => 'trim|escape',
      'username' => 'trim|escape',
      'password' => 'trim|escape',
      'role' => 'trim|escape',
  ];

  $sanitizer = new Sanitizer($request->all(), $filters);
  $attrclean = $sanitizer->sanitize();
  ```

---

## 6. VIEW REQUIREMENTS (BLADE)

### Struktur Index View (DataTables)
```blade
@extends('layouts.main_layout')

@section('content')
<!--begin::Post-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title">
            <h2 class="fw-bold">[Entity Name]</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <a href="{{ route('[entity].create') }}" class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i>
                Tambah Data
            </a>
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!--end::Card body-->
</div>
<!--end::Post-->
@endsection

@push('scripts')
<script>
    var datatableUrl = "{{ route('[entity].datatable') }}";
</script>
@endsection
```

### Struktur Form View (Create/Edit)
```blade
@extends('layouts.main_layout')

@section('content')
<!--begin::Post-->
<div class="card card-flush">
    <!--begin::Card header-->
    <div class="card-header">
        <div class="card-title">
            <h2 class="fw-bold">{{ isset($data) ? 'Edit' : 'Tambah' }} [Entity Name]</h2>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body">
        <form action="{{ isset($data) ? route('[entity].update', $data->id) : route('[entity].store') }}" method="POST">
            @csrf
            @if(isset($data))
                @method('PUT')
            @endif

            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <label class="required form-label">Nama</label>
                <input type="text" name="name" class="form-control form-control-solid" value="{{ old('name', $data->name ?? '') }}" placeholder="Masukkan nama">
                @error('name')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <!--end::Input group-->

            <!--begin::Actions-->
            <div class="d-flex justify-content-end">
                <a href="{{ route('[entity].index') }}" class="btn btn-light me-3">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <!--end::Actions-->
        </form>
    </div>
    <!--end::Card body-->
</div>
<!--end::Post-->
@endsection
```

### Wajib Menggunakan
- **Metronic layout**: `layouts.main_layout`
- **Metronic components**: `card`, `card-flush`, `card-header`, `card-body`
- **Metronic inputs**: `form-control form-control-solid`
- **Metronic buttons**: `btn btn-primary`, `btn btn-light`
- **Metronic icons**: `ki-duotone ki-[icon-name]`
- **DataTables** untuk list view
- **Flash messages** untuk feedback

---

## 7. JAVASCRIPT REQUIREMENTS

### Struktur DataTables JS
```javascript
$(document).ready(function() {
    var table = $('#kt_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: datatableUrl,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        }
    });
});
```

### Struktur AJAX Form
```javascript
$(document).on('submit', 'form', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = new FormData(this);

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = response.redirect;
                });
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                displayErrors(xhr.responseJSON.errors);
            }
        }
    });
});
```

### Wajib Menggunakan
- **jQuery** untuk DOM manipulation dan AJAX
- **DataTables** untuk server-side tables
- **SweetAlert2** untuk alerts (Metronic built-in)
- **AJAX** untuk form submissions (opsional, bisa gunakan submit form biasa)
- **Create/Update via JS** hanya untuk modal/satu halaman, contoh pola AJAX:
  ```javascript
  $.ajax({
      type: "POST",
      url: base_url + '/master/user/insert',
      data: {
          name: $('#name').val(),
          username: $('#username').val(),
          email: $('#email').val(),
          role: $('#role').val(),
          _token: csrf_token,
      },
      success: function (response) {
          if (response.status == true) {
              Swal.fire({
                  title: "Success",
                  text: "Data berhasil ditambahkan!",
                  icon: "success",
                  timer: 1500,
                  showConfirmButton: false,
              }).then(() => {
                  $('#kt_datatable_user').DataTable().ajax.reload();
              });
          }
      }
  });
  ```
- **Jika halaman berbeda**, gunakan pola form biasa seperti `umkm/create` dan `umkm/edit` (submit via POST/PUT, redirect + flash message)
- **Script JS wajib dipisahkan dari view**, contoh referensi:
  ```blade
  @section('script')
      <script src="{{ asset('assets/js/master/user.js') }}"></script>
  @endsection
  ```

---

## 8. VALIDATION REQUIREMENTS

### Validation Rules
```php
public function rules()
{
    return [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $this->id,
        'phone' => 'nullable|string|max:20',
        'status' => 'required|in:active,inactive',
    ];
}
```

### Wajib Menggunakan
- **Required** untuk field wajib
- **Type validation** (string, integer, email, etc.)
- **Length validation** (max, min)
- **Unique validation** untuk field unik
- **Enum validation** untuk status/options
- **Custom messages** untuk error messages (opsional)

---

## 9. MIGRATION REQUIREMENTS

### Struktur Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('[entities]', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('[entities]');
    }
};
```

### Wajib Menggunakan
- **id()** untuk primary key
- **timestamps()** untuk created_at dan updated_at
- **softDeletes()** untuk soft delete
- **constrained()** untuk foreign keys
- **onDelete('cascade')** untuk cascade delete
- **nullable()** untuk optional fields
- **default()** untuk default values

---

## 10. ROUTE REQUIREMENTS

### Struktur Routes (routes/web.php)
```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('[entities]', [Entity]Controller::class);
    Route::get('[entities]/datatable', [Entity]Controller::class, 'datatable')
        ->name('[entities].datatable');
});
```

### Wajib Menggunakan
- **Resource routes** untuk CRUD operations
- **Middleware**: `auth`, `verified`
- **Named routes** untuk consistency
- **Route grouping** untuk related routes
- **Gate permission di route** dengan pola seperti modul user, contoh:
  ```php
  if (! auth()->user()?->can('umkm_create')) {
      abort(403, 'Unauthorized');
  }
  ```

---

## 11. AUTHORIZATION & PERMISSIONS

### Role-Based Access Control (RBAC)
```php
// Controller Middleware
public function __construct()
{
    $this->middleware('permission:[entity].index')->only('index');
    $this->middleware('permission:[entity].create')->only(['create', 'store']);
    $this->middleware('permission:[entity].edit')->only(['edit', 'update']);
    $this->middleware('permission:[entity].delete')->only('destroy');
}

// Blade Template
@can('[entity].create')
    <a href="{{ route('[entity].create') }}" class="btn btn-primary">
        <i class="ki-duotone ki-plus fs-2"></i>
        Tambah Data
    </a>
@endcan
```

### Permission Naming Convention
- **[entity].index** - View list
- **[entity].create** - Create new record
- **[entity].edit** - Edit existing record
- **[entity].delete** - Delete record
- **[entity].show** - View detail

---

## 12. SECURITY REQUIREMENTS

### Wajib Menggunakan
- **CSRF Protection**: `@csrf` pada semua form
- **XSS Protection**: Blade `{{ }}` untuk output escaping
- **SQL Injection**: Eloquent ORM dengan prepared statements
- **Input Sanitization**: Gunakan Elegant Sanitizer untuk input
- **File Upload**: Validasi file type, size, dan nama
- **Authentication**: Semua routes harus terautentikasi
- **Authorization**: Permissions untuk setiap aksi
- **Rate Limiting**: Untuk sensitive operations

---

## 13. RESPONSE STANDARDS

### Success Response (JSON)
```json
{
    "status": "success",
    "message": "Data berhasil disimpan",
    "data": {
        "id": 1,
        "name": "Example"
    }
}
```

### Error Response (JSON)
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "name": ["The name field is required."]
    }
}
```

### Flash Messages
- **Success**: `->with('success', 'Pesan sukses')`
- **Error**: `->with('error', 'Pesan error')`
- **Info**: `->with('info', 'Pesan info')`

---

## 14. TESTING REQUIREMENTS

### Unit Tests
```php
public function test_can_create_entity()
{
    $entity = [Entity]::factory()->create([
        'name' => 'Test Entity'
    ]);

    $this->assertDatabaseHas('[entities]', [
        'name' => 'Test Entity'
    ]);
}
```

### Feature Tests
```php
public function test_authenticated_user_can_access_index()
{
    $user = User::factory()->create();
    $user->givePermissionTo('[entity].index');

    $response = $this->actingAs($user)
                     ->get(route('[entity].index'));

    $response->assertStatus(200);
}
```

### Wajib Menggunakan
- **PHPUnit** untuk unit tests
- **Feature tests** untuk endpoints
- **Factory** untuk test data
- **Assertions** untuk validation
- **Coverage**: Minimum 70% untuk critical features

---

## 15. DOCUMENTATION REQUIREMENTS

### Code Comments
- Jelaskan logika kompleks
- Dokumentasikan dependencies
- Berikan contoh penggunaan untuk fungsi utama

### API Documentation
- Gunakan OpenAPI/Swagger untuk API endpoints
- Dokumentasikan semua request/response
- Sertakan contoh cURL atau Postman

---

## 16. GIT WORKFLOW

### Branch Naming
- `feature/[feature-name]` - Untuk fitur baru
- `bugfix/[bug-description]` - Untuk perbaikan bug
- `hotfix/[hotfix-description]` - Untuk perbaikan urgent di production

### Commit Messages
```
feat: add user export functionality
fix: resolve datatable pagination issue
docs: update API documentation
refactor: optimize query performance
test: add unit tests for user model
```

---

## 17. CODE QUALITY

### Wajib Menggunakan
- **Laravel Pint** untuk code formatting
- **PHPStan** untuk static analysis (opsional)
- **ESLint** untuk JavaScript (opsional)
- **Code review** sebelum merge

### Run Commands
```bash
# Format code
./vendor/bin/pint

# Run tests
php artisan test

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 18. PERFORMANCE REQUIREMENTS

### Database Optimization
- Gunakan **Eager Loading** untuk relationships
- Hindari **N+1 queries**
- Gunakan **indexes** untuk frequently queried columns
- Gunakan **pagination** untuk large datasets

### Frontend Optimization
- Lazy load images dan heavy assets
- Minify CSS dan JS (Vite otomatis)
- Gunakan browser caching
- Optimalkan DataTables untuk large datasets

---

## 19. CHECKLIST SEBELUM MERGE

- [ ] Code follows naming conventions
- [ ] All validations implemented
- [ ] Permissions and authorization applied
- [ ] XSS/CSRF protection in place
- [ ] Unit tests written and passing
- [ ] Feature tests written and passing
- [ ] Code formatted with Laravel Pint
- [ ] Documentation updated
- [ ] No console errors or warnings
- [ ] Tested on different browsers (Chrome, Firefox, Safari)
- [ ] Responsive design verified
- [ ] Performance acceptable (queries optimized)

---

## 20. COMMANDS UTAMA

```bash
# Create new resource
php artisan make:model Entity -mcr

# Create new controller
php artisan make:controller EntityController --resource

# Create new migration
php artisan make:migration create_entities_table

# Run migrations
php artisan migrate

# Create new seeder
php artisan make:seeder EntitySeeder

# Run seeders
php artisan db:seed

# Clear all caches
php artisan optimize:clear

# Build frontend assets
npm run build

# Watch frontend assets (development)
npm run dev

# Run tests
php artisan test

# Format code
./vendor/bin/pint
```

---

**Dokumen ini adalah standar baku untuk semua pengembangan fitur baru di project BoilerPlate Harma.**
**Pastikan untuk mengikuti semua requirement dan convention yang tercantum di atas.**
