<template>
<div class="container-fuiled">
     <Navbar />
<div id="contact_form">
          <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4 contact_form">
                <form id="algin-form" style="background-color:#343a40;" action="#" @submit.prevent="createmessage">
                    <div class="form-group">
                        <h4>Contact me!</h4> <label for="message">Message</label> <textarea name="message" id="message" msg cols="30" rows="5" class="form-control" v-model="formData.message" style="background-color: black;"></textarea>
                    </div>
                    <div class="form-group"> <label for="name">Name</label> <input type="text" name="name" id="name" class="form-control"  v-model="formData.name"> </div>
                    <div class="form-group"> <label for="email">Email</label> <input type="text" name="Email" id="Email" class="form-control" v-model="formData.Email"> </div>

                    <div class="form-group"> <button type="submit" class="btn btn-primary">Send message!</button> </div>
                </form>
            </div>
</div>
<iframe width="648" height="367" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=648&amp;height=367&amp;hl=en&amp;q=K.%20Bar%C5%A1ausko%20g.%2066A%20Kaunas+()&amp;t=k&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
</iframe> 


</div>

</template>

<script>
import axios from 'axios'
import Navbar from '../components/Navbar.vue';
export default {
data(){
  return{
    formData:{
      name:'',
      Email:'',
      message:'',
        
    },
    token: localStorage.getItem("token"),
    errors:{}
  }
},
    components:{
    Navbar,
    },
methods:{
  createmessage(){
      axios.post('/api/messages',this.formData,{
            headers: {
            Authorization: "Bearer " + this.token,
          },
      }).then((response)=>{
        console.log(response.data)
      
        this.errors={}   
        this.$toaster.success('Message sent successfully!')
      
      }).catch((errors)=>{
         this.errors=errors.response.data.errors
         console.log(errors.response.data.errors)
      })
  },
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