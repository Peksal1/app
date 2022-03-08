<template>
  <div>
     <Navbar />
 
   <div class="d-flex justify-content-center flex-wrap my-5">
     

   <v-card  v-for="order in orders" v-bind:key="order.id" 
    class="mx-auto my-3 "
  max-width="15rem"
        min-width="15rem"
  >
    <v-img
      class="white--text align-end"
      height="10rem"
      src="https://rb.gy/rnnzki"
    >
      <v-card-title class="d-flex justify-center text-dark">{{order.id}}</v-card-title>
    </v-img>

    <v-card-subtitle class="pb-0">
      <div>size:
    {{order.size}}
    </div>
    </v-card-subtitle>

    <v-card-text class="text--primary">
      <div>paint:
      {{order.paint}}</div>  
    </v-card-text>
      <v-card-text class="text--primary">
      <div>canvas:
      {{order.canvas}}</div>  
    </v-card-text>
    <hr>
   
  </v-card>

   </div> </div> 




</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data: function () {
    return {
      orders: [],
       token: localStorage.getItem("token"),
       isLoggedIn: false,
    };
  },
  components: {
    Navbar,
  },
  
 methods: {
    loadUsers() {
      axios.get('/api/orders/'+this.$route.params.id,{
          headers: {
            Authorization: "Bearer " + this.token,
          },
      })
            .then(response => {
              this.isLoggedIn= false

          this.orders=response.data;

        })
        .catch((error)=> {
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
		  console.log( this.currentUser.name)
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
    
  }, 
 mounted() {
     this.checkLoginStatus() 
         this.loadUsers();
        
 }

};
</script>

<style>
</style>