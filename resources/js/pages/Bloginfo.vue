<template>
  <div class="container-fuiled">
    <Navbar />

  
    <section class="post-content-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 post-title-block">
            <h1 class="text-center">{{ blog.title }}</h1>
            <ul class="list-inline text-center">
              <li>Author | {{blog.user.name}}</li>
              <li>Category | {{ blog.blog_category.category }}</li>
              <li>Date | {{ blog.created_at }}</li>
            </ul>
          </div>
          <div class="col-lg-9 col-md-9 col-sm-12">
            <p class="lead">
              {{ blog.thumbnail }}
            </p>
           
        
            <div class="image-block">
              <img
                :src="`/blog/${blog.image}`"
                class="img-responsive"
              />
            </div>

           <p>
              {{ blog.description }}
            </p>
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
                        <img
                          src="https://via.placeholder.com/280x280/FFB6C1/000000"
                          alt="Instagram post"
                        />
                      </div>
                    </div>
                    <div class="single_post">
                      <p class="m-b-0">Second post</p>
                      <span>May 23, 2022</span>
                      <div class="img-post">
                        <img
                          src="https://via.placeholder.com/280x280/FFB6C1/000000"
                          alt="Instagram post"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="row d-flex justify-content-center mt-100 mb-100">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title">Latest Comments</h4>
            </div>
            <div class="comment-widgets">
                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row m-t-0" v-for="(comment, index) in comments"
            :key="index">
                    <div class="p-2"><img :src="`/avatar/${comment.user.avatar}`" alt="user" width="50" class="rounded-circle"></div>
                    <div class="comment-text w-100">
                        <h6 class="font-medium"><strong> {{comment.user.name}} </strong> </h6> <span class="m-b-15 d-block">{{comment.message}} </span>
                        <div class="comment-footer"> <span class="text-muted float-right">{{comment.created_at}}</span> <button type="button" style="color:white" class="btn btn-danger btn-sm">Delete</button> </div>
                    </div>
                </div>
            </div>
             <form @submit.prevent="postMessage">
              <div class="form-group">
                <label for="">Write your own comment:</label>
                <textarea
                  v-model="formData.message"
                  type="textarea"
                  class="form-control"
                  style="max-width:600px"
                />
              </div>
              <div class="form-group">
                <input
                  type="submit"
                  value="Submit"
                  class="btn btn-primary btn-block"
                  style="max-width:80px; color:white"
                />
              </div>
            </form>
        </div>
    </div>
</div>
    
    </section>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data: function () {
    return {
      blog: {},
      comments: null,
      currentUser: {},
          formData: {
        message: "",
        user_id: "",
        blog_id: "",
      },
      isLoggedIn: false,
      token: localStorage.getItem("token"),
    };
  },
  components: {
    Navbar,
  },

  methods: {
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
    loadBlogComments(){
      axios
        .get("/api/blog/comments/" + this.$route.params.id, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })

        .then((response) => {
          console.log(response);
          this.comments = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  postMessage() {
      const commentForm = new FormData();
      commentForm.append("message", this.formData.message);
      commentForm.append("blog_id", this.$route.params.id);
      commentForm.append("user_id", this.currentUser.id);
      axios
        .post("/api/comment/" + this.$route.params.id, commentForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: commentForm._boundary,
          },
        })
        .then((response) => {
          alert("Comment posted!");
          this.loadBlogComments();        
                       
        })
        .catch((errors) => {
          console.log("error");
        });
    },
    loadBlogInfo(){
  axios
      .get("/api/blog/" + this.$route.params.id, {
        headers: {
          Authorization: "Bearer " + this.token,
        },
      })

      .then((response) => {
        this.blog = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    axios
      .get("/api/blog/comments/" + this.$route.params.id, {
        headers: {
          Authorization: "Bearer " + this.token,
        },
      })
      .then((response) => {
        this.isLoggedIn = false;
        ///    this.appointments=response.data.data
        this.comments = response.data;
        console.log("lol" + comments);
        ///    console.log(response.data);
      })
      .catch((error) => {
        console.log(error.message);
      });
    },
  },
  mounted() {
  this.loadBlogInfo();
  this.loadBlogComments();
  },
};
</script>

 <style scoped>


body {
    background-color: #D32F2F;
    font-family: 'Calibri', sans-serif !important
}

.mt-100 {
    margin-top: 100px
}

.mb-100 {
    margin-bottom: 100px
}

.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0px solid transparent;
    border-radius: 0px
}

.card-body {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem
}

.card .card-title {
    position: relative;
    font-weight: 600;
    margin-bottom: 10px
}

.comment-widgets {
    position: relative;
    margin-bottom: 10px
}

.comment-widgets .comment-row {
    border-bottom: 1px solid transparent;
    padding: 14px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin: 10px 0
}

.p-2 {
    padding: 0.5rem !important
}

.comment-text {
    padding-left: 15px
}

.w-100 {
    width: 100% !important
}

.m-b-15 {
    margin-bottom: 15px
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.76563rem;
    line-height: 1.5;
    border-radius: 1px
}

.btn-cyan {
    color: #fff;
    background-color: #27a9e3;
    border-color: #27a9e3
}

.btn-cyan:hover {
    color: #fff;
    background-color: #1a93ca;
    border-color: #198bbe
}

.comment-widgets .comment-row:hover {
    background: rgba(0, 0, 0, 0.05)
}
</style>