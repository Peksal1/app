<template>
  <div class="container-fuiled">
    <Navbar />

    <div>
      <router-link class="addtopic" :to="{ name: 'createuserpost', params: { id: this.$route.params.id } }">Post your
        message here!</router-link>
    </div>

    <div class="subforum-row" v-for="post in posts" v-bind:key="post.id">
      <div class="subforum-icon subforum-column center">
        <img src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg"
          style="width: 45px; height: 45px; margin-right: 25px" />
      </div>
      <div class="subforum-description subforum-column">
        <p>{{ post.post_text }}</p>
      </div>
      <div class="subform-stats subforum-column center">
        <span>24 posts and 15 topics</span>
      </div>
      <div class="subforum-info subforum-column">
        <b><a href="">Created</a></b> by <a href="">{{ post.user_id }}</a>
        <br />
        on <small>{{ post.created_at }} </small>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data: function () {
    return {
      posts: [],
      currentUser: {},
      isLoggedIn: false,
      token: localStorage.getItem("token"),
    };
  },
  components: {
    Navbar,
  },

  methods: {
    loadUsers() {
      axios
        .get("/api/topic/post/" + this.$route.params.id, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.isLoggedIn = false;
          ///    this.appointments=response.data.data
          this.posts = response.data;
          ///    console.log(response.data);
        })
        .catch((error) => {
          console.log(error.message);
        });
    },

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
          console.log(this.currentUser.name);
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
  },
  created() { },

  mounted() {
    this.checkLoginStatus();
    this.loadUsers();
  },
};
</script>

 <style scoped>
* {
  box-sizing: border-box;
}

.search {
  text-align: right;
}

.bland {
  font-size: 60px;
  color: #ffa309;
  font-family: "Queen of Camelot" !important;
  margin-left: 40px;
}

.home {
  font-size: 30px;
  font-family: "Queen of Camelot" !important;
  text-align: center;
}

.addtopic {
  color: #ffa309;
  text-align: right;
  font-size: 24px;
}

html {
  font-size: 14px;
  font-family: "Titillium Web", sans-serif;
  background-color: #151426;
  color: #fefefe;
}

a {
  color: #ffa309;
  font-weight: bolder;
  text-decoration: none;
}

h1 {
  font-size: 16px;
  font-weight: bolder;
}

/* ########################################### */
/*           Forums.html                       */
/* ########################################### */
.container {
  margin: 20px;
  padding: 20px;
}

.subforum {
  margin-top: 20px;
}

.subforum-title {
  background-color: #292b2e;
  padding: 5px;
  border-radius: 5px;
  margin: 4px;
  color: white;
}

.subforum-row {
  display: grid;
  grid-template-columns: 7% 60% 13% 20%;
}

.subforum-column {
  padding: 10px;
  margin: 4px;
  border-radius: 5px;
  background-color: #111314;
}

.subforum-description * {
  margin-block: 0;
}

.center {
  display: flex;
  justify-content: center;
  align-items: center;
}

.subforum-icon i {
  font-size: 45px;
}

.subforum-devider {
  display: none;
}
</style>