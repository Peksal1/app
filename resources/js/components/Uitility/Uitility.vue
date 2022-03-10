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
      <div class="btn btn-sm btn-primary" @click="openSizeModal">
        Add New size
      </div>
      <div class="btn btn-sm btn-primary">Add New Canvas</div>
      <div class="btn btn-sm btn-primary">Add New size</div>
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
              <li
                v-for="(size, index) in sizes"
                :key="index"
                class="
                  list-item
                  text-black
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
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
    </div>

    <div
      class="modal"
      :class="{ show: showSizeModal }"
      id="sizeModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add Size
            </h5>
            <button
              type="button"
              class="close text-dark"
              data-dismiss="modal"
              aria-label="Close"
              @click="hideSizeModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitSizeForm">
              <div class="form-group">
                <label for="">Type</label>
                <input
                  v-model="sizeForm.type"
                  type="text"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="">Price</label>
                <input
                  v-model="sizeForm.price_in_eur"
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
      showSizeModal: false,
      sizeForm: {
        type: "",
        price_in_eur: "",
      },
      sizes: [],
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
        .post("/api/sizes", this.sizeForm)
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
        .get("/api/sizes")
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
        .delete("/api/sizes/" + this.sizes[index].id)
        .then((res) => {
          if (res.data.status == "success") {
            this.sizes.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.getAllSizes();
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