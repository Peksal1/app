<template>

<div class="container-fuiled">
     <Navbar />


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
  
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-row>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from '../components/Navbar.vue';
export default {
  data: function () {
    return {
      portfolios: [],
       isLoggedIn: false,
    };
  },
      components:{
    Navbar,
    },
  methods: {
    loadUsers() {
      axios.get("api/portfolio").then(({ data }) => (this.portfolios = data.data));
       this.isLoggedIn= false
      console.log(this.portfolios)
    },
  },
  created() {
    this.loadUsers();
    this.isLoggedIn= false
  },

};
</script>

<style>
</style>