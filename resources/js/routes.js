
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

const routes = [
    {
        path:'/deliveryshipping',
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
    },
    {
        path: '/store',
        name: 'store',
        component: Store,
    },
    {
        path: '/thank-you',
        name: 'store',
        component: ThankYou,
    },
    {
        path: '/orderlist',
        name: 'orderlist',
        component: OrderList,
        meta: {
            requiresAuth: true,
            requiresAdminAuth: true,
        },
    },
    {
        path: '/neworder',
        name: 'neworder',
        component: NewOrder,
    },
    {
        path: '/user/:id',
        name: 'userprofile',
        component: UserProfile,
    },
    {
        path: '/adminnewpost/:id',
        name: 'adminnewpost',
        component: AdminNewPost,
    },
    {
        path: '/adminnewtopic',
        name: '/adminnewtopic',
        component: AdminNewTopic
    },
    {
        path: '/updatetopic/:id',
        name: 'updatetopic',
        component: UpdateTopic
    },
    {
        path: '/updateportfolio/:id',
        name: 'updateportfolio',
        component: UpdatePortfolio
    },
    {
        path: '/admintopicsposts/:id',
        name: 'admintopicsposts',
        component: AdminTopicPosts
    },
    {
        path: '/newportfolio',
        name: 'newportfolio',
        component: NewPortfolio
    },
    {
        path: '/adminhome',
        name: 'adminhome',
        component: AdminHome
    },
    {
        path: '/adminportfolio',
        name: 'adminportfolio',
        component: AdminPortfolio
    },
    {
        path: '/adminfeedback',
        name: 'adminfeedback',
        component: AdminFeedback
    },
    {
        path: '/updateuser/:id',
        name: 'updateuser',
        component: updateuser
    },
    {
        path: '/users',
        name: 'users',
        component: Users
    },
    {
        path: '/updatefeedback/:id',
        name: 'updatefeedback',
        component: updatefeedback
    },
    {
        path: '/adminqna',
        name: 'adminqna',
        component: AdminQnA
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
        component: NewTopic
    },
    {
        path: '/newfeedback',
        name: 'newfeedback',
        component: NewFeedback
    },
    {
        path: '/messages',
        name: 'messages',
        component: Messages
    },
    {
        path: '/portfolio',
        name: 'portfolio',
        component: Portfolio
    },
    {
        path: '/pleaselogin',
        name: 'pleaselogin',
        component: Pleaselogin
    },
    {
        path: '/admin',
        name: 'admin',
        component: Admin
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
        path: '/service',
        name: 'service',
        component: Services,
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

        path:'/user_orders/:id',
        name:'user_orders',
        component: User_orders,
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


export default router;

