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
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\PostGuzzleController;

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
    Route::post('/collection', [PortfolioController::class, 'newCollection']);
    Route::get('/collections', [PortfolioController::class, 'collections']);
    Route::delete('/messages/{id}', [ContactsController::class, 'destroy']); /// Deleting a message
     /// Information about a specific portfolio item
    Route::put('/portfolio/{id}', [PortfolioController::class, 'update']); /// User editing
    Route::get('/message/{specific_message}', [ContactsController::class, 'show']); /// Deleting a message
});
Route::put('/messages/{id}', [ContactsController::class, 'isRead']);; /// New message
Route::get('/painting_categories', [UtilityController::class, 'paintingCategories']);
///Owner and admin APIs
Route::group(['middleware' => ['auth:sanctum', 'role:1|2']], function () {
 Route::get('/purchases/all', [PurchasesController::class, 'index']);
    Route::delete('/topics/{id}', [QnAController::class, 'destroy_topic']); /// Information about a specific portfolio item
    Route::delete('/posts/{id}', [QnAController::class, 'destroy_post']); /// Information about a specific portfolio item
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy']); /// Deleting feedback
    Route::put('/feedback/{id}', [FeedbackController::class, 'feedbackedit']); /// Editing feedback
    Route::get('/sizes', [UtilityController::class, 'sizes']);
    Route::post('/sizes', [UtilityController::class, 'storeSize']);
    Route::delete('/sizes/{size}', [UtilityController::class, 'deleteSize']);
    Route::get('/orders', [OrderController::class, 'index']); /// Order list
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy']);
    Route::post('/painting_categories', [UtilityController::class, 'storePaintingCategory']);
    Route::delete('/painting_categories/{category}', [UtilityController::class, 'deletePaintingCategory']);
    Route::delete('/shops/{shop}', [ShopController::class, 'destroy']);
    Route::post('/orders/{order}/update', [OrderController::class, 'update']);
    Route::post('/shops/{shop}/update', [ShopController::class, 'update']);
    Route::post('/portfolios/{portfolio}/update', [PortfolioController::class, 'update']);
    Route::post('/blogs/{blog}/update', [BlogController::class, 'update']);
    Route::post('/purchases/{purchase}/update', [PurchasesController::class, 'update']);
    Route::post('/collections/{collection}/update', [PortfolioController::class, 'updateCollection']);
    Route::post('/users', [UserController::class, 'store']); /// New user
    Route::get('/users', [UserController::class, 'index']); /// User list
    Route::delete('/users/{id}', [UserController::class, 'destroy']); /// User deleting
    Route::delete('/portfolio/{id}', [PortfolioController::class, 'destroy']);
    Route::delete('/collection/{id}', [PortfolioController::class, 'destroyCollection']);
    Route::put('/users/{id}', [UserController::class, 'update']); /// User editing
    Route::post('/portfolio/digital/{currentPortfolio}', [PortfolioController::class, "newDigital"]);
    Route::get('/user/{id}/feedback', [UserController::class, 'userfeedback']); /// Users feedback
    Route::get('/user/{id}/posts', [UserController::class, 'userposts']); /// Users posts
    Route::get('/user/search/{name}', [UserController::class, 'user_search']); /// Search user by name
    Route::get('/admin/order/{id}', [OrderController::class, 'showAdminOrder']); /// Order list
});


///Owner, admin, user APIs
Route::group(['middleware' => ['auth:sanctum', 'role:1|2|3']], function () {
    Route::get('/purchases', [PurchasesController::class, 'userPurchases']);
    Route::get('/purchases/digital', [PurchasesController::class, 'userDigitalPurchases']);
    Route::get('/purchases/{specific_purchase}', [PurchasesController::class, 'show']); /// User list
    Route::get('/purchases/digital/{specific_purchase}', [PurchasesController::class, 'showDigital']); /// User list
    Route::get('/blog/search/{title}', [BlogController::class, 'blog_search ']);
    Route::post('/topics', [QnAController::class, 'newtopic']); /// Store a new topic to the database
    Route::get('/topic/post/{id}', [QnAController::class, 'display']); /// Store a new topic to the database
    Route::post('/posts', [QnAController::class, 'newpost']); /// Store a new post to the database
    Route::put('/topics/{id}', [QnAController::class, 'update_topic']); /// User editing
    Route::put('/posts/{id}', [QnAController::class, 'update_post']); /// User editing
    Route::post('/feedback', [FeedbackController::class, 'store']); /// New feedback
    Route::get('/users_orders',[OrderController::class,'show'] );
    Route::get('/users_paid_orders', [OrderController::class, 'showPaid']);
    Route::get('/order_messages/{order_messages}', [OrderController::class, 'getOrderMessages']);
    Route::post('/order_messages/{currentorder}', [OrderController::class, 'postOrderMessages']);
    Route::delete('/order_messages', [OrderController::class, 'delete_order_messages']);
    Route::get('order_messages/admin/{order_messages}', [OrderController::class, 'adminGetMessages']);
    Route::get('/topics/search/{topic_title}', [QnAController::class, 'topic_search']); /// topic search
    Route::put('/user/{id}', [UserController::class, 'updateuser']); /// User editing
    Route::post('/create-payment-session', [StripeController::class, 'createPaymentSession']);
    Route::post('/order/create-payment-session', [StripeController::class, 'createOrderPaymentSession']);
    Route::post('/portfolio/create-payment-session', [StripeController::class, 'createDigitalPaintingPaymentSession']);
    Route::post('/comment/{id}', [BlogController::class, 'newComment']);
    Route::get('/user/order/{id}', [OrderController::class, 'showOrder']); /// Order list
}); 

Route::get('/collection/portfolio/{id}', [PortfolioController::class, 'display']);
Route::get('/portinfo', [PortfolioController::class, 'create']); /// Feedback list
///Everyones APIs
Route::get('/store/{id}', [ShopController::class, 'show']);
Route::get('/portfolio/{id}', [PortfolioController::class, 'show']); /// User list
Route::get('/collection/{id}', [PortfolioController::class, 'specificCollection']); /// User list
Route::get('/blog/{id}', [BlogController::class, 'show']); /// User list
Route::get('blog/comments/{id}', [BlogController::class, 'showComments']);
Route::get('/blog_categories', [BlogController::class, 'blogCategories']);
Route::post('/blog_categories', [BlogController::class, 'newCategory']);
Route::get('/portfolios', [PortfolioController::class, 'fullPortfolio']);
Route::get('/collection/{id}', [PortfolioController::class, 'collection']);
Route::get('/canvases', [UtilityController::class, 'canvases']);
Route::post('/canvases', [UtilityController::class, 'storeCanvas']);
Route::delete('/canvases/{canvas}', [UtilityController::class, 'deleteCanvas']);
Route::get('/paints', [UtilityController::class, 'paints']);
Route::post('/paints', [UtilityController::class, 'storePaint']);
Route::delete('/paints/{paint}', [UtilityController::class, 'deletePaint']);

Route::post('/blogs', [BlogController::class, 'store']);
Route::delete('/blog_categories', [BlogController::class, 'delete_blog_categories']);


Route::get('/topic/{id}/post', [QnAController::class, 'topic_posts']); /// Returns a list of topics in a post
Route::get('/topics', [QnAController::class, 'topiclist']); /// Returns the list of topics
Route::get('/posts', [QnAController::class, 'postlist']); /// Returns the list of topics
Route::get('/feedback', [FeedbackController::class, 'index']); /// Feedback list
Route::post('/messages', [ContactsController::class, 'store']);; /// New message
Route::get('/portfolio/search/{name}', [PortfolioController::class, 'portfolio_search']); /// Search a work in the portfolio by its name
Route::get('/portfolio', [PortfolioController::class, 'index']); /// All of the portfolio items
Route::get('/feedback/{id}', [FeedbackController::class, 'feedback']); /// Feedback list
Route::get('/blog', [BlogController::class, 'index']);
//Route::get('/portfolio/{id}', [FeedbackController::class, 'portfolio']); /// Feedback list
Route::get('/order/{id}', [OrderController::class, 'order']); /// Order list
Route::delete('/order/{id}', [OrderController::class, 'destroy']); /// Deleting orders
Route::put('/order/{id}', [OrderController::class, 'orderedit']); /// Editing orders
Route::post('neworder', [OrderController::class, 'store']); /// New order


Route::get('/users/{id}', [UserController::class, 'show']); /// User list
Route::get('/user/{id}/orders', [OrderController::class, 'userorders']); /// Users feedback
Route::post('/shipping', [ShopController::class, 'createShipping']);
Route::get('/check/purchase/{purchase}/status', [ShopController::class, 'checkPurchase']);
Route::get('/check/order/{order}/status', [OrderController::class, 'checkOrderPurchase']);
Route::get('/check/digital/{digital}/status', [PortfolioController::class, 'checkDigitalPurchase']);
Route::post('/store', [ShopController::class, 'store']); /// New order
Route::get('/store', [ShopController::class, 'index']); /// Order list
Route::put('/store/{id}', [ShopController::class, 'storeedit']); /// Editing orders
Route::get('/collections', [PortfolioController::class, 'collections']);
Route::get('/all_sizes', [UtilityController::class, 'allSizes']);
Route::get('/all_paints', [UtilityController::class, 'allPaints']);
Route::get('/all_canvases', [UtilityController::class, 'allCanvases']);
Route::get('/all_painting_categories', [UtilityController::class, 'allPaintingCategories']);
Route::get('/coins/all', [PostGuzzleController::class, 'index']);
Route::post('/coins/store', [PostGuzzleController::class, 'storeCoin']);
///registration
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
///Token refresh
Route::middleware('auth:sanctum')->get("/refresh", [AuthController::class, 'refresh']);
