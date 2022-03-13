<template>
  <div class="container-fuiled">
    <AdminNavbar />
    <router-link class="new_feedback" :to="{ name: 'newportfolio' }"
      >New portfolio item</router-link
    >
    <router-link class="new_feedback" :to="{ name: 'newcollection' }"
      >New collection!!!</router-link
    >

    <Uitility></Uitility>

    <v-row class="p-5">
      <v-card
        v-for="portfolio in portfolios"
        v-bind:key="portfolio.id"
        class="mx-auto"
      >
        <v-card-title>
          {{ portfolio.work_name }}
        </v-card-title>
        <v-card-title>
          {{ portfolio.file_path }}
        </v-card-title>
        <v-card-title>
          {{ portfolio.description }}
        </v-card-title>
        <v-card-actions>
          <button>
            <router-link
              class="item"
              :to="{ name: 'updateportfolio', params: { id: portfolio.id } }"
            >
              Update</router-link
            >
          </button>
          <br />
          <b-button class="mod" @click="$bvModal.show('bv-modal-example')"
            ><v-icon large color="teal darken-2"> mdi-delete </v-icon>Delete
            item</b-button
          >
          <b-modal id="bv-modal-example" hide-footer>
            <template #modal-title> Delete item </template>
            <div class="d-block text-center">
              <h3>
                Do you want to delete this {{ portfolio.work_name }} portfolio
                item?
              </h3>
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
              @click="deletePortfolio(portfolio.id)"
              >Delete</b-button
            >
          </b-modal>
        </v-card-actions>
      </v-card>
    </v-row>
  </div>
</template>

<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
import Uitility from "../components/Uitility/Uitility.vue";
export default {
  data: function () {
    return {
      portfolios: [],
      OrderMessageForm: {
        type: "",
        price_in_eur: "",
      },
      isLoggedIn: false,
      token: localStorage.getItem("token"),
    };
  },
  components: {
    AdminNavbar,
    Uitility,
  },
  methods: {
    loadUsers() {
      axios
        .get("api/portfolio")
        .then(({ data }) => (this.portfolios = data.data));
      this.isLoggedIn = false;
      console.log(this.portfolios);
    },
    deletePortfolio(id) {
      axios
        .delete("/api/portfolio/" + id, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          console.log(response);
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "The portfolio item was deleted!",
            showConfirmButton: false,
            timer: 1500,
          });
          this.$router.push("/adminportfolio");
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.loadUsers();
    this.isLoggedIn = false;
  },
};
</script>

<style>
</style>