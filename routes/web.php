<?php
use App\Events\WebSocketDemoEvent;
use App\Message;

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

Route::get('/', function () {
    broadcast(new WebSocketDemoEvent('some-data'));
    return view('welcome');
});
Route::get('/test',function(){
 \Illuminate\Support\Facades\Artisan::call('websocket:serve');
});
Route::get('paths',function(){
    exec('cd'.' '.base_path() .' && php artisan websocket:serve');
});
Route::get('chats','ChatsController@index');
Route::get('messages','ChatsController@fetchAll');
Route::post('messages','ChatsController@sendMessage');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test',function(){
    $message = Message::find(4);
    return $message->room;
});
Route::get('room/{id}','RoomController@index');
Route::post('/room','RoomController@sendMessage');
Route::get('/room-messages/{id}','RoomController@getRoomMessages');