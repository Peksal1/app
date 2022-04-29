<template>
  <div class="container-fuiled">
    <Navbar />

  
    <section class="post-content-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 post-title-block">
            <h1 class="text-center">{{ blog.title }}</h1>
            <ul class="list-inline text-center">
              <li>Author |</li>
              <li>Category | {{ blog.blog_category_id }}</li>
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
          <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="well">
              <h2>Subscription Box</h2>
              <p>Form Description Goes here</p>
              <div class="input-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Search for..."
                />
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Go!</button>
                </span>
              </div>
            </div>
            <div class="well">
              <h2>Share love</h2>
              <ul class="list-inline">
                <li>
                  <span
                    class="glyphicon glyphicon-heart"
                    aria-hidden="true"
                  ></span>
                </li>
                <li>
                  <span
                    class="glyphicon glyphicon-heart"
                    aria-hidden="true"
                  ></span>
                </li>
                <li>
                  <span
                    class="glyphicon glyphicon-heart"
                    aria-hidden="true"
                  ></span>
                </li>
                <li>
                  <span
                    class="glyphicon glyphicon-heart"
                    aria-hidden="true"
                  ></span>
                </li>
              </ul>
            </div>
            <div class="well">
              <h2>About Author</h2>
              <img src="" class="img-rounded" />
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna
              </p>
              <a href="#" class="btn btn-default">Read more</a>
            </div>
            <div class="list-group">
              <a class="list-group-item active" href="#">
                <h4 class="list-group-item-heading">List group item heading</h4>
                <p class="list-group-item-text">
                  Donec id elit non mi porta gravida at eget metus. Maecenas sed
                  diam eget risus varius blandit.
                </p>
              </a>
              <a class="list-group-item" href="#">
                <h4 class="list-group-item-heading">List group item heading</h4>
                <p class="list-group-item-text">
                  Donec id elit non mi porta gravida at eget metus. Maecenas sed
                  diam eget risus varius blandit.
                </p>
              </a>
              <a class="list-group-item" href="#">
                <h4 class="list-group-item-heading">List group item heading</h4>
                <p class="list-group-item-text">
                  Donec id elit non mi porta gravida at eget metus. Maecenas sed
                  diam eget risus varius blandit.
                </p>
              </a>
            </div>
            <div class="well">
              <div class="media">
                <div class="media-left">
                  <a href="#">
                    <img
                      data-src="holder.js/64x64"
                      class="media-object"
                      alt="64x64"
                      style="width: 64px; height: 64px"
                      src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTY5MjIxZTM1NSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NjkyMjFlMzU1Ij48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMi41IiB5PSIzNi44Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg=="
                      data-holder-rendered="true"
                    />
                  </a>
                </div>
                <div class="media-body">
                  <h4 class="media-heading">Media heading</h4>
                  Cras sit amet nibh libero, in gravida nulla.
                </div>
              </div>
              <div class="media">
                <div class="media-left">
                  <a href="#">
                    <img
                      data-src="holder.js/64x64"
                      class="media-object"
                      alt="64x64"
                      style="width: 64px; height: 64px"
                      src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTY5MjIxZTM1NSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NjkyMjFlMzU1Ij48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMi41IiB5PSIzNi44Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg=="
                      data-holder-rendered="true"
                    />
                  </a>
                </div>
                <div class="media-body">
                  <h4 class="media-heading">Media heading</h4>
                  Cras sit amet nibh libero, in gravida nulla.
                </div>
              </div>
              <div class="media">
                <div class="media-left">
                  <a href="#">
                    <img
                      data-src="holder.js/64x64"
                      class="media-object"
                      alt="64x64"
                      style="width: 64px; height: 64px"
                      src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTY5MjIxZTM1NSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NjkyMjFlMzU1Ij48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMi41IiB5PSIzNi44Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg=="
                      data-holder-rendered="true"
                    />
                  </a>
                </div>
                <div class="media-body">
                  <h4 class="media-heading">Media heading</h4>
                  Cras sit amet nibh libero, in gravida nulla.
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
                        <div class="comment-footer"> <span class="text-muted float-right">{{comment.created_at}}</span> <button type="button" class="btn btn-cyan btn-sm">Edit</button> <button type="button" class="btn btn-success btn-sm">Publish</button> <button type="button" class="btn btn-danger btn-sm">Delete</button> </div>
                    </div>
                </div>
            </div>
             <form @submit.prevent="postMessage">
              <div class="form-group">
                <label for="">message</label>
                <input
                  v-model="formData.message"
                  type="text"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <input
                  type="submit"
                  value="Submit"
                  class="btn btn-primary btn-block"
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