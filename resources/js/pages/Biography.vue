<template>
  <div class="container-fuiled">
    <Navbar />
    <body>
      <div class="about-section">
        <div class="inner-container">
          <h1>About Us</h1>
          <p class="text">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus
            velit ducimus, enim inventore earum, eligendi nostrum pariatur
            necessitatibus eius dicta a voluptates sit deleniti autem error eos
            totam nisi neque voluptates sit deleniti autem error eos totam nisi
            neque.
          </p>
          <div class="skills">
            <span class="active">Web Design</span>
            <span>Pro Develpor</span>
            <span>Android Develpor</span>
          </div>
        </div>
      </div>
    </body>
  </div>
</template>
<script>
import Navbar from "../components/Navbar.vue";
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
  components: {
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
            },
          }
        )
        .then((response) => {
          console.log(response);
          localStorage.removeItem("token");
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

<style scoped>
.rightimg {
  float: right;
  margin: 7px 0 7px 7px;
}
.container-fuiled {
  background: #343a40;
  color: white;
  font-family: "Nunito" !important;
}
h2 {
  color: #fca504;
  margin-left: 10px;
}
.line {
  color: white !important;
}
</style>