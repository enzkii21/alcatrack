<template>
    <v-container >
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col cols="12" align="center" justify="center">
                    <v-img max-height="100" max-width="450" src="images/USER-LIST.png"></v-img>
                </v-col>
            </v-row>
            <v-row v-if="userList.length == 0" align="center" justify="center">
                <v-col class="py-16">
                    <center>
                        <h1 style="color:rgb(202, 198, 198)">NO DATA AVAILABLE!</h1>
                    </center>
                </v-col>
            </v-row>
            <v-row align="center" justify="center" v-else>
                <v-col cols="12">
                    <v-toolbar flat>
                        <v-row align="center" justify="center">
                            <v-col cols="4">
                                <v-text-field
                                    v-model="searchUser"
                                    placeholder="Search"
                                    dense
                                    solo
                                    outlined
                                    prepend-inner-icon="mdi-magnify"
                                />
                            </v-col>
                        </v-row>
                    </v-toolbar>
                </v-col>
                <v-col cols="12" xl="2" lg="4" md="6" sm="8" xs="12" v-for="(items,i) in searchFilter" :key="i">
                    <template>
                        <v-tooltip top color="#c5aa6a">
                            <template v-slot:activator="{ on, attrs }"> 
                                <v-hover>
                                    <template v-slot:default="{hover}">
                                        <v-card 
                                            dark 
                                            :style="hover ? 'border: 2px solid #c5aa6a' : 'border: 2px solid black'" 
                                            :elevation="hover ? 24 : 0" @click="mviewUser(items)"
                                            v-on="on"
                                            v-bind="attrs"
                                        >
                                            <v-card-text  class="justify-center pa-0" style="background-color:#2f2626">
                                                <v-row no-gutters align="center" justify="center">
                                                    <v-col align="center" justify="center">
                                                        <v-avatar size="128" rounded>
                                                            <v-img v-if="items.ImageName != 'blank.png'"
                                                                :src="'storage/UploadImage/' + items.AlumniID + '/' + items.ImageName"
                                                            ></v-img>
                                                            <v-img v-else
                                                                :src="'storage/UploadImage/' + items.ImageName"
                                                            ></v-img>
                                                        </v-avatar>
                                                    </v-col>
                                                    
                                                    <v-col >
                                                        <v-container fluid class="pa-0">
                                                            <v-row no-gutters align="center" justify="center">
                                                                <v-col cols="2">
                                                                    <v-icon small>mdi-account-circle</v-icon>
                                                                </v-col>
                                                                <v-col>
                                                                    <h5>{{ items.FirstName + ' ' + items.LastName + ' ' + items.Suffix }} </h5>
                                                                </v-col>
                                                            </v-row>
                                                            <v-row no-gutters align="center" justify="center">
                                                                <v-col cols="2">
                                                                    <v-icon small>mdi-cake</v-icon>
                                                                </v-col>
                                                                <v-col>
                                                                    <h5>{{ transformBirthDate(items.BirthDate) }}</h5>
                                                                </v-col>
                                                            </v-row >
                                                            <v-row no-gutters align="center" justify="center">
                                                                <v-col cols="2">
                                                                    <v-icon small>mdi-school</v-icon>
                                                                </v-col>
                                                                <v-col>
                                                                    <h5>{{ items.CourseAbvr }}</h5>
                                                                </v-col>
                                                            </v-row>
                                                            <v-row no-gutters align="center" justify="center">
                                                                <v-col cols="2">
                                                                    <v-icon small>mdi-seal</v-icon>
                                                                </v-col>
                                                                <v-col>
                                                                    <h5>S.Y {{ items.Batch }}</h5>
                                                                </v-col>
                                                            </v-row>
                                                            <v-row no-gutters align="center" justify="center">
                                                                <v-col cols="2">
                                                                    <v-icon small>mdi-briefcase-variant</v-icon>
                                                                </v-col>
                                                                <v-col>
                                                                    <h5>{{ items.LatestJobTitle }}</h5>
                                                                </v-col>
                                                            </v-row>
                                                        </v-container>
                                                    </v-col>
                                                </v-row>
                                            </v-card-text>
                                        </v-card>
                                    </template>
                                </v-hover>
                            </template>
                            <span>Click to see photos</span>
                        </v-tooltip>
                    </template>
                </v-col>
            </v-row>
        </v-card>
        <template>
            <!-- <div class="text-center"> -->
                <v-pagination
                class="pt-3"
                v-model="pageNumber"
                :length="cUserListpage"
                :total-visible="5"
                prev-icon="mdi-menu-left"
                next-icon="mdi-menu-right"
                ></v-pagination>
            <!-- </div> -->
        </template>









        <!-- <v-hover>
            <template v-slot:default="{hover}">
                <v-card :style="hover ? 'border: 1px solid black' : ''" color="#c5aa6a" :elevation="hover ? 24 : 0" @click="mviewUser(items)">
                    <v-card-text>
                        <v-row align="center" justify="center">
                            <v-avatar size="48">
                                <v-img v-if="items.ImageName != 'blank.png'"
                                    :src="'storage/UploadImage/' + items.AlumniID + '/' + items.ImageName"
                                ></v-img>
                                <v-img v-else
                                    :src="'storage/UploadImage/' + items.ImageName"
                                ></v-img>
                            </v-avatar>
                        </v-row>
                        <v-row  align="center" justify="center">
                            <span><b>{{ items.FirstName + ' ' + items.LastName + ' ' + items.Suffix }}</b></span>
                        </v-row>
                        <v-row align="center" justify="center">
                            <span>{{ items.Batch }}</span>
                        </v-row >
                        <v-row align="center" justify="center">
                            <span>{{ items.CourseName }}</span>
                        </v-row >
                        <v-row align="center" justify="center">
                            <span>{{ items.LatestJobTitle }}</span>
                        </v-row>
                    </v-card-text>
                </v-card>
            </template>
        </v-hover> -->


        <!-- <template>
            <v-dialog v-model="viewDialog" max-width="1200px" persistent>
                <v-card >
                    <v-card-title style="background-color:#404040 ;color:white" class="justify-center">
                        <h1>{{ dialogName }}</h1>
                        <v-spacer/>
                        <span class="cursor" @click="mcloseDialog()">❌</span>
                    </v-card-title>
                    <v-container fluid>
                        <v-row justify="center" align="center">
                            <v-col cols="12" >
                                <v-tabs v-model="tabs" centered color="#404040">
                                    <v-tab v-for="(items,i) in tabHeader" :key="i">
                                        {{ items.label }}
                                    </v-tab>
                                </v-tabs>

                                <v-tabs-items v-model="tabs">
                                    <v-tab-item>
                                        <v-card>
                                            <v-card-text>
                                                <v-row>
                                                    <v-col>
                                                        <span>test1</span>
                                                    </v-col>
                                                </v-row>
                                            </v-card-text>
                                        </v-card>
                                    </v-tab-item>
                                    <v-tab-item>
                                        <v-row align="center" justify="center" v-if="toShowCareer == 'N/A'">
                                            <v-col align="center" justify="center" class="py-16">
                                                <span>
                                                    <h1 style="color:rgb(202, 198, 198)">NO DATA AVAILABLE!</h1>
                                                </span>
                                            </v-col>
                                        </v-row>
                                        <v-row align="center" justify="center" v-else>
                                            <v-col align="center" justify="center">
                                                <v-timeline>
                                                    <v-timeline-item 
                                                        icon="mdi-briefcase-variant-outline"
                                                        color="#2f2626"
                                                        v-for="(items,i) in userCareer" :key="i">

                                                        <template v-slot:opposite>
                                                            <span class="headline font-weight-bold"
                                                            >{{ TransformDate(items.StartDate,items.EndDate) }}</span>
                                                        </template>

                                                        <v-card class="mx-auto" max-width="400px" dark color="#c5aa6a">
                                                            <v-card-title style="text-transform: uppercase;" class="text-h6">{{ items.JobTitle }}</v-card-title>
                                                            <v-card-text class="white text--primary">
                                                                <v-row no-gutters>
                                                                    <v-col cols="12">
                                                                        <span style="font-weight:bold">Company Name</span>
                                                                    </v-col>
                                                                    <v-col style="text-align: center;text-transform: uppercase;" >
                                                                        <v-chip small >{{ items.CompanyName }}</v-chip>
                                                                    </v-col>
                                                                </v-row>
                                                                <v-row no-gutters >
                                                                    <v-col cols="12">
                                                                        <span style="font-weight:bold">Company Address</span>
                                                                    </v-col>
                                                                    <v-col style="text-align: center;text-transform: uppercase;">
                                                                        <v-chip small>{{ items.CompanyAddress }}</v-chip>
                                                                    </v-col>
                                                                </v-row>
                                                            </v-card-text>
                                                        </v-card>
                                                    </v-timeline-item>
                                                </v-timeline>
                                            </v-col>
                                        </v-row>
                                    </v-tab-item>
                                    <v-tab-item>
                                        <v-card>
                                            <v-card-text>
                                                <v-row align="center" justify="center" v-if="userPicture.length != 0">
                                                    <v-col cols="12" xl="2" lg="4" md="6" sm="8" xs="12"  v-for="(items, i) in userPicture" :key="i" class="d-flex child-flex" >
                                                        
                                                        <v-hover>
                                                                <template v-slot:default="{hover}">
                                                                    <v-card outlined :elevation="hover ? 24:6" >
                                                                        <v-card-text >
                                                                            <v-row align="center" justify="center">
                                                                                <v-col cols="12">
                                                                                <center>
                                                                                        <v-img
                                                                                            class="cursor"
                                                                                            :src="'storage/UploadImage/' + items.AlumniID + '/' + items.img "
                                                                                            max-height="200px"
                                                                                            @click="mViewPhoto(items.img,items.AlumniID)">

                                                                                            <template v-slot:placeholder>
                                                                                                <v-row class="fill-height ma-0" align="center" justify="center" >
                                                                                                    <v-progress-circular indeterminate/>
                                                                                                </v-row>
                                                                                            </template>
                                                                                        </v-img>
                                                                                </center>
                                                                                </v-col>
                                                                            </v-row>
                                                                        </v-card-text>
                                                                    </v-card>
                                                                </template>
                                                        </v-hover>
                                                    </v-col>
                                                </v-row>
                                                <v-row align="center" justify="center" v-else>
                                                    <v-col class="py-16">
                                                        <center>
                                                            <h1 style="color:rgb(202, 198, 198)">NO IMAGE AVAILABLE!</h1>
                                                        </center>
                                                    </v-col>
                                                </v-row>
                                            </v-card-text>
                                        </v-card>
                                    </v-tab-item>
                                </v-tabs-items>
                            </v-col>
                        </v-row>
                    </v-container>
                        <template>
                            <v-overlay :value="overlayDialog">
                                <div class="spinner">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                </div>
                            </v-overlay>
                        </template>
                </v-card>
            </v-dialog>
            
        </template> -->


        <template>
            <v-dialog v-model="viewDialog" max-width="600px">
                <v-card>
                    <v-card-title class="justify-center " style="background-color:#404040; color:white">
                      {{ dialogName }}
                      <v-spacer/>
                        <span class="cursor" @click="mcloseDialog()">❌</span>
                    </v-card-title>
                    <v-container fluid>
                        <v-card-text>
                            <v-row align="center" justify="center" v-if="userPicture.length != 0">
                                <v-col cols="12" xl="2" lg="4" md="6" sm="8" xs="12"  v-for="(items, i) in userPicture" :key="i" class="d-flex child-flex" >
                                    
                                    <v-hover>
                                            <template v-slot:default="{hover}">
                                                <v-card outlined :elevation="hover ? 24:6" >
                                                    <v-card-text >
                                                        <v-row align="center" justify="center">
                                                            <v-col cols="12">
                                                            <center>
                                                                    <v-img
                                                                        class="cursor"
                                                                        :src="'storage/UploadImage/' + items.AlumniID + '/' + items.img "
                                                                        max-height="200px"
                                                                        @click="mViewPhoto(items.img,items.AlumniID)">

                                                                        <template v-slot:placeholder>
                                                                            <v-row class="fill-height ma-0" align="center" justify="center" >
                                                                                <v-progress-circular indeterminate/>
                                                                            </v-row>
                                                                        </template>
                                                                    </v-img>
                                                            </center>
                                                            </v-col>
                                                        </v-row>
                                                    </v-card-text>
                                                </v-card>
                                            </template>
                                    </v-hover>
                                </v-col>
                            </v-row>
                            <v-row align="center" justify="center" v-else>
                                <v-col class="py-16">
                                    <center>
                                        <h1 style="color:rgb(202, 198, 198)">NO IMAGE AVAILABLE!</h1>
                                    </center>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-container>
                    <template>
                        <v-overlay :value="overlayDialog">
                            <div class="spinner">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            </div>
                        </v-overlay>
                    </template>
                </v-card>
            </v-dialog>
        </template>



        <template>
            <v-dialog v-model="viewPicDialog" width="auto" flat>
                    <v-card flat >
                        <center>
                            <v-img max-height="600px" max-width="800px" contain :src="viewURL"/>
                        </center>
                    </v-card>
                <!-- </v-card> -->
            </v-dialog>
        </template>


        <template>
            <v-overlay :value="overlay">
                <div class="spinner">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                </div>
            </v-overlay>
        </template>


    </v-container>
</template>

<script>
import moment from "moment";
export default {
    data(){
        return{
            searchUser: '',
            toShowCareer: '',
            dialogName: '',
            UserID: '',
            viewURL: '',
            profileName: '',
            tabs: null,
            overlay: false,
            overlayDialog: false,
            viewDialog: false,
            viewPicDialog: false,
            userList: [],
            userPicture:[],
            userCareer:[],
            tabHeader: [
                {label: 'Profile'},
                {label: 'Job'},
                {label: 'Gallery'},
            ],
            userListpage: '',
            pageNumber: 1,
            r: 0,
            g: 0,
            b: 0,
        }
    },

    created() {
        this.mgetUserlist()
    },

    watch: {
        // watchColor(){
            
        //     if(this.is)
        // }
    },

    computed: {
        searchFilter(){
            return this.userList.filter(rec => {
                if(this.searchUser){
                    return rec.FirstName.toUpperCase().includes(this.searchUser.toUpperCase()) ||
                    rec.MiddleName.toUpperCase().includes(this.searchUser.toUpperCase()) ||
                    rec.LastName.toUpperCase().includes(this.searchUser.toUpperCase()) ||
                    rec.Suffix.toUpperCase().includes(this.searchUser.toUpperCase()) ||
                    rec.CourseName.toUpperCase().includes(this.searchUser.toUpperCase()) ||
                    rec.LatestJobTitle.toUpperCase().includes(this.searchUser.toUpperCase()) ||
                    rec.Batch.toString().includes(this.searchUser.toString()) 
                }else{
                    return rec;
                }
            })
        },
 
        cUserList(){
            const start = (this.pageNumber - 1) * 12, end = start + 12;
            return this.userList.slice(start, end);
        },
        cUserListpage(){
            let length = this.userList.length
            return Math.ceil(length/12);
        },

        


        cardStyle(){
            this.isHover = true
            if(this.isHover){
                return {
                    border: this.getRandomColor, 
                    elevation: 24
                };
            }else{
                return {
                    border: '2px solid black',
                    elevation: 0
                };
            }
        },
        

        
       

        
    },

    methods: {
 

        mgetUserlist(){
            this.overlay = true
            axios.get('api/userlist')
            .then((res) =>{
                this.userList = res.data
                this.overlay = false
            })
        },

        mgetPictures(){
            this.overlayDialog = true
            axios.get(`api/userlist/show?method=PICTURE&&userID=${this.UserID}`)
            .then((res) =>{
                this.userPicture = res.data
                this.overlayDialog = false
            })
        },

        mgetCareerInfo(){
            axios.get(`api/userlist/show?method=CAREER&&userID=${this.UserID}`)
            .then((res) =>{
                
                this.userCareer = res.data
                this.toShowCareer = this.userCareer[0].StartDate
                this.overlayDialog = false
            })
        },

        mviewUser(data){
            this.dialogName = data.FirstName + "'s Gallery"
            this.UserID = data.AlumniID
            this.profileName = data.ImageName
            this.viewDialog = true
            // this.mgetCareerInfo()
            this.mgetPictures()
        },

        TransformDate(start,end){
            return moment(start).format('MMMM YYYY') 
            // + ' ~ ' + moment(end).format('MMMM YYYY');
        },

        transformBirthDate(item){
            return moment(item).format('ll') 
        },

        mViewPhoto(url,id){
            this.viewPicDialog = true
            this.viewURL = 'storage/UploadImage/' + id + '/' + url
        },


        mcloseDialog(){
            this.viewDialog= false
            this.userCareer= []
            this.dialogName = ''
            this.UserID = ''
            this.userPicture = []
        }

        
    },
}
</script>
<style scoped>

.large-name {
  font-size: 1.25rem; /* Adjust this value as needed */
}
.v-card:hover {
  transition: border-color 0.3s ease-in-out;
}
.cardBorder_black{
    border: 1px solid black
}


</style>