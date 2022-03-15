
import VueRouter from 'vue-router';
import Home from './pages/Home.vue'
import Register from './pages/Register.vue'
import Login from './pages/Login.vue'
import Services from './pages/Services.vue'
import Blog from './pages/Blog.vue'
import Contact from './pages/Contact_us.vue'
import Feedback from './pages/Feedback.vue'
import Admin from './components/Admin.vue'
import Pleaselogin from './pages/pleaselogin.vue'
import Portfolio from './pages/Portfolio.vue'
import createuserpost from './pages/createuserpost.vue'
import Topicspost from './pages/Topicspost.vue'
import Messages from './admin/Messages.vue'
import NewFeedback from './pages/NewFeedback.vue'
import NewTopic from './pages/NewTopic.vue'
import RegisterUser from './pages/RegisterUser.vue'
import AdminQnA from './pages/Admin_QnA.vue'
import updatefeedback from './pages/updatefeedback.vue'
import Users from './pages/users.vue'
import updateuser from './pages/updateuser.vue'
import AdminFeedback from './pages/Admin_feedback.vue'
import AdminPortfolio from './pages/Admin_portfolio.vue'
import AdminHome from './pages/Admin_home.vue'
import NewPortfolio from './pages/NewPortfolio.vue'
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
import User_orders from './pages/User_orders.vue'
import Bloginfo from './pages/Bloginfo.vue'
import NewCollection from './pages/NewCollection.vue'
import Collections from './pages/Collections.vue'
import PaymentOptions from './pages/payment_options'
import DeliveryShipping from './pages/Deliveryshipping.vue'
import PortfolioAll from './pages/PortfolioAll.vue'
import Biography from './pages/Biography.vue'
import Purchases from './pages/Purchases.vue'
import AdminBlog from './pages/Admin_blog.vue'

const routes = [
    {
        path: '/admin_blog',
        name: 'admin_blog',
        component: AdminBlog,
        meta: {
            requiresAdminAuth: true,
        },
    },
    {
        path: '/purchases/:id',
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
        path: '/newcollection',
        name: 'newcollection',
        component: NewCollection,
        meta: {
            requiresAdminAuth: true,
        },
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
        path: '/user/:id',
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
        path: '/newportfolio',
        name: 'newportfolio',
        component: NewPortfolio,
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
        path: '/adminportfolio',
        name: 'adminportfolio',
        component: AdminPortfolio,
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

        path: '/user_orders/:id',
        name: 'user_orders',
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

