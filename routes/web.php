<?php

use Illuminate\Support\Facades\Route;
use App\Models\Transaction;
use App\Models\Order;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/*Route::get('/test', function(){

	$order = Order::with(['customer'])->where('id', 36)->first();
	if (is_object($order)) {
		$order_total = $order->total;
		$customer_id = $order->customer->id;
		$customer_wallet = $order->customer->total_fund;
		echo "order_total: ".$order_total; echo "<br>";
		echo "customer_id: ".$customer_id; echo "<br>";
		echo "customer_wallet: ".$customer_wallet; echo "<br>";
	}

	die('123');
});*/


//custom admin routes
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function() {
	Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);
	Route::resource('products', '\App\Http\Controllers\ProductController');
	Route::resource('categories', '\App\Http\Controllers\CategoryController');
	Route::resource('orders', '\App\Http\Controllers\OrderController');
	Route::resource('transactions', '\App\Http\Controllers\TransactionController');
	Route::resource('users', '\App\Http\Controllers\UserController');
	Route::resource('customers', '\App\Http\Controllers\CustomerController');
	Route::resource('pricelists', '\App\Http\Controllers\PricelistController');
	Route::resource('advance-payments', '\App\Http\Controllers\AdvancePaymentController');

	//Show
	Route::get('/orders/{id}/show', [App\Http\Controllers\OrderController::class, 'show']);
	Route::get('/customers/{id}/show', [App\Http\Controllers\CustomerController::class, 'show']);

	//http://127.0.0.1/csm/admin/customer-transactions?customer_id=85
	//http://127.0.0.1/csm/admin/customer-transactions/create?customer_id=85
	//http://127.0.0.1/csm/admin/customer-transactions/show?customer_id=85
	Route::resource('customer-transactions', '\App\Http\Controllers\CustomerTransactionController');


	
	Route::resource('groups', '\App\Http\Controllers\GroupController');
	Route::resource('members', '\App\Http\Controllers\MemberController');
	Route::resource('bcs', '\App\Http\Controllers\BcController');
	Route::resource('group-bc-relations', '\App\Http\Controllers\GroupBcRelationController');
	Route::resource('member-bc-plans', '\App\Http\Controllers\MemberBcPlanController');
	

	
	

});



Route::get('/orders/exportcsv', [App\Http\Controllers\OrderController::class, 'exportcsv']);
Route::get('/transactions/exportcsv', [App\Http\Controllers\TransactionController::class, 'exportcsv']);
Route::get('/pricelists/exportcsv', [App\Http\Controllers\PricelistController::class, 'exportcsv']);
Route::get('/customers/exportcsv', [App\Http\Controllers\CustomerController::class, 'exportcsv']);

//Ajax
Route::post('/orders/additem', [App\Http\Controllers\OrderController::class, 'additem']);
Route::post('/orders/searchitem', [App\Http\Controllers\OrderController::class, 'searchitem']);
Route::post('/orders/add_discount', [App\Http\Controllers\OrderController::class, 'add_discount']);
Route::post('/orders/remove_item', [App\Http\Controllers\OrderController::class, 'remove_item']);
Route::post('/orders/update_item_qty', [App\Http\Controllers\OrderController::class, 'update_item_qty']);
Route::post('/orders/calculate_order', [App\Http\Controllers\OrderController::class, 'calculate_order']);
Route::post('/orders/get_product_category', [App\Http\Controllers\OrderController::class, 'get_product_category']);
Route::post('/transactions/calculate_customer_balance', [App\Http\Controllers\TransactionController::class, 'calculate_customer_balance']);

//Bulk action delete
Route::post('/products/destroy_bulk', [App\Http\Controllers\ProductController::class, 'destroy_bulk']);
Route::post('/users/destroy_bulk', [App\Http\Controllers\UserController::class, 'destroy_bulk']);





/*
Make:
php artisan make:controller OrdersitemController --model=User
php artisan make:model CustomerTransaction -mcr
php artisan make:seeder CustomersTableSeeder
php artisan make:controller CustomerTransactionController --resource
php artisan make:migration create_{customer_balances}_table
php artisan make:migration create_customer_balances_table
php artisan make:model CustomerTransactionLog -m

Step 1:
php artisan key:generate
php artisan cache:clear //clear the view cache
php artisan config:clear //clear confige cache

Step 2:
php artisan migrate

Step 3:
php artisan db:seed --class=CustomersTableSeeder
php artisan db:seed --class=ProductsTableSeeder
php artisan db:seed --class=UsersTableSeeder



@csrf
@method('DELETE')
{{ csrf_field() }}

composer require laravelcollective/html

custom paginatation template
https://www.codecheef.org/article/laravel-7-custom-pagination-example-tutorial
{!! $customers->links() !!}



https://www.jhanley.com/laravel-redirecting-http-to-https/
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

php artisan make:middleware HttpRedirect
*/