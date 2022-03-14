<template>
  <div>
    <Navbar />
    <router-link class="new_feedback" :to="{ name: 'neworder' }"
      >New Order!</router-link
    >
    <router-link
      class="item"
      :to="{
        name: 'user_orders',

        params: { id: currentUser.id },
      }"
      >My orders</router-link
    >

    <div class="row justify-content-center my-5">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">Account</div>
          <div class="card-body">
            <form action="#" @submit.prevent="updateUser">
              <div class="form-group">
                <label for="">User Name</label>
                <input
                  type="text"
                  class="form-control"
                  name="name"
                  placeholder="name"
                  v-model="name"
                />
              </div>
              <div class="form-group">
                <label for="">Email</label>
                <input
                  type="text"
                  class="form-control"
                  name="email"
                  placeholder="email"
                  v-model="email"
                />
              </div>

              <div class="row">
                <div class="col-md-6">
                  <button type="submit" id="show-btn" class="btn btn-primary">
                    Update
                  </button>
                </div>
                <div class="col-md-6">
                  <b-button
                    id="show-btn"
                    class="btn btn-danger"
                    @click="$bvModal.show('bv-modal-example')"
                    >Delete</b-button
                  >

                  <b-modal id="bv-modal-example" hide-footer>
                    <template #modal-title> Delete account </template>
                    <div class="d-block text-center">
                      <h3>Do you want to delete your account</h3>
                    </div>
                    <b-button
                      class="btn btn-primary mt-3"
                      block
                      @click="$bvModal.hide('bv-modal-example')"
                      >Cancel</b-button
                    >
                    <b-button
                      class="btn btn-danger mt-3"
                      block
                      @click="deleteUser($route.params.id)"
                      >delete</b-button
                    >
                  </b-modal>
                  <!-- <button
              type="submit"
              class="btn btn-danger "
              @click="deleteUser($route.params.id)"
            >
              Delete
            </button> -->
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    {{ id }}
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data() {
    return {
      currentUser: {},
      name: "",
      email: "",
      password: "",
      id: "",
      token: localStorage.getItem("token"),
    };
  },
  components: {
    Navbar,
  },
  methods: {
    updateUser() {
      axios
        .put(
          "/api/users/" + this.$route.params.id,
          {
            name: this.name,
            email: this.email,
          },
          {
            headers: {
              Authorization: "Bearer " + this.token,
            },
          }
        )
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteUser(id) {
      axios
        .delete("/api/user/" + id, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          console.log(response);
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your Account have been deleted",
            showConfirmButton: false,
            timer: 1500,
          });
          this.$router.push("/");
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    axios
      .get("/api/users/" + this.$route.params.id, {
        headers: {
          Authorization: "Bearer " + this.token,
        },
      })
      .then((response) => {
        const user = response.data;
        this.name = user.name;
        this.currentUser = response.data;
        this.email = user.email;
        console.log(user.email);
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style scoped>
</style>