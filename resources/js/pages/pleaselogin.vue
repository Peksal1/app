<template>
<div class="container-fuiled">


     <Navbar />
  <h1>You need to be logged in to see this page.</h1>
         <v-button class="item"
              ><router-link class="button" :to="{ name: 'register' }"
                >Register</router-link
              >
            </v-button>
                   <v-button class="item"
              ><router-link class="button" :to="{ name: 'login' }"
                >Already have an account?</router-link
              >
            </v-button>
  </div>

  </template>

<script>
import Navbar from '../components/Navbar.vue';
export default {
  data() {
    return {
      currentUser: {},
      token: localStorage.getItem("token"),
      isLoggedIn: false,
      loading: true,
    };
  },
    components:{
    Navbar,
    },
  methods: {
    checkLoginStatus() {
      this.loading = true;
      // this.loading = true
      axios
        .get("/api/user", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.currentUser = response.data;
          console.log("LOGGED IN");
          this.isLoggedIn = true;
		  console.log( response.data.id)
        })
        .catch((errors) => {
          console.log(errors);
          this.isLoggedIn = false;
        })
        .finally(() => {
          this.loading = false;
        });
      // this.loading = false
    },
    
    logout() {
      axios
        .post(
          "api/logout",
          {},
          {
            headers: {
              Authorization: "Bearer " + this.token,
            },
          }
        )
        .then((response) => {
          console.log(response);
          localStorage.removeItem("token");
          this.isLoggedIn = false;
		  this.$router.push('/')
        })
        .catch((errors) => {
          console.log("it is not working");
          console.log(errors);
        });
    },
  },
  mounted() {
    //  axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    this.checkLoginStatus();
  },
  updated() {
	  console.log(this.isLoggedIn)
  },
  watch: {
	  $route(to, from) {
		  this.checkLoginStatus();
	  }
  }
};
</script>

<style scoped>
   .rightimg  {
    float: right;
    margin: 7px 0 7px 7px;
   }
.container-fuiled {
  background:#343a40;
  color:white;
}
h2 {
   color:#fca504;
   margin-left:10px;
}
.line {
  color:white !important;
}
</style>