    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\swalayanController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\LandingPageControllers;


    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "web" middleware group. Make something great!
    |
    */

    // Route::get('/', function () {
    //     return view('welcome');
    // });

    // Struktur routing laravel:
    // Route::httpMethod('/nama-path', [NamaController::class,'namaFunction])->nama('identitas-route')
    // Http Method:
    // 1. get -> mengambil data/menampilkan halaman
    // 2. post -> menambahkan data baru ke db
    // 3. patch/put -> mengubah data di db
    // 4. delete -> menghapus data di db
    // Route::get('/landing-page', [LandingPageControllers::class, 'index'])->name('landing_page');

    Route::middleware(['IsGuest'])->group(function(){
        Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
        Route::get('/', function () {
            return view('login');
        })->name('login');
    });

    Route::get('/error-permission', function () {
        return view('errors.permission');
    })->name('erorr.permission');

    Route::middleware(['IsLogin'])->group(function() {
        Route::get('/home', function (){
            return view('home');
        })->name('home.page');
    });

    //DIAKSES SEBELUM LOGIN
    // Route::post('/', [UserController::class, 'LandingPage'])->name('home');
    // Route::get('/login', [UserController::class, 'login'])->name('login');

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/home', function(){
        return view('home');
    })->name('home.page');


        Route::middleware(['IsLogin'])->group(function(){
            
        Route::middleware(['IsAdmin'])->group(function() {
            Route::prefix('/swalayan')->name('swalayan.')->group(function () {
                Route::get('/', [swalayanController::class, 'index'])->name('home');
                Route::get('/create', [swalayanController::class, 'create'])->name('create');
                Route::post('/store', [swalayanController::class, 'store'])->name('store');
                Route::get('/{id}', [swalayanController::class, 'edit'])->name('edit');
                Route::patch('/{id}', [swalayanController::class, 'update'])->name('update');
                Route::delete('/{id}', [swalayanController::class, 'destroy'])->name('delete');
                Route::get('/data/stock', [swalayanController::class, 'stock'])->name('stock');
                Route::get('/data/stock/{id}', [swalayanController::class, 'stockEdit'])->name('stock.edit');
                Route::patch('/data/stock/{id}', [swalayanController::class, 'stockUpdate'])->name('stock.update');
        
                // //routing fitur kelola akun
                // Route::prefix('/user')->name('user.')->group(function(){
                // });
            });
        
            Route::prefix('/user')->name('user.')->group(function () {
                Route::get('/users/create', [UserController::class, 'create'])->name('create');
                Route::post('/users', [UserController::class, 'store'])->name('store');
                Route::get('/users', [UserController::class, 'index'])->name('index');
                Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('edit');
                Route::patch('/users/{id}', [UserController::class, 'update'])->name('update');
                Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('delete');
            });
        
        });

        Route::middleware(['IsKasir'])->group(function(){
            Route::prefix('/kasir')->name('kasir.')->group(function(){
                Route::prefix('/order')->name('order.')->group(function(){
                Route::get('/', [OrderController::class, 'index'])->name('index');
                Route::get('/create', [OrderController::class, 'create'])->name('create');
                Route::post('/store', [OrderController::class, 'store'])->name('store');
                Route::get('/print{id}', [OrderController::class, 'show'])->name('print');
                });
            });
        });
    });


