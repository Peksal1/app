<template>
  <div class="container-fuiled">
    <AdminNavbar />

    <router-link class="registeruser" :to="{ name: 'registeruser' }"
      >Register a new user!</router-link
    >

    <h1>Users:</h1>
    <div
      class="col-sm-5 col-md-6 col-12 pb-4"
      v-for="user in users"
      v-bind:key="user.id"
    >
      <div class="comment mt-4 text-justify float-left">
        <img
          src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg"
          alt=""
          class="rounded-circle"
          width="40"
          height="40"
        />
        <h4>{{ user.name }}</h4>
        <span>- Registered on the website on: {{ user.created_at }}</span>
        <br />
        <p>
          Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus
          numquam assumenda hic aliquam vero sequi velit molestias doloremque
          molestiae dicta?
        </p>
        <p>Users email: {{ user.email }}</p>
        <p>Users password: {{ user.password }}</p>
        <p>Users role: {{ user.role }}</p>
      </div>
      <button>
        <router-link
          class="item"
          :to="{ name: 'updateuser', params: { id: user.id } }"
        >
          Update</router-link
        >
      </button>
      <b-button class="mod" @click="$bvModal.show('bv-modal-example')"
        ><v-icon large color="teal darken-2"> mdi-delete </v-icon>Delete
        user</b-button
      >
      <b-modal id="bv-modal-example" hide-footer>
        <template #modal-title> Delete topic </template>
        <div class="d-block text-center">
          <h3>Do you want to delete this {{ user.name }} topic?</h3>
        </div>
        <b-button
          class="btn btn-primary mt-3"
          block
          @click="$bvModal.hide('bv-modal-example')"
          >Cancel</b-button
        >
        <b-button class="btn btn-danger mt-3" block @click="deleteUser(user.id)"
          >delete</b-button
        >
      </b-modal>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
export default {
  data: function () {
    return {
      users: [],
      isLoggedIn: false,
      token: localStorage.getItem("token"),
    };
  },
  components: {
    AdminNavbar,
  },
  methods: {
    loadUsers() {
      axios
        .get("api/users", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then(({ data }) => (this.users = data.data));
      this.isLoggedIn = false;
      console.log(this.users);
    },
    deleteUser(id) {
      axios
        .delete("/api/users/" + id, {
          headers: {
            Authorization: "Bearer " + this.token,
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
          this.$router.push("/users");
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
.comments {
  margin-top: 5%;
  margin-left: 20px;
}

.comment {
  border: 1px solid rgba(16, 46, 46, 1);
  background-color: #343a40;
  float: left;
  border-radius: 5px;
  padding-left: 40px;
  padding-right: 30px;
  padding-top: 10px;
}

.comment h4,
.comment span,
.darker h4,
.darker span {
  display: inline;
}

.comment p,
.comment span,
.darker p,
.darker span {
  color: rgb(184, 183, 183);
}

h1,
h4 {
  color: white;
  font-weight: bold;
}

label {
  color: rgb(212, 208, 208);
}

#align-form {
  margin-top: 20px;
}

.form-group p a {
  color: white;
}

form {
  border: 1px solid rgba(16, 46, 46, 1);
  background-color: rgba(16, 46, 46, 0.973);
  border-radius: 5px;
  padding: 20px;
}
</style>