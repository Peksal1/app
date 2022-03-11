<template>
  <div>
    <Navbar />
    <div class="input-group mb-3">
      <input v-model="searchKeyword" type="text" class="form-control" />
      <div class="input-group-append">
        <button @click="getAllBlogs" class="btn btn-primary">Search</button>
      </div>
    </div>
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
                    params: { id: blog.id },
                  }"
                  >{{ blog.title }}</router-link
                >
              </a>
              <div class="title">{{ blog.description }}</div>
              <div class="title">{{ blog.thumbnail }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 text-center center-pagination">
        <Pagination
          :pagination="pagination"
          @perPage="getAllBlogs()"
          @paginate="getAllBlogs()"
          :offset="6"
        >
        </Pagination>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
import Pagination from "../components/Pagination.vue";
export default {
  data() {
    return {
      blogs: [],
      searchKeyword: "",
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      token: localStorage.getItem("token"),
    };
  },
  components: {
    Navbar,
    Pagination,
  },
  methods: {
    getAllBlogs() {
      axios
        .get(
          `/api/blog?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}`
        )
        .then((res) => {
          this.blogs = res.data.data;
          this.pagination = res.data;
        });
    },
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
        console.log(this.currentUser.name);
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