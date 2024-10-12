<template>
    <!-- <v-app id="inspire"> -->
    <div>
        <v-navigation-drawer v-model="drawer" app color="#5f4c4c" temporary v-if="cMyCredential"  >

            
            <template>
                <v-card color="transparent" style="height:220px" class="text-center" dark flat tile>
                    <br>
                    <!-- <v-tooltip right >
                        <template v-slot:activator="{on, attrs}">
                            <v-avatar size="120px" style="border:solid; ">
                                <v-img
                                    class="cursor"
                                    :src="urlPic"
                                    max-height="150"
                                    max-width="250"
                                    v-on="on"
                                    v-bind="attrs"
                                    @click="mViewPhoto(urlPic)">
                                </v-img>
                            </v-avatar>
                        </template>
                        <span>View</span>
                    </v-tooltip> -->
                
                    <v-hover>
                        <template v-slot:default="{hover}">
                            <v-avatar size="120px" style="border:solid; ">
                                <v-overlay 
                                    v-if="hover"
                                    absolute
                                    class="cursor"
                                    @click="triggerFileInput"
                                    
                                >
                                    <v-icon>mdi-camera</v-icon>
                                    <input type="file" ref="fileInput" style="display: none;" accept=".jpg, .jpeg, .png" @change="handleFileChange">
                                    
                                </v-overlay>
                                <v-img
                                    class="cursor"
                                    :src="cImageName"
                                    max-height="150"
                                    max-width="250"
                                >
                                    <template v-slot:placeholder>
                                        <v-row class="fill-height ma-0" align="center" justify="center" >
                                            <v-progress-circular indeterminate/>

                                        </v-row>
                                       
                                    </template>
                                </v-img>

                                <v-overlay v-if="loading" absolute>
                                    <v-progress-circular
                                        indeterminate
                                    />
                                </v-overlay>


                            </v-avatar>
                        </template>
                    </v-hover>


                    <v-row no-gutters>
                        <v-col>
                            <span class="cursor" style="font-size: 20px">
                                <span style="font-size:larger" >💳</span>
                                    {{ cAccountName }}
                            </span>
                        </v-col>
                    </v-row>
                    <v-row no-gutters v-if="this.$store.state.UserInfo.AlumniID != 1">
                        <v-col>
                            <v-chip  color="#c5aa6a" label @click="GoToAccount()">
                                <span class="cursor" style="font-size:larger" >📋 </span>
                                    <span style="color:white"> View Account</span>
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row >
                        <v-col>
                            <v-divider color="white"/>
                        </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col >
                            <v-list dense>
                                <!-- <v-subheader>LIST COMPONENTS:</v-subheader> -->
                                <v-list-item v-for="(item, i) in userView" :key="i" :to="item.to">
                                    <v-list-item-icon>
                                        <!-- <span class="cursor" style="font-size: larger;" >{{ item.icon }}</span> -->
                                            <v-img :src="'images/Icons/' + item.icon" max-height="25" max-width="25"></v-img>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title style="text-align:left; font-weight:bold">{{ item.text }}</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-col>
                    </v-row>
                    <v-row align="center" justify="center" v-if=" this.$store.state.UserInfo.UserType === 'Admin'">
                        <v-col cols="4" class="pr-0">
                            <h6>ADMIN</h6>
                        </v-col>
                        <v-col  class="px-0">
                            <v-divider color="white"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col class="py-0">
                            <v-list dense>
                                <!-- <v-subheader>LIST COMPONENTS:</v-subheader> -->
                                <v-list-item v-for="(item, i) in cFilteredItems" :key="i" :to="item.to">
                                    <v-list-item-icon>
                                        <!-- <span class="cursor" style="font-size: larger;" >{{ item.icon }}</span> -->
                                            <v-img :src="'images/Icons/' + item.icon" max-height="25" max-width="25"></v-img>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title style="text-align:left; font-weight:bold">{{ item.text }}</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-col>
                    </v-row>
                </v-card>
            </template>

            <template v-slot:append>
               <div class="pa-2">
                  <v-btn block color="error" @click="mLogoutDialog()">
                     Logout
                  </v-btn>
               </div>
            </template>

        </v-navigation-drawer>

        <v-app-bar app dark color="#404040" v-if="cMyCredential">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>
                <v-img max-height="50" max-width="200" src="images/ALCATRACK.png"></v-img>
            </v-toolbar-title>
         </v-app-bar>

        <v-app-bar app style="background-color: transparent;" flat v-else>
            <v-toolbar-title>
                <v-img  max-height="50" max-width="200"  src="images/ALCATRACK-2.png"></v-img>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-tooltip bottom v-if="this.$route.path == '/login'">
                <template v-slot:activator="{ on, attrs }">
                    <span
                        class="cursor"
                        v-on="on"
                        v-bind="attrs"
                        @click="GoToDashboard()"
                        style="font-size: xx-large;"
                    >
                        <v-img max-height="25" max-width="25" src="images/Icons/home.png"></v-img>
                    </span>
                </template>
                <span>Home</span>
            </v-tooltip>

            <v-tooltip bottom v-else>
                <template v-slot:activator="{ on, attrs }">
                    <span
                    class="cursor"
                        v-on="on"
                        v-bind="attrs"
                        @click="GoToLogin()"
                        style="font-size: xx-large;"
                    >
                        <v-img max-height="25" max-width="25" src="images/Icons/login.png"></v-img>
                    </span>
                </template>
                <span>Login</span>
            </v-tooltip>

        </v-app-bar>

      

        <v-footer app padless dark v-if="cMyCredential">
            <v-col class="text-center" cols="12">
                <marquee>
                    <strong>{{ footer.title }}</strong>
                    <span class="caption">{{ footer.text }}</span>
                </marquee>
            </v-col>
        </v-footer>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    data: () => ({
        footer: {
            title: "© 2024 BSCS-4F GROUP 3",
            text: "All Rights Reserved",
        },
        selectedFile: [],
        urlPic: 'https://cdn.vuetifyjs.com/images/john.jpg',
        ImageName: '',
        loading: false,
        viewPicDialog: false,
        drawer: false,

        userView: [
            { text: 'Dashboard', icon: 'dashboard.png', to: '/', show: true  },
            { text: 'User List', icon: 'phone-book.png', to: 'userlist', show: true  },
        ],

        items: [
            { text: 'Graph', icon: 'chart.png', to: 'graph', show: false },
            { text: 'Forum', icon: 'forum.png', to: 'forum', show: false },
            { text: 'Courses', icon: 'course.png', to: 'course', show: false },
            { text: 'Registered Alumnis', icon: 'registered.png', to: 'registeredalumnis', show: false },
            { text: 'Registered Accounts', icon: 'social-page.png', to: 'registeredaccounts', show: false },
            
        ]
    }),

    created() {
        // this.getProfilePic()
        // console.log(this.$store.state.UserInfo.UserTypeName);
    },


    watch: {

    },
    

    computed: {
        cFilteredItems(){
            return this.items.filter(item => 
                this.$store.state.UserInfo.UserType === 'Admin' || item.show
            )
        },

        cMyCredential(){
            return this.$store.state.UserInfo.Username != undefined;
        },

        cAccountName(){
            return this.$store.state.UserInfo.FirstName + " " + this.$store.state.UserInfo.LastName
        },

        cImageName(){
            if(this.$store.state.UserInfo.Image == 'blank.png'){
                return 'storage/UploadImage/blank.png' 
            }else{
                return 'storage/UploadImage/' + this.$store.state.UserInfo.AlumniID + '/' + this.$store.state.UserInfo.Image
            }
           
            
        }
        
    },

    methods: {
        // onImageLoad(){
        //     this.loading = true
        //     console.log(this.loading, 'tae');
        // },

        triggerFileInput(){
            this.$refs.fileInput.click();
        },

        handleFileChange(event){
            this.loading = true
            const file = event.target.files[0]
            if(file){
                this.selectedFile = file.name
                const formData = new FormData();
                formData.append('file', file);
                formData.append('user', this.$store.state.UserInfo.AlumniID)
                this.uploadImage(formData);
            }
            
        },

        uploadImage(formData){
            
            axios.post(`api/uploadProfilePic`, formData)
            .then((res) =>{
                console.log(res.data)
                if(res.data == 'Success'){
                    // this.insertImage()
                    this.updateImageStatus()
                }else{
                    Swal.fire({
                        title: 'Error',
                        text: 'Something happened upon uploading',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            })
        },


        insertImage(){
            let userID = this.$store.state.UserInfo.AlumniID
            axios.post(`api/imagelist?data=${this.selectedFile}&&id=${userID}`)
            .then((res) =>{
                if(res.data == 'success'){
                    this.getProfilePic() 
                }else{
                    Swal.fire({
                        title: 'Error',
                        text: 'Something happened upon uploading',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 3000
                    })
                }

            })
        },

        updateImageStatus(){
            let userID = this.$store.state.UserInfo.AlumniID
            let imageName = this.$store.state.UserInfo.Image
            axios.put(`api/imagelist/update?data=${imageName}&&id=${userID}`)
            .then((res) =>{
                if(res.data == 'updated'){
                    this. insertImage()
                }else{
                    Swal.fire({
                        title: 'Error',
                        text: 'Something happened upon uploading',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            })
        },

        getProfilePic(){
            let userID = this.$store.state.UserInfo.AlumniID
            if(userID != undefined){
                axios.get(`api/imagelist?id=${userID}`)
                .then((res) => {
                    this.$store.commit('UpdateProfilePic', res.data[0].ImageName)
                    this.loading = false
                    // console.log(this.loading);
                })
            }
        },


        GoToLogin(){
            if(this.$route.path != '/login'){
                this.$router.push('/login')
            }
        },

        GoToDashboard(){
            if(this.$route.path != '/'){
                this.$router.push('/')
            }
        },
        GoToAccount(){
            if(this.$route.path != '/account'){
                this.$router.push('/account')
            }
        },

        mLogoutDialog(){
            Swal.fire({
                title: "Are you sure?",
                text: "You wil be logged out",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "<span style='color: white;'>NO</span>",
                confirmButtonText: "<span style='color: white;'>YES</span>",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.mLogout()
                }
            })
        },

        mLogout(){
            if(this.$route.path != '/'){
                this.$router.push('/')
            }
            this.$store.commit('Logout');
        }
    },
}
</script>

<style>
/* #2f2626
#4c3c3c
#5f4c4c
#c5aa6a
#404040 
FREDOKA BOLD*/
#previewImage{
    border: 1px solid black;
    max-width: 800px;
    max-height: 500px;
}

.app_bar{
    background-image: linear-gradient(135deg, #F9F7F7, #3F72AF);
}

.cursor{
    cursor: pointer;
}

.title-card{
    background-image: linear-gradient(  #3F72AF,#D1E9F6);
}


.spinner {
  width: 80px;
  height: 80px;
  --clr: rgb(127, 207, 255);
  --clr-alpha: rgb(127, 207, 255, .1);
  animation: spinner 2s infinite linear;
  transform-style: preserve-3d;
}

.spinner > div {
  background-color: var(--clr-alpha);
  height: 100%;
  position: absolute;
  width: 100%;
  border: 5px solid var(--clr);
}

.spinner div:nth-of-type(1) {
  transform: translateZ(-40px) rotateY(180deg);
}

.spinner div:nth-of-type(2) {
  transform: rotateY(-270deg) translateX(50%);
  transform-origin: top right;
}

.spinner div:nth-of-type(3) {
  transform: rotateY(270deg) translateX(-50%);
  transform-origin: center left;
}

.spinner div:nth-of-type(4) {
  transform: rotateX(90deg) translateY(-50%);
  transform-origin: top center;
}

.spinner div:nth-of-type(5) {
  transform: rotateX(-90deg) translateY(50%);
  transform-origin: bottom center;
}

.spinner div:nth-of-type(6) {
  transform: translateZ(40px);
}

@keyframes spinner {
  0% {
    transform: rotate(0deg) rotateX(0deg) rotateY(0deg);
  }

  50% {
    transform: rotate(180deg) rotateX(180deg) rotateY(180deg);
  }

  100% {
    transform: rotate(360deg) rotateX(360deg) rotateY(360deg);
  }
}
</style>