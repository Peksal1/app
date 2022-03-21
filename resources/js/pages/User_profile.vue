<template>
  <div>
    <Navbar />
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active"
              >Dashboard</a
            >
            <router-link
              class="list-group-item list-group-item-action"
              :to="{ name: 'neworder' }"
              >New Order!</router-link
            >
            <router-link
              class="list-group-item list-group-item-action"
              :to="{
                name: 'user_orders',

                params: { id: currentUser.id },
              }"
              >My orders</router-link
            >
            <router-link
              class="list-group-item list-group-item-action"
              :to="{
                name: 'purchases',

                params: { id: currentUser.id },
              }"
              >My purchases</router-link
            >
          </div>
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h4>{{ currentUser.name }} {{ currentUser.surname }}</h4>
                  <hr />
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <form action="#" @submit.prevent="updateUser">
                    <div class="form-group row">
                      <label for="name" class="col-4 col-form-label"
                        >First Name</label
                      >
                      <div class="col-8">
                        <input
                          id="name"
                          name="name"
                          placeholder="name"
                          v-model="name"
                          class="form-control here"
                          type="text"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="lastname" class="col-4 col-form-label"
                        >Last Name</label
                      >
                      <div class="col-8">
                        <input
                          id="lastname"
                          name="lastname"
                          v-model="surname"
                          placeholder="Last Name"
                          class="form-control here"
                          type="text"
                        />
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="email" class="col-4 col-form-label"
                        >Email*</label
                      >
                      <div class="col-8">
                        <input
                          id="email"
                          name="email"
                          placeholder="Email"
                          class="form-control here"
                          required="required"
                          type="text"
                          v-model="email"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="name" class="col-4 col-form-label"
                        >Phone number</label
                      >
                      <div class="col-8">
                        <input
                          id="name"
                          name="name"
                          placeholder="Phone number"
                          v-model="name"
                          class="form-control here"
                          type="text"
                        />
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="newpass" class="col-4 col-form-label"
                        >New Password</label
                      >
                      <div class="col-8">
                        <input
                          id="newpass"
                          name="newpass"
                          placeholder="New Password"
                          class="form-control here"
                          type="text"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-4 col-8">
                        <button
                          name="submit"
                          type="submit"
                          id="show-btn"
                          class="btn btn-primary"
                        >
                          Update My Profile
                        </button>
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
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
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
      currentUser: {},
      name: "",
      surname: "",
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
        this.surname = user.surname;
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
.user-row {
  margin-bottom: 14px;
}

.user-row:last-child {
  margin-bottom: 0;
}

.dropdown-user {
  margin: 13px 0;
  padding: 5px;
  height: 100%;
}

.dropdown-user:hover {
  cursor: pointer;
}

.table-user-information > tbody > tr {
  border-top: 1px solid rgb(221, 221, 221);
}

.table-user-information > tbody > tr:first-child {
  border-top: 0;
}

.table-user-information > tbody > tr > td {
  border-top: 0;
}
.toppad {
  margin-top: 20px;
}
</style>