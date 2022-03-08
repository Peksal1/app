<template>
  <div>
    <Navbar />
    <div class="container">
      <div class="row">
        <div class="col-md-3" v-for="blog in blogs" :key="blog.id">
          <div class="card">
            <div class="card-body">
              <div class="product-image">
                <img :src="`/blog/${blog.image}`" alt="" />
              </div>
         
                  <a href="#" name="Blog">
          <router-link 
                                        :to="{
                                            name: 'Bloginfo',
                                            params: { id: blog.id }
                                        }"
                                      
                                        >{{blog.title}}</router-link
                                    >
          
     </a>
              <div class="title">{{ blog.description }}</div>
              <div class="title">{{ blog.thumbnail }}</div>
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
      blogs: [],
      pagination: {},
    };
  },
  components: {
    Navbar,
  },
  methods: {
    getAllBlogs() {
      axios.get("/api/blog").then((res) => {
        this.blogs = res.data.data;
        this.pagination = res.data;
      });
    },
  },
  created() {
    this.getAllBlogs();
  },
};
</script>


<style  scoped>
.product-image img {
  max-width: 100%;
  width: 100%;
}
</style>