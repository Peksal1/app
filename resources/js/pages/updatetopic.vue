<template>
<div class="container-fuiled">
     <AdminNavbar />
  <div class="row justify-content-center" >
  <div class="col-md-6">
<div class="card">
  <div class="card-header">
    Editing the information of the topic:
  </div>
  <div class="card-body">
    <form action="#" @submit.prevent="updatetopic">
    <div class="form-group">
      <label for="">Topic title</label>
      <input type="text" class="form-control" name="topic_title"  v-model="topic_title">     
    </div>
    <div class="form-group">
      <label for="">Topic description</label>
      <input type="text" class="form-control" name="topic_description"  v-model="topic_description">     
    </div>
    <div class="row">
      <div class="col-md-6">
        <button type="submit"  class="btn btn-primary">Update</button>
      </div>
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
import AdminNavbar from '../components/AdminNavbar.vue';
export default {
  data() {
    return {   
        topic_title:'',
        topic_description:'',
      token: localStorage.getItem("token"),
     
    };
  },
         components:{
    AdminNavbar,
    },
  methods:{
   updatetopic(){
    axios.put('/api/topics/'+ this.$route.params.id,{
      topic_title:this.topic_title,
      topic_description:this.topic_description,
 
    },{
      headers: {
      Authorization: "Bearer " + this.token,
      }
     
    }).then(response=>{
      console.log(response)
        Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'The topic was changed successfully!',
  showConfirmButton: false,
  timer: 1500
})
       this.$router.push('/adminqna')
    }).catch(error =>{
      console.log(error)
    })
   },
  
  }, 
  ///here we mounted when activity start 
  mounted(){
    axios.get('/api/topic/'+ this.$route.params.id, {
      headers: {
      Authorization: "Bearer " + this.token,
      }
    }).then(response=>{
      const user=response.data
      this.topic_title=user.topic_title
      this.topic_description=user.topic_description
    

    }).catch(error =>{
      console.log(error)
    })
  }
  
  
}
</script>

<style>
</style>