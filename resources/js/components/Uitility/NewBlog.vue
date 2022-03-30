<template>
  <div class="container">
    <div
      class="
        new-stores-option
        d-flex
        justify-content-between
        align-items-center
      "
    >
      <div class="btn btn-sm btn-primary" @click="openBlogModal">
        Add New Post
      </div>
      <div class="btn btn-sm btn-primary" @click="openBlogCategoryModal">
        Add New Blog Category
      </div>
    </div>

    <!-- modal vindows -->
    <div
      class="modal"
      :class="{ show: showBlogModal }"
      id="blogModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add a post
            </h5>
            <button
              type="button"
              class="close text-dark"
              data-dismiss="modal"
              aria-label="Close"
              @click="hideBlogModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitBlogForm">
              <div class="form-group">
                <label for="">Title</label>
                <input
                  v-model="blogForm.title"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="form-group">
                <label for="">Description</label>
                <input
                  v-model="blogForm.description"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="form-group">
                <label for="">Thumbnail</label>
                <input
                  v-model="blogForm.thumbnail"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <select
                name="paint"
                v-model="blogForm.blog_category_id"
                style="width: 15rem"
                required
              >
                <option value="">Choose</option>
                <option
                  v-for="blog_category in blog_categories"
                  v-bind:key="blog_category.id"
                  :value="blog_category.id"
                >
                  {{ blog_category.category }}
                </option>
              </select>
              <div class="p-2 w-full">
                <div class="relative">
                  <label
                    for="attachment"
                    class="leading-7 text-sm text-gray-600"
                    >Attachments</label
                  ><br />

                  <input
                    type="file"
                    accept="image/*"
                    @change="uploadImage($event)"
                    id="file-input"
                    required
                  />
                </div>
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
    </div>

    <div
      class="modal"
      :class="{ show: showBlogCategoryModal }"
      id="blogCategoryModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add a blog category
            </h5>
            <button
              type="button"
              class="close text-dark"
              data-dismiss="modal"
              aria-label="Close"
              @click="hideBlogCategoryModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitBlogCategoryForm">
              <div class="form-group">
                <label for="">Category</label>
                <input
                  v-model="BlogCategoryForm.category"
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
    </div>
  </div>
</template>


<script>
import axios from "axios";
export default {
  name: "Uitility",
  data() {
    return {
      showBlogModal: false,
      showBlogCategoryModal: false,

      blogForm: {
        title: "",
        description: "",
        thumbnail: "",
        image: "",
        blog_category_id: "",
      },
      BlogCategoryForm: {
        category: "",
      },
      blogs: [],
      blog_categories: [],
      adminToken: localStorage.getItem("adminToken"),
    };
  },
  methods: {
    afterUploadComplete: async function (response) {
      if (response.status == "success") {
        console.log("upload successful");
        this.sendSuccess = true;
      } else {
        console.log("upload failed");
      }
    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.blogForm.image = file;
    },
    openBlogModal() {
      this.showBlogModal = true;
    },
    hideBlogModal() {
      this.showBlogModal = false;
    },
    submitBlogForm() {
      let formData = new FormData();
      formData.append("title", this.blogForm.title);
      formData.append("description", this.blogForm.description);
      formData.append("thumbnail", this.blogForm.thumbnail);
      formData.append("image", this.blogForm.image);
      formData.append("blog_category_id", this.blogForm.blog_category_id);
      formData.append("user_id", this.blogForm.blog_category_id);

      axios
        .post("/api/blogs", formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data.success) {
            this.blogs.push(res.data.blog);
            // reset the form
            this.blogForm = {
              title: "",
              description: "",
              thumbnail: "",
              image: "",
              blog_category_id: "",
            };
            // hide the modal
            this.hideBlogModal();
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    openBlogCategoryModal() {
      this.showBlogCategoryModal = true;
    },
    hideBlogCategoryModal() {
      this.showBlogCategoryModal = false;
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
    getAllBlogCategories() {
      axios.get(`/api/blog_categories`).then((res) => {
        this.blog_categories = res.data.blog_categories;
      });
    },
    submitBlogCategoryForm() {
      axios
        .post("/api/blog_categories", this.BlogCategoryForm)
        .then((res) => {
          if (res.data.status == "success") {
            this.blog_categories.push(res.data.blog_category);
            // reset the form
            this.BlogCategoryForm = {
              category: "",
            };
            // hide the modal
            this.hideBlogCategoryModal();
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.checkLoginStatus();
    this.getAllBlogCategories();
  },
};
</script>


<style scoped>
.show {
  display: block !important;
}

form {
  background: #fff;
  padding: 20px;
  border-radius: 5px;
  border: 0px;
}
label {
  color: #000;
}

.text-black {
  color: #000;
}

li {
  list-style: none;
  padding: 10px;
}
ul {
  padding: 0px;
  margin: 0px;
}
</style>