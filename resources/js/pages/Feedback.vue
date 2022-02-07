<template>

<div class="container-fuiled">
     <Navbar />
<router-link class="new_feedback" :to="{ name: 'newfeedback' }"
                >New feedback!</router-link>

      <h1>Comments</h1>
<div class="col-sm-5 col-md-6 col-12 pb-4" v-for="feedback in feedbacks"
        v-bind:key="feedback.id">
                <div class="comment mt-4 text-justify float-left"> <img src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg" alt="" class="rounded-circle" width="40" height="40">
                    <h4>{{ feedback.userfeedback.name }}</h4> <span>- {{ feedback.created_at}}</span> <br>
                     <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias doloremque molestiae dicta?</p>
                    <p>{{ feedback.evaluation }}/10</p>
                    <p>{{ feedback.pros }}</p>
                    <p>{{ feedback.cons }}</p>
                </div>
              
    </div>

    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import axios from "axios";

export default {
  data: function () {
    return {
      feedbacks: [],
       isLoggedIn: false,
    };
  },
    components:{
    Navbar,
    },
  methods: {
    loadUsers() {
      axios.get("api/feedback").then(({ data }) => (this.feedbacks = data.data));
       this.isLoggedIn= false
      console.log(this.feedbacks)
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
		  console.log( response.data.id)
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
    this.loadUsers();
    checkLoginStatus.this()
}
};
</script>

<style>
.comments {
    margin-top: 5%;
    margin-left: 20px
}


.comment {
    border: 1px solid rgba(16, 46, 46, 1);
    background-color:#343a40;;
    float: left;
    border-radius: 5px;
    padding-left: 40px;
    padding-right: 30px;
    padding-top: 10px
}

.comment h4,
.comment span,
.darker h4,
.darker span {
    display: inline
}

.comment p,
.comment span,
.darker p,
.darker span {
    color: rgb(184, 183, 183)
}

h1,
h4 {
    color: white;
    font-weight: bold
}

label {
    color: rgb(212, 208, 208)
}

#align-form {
    margin-top: 20px
}

.form-group p a {
    color: white
}

form {
    border: 1px solid rgba(16, 46, 46, 1);
    background-color: rgba(16, 46, 46, 0.973);
    border-radius: 5px;
    padding: 20px
}
.container-fuiled {
  background:#343a40;
  color:white;
}
</style>