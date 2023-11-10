<template>
    <v-row class="main-dashboard">
        <v-col cols="12">
            <v-breadcrumbs :items="breadcrumbs">
                <template v-slot:prepend>
                    <v-icon size="small" icon="mdi-home-city"></v-icon>
                </template>
                <template v-slot:divider>
                    <v-icon>mdi-forward</v-icon>
                </template>
            </v-breadcrumbs>
        </v-col>
        <v-col cols="12">
            <div class="upload-video-form">                
                <form @submit.prevent="submit">
                    <v-row>

                        <v-col v-if="!form.video_url" cols="12">
                            <v-file-input label="Select Video" accept="video/mp4,video/x-m4v,video/*" required persistent-hint hint="Allowed Extensions: mp4,ogx,oga,ogv,ogg,webm | Video should be less than 200MB" :error-messages="errors.video" @change="onFileChange"></v-file-input>
                        </v-col>
                        <video class="upload-video-tag" style="height: 400px;"  v-if="form.videoUrl" controls>
                            <source :src="form.videoUrl" type="video/mp4">
                        </video>
                        <v-col cols="12" v-if="!form.video_url" >
                            <v-btn @click="insertRecord"  :loading="loading" :loading-text="'Uploading'" class="upload-your-video" :disabled="loading">Upload Video</v-btn>
                        </v-col>
                        <!--  <v-col cols="12" v-if="form.video_url">
                            <v-btn @click="insertRecord"  class="upload-your-video uploaded-video" :disabled="true">Video Uploaded</v-btn> 
                        </v-col> -->
                        <v-col class="text-left" v-if="form.video_url" sm="12" md="6" lg="6">
                                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16" fill="none">
                                    <path d="M23 3L16 8L23 13V3Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M14 1H3C1.89543 1 1 1.89543 1 3V13C1 14.1046 1.89543 15 3 15H14C15.1046 15 16 14.1046 16 13V3C16 1.89543 15.1046 1 14 1Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg> -->
                                <v-btn  class="ml-3 view-upload-video" @click="gotoVideo">Click here to play the video</v-btn>
                                <p class="pl-3 mt-5 uploaded-video-text">You have successfully submitted your video entry for the 'MG 1 MILLION ASMR CHALLENGE!' Please note that in accordance with the contest policy, you are unable to make any edits or deletions to your uploaded video. If you require additional assistance, please don't hesitate to reach out to us at <a href="marketing@mgmotors.com.pk">marketing@mgmotors.com.pk</a></p>
                        </v-col>
                        <v-col class="uploaded-video" v-if="form.video_url" sm="12" md="6" lg="6">
                            <img src="../../../../../public/images/mg-hs-black-updated.png" alt="">            
                        </v-col>
                    </v-row>
                </form>
            </div>
        </v-col>
    </v-row>
</template>
<script>
import otherrequestservice from "@services/auth/otherrequests";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            roles: [],
            breadcrumbs: [
                {
                    title: 'Dashboard',
                    to: { name: "auth.panel" },
                    disabled: false,
                    exact: true,
                },
            ],
            form: {
                video: undefined,
                videoUrl: null,
            },
            loading: false,
            errors: {
                video: [],
            },
            res: null,
        }
    },
    methods: {
        gotoVideo(){
            window.open(this.form.video_url, "_blank");
        },
        async insertRecord() {
            this.resetErrors();
            this.loading = true;
            var formData = new FormData();
            if (this.form.video) {
                formData.append('video', this.form.video);
            }
            try {
                const isConfirmed = await Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Upload it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    return true;
                }
            });
            if (isConfirmed) {
                var res = await otherrequestservice.create('upload-video', formData)
                if (!res.status) {
                    if (res.data.video) {
                        this.errors.video = res.data.video;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Upload failed. Please try again.',
                    }).then(()=>{
                    location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Video Uploaded successfully!',
                    }).then(() => {
                        location.reload();
                    });
                }
                
                this.loadItems({ page: 1, itemsPerPage: 10 });
            }
                
            } catch (error) {
                console.error(error);
            }
            this.loading = false;
        },
        onFileChange(event) {
            this.form.video = event.target.files[0];
            this.form.videoUrl = URL.createObjectURL(this.form.video);
        },
        resetErrors() {
            this.errors = {
                video: [],
            };
        }
    },
    watch: {

    },
    async mounted() {
        const res = await otherrequestservice.get('me').then(e=>e.data)
        this.res = res;
        this.form = {
            video_url: (res.video_url ? res.video_url : ''),
        };
        this.breadcrumbs.push({
            title: 'Upload Video',
            exact: true,
            disabled: true,
        });
    },

}
</script>
