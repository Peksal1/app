<template>
  <div>
    <Navbar />
    <div class="body">
      <div class="container">
        <div class="row">
          <div class="col-md-offset-5 col-md-4 text-center">
            <div class="form-login">
              <h4>Secure Login</h4>
              <form action="#" @submit.prevent="login">
                <input type="text" id="email" class="form-control input-sm chat-input" placeholder="email"
                  v-model="formData.email" />

                <input type="password" id="userPassword" class="form-control input-sm chat-input" placeholder="password"
                  v-model="formData.password" />
                <div class="wrapper">
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">login</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data() {
    return {
      formData: {
        email: "",
        password: "",
      },
      errors: {},
    };
  },
  components: {
    Navbar,
  },
  methods: {
    login() {
      axios
        .post("api/login", this.formData)
        .then((response) => {
          const token = response.data.token;
          localStorage.setItem("token", token);
          axios
            .get("/api/user", {
              headers: {
                Authorization: "Bearer " + token,
              },
            })
            .then((response) => {
              if (response.data.role == "3") {
                this.$router.push({
                  path: "/",
                  params: response.data,
                });
              } else {
                localStorage.setItem("adminToken", token);
                this.$router.push({
                  path: "/admin",
                  params: response.data,
                });
              }
            });
        })
        .catch((errors) => {
          this.errors = errors.response.data.errors;
        });
    },
  },
};
</script>


<style scoped>
.body {
  background-image: url("https://scontent-dub4-1.xx.fbcdn.net/v/t1.6435-9/139445257_101736648576494_1094957703595214905_n.jpg?_nc_cat=101&ccb=1-5&_nc_sid=e3f864&_nc_ohc=8Wn3FpWWo2cAX__vJ-o&_nc_ht=scontent-dub4-1.xx&oh=00_AT9l5iq1ld6_YHI1JZXddGbPwIPyeavodcFsglywoivh8w&oe=62537A45");
  background-position: center;
  background-size: cover;

  -webkit-font-smoothing: antialiased;
  font: normal 14px Roboto, arial, sans-serif;
  font-family: "Dancing Script", cursive !important;
}

.container {
  padding: 110px;
}

::placeholder {
  /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #ffffff !important;
  opacity: 1;
  /* Firefox */
  font-size: 18px !important;
}

.form-login {
  background-color: rgba(0, 0, 0, 0.55);
  padding-top: 10px;
  padding-bottom: 20px;
  padding-left: 20px;
  padding-right: 20px;
  border-radius: 15px;
  border-color: #d2d2d2;
  border-width: 5px;
  color: white;
  box-shadow: 0 1px 0 #cfcfcf;
}

.form-control {
  background: transparent !important;
  color: white !important;
  font-size: 18px !important;
}

h1 {
  color: white !important;
}

h4 {
  border: 0 solid #fff;
  border-bottom-width: 1px;
  padding-bottom: 10px;
  text-align: center;
}

.form-control {
  border-radius: 10px;
}

.text-white {
  color: white !important;
}

.wrapper {
  text-align: center;
}

.footer p {
  font-size: 18px;
}
</style>