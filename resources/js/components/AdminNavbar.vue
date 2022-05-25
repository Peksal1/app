<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
      <b-navbar-brand href="#">Ilja Laurs website</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>

          <b-nav-item class="item">
            <router-link class="col" :to="{ name: 'adminhome' }">Home</router-link>
          </b-nav-item>
          <b-nav-item class="item">
            <router-link class="col" :to="{ name: 'admincollections' }">Portfolio</router-link>
          </b-nav-item>
          <b-nav-item class="item">
            <router-link class="col" :to="{ name: 'admin_blog' }">Blog</router-link>
          </b-nav-item>
          <b-nav-item class="item">
            <router-link class="col" :to="{ name: 'users' }">User list</router-link>
          </b-nav-item>
          <b-nav-item class="item">
            <router-link class="col" :to="{ name: 'messages' }">Messages</router-link>
          </b-nav-item>
          <b-nav-item class="item">
            <router-link class="col" :to="{ name: 'orderlist' }">Orders</router-link>
          </b-nav-item>
          <b-nav-item class="item">
            <router-link class="col" :to="{ name: 'admin_store' }">For sale</router-link>
          </b-nav-item>
          <b-nav-item class="item">
            <router-link class="col" :to="{ name: 'admin_faq' }">FAQ</router-link>
          </b-nav-item>
          <b-nav-item class="item">
            <router-link class="col" :to="{ name: 'purchases/manage' }">Purchases</router-link>
          </b-nav-item>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <!-- Using 'button-content' slot -->

          <b-navbar-nav v-if="!isLoggedIn && !loading">
            <b-nav-item class="item">
              <router-link class="col" :to="{ name: 'register' }">Register</router-link>
            </b-nav-item>
            <b-nav-item class="item">
              <router-link class="col" :to="{ name: 'login' }">Login</router-link>
            </b-nav-item>
          </b-navbar-nav>

          <b-nav-item-dropdown class="profileMenu" :text="currentUser.name" right v-if="isLoggedIn && !loading">
            <b-dropdown-item>
              <router-link class="item" :to="{
                name: 'userprofile',
                params: { id: currentUser.id },
              }">
                <v-icon large text color="teal darken-2">
                  mdi-account-circle </v-icon>Account
              </router-link>
              <br />
              <br />
              <button class="btn btn-danger" @click="logout">Logout</button>
            </b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      currentUser: {},
      token: localStorage.getItem("token"),
      isLoggedIn: false,
      loading: true,
    };
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
          console.log(response.data.id);
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
              Authorization: "Bearer " + this.adminToken,
            },
          }
        )
        .then((response) => {
          console.log(response);
          localStorage.removeItem("token");
          localStorage.removeItem("adminToken");
          this.isLoggedIn = false;
          this.$router.push("/");
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
    console.log(this.isLoggedIn);
  },
  watch: {
    $route(to, from) {
      this.checkLoginStatus();
    },
  },
};
</script>

<style scope>
.logoimage {
  margin-left: 4rem;
}

.nav-link {
  color: white !important;
  font-size: 1.4rem;
  font-family: "Source Sans Pro", sans-serif;
  font-style: italic;
  font-weight: 600;
}

.col {
  color: white !important;
  text-decoration: none !important;
}

.col:hover {
  color: #fca504 !important;
}

.pages {
  margin-left: 70%;
}

.nav {
  border-color: coral;
}

.v-tab {
  text-transform: none;
}
</style>