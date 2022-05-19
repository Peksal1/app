    <template>
  <div>
    <AdminNavbar />

    <Utility />
    <NewCollection />
    <NewPortfolio />
    <NewPaintingCategory />

    <section class="section-products">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>Painting collections</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Single Product -->
          <div class="col-md-6 col-lg-4 col-xl-3" v-for="(collection, index) in collections" :key="index">

            <div id="product-1" class="single-product">
              <div class="part-1">

                <img :src="`/collection/${collection.image}`" alt="" @click="openAdminCollectionModal(index)"
                  style="cursor: pointer; max-width: 350px" />

                <ul>
                  <li>
                    <a href="#"><i class="fas fa-expand"></i></a>
                  </li>
                </ul>
              </div>
              <div class="part-2">
                <h3 class="product-title">
                  <strong>{{ collection.name }}</strong>
                </h3>
                <div class="category">{{ collection.description }}</div>
                <h4 class="product-price">
                  {{ collection.start_date }} - {{ collection.end_date }}
                </h4>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 text-center center-pagination">
          <Pagination :pagination="pagination" @perPage="getAllCollections()" @paginate="getAllCollections()"
            :offset="6">
          </Pagination>
        </div>
      </div>
    </section>
    <!-- collection modal vindow -->
    <div class="modal" :class="{ show: showAdminCollectionModal }" id="adminCollectionModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>{{ collection.name }}</strong>
            </h5>
            <button type="button" class="close text-dark cursor: pointer" data-dismiss="modal" aria-label="Close"
              @click="hideAdminCollectionModal()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img :src="`/collection/${collection.image}`" style="max-width: 470px; max-height: 470px" />

            <br />
            {{ collection.description }}
            <br />
            {{ collection.start_date }} - {{ collection.end_date }}

            <br />
            <div @click="callEditModal(collection.id)" class="btn btn-sm btn-primary">
              Update
            </div>
            <div @click="deleteCollection(collection.id)" class="btn btn-sm btn-danger">
              Delete
            </div>
          </div>


        </div>
      </div>
    </div>
    <!-- Edit collection modal vindow -->
    <div class="modal" :class="{ show: showEditModal }" id="editCollectionModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>Update</strong>
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideEditModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateCollection">



              <div class="form-group">
                <label for="">Name</label>
                <input v-model="updateForm.name" type="text" class="form-control" required />
              </div>

              <div class="form-group">
                <label for="">Description</label>
                <input v-model="updateForm.description" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Start date:</label>
                <input v-model="updateForm.start_date" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">End date:</label>
                <input v-model="updateForm.end_date" type="text" class="form-control" required />
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
import Utility from "../components/Uitility/Uitility.vue";
import NewCollection from "../components/Uitility/NewCollection.vue";
import NewPortfolio from "../components/Uitility/NewPortfolio.vue";
import NewPaintingCategory from "../components/Uitility/NewPaintingCategory.vue";
export default {
  data() {
    return {
      collections: [],
      showAdminCollectionModal: false,
      showEditModal: false,
      collection: [],
      updateForm: {
        id: null,
        name: "",
        description: "",
        image: "",
        start_date: "",
        end_date: "",
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
    Pagination,
    Utility,
    NewCollection,
    NewPortfolio,
    NewPaintingCategory,
  },
  methods: {
    getAllCollections() {
      axios.get(`/api/collections?page=${this.pagination.current_page}`).then((res) => {
        this.collections = res.data.data;
        this.pagination = res.data;
      });
    },
    callEditModal(index) {
      this.showEditModal = true;
      this.updateForm = this.collection;
    },
    hideEditModal() {
      this.showEditModal = false;
    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.updateForm.image = file;
    },
    updateCollection() {
      let formData = new FormData();
      formData.append("name", this.updateForm.name);
      formData.append("image", this.updateForm.image);
      formData.append("description", this.updateForm.description);
      formData.append("start_date", this.updateForm.start_date);
      formData.append("end_date", this.updateForm.end_date);

      axios
        .post(`/api/collections/${this.updateForm.id}/update`, formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data.success) {
            let collectionIndex = this.collections.findIndex(item => item.id == this.updateForm.id);
            this.collections[collectionIndex] = res.data.collection;
            // reset the form
            this.updateForm = {
              name: "",
              image: "",
              description: "",
              start_date: "",
              end_date: "",
            };
            // hide the modal
            this.hideEditModal();
            alert("The collection was successfully edited!");

          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deleteCollection(index) {
      axios
        .delete("/api/collection/" + this.collection.id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          this.getAllCollections();
          this.hideAdminCollectionModal();
          if (res.data.status == "success") {
            this.collections.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    openAdminCollectionModal(index) {
      this.showAdminCollectionModal = true;
      this.loadSpecificCollection(index);
    },
    hideAdminCollectionModal() {
      this.showAdminCollectionModal = false;
    },
    loadSpecificCollection(index) {
      axios
        .get("/api/collection/" + this.collections[index].id, {})

        .then((response) => {
          this.collection = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    checkLoginStatus() {
      this.loading = true;
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
  },
  created() {
    this.getAllCollections();
  },
};
</script>


<style  scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap");

body {
  font-family: "Poppins", sans-serif;
  color: #444444;
}

.modal {
  overflow-x: hidden;

}

a,
a:hover {
  text-decoration: none;
  color: inherit;
}

.section-products {
  padding: 80px 0 54px;
}

.section-products .header {
  margin-bottom: 50px;
}

.section-products .header h3 {
  font-size: 1rem;
  color: #fe302f;
  font-weight: 500;
}

.section-products .header h2 {
  font-size: 2.2rem;
  font-weight: 400;
  color: #444444;
}

.section-products .single-product {
  margin-bottom: 26px;
}

.section-products .single-product .part-1 {
  position: relative;
  height: 290px;
  max-height: 290px;
  margin-bottom: 20px;
  overflow: hidden;
}

.section-products .single-product .part-1::before {
  position: absolute;
  content: "";
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  transition: all 0.3s;
}

.section-products .single-product:hover .part-1::before {
  transform: scale(1.2, 1.2) rotate(5deg);
}

.section-products #product-1 .part-1::before {
  background: url("https://i.ibb.co/L8Nrb7p/1.jpg") no-repeat center;
  background-size: cover;
  transition: all 0.3s;
}

.section-products #product-2 .part-1::before {
  background: url("https://i.ibb.co/cLnZjnS/2.jpg") no-repeat center;
  background-size: cover;
}

.section-products #product-3 .part-1::before {
  background: url("https://i.ibb.co/L8Nrb7p/1.jpg") no-repeat center;
  background-size: cover;
}

.section-products #product-4 .part-1::before {
  background: url("https://i.ibb.co/cLnZjnS/2.jpg") no-repeat center;
  background-size: cover;
}

.section-products .single-product .part-1 .discount,
.section-products .single-product .part-1 .new {
  position: absolute;
  top: 15px;
  left: 20px;
  color: #ffffff;
  background-color: #fe302f;
  padding: 2px 8px;
  text-transform: uppercase;
  font-size: 0.85rem;
}

.section-products .single-product .part-1 .new {
  left: 0;
  background-color: #444444;
}

.section-products .single-product .part-1 ul {
  position: absolute;
  bottom: -41px;
  left: 20px;
  margin: 0;
  padding: 0;
  list-style: none;
  opacity: 0;
  transition: bottom 0.5s, opacity 0.5s;
}

.section-products .single-product:hover .part-1 ul {
  bottom: 30px;
  opacity: 1;
}

.section-products .single-product .part-1 ul li {
  display: inline-block;
  margin-right: 4px;
}

.section-products .single-product .part-1 ul li a {
  display: inline-block;
  width: 40px;
  height: 40px;
  line-height: 40px;
  background-color: #ffffff;
  color: #444444;
  text-align: center;
  box-shadow: 0 2px 20px rgb(50 50 50 / 10%);
  transition: color 0.2s;
}

.section-products .single-product .part-1 ul li a:hover {
  color: #fe302f;
}

.section-products .single-product .part-2 .product-title {
  font-size: 1rem;
}

.section-products .single-product .part-2 h4 {
  display: inline-block;
  font-size: 1rem;
  color: gray;
}

.section-products .single-product .part-2 .product-old-price {
  position: relative;
  padding: 0 7px;
  margin-right: 2px;
  opacity: 0.6;
}

.section-products .single-product .part-2 .product-old-price::after {
  position: absolute;
  content: "";
  top: 50%;
  left: 0;
  width: 100%;
  height: 1px;
  background-color: #444444;
  transform: translateY(-50%);
}
</style>