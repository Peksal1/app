<template>
<div class="container-fuiled">
     <AdminNavbar />
<div id="contact_form">
          <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4 contact_form">
                <form id="algin-form" style="background-color:#343a40;" action="#" @submit.prevent="createmessage">
                 
                    <div class="form-group"> <label for="name">post_text</label> <input type="text" name="post_text" id="post_text" class="form-control"  v-model="formData.post_text"> </div>
                   

                    <div class="form-group"> <button type="submit" class="btn btn-primary">Send message!</button> </div>
                </form>
            </div>
            <pre>

</pre>
</div>
</div>
</template>

<script>
import axios from 'axios'
import AdminNavbar from '../components/AdminNavbar.vue';
export default {
data(){
  return{
      currentUser:{},
    formData:{
      post_text:'',
      topic_id:this.$route.params.id,
      user_id:'',
        
    },
    token: localStorage.getItem("token"),
    errors:{}
  }
},
    components:{
    AdminNavbar,
    },
methods:{
  createmessage(){
      this.formData.user_id=this.currentUser.id
      axios.post('/api/posts',this.formData,{
            headers: {
            Authorization: "Bearer " + this.token,
          },
      }).then((response)=>{
        console.log(response.data)
      
        this.errors={}   
        this.$router.push('/admintopicsposts/'+this.$route.params.id)
        this.$toaster.success('Message sent successfully!')
      
      }).catch((errors)=>{
         this.errors=errors.response.data.errors
         console.log(errors.response.data.errors)
      })
  },checkLoginStatus() {
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
		  console.log( this.currentUser.name)
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

    
  }, 

 mounted() {
     this.checkLoginStatus() 
         this.loadUsers();
        
 }
};
</script>

<style>
.login {
  margin-left: 25rem;
}
.contact_form {
 float:right;
}
</style>