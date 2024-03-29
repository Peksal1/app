
import VueRouter from 'vue-router';
import Home from './pages/Home.vue'
import Register from './pages/Register.vue'
import Login from './pages/Login.vue'
import Blog from './pages/Blog.vue'
import Contact from './pages/Contact_us.vue'
import Feedback from './pages/Feedback.vue'
import Admin from './components/Admin.vue'
import Pleaselogin from './pages/pleaselogin.vue'
import Portfolio from './pages/Portfolio.vue'
import createuserpost from './pages/createuserpost.vue'
import Topicspost from './pages/Topicspost.vue'
import Messages from './admin/Messages.vue'
import AdminPurchases from './admin/Admin_purchases.vue'
import NewFeedback from './pages/NewFeedback.vue'
import NewTopic from './pages/NewTopic.vue'
import RegisterUser from './pages/RegisterUser.vue'
import AdminQnA from './pages/Admin_QnA.vue'
import updatefeedback from './pages/updatefeedback.vue'
import Users from './admin/users.vue'
import updateuser from './pages/updateuser.vue'
import AdminFeedback from './admin/Admin_feedback.vue'
import AdminCollections from './admin/Admin_collections.vue'
import AdminHome from './admin/Admin_home.vue'
import AdminTopicPosts from './pages/Admin_topicsposts.vue'
import UpdatePortfolio from './pages/updateportfolio.vue'
import UpdateTopic from './pages/updatetopic.vue'
import AdminNewPost from './pages/Admin_newpost.vue'
import AdminNewTopic from './pages/Admin_newtopic.vue'
import UserProfile from './pages/User_profile.vue'
import NewOrder from './pages/NewOrder.vue'
import OrderList from './pages/orderlist.vue'
import Store from './pages/Store.vue'
import NewStore from './pages/new_store.vue'
import FAQ from './pages/FAQ.vue'
import ThankYou from './pages/ThankYou.vue'
import OrderThankYou from './pages/OrderThankYou.vue'
import User_orders from './pages/User_orders.vue'
import Bloginfo from './pages/Bloginfo.vue'
import Collections from './pages/Collections.vue'
import PaymentOptions from './pages/payment_options'
import DeliveryShipping from './pages/Deliveryshipping.vue'
import PortfolioAll from './pages/PortfolioAll.vue'
import Biography from './pages/Biography.vue'
import Purchases from './pages/Purchases.vue'
import AdminBlog from './admin/Admin_blog.vue'
import AdminStore from './admin/AdminStore.vue'
import AdminFAQ from './admin/Admin_FAQ.vue'
import DigitalThankYou from './pages/DigitalThankYou.vue'
import DigitalPurchases from './pages/DigitalPurchases.vue'
import AdminPaintings from './admin/Admin_paintings.vue'
import Coins from './pages/coins.vue'

const routes = [
    {
        path: '/coins',
        name: 'coins',
        component: Coins,
    },
    {
        path: '/portfolio/admin',
        name: 'portfolio/admin',
        component: AdminPaintings,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/purchases/digital',
        name: 'purchases/digital',
        component: DigitalPurchases,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/admin_faq',
        name: 'admin_faq',
        component: AdminFAQ,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/admin_store',
        name: 'admin_store',
        component: AdminStore,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/admin_blog',
        name: 'admin_blog',
        component: AdminBlog,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/purchases',
        name: 'purchases',
        component: Purchases,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/biography',
        name: 'biography',
        component: Biography,
    },

    {
        path: '/portfolio/all',
        name: 'portfolio/all',
        component: PortfolioAll,
    },

    {
        path: '/deliveryshipping',
        name: 'deliveryshipping',
        component: DeliveryShipping,
    },
    {
        path: '/paymentoptions',
        name: 'paymentoptions',
        component: PaymentOptions,
    },
    {
        path: '/collections',
        name: 'collections',
        component: Collections,
    },

    {
        path: '/faq',
        name: 'faq',
        component: FAQ,
    },
    {
        path: '/newstore',
        name: 'newstore',
        component: NewStore,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/store',
        name: 'store',
        component: Store,
    },
    {
        path: '/thank-you',
        name: 'thank-you',
        component: ThankYou,
    },
    {
        path: '/order/thank-you',
        name: 'order-thank-you',
        component: OrderThankYou,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/digital/thank-you',
        name: 'digital-thank-you',
        component: DigitalThankYou,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/orderlist',
        name: 'orderlist',
        component: OrderList,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/neworder',
        name: 'neworder',
        component: NewOrder,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/user',
        name: 'userprofile',
        component: UserProfile,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/adminnewpost/:id',
        name: 'adminnewpost',
        component: AdminNewPost,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/adminnewtopic',
        name: '/adminnewtopic',
        component: AdminNewTopic,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/updatetopic/:id',
        name: 'updatetopic',
        component: UpdateTopic,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/updateportfolio/:id',
        name: 'updateportfolio',
        component: UpdatePortfolio,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/admintopicsposts/:id',
        name: 'admintopicsposts',
        component: AdminTopicPosts,
        meta: {
            requiresAdminAuth: true,
        },
    },

    {
        path: '/adminhome',
        name: 'adminhome',
        component: AdminHome,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/admincollections',
        name: 'admincollections',
        component: AdminCollections,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/adminfeedback',
        name: 'adminfeedback',
        component: AdminFeedback,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/updateuser/:id',
        name: 'updateuser',
        component: updateuser,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/users',
        name: 'users',
        component: Users,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/updatefeedback/:id',
        name: 'updatefeedback',
        component: updatefeedback,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/adminqna',
        name: 'adminqna',
        component: AdminQnA,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/registeruser',
        name: 'registeruser',
        component: RegisterUser
    },
    {
        path: '/newtopic',
        name: '/newtopic',
        component: NewTopic,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/newfeedback',
        name: 'newfeedback',
        component: NewFeedback
    },
    {
        path: '/messages',
        name: 'messages',
        component: Messages,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/purchases/manage',
        name: 'purchases/manage',
        component: AdminPurchases,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/portfolio/:id',
        name: 'portfolio',
        component: Portfolio,
    },
    {
        path: '/pleaselogin',
        name: 'pleaselogin',
        component: Pleaselogin
    },
    {
        path: '/admin',
        name: 'admin',
        component: Admin,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/feedback',
        name: 'feedback',
        component: Feedback,
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/blog',
        name: 'blog',
        component: Blog,
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact,
    },
    {
        path: '/Topicspost/:id',
        name: 'Topicspost',
        component: Topicspost,
    },
    {
        path: '/Bloginfo/:id',
        name: 'Bloginfo',
        component: Bloginfo,
    },

    {

        path: '/orders',
        name: 'orders',
        component: User_orders,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/createuserpost/:id',
        name: 'createuserpost',
        component: createuserpost,
    },

]
const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

// check if user is authenticated
router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAdminAuth)) {
        if (localStorage.getItem("adminToken") != null) {
            next();
        } else {
            next("/");
        }

    } else {
        next();
    }
});
router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (localStorage.getItem("token") != null) {
            next();
        } else {
            next("/");
        }

    } else {
        next();
    }
});

export default router;

