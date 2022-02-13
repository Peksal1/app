
import VueRouter from 'vue-router';
import Home from './pages/Home.vue'
import Register from './pages/Register.vue'
import Login from './pages/Login.vue'
import Services from './pages/Services.vue'
import Qna from './pages/Qna.vue'
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


const routes = [
    {
        path: '/orderlist',
        name: 'orderlist',
        component: OrderList,
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
        path: '/qna',
        name: 'qna',
        component: Qna,
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
        path: '/createuserpost/:id',
        name: 'createuserpost',
        component: createuserpost,
    },

]
const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

export default router;

