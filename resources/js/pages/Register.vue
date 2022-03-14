<template>
  <div class="container-fuiled">
    <Navbar />
    <div class="container">
      <div class="row">
        <div
          class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3"
        >
          <form role="form" action="#" @submit.prevent="validate">
            <h2>Please Sign Up <small>It's free and always will be.</small></h2>
            <hr class="colorgraph" />
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <input
                    type="text"
                    name="first_name"
                    id="first_name"
                    class="form-control input-lg"
                    placeholder="First Name"
                    tabindex="1"
                    required
                    v-model="formData.name"
                  />
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <input
                    type="text"
                    name="last_name"
                    id="last_name"
                    class="form-control input-lg"
                    placeholder="Last Name"
                    required
                    tabindex="2"
                  />
                </div>
              </div>
            </div>
            <div class="form-group">
              <input
                type="text"
                name="display_name"
                id="display_name"
                class="form-control input-lg"
                placeholder="Display Name"
                required
                tabindex="3"
              />
            </div>
            <div class="form-group">
              <input
                type="email"
                name="email"
                id="email"
                class="form-control input-lg"
                placeholder="Email Address"
                tabindex="4"
                required
                v-model="formData.email"
              />
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control input-lg"
                    placeholder="Password"
                    tabindex="5"
                    required
                    v-model="formData.password"
                  />
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control input-lg"
                    placeholder="Confirm Password"
                    tabindex="6"
                    required
                    v-model="formData.password_confirmation"
                  />
                </div>
                <div class="form-group">
                  <vue-recaptcha
                    @verify="register"
                    sitekey="6Lci1HQeAAAAANZzrDOXddaYziFVN3T8HhJftdW5"
                  ></vue-recaptcha>
                </div>
              </div>
            </div>
            <hr class="colorgraph" />
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <input
                  type="submit"
                  value="Register"
                  class="btn btn-primary btn-block btn-lg"
                  tabindex="7"
                />
              </div>
              <div class="col-xs-12 col-md-6">
                <router-link :to="{ name: 'login' }">
                  <a class="btn btn-success btn-block btn-lg"
                    >Login</a
                  ></router-link
                >
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- Modal -->
      <div
        class="modal fade"
        id="t_and_c_m"
        tabindex="-1"
        role="dialog"
        aria-labelledby="myModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-hidden="true"
              >
                ×
              </button>
              <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
            </div>
            <div class="modal-body">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Similique, itaque, modi, aliquam nostrum at sapiente
                consequuntur natus odio reiciendis perferendis rem nisi tempore
                possimus ipsa porro delectus quidem dolorem ad.
              </p>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Similique, itaque, modi, aliquam nostrum at sapiente
                consequuntur natus odio reiciendis perferendis rem nisi tempore
                possimus ipsa porro delectus quidem dolorem ad.
              </p>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Similique, itaque, modi, aliquam nostrum at sapiente
                consequuntur natus odio reiciendis perferendis rem nisi tempore
                possimus ipsa porro delectus quidem dolorem ad.
              </p>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Similique, itaque, modi, aliquam nostrum at sapiente
                consequuntur natus odio reiciendis perferendis rem nisi tempore
                possimus ipsa porro delectus quidem dolorem ad.
              </p>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Similique, itaque, modi, aliquam nostrum at sapiente
                consequuntur natus odio reiciendis perferendis rem nisi tempore
                possimus ipsa porro delectus quidem dolorem ad.
              </p>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Similique, itaque, modi, aliquam nostrum at sapiente
                consequuntur natus odio reiciendis perferendis rem nisi tempore
                possimus ipsa porro delectus quidem dolorem ad.
              </p>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Similique, itaque, modi, aliquam nostrum at sapiente
                consequuntur natus odio reiciendis perferendis rem nisi tempore
                possimus ipsa porro delectus quidem dolorem ad.
              </p>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
              >
                I Agree
              </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { VueRecaptcha } from "vue-recaptcha";

import Navbar from "../components/Navbar.vue";
export default {
  data() {
    return {
      formData: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        role: "1",
      },
      errors: {},
    };
  },
  components: {
    Navbar,
    VueRecaptcha,
  },
  methods: {
    validate() {
      this.$refs.recaptcha.execute();
    },

    register() {
      axios
        .post("/api/register", this.formData)
        .then((response) => {
          console.log(response.data);

          this.errors = {};
          var $statues = this.formData.role;
          console.log($statues);

          this.$router.push("/");

          this.$toaster.success("Account created");
        })
        .catch((errors) => {
          this.errors = errors.response.data.errors;
          console.log(errors.response.data.errors);
        });
    },
  },
};
</script>

<style scoped>
.colorgraph {
  height: 5px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(
    left,
    #c4e17f,
    #c4e17f 12.5%,
    #f7fdca 12.5%,
    #f7fdca 25%,
    #fecf71 25%,
    #fecf71 37.5%,
    #f0776c 37.5%,
    #f0776c 50%,
    #db9dbe 50%,
    #db9dbe 62.5%,
    #c49cde 62.5%,
    #c49cde 75%,
    #669ae1 75%,
    #669ae1 87.5%,
    #62c2e4 87.5%,
    #62c2e4
  );
  background-image: -moz-linear-gradient(
    left,
    #c4e17f,
    #c4e17f 12.5%,
    #f7fdca 12.5%,
    #f7fdca 25%,
    #fecf71 25%,
    #fecf71 37.5%,
    #f0776c 37.5%,
    #f0776c 50%,
    #db9dbe 50%,
    #db9dbe 62.5%,
    #c49cde 62.5%,
    #c49cde 75%,
    #669ae1 75%,
    #669ae1 87.5%,
    #62c2e4 87.5%,
    #62c2e4
  );
  background-image: -o-linear-gradient(
    left,
    #c4e17f,
    #c4e17f 12.5%,
    #f7fdca 12.5%,
    #f7fdca 25%,
    #fecf71 25%,
    #fecf71 37.5%,
    #f0776c 37.5%,
    #f0776c 50%,
    #db9dbe 50%,
    #db9dbe 62.5%,
    #c49cde 62.5%,
    #c49cde 75%,
    #669ae1 75%,
    #669ae1 87.5%,
    #62c2e4 87.5%,
    #62c2e4
  );
  background-image: linear-gradient(
    to right,
    #c4e17f,
    #c4e17f 12.5%,
    #f7fdca 12.5%,
    #f7fdca 25%,
    #fecf71 25%,
    #fecf71 37.5%,
    #f0776c 37.5%,
    #f0776c 50%,
    #db9dbe 50%,
    #db9dbe 62.5%,
    #c49cde 62.5%,
    #c49cde 75%,
    #669ae1 75%,
    #669ae1 87.5%,
    #62c2e4 87.5%,
    #62c2e4
  );
}
</style>