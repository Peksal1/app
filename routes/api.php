<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QnAController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

///Owner only APIs
Route::group(['middleware' => ['auth:sanctum', 'role:1']], function () {
    Route::post('/portfolio', [PortfolioController::class, 'store']); /// Store a new item to the portfolio
    Route::get('/messages', [ContactsController::class, 'index']); /// Message list
    Route::post('/collection', [PortfolioController::class, 'new_collection']);
    Route::delete('/messages/{id}', [ContactsController::class, 'destroy']); /// Deleting a message
    Route::delete('/portfolio/{id}', [PortfolioController::class, 'destroy']); /// Information about a specific portfolio item
    Route::put('/portfolio/{id}', [PortfolioController::class, 'update']); /// User editing
});

///Owner and admin APIs
Route::group(['middleware' => ['auth:sanctum', 'role:1|2']], function () {

    Route::delete('/topics/{id}', [QnAController::class, 'destroy_topic']); /// Information about a specific portfolio item
    Route::delete('/posts/{id}', [QnAController::class, 'destroy_post']); /// Information about a specific portfolio item
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy']); /// Deleting feedback
    Route::put('/feedback/{id}', [FeedbackController::class, 'feedbackedit']); /// Editing feedback

    Route::post('/users', [UserController::class, 'store']); /// New user
    Route::get('/users', [UserController::class, 'index']); /// User list
    Route::delete('/users/{id}', [UserController::class, 'destroy']); /// User deleting
    Route::put('/users/{id}', [UserController::class, 'update']); /// User editing
    Route::get('/user/{id}/feedback', [UserController::class, 'userfeedback']); /// Users feedback
    Route::get('/user/{id}/posts', [UserController::class, 'userposts']); /// Users posts
    Route::get('/user/search/{name}', [UserController::class, 'user_search']); /// Search user by name
});


///Owner, admin, user APIs
Route::group(['middleware' => ['auth:sanctum', 'role:1|2|3']], function () {
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::get('/bloginfo', [BlogController::class, 'show']);
    Route::get('/blog/search/{title}', [BlogController::class, 'blog_search ']);
    Route::post('/topics', [QnAController::class, 'newtopic']); /// Store a new topic to the database
    Route::get('/topic/post/{id}', [QnAController::class, 'display']); /// Store a new topic to the database
    Route::post('/posts', [QnAController::class, 'newpost']); /// Store a new post to the database
    Route::put('/topics/{id}', [QnAController::class, 'update_topic']); /// User editing
    Route::put('/posts/{id}', [QnAController::class, 'update_post']); /// User editing
    Route::post('/feedback', [FeedbackController::class, 'store']); /// New feedback
    Route::get('/topics/search/{topic_title}', [QnAController::class, 'topic_search']); /// topic search
    Route::put('/user/{id}', [UserController::class, 'updateuser']); /// User editing
    Route::post('/create-payment-session', [StripeController::class, 'createPaymentSession']);
    
});

///Everyones APIs
Route::get('/topic/{id}/post', [QnAController::class, 'topic_posts']); /// Returns a list of topics in a post
Route::get('/topics', [QnAController::class, 'topiclist']); /// Returns the list of topics
Route::get('/posts', [QnAController::class, 'postlist']); /// Returns the list of topics
Route::get('/feedback', [FeedbackController::class, 'index']); /// Feedback list
Route::post('/messages', [ContactsController::class, 'store']);; /// New message
Route::get('/portfolio/search/{name}', [PortfolioController::class, 'portfolio_search']); /// Search a work in the portfolio by its name
Route::get('/portfolio', [PortfolioController::class, 'index']); /// All of the portfolio items
Route::get('/feedback/{id}', [FeedbackController::class, 'feedback']); /// Feedback list
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/portfolio/{id}', [FeedbackController::class, 'portfolio']); /// Feedback list
Route::get('/order/{id}', [OrderController::class, 'order']); /// Order list
Route::delete('/order/{id}', [OrderController::class, 'destroy']); /// Deleting orders
Route::put('/order/{id}', [OrderController::class, 'orderedit']); /// Editing orders
Route::post('neworder', [OrderController::class, 'store']); /// New order
Route::get('/orders', [OrderController::class, 'index']); /// Order list
Route::get('/orders/{id}',[OrderController::class,'show'] );
Route::get('/users/{id}', [UserController::class, 'show']); /// User list
Route::get('/user/{id}/orders', [OrderController::class, 'userorders']); /// Users feedback
Route::post('/shipping', [ShopController::class, 'create_shipping']);
Route::post('/store', [ShopController::class, 'store']); /// New order
Route::get('/store', [ShopController::class, 'index']); /// Order list
Route::put('/store/{id}', [ShopController::class, 'storeedit']); /// Editing orders
///registration
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
///Token refresh
Route::middleware('auth:sanctum')->get("/refresh", [AuthController::class, 'refresh']);
