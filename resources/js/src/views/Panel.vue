<template>
  
  <!-- <v-row class="edit-prof">
    <v-img height="400px" width="100%" cover :src="imgSrc"></v-img>
   
  </v-row> -->
  <div class="main-dashboard">
    <div class="man-dish-inner">
          <v-row>
            <v-col lg="12" md="12" sm="12" class="px-5">
              <h1 class="text-center px-5">Hello {{ user.name }},</h1>
              <div class=""><p class="paragraph pa-0 px-5" v-if="user.role_id==1">Here at MG Enthusiasts, we're thrilled to introduce our newest members, each of whom has contributed fantastic videography showcasing the remarkable MG HS. To savor the unique charm of each video, we invite you to click on the following button, where a world of MG excellence awaits your exploration.</p>
			  </div>
              <v-btn v-if="user.role_id==1" class="ma-0 mt-3 registration text-white" exact :to="{name:'auth.users.listing'}" :link="true">Registrations</v-btn>
            </v-col>
            <v-col cols="12" class="mb-2" v-if="user.role_id==2">
              <v-row class="dash-btn">
                <v-col sm="6" md="6" lg="6" >
                  <!-- <v-btn block class="upload-video text-white" :to="{name: 'auth.uploadvideo'}" link >Upload Video</v-btn> -->
                </v-col>
                <v-col sm="6" md="6" lg="6" class="edit-profile-button">
                  <v-btn block class="edit-profile text-white" :to="{name:'auth.profiles'}" link >Edit Profile</v-btn>
                </v-col>
              </v-row>
            </v-col>
            <!-- <v-col v-if="user.role_id==1">
              
            </v-col> -->
          </v-row>
        </div>
        </div>

  <!-- <v-row>
    <v-col cols="12">
          <div class="user-dashboard" v-if="user.role_id==2">
            <img src="../../../../public/images/mg-hs.png" alt="">
            <h1 class="text-black">DON’T OWN AN MG HS?</h1>
            <a  href="https://mgmotors.com.pk/locateDealer"  target="_blank">CLICK TO FIND YOUR NEAREST DEALER</a>
            <div class="content-container"><p>If you don't currently own an MG HS but wish to take part in this competition, you can easily get involved by reaching out to your nearest dealership to arrange a video shoot featuring an MG HS vehicle. Feel free to click the button to access our Dealer Locator page for assistance.</p>
			</div>
          </div>
        </v-col>
  </v-row> -->
</template>
<style scoped>
.no-print .v-toolbar {
  top: 0px !important;
}

</style>
<script>
import service from "@services/auth/default";
const userservice = new service('users')
import Swal from "sweetalert2";
import UserAvatar from "@/components/UserAvatar.vue";
import otherrequestservice from "@services/auth/otherrequests";
export default {
  computed: {
    user() {
      return this.$store.getters.loggedInUser;
    },
  },
  components: {
    UserAvatar,
  },
  data() {
    return {
      imgSrc : '',
    }
  },
  methods: {
  },
  watch: {

  },
  async mounted() {
    // this.imgSrc = window.innerWidth > 500 ? '/images/ASMR-Webpage-Banner.jpg' : '/images/mob-img-banner.jpg' 

  },
}
</script>
