<template>
  <div>
    <Navbar />
    <div class="container">
      <div class="row">
        <div class="col-md-3" v-for="collection in collections" :key="collection.id">
          <div class="card">
            <div class="card-body">
              <div class="product-image">
                <img :src="`/collection/${collection.image}`" alt="" />
              </div>
         
                  <a href="#" name="Blog">
          <router-link 
                                        :to="{
                                            name: 'portfolio',
                                            params: { id: collection.id }
                                        }"
                                      
                                        >{{collection.name}}</router-link
                                    >
     </a>
              <div class="title">{{ collection.description }}</div>
              <div class="title">{{ collection.start_date }} - {{collection.end_date}}</div>

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
      collections: [],
      pagination: {},
      token: localStorage.getItem("token"),
    };
  },
  components: {
    Navbar,
  },
  methods: {
    getAllCollections() {
      axios.get("/api/collections").then((res) => {
        this.collections = res.data.data;
        this.pagination = res.data;
      });
    },
  },
    checkLoginStatus() {
      this.loading = true;
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
  created() {
    this.getAllCollections();
  },
};
</script>


<style  scoped>
.product-image img {
  max-width: 100%;
  width: 100%;
}
</style>