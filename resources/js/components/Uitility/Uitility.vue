<template>
  <div class="container">
    <div class="
        new-stores-option
        d-flex
        justify-content-between
        align-items-center
      ">
      <div class="btn btn-sm btn-primary" @click="openSizeModal">
        Add New Size
      </div>
      <div class="btn btn-sm btn-primary" @click="openCanvasModal">
        Add New Canvas
      </div>
      <div class="btn btn-sm btn-primary" @click="openPaintModal">
        Add New Paint
      </div>
    </div>

    <!-- 
  
    Show All Sizes

   -->

    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Sizes</div>
          <div class="card-body">
            <ul>
              <li v-for="(size, index) in sizes" :key="index" class="
                  list-item
                  text-black
                  d-flex
                  justify-content-between
                  align-items-center
                ">
                <div>
                  Size: {{ size.type }} CM | Price: {{ size.price_in_eur }} EUR
                </div>
                <div @click="deleteSize(index)" class="btn btn-sm btn-danger">
                  Delete
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>



      <!-- 
  
    Show All Canvases

   -->

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Canvases</div>
          <div class="card-body">
            <ul>
              <li v-for="(canvas, index) in canvases" :key="index" class="
                  list-item
                  text-black
                  d-flex
                  justify-content-between
                  align-items-center
                ">
                <div>
                  Canvas: <strong>{{ canvas.type }}</strong> | Price:
                  {{ canvas.price_in_eur }} EUR
                </div>
                <div @click="deleteCanvas(index)" class="btn btn-sm btn-danger">
                  Delete
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- 
  
    Show All Paints

   -->

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Paints</div>
          <div class="card-body">
            <ul>
              <li v-for="(paint, index) in paints" :key="index" class="
                  list-item
                  text-black
                  d-flex
                  justify-content-between
                  align-items-center
                ">
                <div>
                  Paint: <strong>{{ paint.type }}</strong> | Price:
                  {{ paint.price_in_eur }} EUR
                </div>
                <div @click="deletePaint(index)" class="btn btn-sm btn-danger">
                  Delete
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- modal vindows -->
    <div class="modal" :class="{ show: showSizeModal }" id="sizeModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add Size
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideSizeModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitSizeForm">
              <div class="form-group">
                <label for="">Type</label>
                <input v-model="sizeForm.type" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label for="">Price</label>
                <input v-model="sizeForm.price_in_eur" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary btn-block" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" :class="{ show: showPaintModal }" id="paintModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>New paint</strong>
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hidePaintModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitPaintForm">
              <div class="form-group">
                <label for="">Type</label>
                <input v-model="paintForm.type" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label for="">Price</label>
                <input v-model="paintForm.price_in_eur" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <input type="submit" value="Submit" style="color:white;max-width:100px"
                  class="btn btn-primary btn-block" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" :class="{ show: showCanvasModal }" id="canvasModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add Canvas
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideCanvasModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitCanvasForm">
              <div class="form-group">
                <label for="">Type</label>
                <input v-model="canvasForm.type" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label for="">Price</label>
                <input v-model="canvasForm.price_in_eur" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary btn-block" />
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
      adminToken: localStorage.getItem("adminToken"),
      showSizeModal: false,
      showPaintModal: false,
      showCanvasModal: false,
      sizeForm: {
        type: "",
        price_in_eur: "",
      },
      paintForm: {
        type: "",
        price_in_eur: "",
      },
      canvasForm: {
        type: "",
        price_in_eur: "",
      },
      sizes: [],
      canvases: [],
      paints: [],
    };
  },
  methods: {
    openSizeModal() {
      this.showSizeModal = true;
    },
    hideSizeModal() {
      this.showSizeModal = false;
    },
    submitSizeForm() {
      axios
        .post("/api/sizes", this.sizeForm, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            this.sizes.push(res.data.size);
            // reset the form
            this.sizeForm = {
              type: "",
              price_in_eur: "",
            };
            // hide the modal
            this.hideSizeModal();
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllSizes() {
      axios
        .get("/api/sizes", {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          this.sizes = res.data.sizes;
          console.log(this.sizes);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deleteSize(index) {
      axios
        .delete("/api/sizes/" + this.sizes[index].id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            this.sizes.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    openPaintModal() {
      this.showPaintModal = true;
    },
    hidePaintModal() {
      this.showPaintModal = false;
    },
    submitPaintForm() {
      axios
        .post("/api/paints", this.paintForm, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            this.paints.push(res.data.paint);
            // reset the form
            this.paintForm = {
              type: "",
              price_in_eur: "",
            };
            // hide the modal
            this.hidePaintModal();
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllPaints() {
      axios
        .get("/api/paints", {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          this.paints = res.data.paints;
          console.log(this.paints);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deletePaint(index) {
      axios
        .delete("/api/paints/" + this.paints[index].id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            this.paints.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    openCanvasModal() {
      this.showCanvasModal = true;
    },
    hideCanvasModal() {
      this.showCanvasModal = false;
    },
    submitCanvasForm() {
      axios
        .post("/api/canvases", this.canvasForm, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            this.canvases.push(res.data.canvas);
            // reset the form
            this.canvasForm = {
              type: "",
              price_in_eur: "",
            };
            // hide the modal
            this.hideCanvasModal();
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllCanvases() {
      axios
        .get("/api/canvases", {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          this.canvases = res.data.canvases;
          console.log(this.canvases);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deleteCanvas(index) {
      axios
        .delete("/api/canvases/" + this.canvases[index].id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            this.canvases.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
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
  },
  mounted() {
    this.getAllSizes();
    this.getAllPaints();
    this.getAllCanvases();
    this.checkLoginStatus();
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

.card-body {
  max-height: 200px;
  overflow: scroll;
  overflow-x: hidden;
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