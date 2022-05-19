<template>
  <div class="container-fuiled">
    <AdminNavbar />

    <div class="btn btn-sm btn-primary" @click="openUserModal">
      Register a new user
    </div>

    <div class="container">
      <div class="row">
        <h2>Registered User List</h2>
        <div class="container d-flex justify-content-center mt-5 p-4">
          <div class="input-group mb-3">
            <input v-model="searchKeyword" type="text" class="form-control" />
            <div class="input-group-append">
              <button @click="loadUsers" class="btn btn-primary">Search</button>
            </div>
          </div>
        </div>
        <div class="searchable-container">
          <div class="items col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix" v-for="user in users" v-bind:key="user.id">
            <div class="info-block block-info clearfix">
              <div class="square-box pull-left">
                <span class="glyphicon glyphicon-user glyphicon-lg"></span>
              </div>
              <h5>Role : {{ user.role }}</h5>
              <h4>Name: {{ user.name }} {{ user.surname }}</h4>
              <p>NickName: {{ user.display_name }}</p>
              Contacts:
              <br />
              <span>Phone number: {{ user.phone_number }}</span>
              <br />
              <span>Email: {{ user.email }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 text-center center-pagination">
        <Pagination :pagination="pagination" @perPage="loadUsers()" @paginate="loadUsers()" :offset="6">
        </Pagination>
      </div>
    </div>
    <div class="modal" :class="{ show: showUserModal }" id="userModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Register a new user:
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideUserModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="registerUser">
              <div class="form-group">
                <label for="">Name</label>
                <input v-model="userForm.name" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Surname</label>
                <input v-model="userForm.surname" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Display name: </label>
                <input v-model="userForm.display_name" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Phone number:</label>
                <input v-model="userForm.phone_number" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Email:</label>
                <input v-model="userForm.email" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Role:</label>
                <input v-model="userForm.role" :options="options" type="text" required class="form-control" />
              </div>
              <div class="form-group">
                <label for="">Password:</label>
                <input v-model="userForm.password" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Conform the password:</label>
                <input v-model="userForm.password_confirmation" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary btn-block" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Pagination from "../components/Pagination.vue";
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
export default {
  data: function () {
    return {
      users: [],
      userForm: {
        name: "",
        surname: "",
        role: "",
        password_confirmation: "",
        display_name: "",
        phone_number: "",
        email: "",
        password: "",
      },
      searchKeyword: "",
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      showUserModal: false,
      options: [{ text: "Select One", value: null }, "1", "2", "3"],
      isLoggedIn: false,
      adminToken: localStorage.getItem("adminToken"),
    };
  },
  components: {
    AdminNavbar,
    Pagination,
  },
  methods: {
    openUserModal() {
      this.showUserModal = true;
    },
    hideUserModal() {
      this.showUserModal = false;
    },
    registerUser() {
      axios
        .post("/api/register", this.userForm)
        .then((response) => {
          this.loadUsers();
          this.userForm = {
            name: "",
            surname: "",
            email: "",
            passowrd: "",
            role: "",
            password_confirmation: "",
            phone_number: "",
            display_name: "",
          };
          this.hideUserModal();
          alert("User was registered successfully!");
          console.log(response.data);

          this.errors = {};
          this.$toaster.success("Account created");
        })
        .catch((errors) => {
          this.errors = errors.response.data.errors;
          console.log(errors.response.data.errors);
        });
    },
    loadUsers() {
      axios
        .get(
          `/api/users?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}`,
          {
            headers: {
              Authorization: "Bearer " + this.adminToken,
            },
          }
        )
        .then(({ data }) => (this.users = data.data));
      this.isLoggedIn = false;
      console.log(this.users);
    },

    deleteUser(id) {
      axios
        .delete("/api/users/" + id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((response) => {
          console.log(response);
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Users account was deleted successfully!",
            showConfirmButton: false,
            timer: 1500,
          });
        })
        .catch((error) => {
          console.log(error);
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
  },
  created() {
    this.loadUsers();
    checkLoginStatus.this();
  },
};
</script>

<style scoped>
.glyphicon-lg {
  font-size: 4em;
}

.info-block {
  border-right: 5px solid #e6e6e6;
  margin-bottom: 25px;
}

.info-block .square-box {
  width: 100px;
  min-height: 110px;
  margin-right: 22px;
  text-align: center !important;
  background-color: #676767;
  padding: 20px 0;
}

.info-block.block-info {
  border-color: #20819e;
}

.info-block.block-info .square-box {
  background-color: #20819e;
  color: #fff;
}
</style>