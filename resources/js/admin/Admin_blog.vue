<template>
  <div>
    <AdminNavbar />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <div id="main-content" class="blog-page">
      <AdminBlog />
      <div class="container">
        <div class="row clearfix">
          <div class="col-lg-8 col-md-12 left-box">
            <div class="card single_post" v-for="(blog, index) in blogs" :key="index">
              <div class="body">
                <div class="img-post">
                  <img class="d-block img-fluid" :src="`/blog/${blog.image}`" alt="First slide" />
                </div>
                <h3>
                  <strong> {{ blog.title }} </strong>
                </h3>
                <p>
                  {{ blog.thumbnail }}
                </p>
              </div>
              <div class="footer">
                <div class="actions">
                  <router-link :to="{
                    name: 'Bloginfo',
                    params: { id: blog.id },
                  }">
                    <a class="btn btn-outline-secondary">Continue Reading</a>
                  </router-link>
                </div>

              </div>
              <div @click="callEditModal(index)" class="btn btn-sm btn-primary" style="max-width:100px">
                Update
              </div>
              <br />
              <div @click="deleteBlog(index)" class="btn btn-sm btn-danger" style="max-width:100px">
                Delete
              </div>


            </div>
            <ul class="pagination pagination-primary">
              <Pagination :pagination="pagination" @perPage="getAllBlogs()" @paginate="getAllBlogs()" :offset="6">
              </Pagination>
            </ul>
          </div>
          <div class="col-lg-4 col-md-12 right-box">
            <div class="card">
              <div class="body search">
                <div class="input-group m-b-0">
                  <div class="input-group-prepend">
                    <button @click="getAllBlogs">
                      <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </button>
                  </div>
                  <input type="text" class="form-control" placeholder="Search..." v-model="searchKeyword" />
                </div>
              </div>
            </div>
            <div class="card">
              <div class="header">
                <h2>Categories</h2>
              </div>
              <div class="body widget">
                <ul class="list-unstyled categories-clouds m-b-0">
                  <div v-for="blog_category in blog_categories" :key="blog_category.id" class="m-1">
                    <li>
                      <input type="checkbox" :id="blog_category.id" class="mycat" v-model="cat"
                        :value="blog_category.id" /><label :for="blog_category.id" class="btn btn-sm border">{{
                            blog_category.category
                        }}</label>
                    </li>
                  </div>
                </ul>
              </div>
            </div>

            <div class="card">
              <div class="header">
                <h2>Instagram feed</h2>
              </div>
              <div class="body widget popular-post">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="single_post">
                      <p class="m-b-0">First post</p>
                      <span>May 22, 2022</span>
                      <div class="img-post">
                        <img src="https://via.placeholder.com/280x280/FFB6C1/000000" alt="Instagram post" />
                      </div>
                    </div>
                    <div class="single_post">
                      <p class="m-b-0">Second post</p>
                      <span>May 23, 2022</span>
                      <div class="img-post">
                        <img src="https://via.placeholder.com/280x280/FFB6C1/000000" alt="Instagram post" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="modal" :class="{ show: showUpdateModal }" id="storeModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>Update</strong>
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideUpdateModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateBlog">



              <div class="form-group">
                <label for="">Title</label>
                <input v-model="updateForm.title" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Thumbnail</label>
                <input v-model="updateForm.thumbnail" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Description</label>
                <input v-model="updateForm.description" type="text" class="form-control" required />
              </div>

              <div class="relative">
                <label for="attachment" class="leading-7 text-sm text-gray-600">Attachments</label><br />

                <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input" required />
              </div>
              <br />
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary btn-block"
                  style="max-width:100px;color:white" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
import Pagination from "../components/Pagination.vue";
import AdminBlog from "../components/Uitility/NewBlog.vue";
export default {
  data() {
    return {
      blogs: {},
      cat: [],
      blog_categories: [],
      showUpdateModal: false,
      searchKeyword: "",
      updateForm: {
        id: null,
        title: '',
        description: '',
        thumbnail: '',
        image: '',
      },
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      adminToken: localStorage.getItem("adminToken"),
    };
  },
  components: {
    AdminNavbar,
    AdminBlog,
    Pagination,
  },
  methods: {
    updateBlog() {
      let formData = new FormData();
      formData.append("title", this.updateForm.title);
      formData.append("image", this.updateForm.image);
      formData.append("description", this.updateForm.description);
      formData.append("thumbnail", this.updateForm.thumbnail);;
      axios
        .post(`/api/blogs/${this.updateForm.id}/update`, formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data.success) {
            let blogIndex = this.blogs.findIndex(item => item.id == this.updateForm.id);
            this.blogs[blogIndex] = res.data.blog;
            // reset the form
            this.updateForm = {
              title: '',
              description: '',
              thumbnail: '',
              image: '',
            };
            // hide the modal
            this.hideUpdateModal();
            alert("The blog post was successfully added!");
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    callEditModal(index) {
      this.updateForm = this.blogs[index];
      this.showUpdateModal = true;
    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.updateForm.image = file;
    },
    hideUpdateModal() {
      this.showUpdateModal = false;
    },
    getAllBlogs() {
      axios
        .get(
          `/api/blog?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}&cat=${this.cat}`
        )
        .then((res) => {
          this.blogs = res.data.data;
          this.pagination = res.data;
        });
    },
    getAllBlogCategories() {
      axios.get(`/api/blog_categories`).then((res) => {
        this.blog_categories = res.data.blog_categories;
      });
    },
    deleteBlog(index) {
      axios
        .delete("/api/blogs/" + this.blogs[index].id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            this.blogs.splice(index, 1);
            this.getAllBlogs();
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  checkLoginStatus() {
    this.loading = true;
    // this.loading = true
    axios
      .get("/api/user", {
        headers: {
          Authorization: "Bearer " + this.adminToken,
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
    this.getAllBlogCategories();
  },
  watch: {
    cat(after, before) {
      this.getAllBlogs();
    },
  },
};
</script>


<style  scoped>
input.mycat {
  display: none;
}

input.mycat:checked+label {
  background: green;
  color: white;
  box-shadow: 0px 1px 3px inset;
}

body {
  background-color: #f4f7f6;
  margin-top: 20px;
}

.card {
  background: #fff;
  transition: 0.5s;
  border: 0;
  margin-bottom: 30px;
  border-radius: 0.55rem;
  position: relative;
  width: 100%;
  box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
}

.card .body {
  color: #444;
  padding: 20px;
  font-weight: 400;
}

.card .header {
  color: #444;
  padding: 20px;
  position: relative;
  box-shadow: none;
}

.single_post {
  -webkit-transition: all 0.4s ease;
  transition: all 0.4s ease;
}

.single_post .body {
  padding: 30px;
}

.single_post .img-post {
  position: relative;
  overflow: hidden;
  max-height: 500px;
  margin-bottom: 30px;
}

.single_post .img-post>img {
  -webkit-transform: scale(1);
  -ms-transform: scale(1);
  transform: scale(1);
  opacity: 1;
  -webkit-transition: -webkit-transform 0.4s ease, opacity 0.4s ease;
  transition: transform 0.4s ease, opacity 0.4s ease;
  max-width: 100%;
  filter: none;
  -webkit-filter: grayscale(0);
  -webkit-transform: scale(1.01);
}

.single_post .img-post:hover img {
  -webkit-transform: scale(1.02);
  -ms-transform: scale(1.02);
  transform: scale(1.02);
  opacity: 0.7;
  filter: gray;
  -webkit-filter: grayscale(1);
  -webkit-transition: all 0.8s ease-in-out;
}

.single_post .img-post:hover .social_share {
  display: block;
}

.single_post .footer {
  padding: 0 30px 30px 30px;
}

.single_post .footer .actions {
  display: inline-block;
}

.single_post .footer .stats {
  cursor: default;
  list-style: none;
  padding: 0;
  display: inline-block;
  float: right;
  margin: 0;
  line-height: 35px;
}

.single_post .footer .stats li {
  border-left: solid 1px rgba(160, 160, 160, 0.3);
  display: inline-block;
  font-weight: 400;
  letter-spacing: 0.25em;
  line-height: 1;
  margin: 0 0 0 2em;
  padding: 0 0 0 2em;
  text-transform: uppercase;
  font-size: 13px;
}

.single_post .footer .stats li a {
  color: #777;
}

.single_post .footer .stats li:first-child {
  border-left: 0;
  margin-left: 0;
  padding-left: 0;
}

.single_post h3 {
  font-size: 20px;
  text-transform: uppercase;
}

.single_post h3 a {
  color: #242424;
  text-decoration: none;
}

.single_post p {
  font-size: 16px;
  line-height: 26px;
  font-weight: 300;
  margin: 0;
}

.single_post .blockquote p {
  margin-top: 0 !important;
}

.single_post .meta {
  list-style: none;
  padding: 0;
  margin: 0;
}

.single_post .meta li {
  display: inline-block;
  margin-right: 15px;
}

.single_post .meta li a {
  font-style: italic;
  color: #959595;
  text-decoration: none;
  font-size: 12px;
}

.single_post .meta li a i {
  margin-right: 6px;
  font-size: 12px;
}

.single_post2 {
  overflow: hidden;
}

.single_post2 .content {
  margin-top: 15px;
  margin-bottom: 15px;
  padding-left: 80px;
  position: relative;
}

.single_post2 .content .actions_sidebar {
  position: absolute;
  top: 0px;
  left: 0px;
  width: 60px;
}

.single_post2 .content .actions_sidebar a {
  display: inline-block;
  width: 100%;
  height: 60px;
  line-height: 60px;
  margin-right: 0;
  text-align: center;
  border-right: 1px solid #e4eaec;
}

.single_post2 .content .title {
  font-weight: 100;
}

.single_post2 .content .text {
  font-size: 15px;
}

.right-box .categories-clouds li {
  display: inline-block;
  margin-bottom: 5px;
}

.right-box .categories-clouds li a {
  display: block;
  border: 1px solid;
  padding: 6px 10px;
  border-radius: 3px;
}

.right-box .instagram-plugin {
  overflow: hidden;
}

.right-box .instagram-plugin li {
  float: left;
  overflow: hidden;
  border: 1px solid #fff;
}

.comment-reply li {
  margin-bottom: 15px;
}

.comment-reply li:last-child {
  margin-bottom: none;
}

.comment-reply li h5 {
  font-size: 18px;
}

.comment-reply li p {
  margin-bottom: 0px;
  font-size: 15px;
  color: #777;
}

.comment-reply .list-inline li {
  display: inline-block;
  margin: 0;
  padding-right: 20px;
}

.comment-reply .list-inline li a {
  font-size: 13px;
}

@media (max-width: 640px) {
  .blog-page .left-box .single-comment-box>ul>li {
    padding: 25px 0;
  }

  .blog-page .left-box .single-comment-box ul li .icon-box {
    display: inline-block;
  }

  .blog-page .left-box .single-comment-box ul li .text-box {
    display: block;
    padding-left: 0;
    margin-top: 10px;
  }

  .blog-page .single_post .footer .stats {
    float: none;
    margin-top: 10px;
  }

  .blog-page .single_post .body,
  .blog-page .single_post .footer {
    padding: 30px;
  }
}
</style>