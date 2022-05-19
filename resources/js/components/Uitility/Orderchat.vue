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
    </div>

    <!-- 
  
    Show All Paints

   -->
    <div class="row">
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
    <!-- 
  
    Show All Canvases

   -->
    <div class="row">
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
              Add Paint
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
                <input type="submit" value="Submit" class="btn btn-primary btn-block" />
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
      showChatModal: false,
      chatForm: {
        message: "",
      },
      order_messages: [],
    };
  },
  methods: {
    openChatModal() {
      this.showChatModal = true;
    },
    hideChatModal() {
      this.showSizeModal = false;
    },
    submitChatForm() {
      axios
        .post("/api/chats", this.chatForm)
        .then((res) => {
          if (res.data.status == "success") {
            this.order_messages.push(res.data.order_message);
            // reset the form
            this.chatForm = {
              message: "",
            };
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllChats() {
      axios
        .get("/api/chats")
        .then((res) => {
          this.order_messages = res.data.order_messages;
          console.log(this.order_messages);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deleteSize(index) {
      axios
        .delete("/api/chats/" + this.order_messages[index].id)
        .then((res) => {
          if (res.data.status == "success") {
            this.order_messages.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.getAllChats();
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