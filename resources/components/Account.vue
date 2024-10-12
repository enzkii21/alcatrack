<template>
    <v-layout>
        <v-container>
            <v-card flat>
                <v-tabs
                    flat
                    centered
                    icons-and-text
                    v-model="tabIndex"
                    color="#404040"
                >
                    <v-tab>Profile
                        <v-icon>mdi-account-tie</v-icon>
                    </v-tab>
                    <v-tab>Jobs
                        <v-icon>mdi-briefcase-account</v-icon>
                    </v-tab>
                    <v-tab>Gallery
                        <v-icon>mdi-image</v-icon>
                    </v-tab>
                    <v-tab>Settings
                        <v-icon>mdi-cog</v-icon>
                    </v-tab>
                </v-tabs>
                
                <v-tabs-items v-model="tabIndex" flat>
                    <v-tab-item>
                        <v-card flat  max-width="500px" class="mx-auto">
                            <v-card-text>
                                <v-row no-gutters  v-for="(item, index) in profileData" :key="index">
                                    <v-col cols="3" class="pt-2">
                                        <span >{{ item.label }}</span>
                                    </v-col>
                                    <v-col >
                                        <v-text-field
                                            v-if="item.label == 'Age'"
                                            dense
                                            outlined
                                            v-model="item.value"
                                            readonly
                                            hint="This field is based on the Birth Date"
                                            
                                        />

                                        <v-text-field
                                            v-else
                                            dense
                                            outlined
                                            v-model="item.value"
                                            :readonly="item.isDisabled == 1 ? true : false"
                                            :hint="item.isEditable == 'yes' ? 'Double click to edit': ''"
                                            @dblclick="meditDialog(item.value,item.isEditable,item.label)"
                                        />
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item>
                        <v-row align="center" justify="center" v-if="toshowCareer == 'N/A'">
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
                                        v-for="(items,index) in careerData" :key="index"
                                    >
                                        <template v-slot:opposite>
                                            <span class="headline font-weight-bold"
                                            >{{ TransformDate(items.StartDate) }}</span>
                                        </template>

                                        <v-card class="mx-auto" max-width="400px" dark color="#c5aa6a">
                                            <v-card-title  style="text-transform: uppercase;" class="text-h6">{{ items.JobTitle }}
                                                <v-spacer/>
                                                <v-btn
                                                    @click="mEditJob(items)"
                                                    fab
                                                    small
                                                ><span style="font-size: x-large;">🖉</span></v-btn>
                                            </v-card-title>
                                            <v-card-text class="white text--primary">
                                                <v-row no-gutters >
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
                                                <!-- <v-row no-gutters >
                                                    <v-col cols="12">
                                                        <span style="font-weight:bold">Length of Service</span>
                                                    </v-col>
                                                    <v-col style="text-align: center;text-transform: uppercase;">
                                                        <v-chip small>{{ items.LengthOfService }}</v-chip>
                                                    </v-col>
                                                </v-row> -->
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
                                <v-row align="center" justify="center" v-if="ImageURL.length != 0">
                                    <v-col cols="12" xl="2" lg="4" md="6" sm="8" xs="12"  v-for="(items, i) in ImageURL" :key="i" class="d-flex child-flex" >
                                        <!-- <v-container > -->
                                           <v-hover>
                                                <template v-slot:default="{hover}">
                                                    <v-card outlined :elevation="hover ? 24:6" >
                                                        <v-card-title class="py-0" >
                                                            <v-spacer/>
                                                            <!-- <span @click="deleteImage(items.ImageID)"  class="cursor" style="font-size: x-small">❌</span> -->
                                                            <v-menu offset-y close-on-content-click tile>
                                                                <template v-slot:activator="{on, attrs}">
                                                                    <v-btn
                                                                        v-on="on"
                                                                        v-bind="attrs"
                                                                        icon
                                                                    >
                                                                        <v-icon>mdi-dots-horizontal</v-icon>
                                                                    </v-btn>
                                                                </template>
                                                                <v-list>
                                                                    <v-list-item @click="updateProfilePic(items.ImageID)" v-if="items.isProfile != 1">
                                                                        <h6>SET AS PROFILE</h6>
                                                                    </v-list-item>
                                                                    <v-list-item @click="deleteImage(items.ImageID)">
                                                                        <h6>DELETE</h6>
                                                                    </v-list-item>
                                                                </v-list>
                                                            </v-menu>
                                                        </v-card-title>
                                                        <!-- <v-card-title  v-else>
                                                        </v-card-title> -->
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
                                        <!-- </v-container> -->
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
                    <v-tab-item>
                        <v-card>
                            <v-card-text>
                                <v-btn v-if="this.$store.state.UserInfo.UserType != 'Admin'" 
                                    @click="mPrivateAccount()" block depressed  plain>
                                    {{ isPrivateTrigger == 1 ? 'public my account' : 'private my account' }}
                                </v-btn>
                                <v-btn @click="mDelete()" block depressed color="error" plain>
                                    Delete my Account
                                </v-btn>
                                
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>

                <v-tooltip top v-if="tabIndex == 1 && this.$store.state.UserInfo.UserType != 'Admin'">
                    <template v-slot:activator="{on, attrs}">
                        <v-speed-dial
                            v-if="tabIndex == 1"
                            :top="top"
                            :bottom="bottom"
                            :right="right"
                            :left="left"
                            :direction="direction"
                            :open-on-hover="hover"
                            :transition="transition"
                            fixed
                        >
                            <template v-slot:activator>
                                <v-btn
                                    v-model="fab"
                                    color="green darken-2"
                                    dark
                                    fab
                                    v-on="on"
                                    v-bind="attrs"
                                    @click="(jobDialog = true),(boolAddUpdate = 0)"
                                >
                                    <span style="font-size: large" >➕</span>
                                </v-btn>
                            </template>
                        </v-speed-dial>
                    </template>
                    <span>Add Job Profile</span>
                </v-tooltip>




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
                    <v-dialog v-model="editDialog" max-width="400px" persistent>
                        <v-card>
                            <v-card-title  style="background-color:#404040 ;color:white">
                                <span> ✏️ Edit {{ editTitle }}</span>
                                <v-spacer/>
                                <span class="cursor" @click="editDialog = false">❌</span>
                            </v-card-title>
                            <v-card-text class="pb-0 pt-2">
                                <v-text-field
                                    dense
                                    outlined
                                    v-model="oldEditModel"
                                    readonly
                                    :label="oldTextfieldLabel"
                                />

                                <v-menu v-if="editTitle == 'Birth Date'"
                                    v-model="menu1"
                                    :close-on-content-click="false"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto">
                                    <template v-slot:activator="{on,attrs}">
                                      <v-text-field
                                          v-model="formatFirstDate"
                                          hide-details
                                          background-color="#E0E0E0"
                                          outlined
                                          dense
                                          label="New Birth Date"
                                          readonly
                                          v-bind="attrs"
                                          v-on="on"
                                        /> 
                                    </template>
                                    <v-date-picker
                                        v-model="birthDate"
                                        header-color="#26A69A"
                                        color="#80CBC4"
                                        @change="updateFormattedDates()"
                                        :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
                                      >
                                    </v-date-picker>
                                </v-menu>

                                <v-text-field
                                    v-else
                                    dense
                                    outlined
                                    v-model="newEditModel"
                                    @keydown="preventSpace($event,newEditModel)"
                                    @keypress="editTitle == 'Contact Number' ? isNumber($event) : ''"
                                    :label="newTextfieldLabel"
                                    :maxlength="editTitle == 'Contact Number' ? 11 : ''"
                                />
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer/>
                                <v-btn color="success" @click="mSaveEdit(ageComputed)"> 💾 SAVE</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </template>

                <template>
                    <v-dialog v-model="jobDialog" max-width="400px" persistent>
                        <v-card>
                            <v-card-title  style="background-color:#404040 ;color:white">{{ boolAddUpdate == 1 ? 'Edit Job Profile' : 'Add Job Profile' }}
                                <v-spacer/>
                                <span class="cursor" @click="(jobDialog = false),(objData = {})">❌</span>
                            </v-card-title>
                            <v-card-text class="pt-2">
                                <v-row no-gutters>
                                    <v-col>
                                        <v-text-field
                                            v-model="objData.JobTitle"
                                            label="Job Title"
                                            dense
                                            outlined
                                        />
                                    </v-col>
                                </v-row>
                                <v-row no-gutters>
                                    <v-col>
                                        <v-text-field
                                            v-model="objData.CompanyName"
                                            label="Company Name"
                                            dense
                                            outlined
                                        />
                                    </v-col>
                                </v-row>
                                <v-row no-gutters>
                                    <v-col>
                                        <v-text-field
                                            v-model="objData.CompanyAddress"
                                            label="Company Address"
                                            dense
                                            outlined
                                        />
                                    </v-col>
                                </v-row>
                                <v-row no-gutters>
                                    <v-col>
                                        <v-menu 
                                            v-model="menuStart"
                                            :close-on-content-click="false"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                        >
                                            <template v-slot:activator="{on,attrs}">
                                                <v-text-field
                                                    v-model="objData.StartDate"
                                                    background-color="#E0E0E0"
                                                    outlined
                                                    dense
                                                    label="Start Date"
                                                    prepend-inner-icon="mdi-calendar"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                /> 
                                            </template>
                                                <v-date-picker
                                                    v-model="startDate"
                                                    header-color="#26A69A"
                                                    color="#80CBC4"
                                                    type="month"
                                                    @change="updateStartDate()"
                                                    :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
                                                >
                                            </v-date-picker>
                                        </v-menu>
                                    </v-col>
                                </v-row>

                                <!-- <v-row no-gutters>
                                    <v-col>
                                        <v-menu 
                                            v-model="menuEnd"
                                            :close-on-content-click="false"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto">
                                                <template v-slot:activator="{on,attrs}">
                                                    <v-text-field
                                                        v-model="objData.EndDate"
                                                        background-color="#E0E0E0"
                                                        outlined
                                                        dense
                                                        label="End Date"
                                                        prepend-inner-icon="mdi-calendar"
                                                        readonly
                                                        v-bind="attrs"
                                                        v-on="on"
                                                    /> 
                                                </template>
                                                <v-date-picker
                                                    v-model="endDate"
                                                    header-color="#26A69A"
                                                    color="#80CBC4"
                                                    type="month"
                                                    :disabled="disabledDate"
                                                    @change="updateEndDate()"
                                                    :min="getMinEndDate"
                                                    :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
                                                >
                                                </v-date-picker>
                                        </v-menu>
                                    </v-col>
                                </v-row> -->

                                <div class="radio-container">
                                    <span class="mb-0">Related to your course?</span>
                                    <v-radio-group hide-details v-model="objData.IsRelated" row class="mt-0 pt-0">
                                      <v-radio
                                        class="mt-0"
                                        :value="1"
                                        label="Yes"
                                      ></v-radio>
                                      <v-radio
                                        class="mt-0"
                                        :value="2"
                                        label="No"
                                      ></v-radio>
                                    </v-radio-group>
                                  </div>

                            </v-card-text>
                            <v-card-actions>
                                <v-spacer/>
                                <v-btn @click="mInsertJobProfile()">SAVE</v-btn>
                            </v-card-actions>
                        </v-card>
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

            </v-card>
        </v-container>
    </v-layout>
</template>

<script>
import CryptoJS from 'crypto-js'
import Swal from 'sweetalert2'
import moment from "moment";
export default {
    data() {
        return {
            overlay: false,
            // urlPic: 'https://cdn.vuetifyjs.com/images/john.jpg',
            ImageURL: [],
            isPrivateTrigger: '',
            viewURL: '',
            boolAddUpdate: 0,
            viewPicDialog: false,
            menuStart: false,
            menuEnd: false,
            EndFormatDate: '',
            endDate: '',
            StartFormatDate: '',
            startDate:'',
            rCompanyAddress: '',
            rCompanyName: '',
            rJobTitle: '',

            direction: 'top',
            fab: false,
            fling: false,
            hover: false,
            tabs: null,
            top: false,
            right: true,
            bottom: true,
            left: false,
            transition: 'slide-y-reverse-transition',

            jobDialog: false,

            isrelatedToCourse: null,

            toshowCareer: '',
            tabIndex: null,
            objData: {},
            user:[],
            profileData:[],
            careerData: [],
            jobDescription: [
                {label: 'Company Name',value: ''},
                {label: 'Job Title', value: ''},
                {label: 'Company Address', value: ''},
                {label: 'Length of Service', value: ''},
                {label: 'Company Name', value: ''},

            ],
            JobID: '',
            editDialog: false,
            editTitle: '',
            oldEditModel: '',
            newEditModel: '',
            oldTextfieldLabel: '',
            newTextfieldLabel: '',
            menu1: false,
            formatFirstDate:'',
            birthDate: '',
        }
    },

    created() {
        this.mgetAccounts()
        this.mgetCareerInfo()
        this.mgetPictures()
    },

    watch: {
        
    },

    computed: {


    //     computeLOS(){
    //     if(this.objData.StartDate &&  this.objData.EndDate){
    //         const start = moment(this.objData.StartDate, 'YYYY-MM');
    //         const end = moment(this.objData.EndDate, 'YYYY-MM');

    //         let diff = end.diff(start, 'month', true);

    //         diff = Math.round(diff);

    //         let years = Math.floor(diff / 12);
    //         let remainingMonths = diff % 12;

    //       // Format the result
    //         if (years > 0 && remainingMonths > 0) {
    //             return `${years} Year/s and ${remainingMonths} Month/s`;
    //         } else if (years > 0) {
    //             return `${years} Year/s`;
    //         } else if (remainingMonths > 0) {
    //             return `${remainingMonths} Month/s`;
    //         } else {
    //             return '0';
    //         }
    //     }
        
    //   },


        isDisabled(){
            this.profileData.forEach(element => {
                if(element.isDisabled == 1){
                    return true
                }else{
                    return false
                }
           });
        },

        // getMinEndDate(){
        // if (!this.startDate) {
        //     return null;
        // }
        
        //     const startMonth = new Date(this.startDate).getMonth();
        //     const minEndDate = new Date(this.startDate);
        //     minEndDate.setMonth(startMonth);
        //     return minEndDate.toISOString().slice(0, 7);
        // },



      disabledDate(){
        if(!this.startDate){
            return true
        }else{
            return false
        }
      },

       

        ageComputed() {
            if (!this.formatFirstDate) {
                return '';
            }
            const currentDate = moment();
            const birthMoment = moment(this.birthDate);
            const ageYears = currentDate.diff(birthMoment, 'years');

            return ageYears;
      },
        
    },

    methods: {

        mViewPhoto(url,id){
            this.viewPicDialog = true
            this.viewURL = 'storage/UploadImage/' + id + '/' + url
        },

        updateStartDate(){
        //   this.StartFormatDate = this.startDate
            this.objData.StartDate = this.startDate
            this.menuStart = false
        },

        // updateEndDate(){
        //     // this.EndFormatDate = this.endDate
        //     this.objData.EndDate = this.endDate
        //     this.menuEnd = false
        // },

        preventSpace(e,data){
            if (e.key === ' ' && data.length === 0) {
                e.preventDefault();
                return false;
            }
        },

        isNumber(e) {
            let char = String.fromCharCode(e.keyCode);
            if (/^[0-9]+$/.test(char)) {
                return true;
            }
            else {
                e.preventDefault();
            }
        },

        mSaveEdit(item){
            let holdData = {
                formtitle: this.newTextfieldLabel,
                newdata: this.newTextfieldLabel == 'New Birth Date' ? this.formatFirstDate : this.newEditModel,
                age: item,
                user: this.user.AlumniID
            }
            axios.put(`api/accountsetting/update?
                method=PROFILE&&data=${holdData.newdata}&&title=${holdData.formtitle}&&user=${holdData.user}&&age=${holdData.age}`)
            .then((res) =>{
                if(res.data.status == 200){
                    this.mgetAccounts()
                    this.editDialog = false
                    Swal.fire({
                        title: res.data.result,
                        showConfirmButton: false,
                        icon: 'success',
                        timer: 3000
                    });
                }
            })

        },


        updateFormattedDates(){
          this.formatFirstDate = this.birthDate
          this.menu1 = false
        },

        mEditJob(item){
            this.jobDialog = true
            this.boolAddUpdate = 1
            this.objData.JobTitle = item.JobTitle
            this.objData.CompanyName = item.CompanyName
            this.objData.CompanyAddress = item.CompanyAddress
            this.objData.StartDate = item.StartDate
            // this.objData.EndDate = item.EndDate
            this.objData.IsRelated = item.IsRelated
            this.objData.LOS = this.computeLOS
            this.JobID = item.InfoID
            // console.log(this.objData);
        },


        meditDialog(item,bool,title){
            if(bool == 'yes'){
                this.newEditModel = ''
                this.editDialog = true
                this.editTitle = title
                this.oldEditModel = item
                this.oldTextfieldLabel = `Old ${title}`
                this.newTextfieldLabel = `New ${title}`
            }
        },

        TransformDate(start,end){
            return moment(start).format('MMMM YYYY') 
            // + ' ~ ' + moment(end).format('MMMM YYYY');
        },

        

        mgetCareerInfo(){
            let id = this.$store.state.UserInfo.AlumniID
            axios.get(`api/accountsetting?method=GET_CAREER&&ID=${id}`)
            .then((res)=>{
                // console.log(res.data);
                this.careerData = res.data
                this.toshowCareer = this.careerData[0].StartDate
            })
        },

        mInsertJobProfile(){
            let userID = this.$store.state.UserInfo.AlumniID
            if(this.boolAddUpdate == 1){
                axios.put(`api/accountsetting/update?method=JOB&&userID=${userID}&&InfoID=${this.JobID}&&LOS=${this.computeLOS}`, this.objData)
                .then((res) =>{
                    // console.log(res.data);
                    if(res.data == 'updated'){
                        this.mgetCareerInfo()
                        this.jobDialog = false
                        this.objData = {}
                        Swal.fire({
                            title: 'Updated Successfully',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 3000
                        });
                    }else{
                        Swal.fire({
                            title: "There's something happened",
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        });
                    }
                })
            }else{
                let data = {
                    userID: this.$store.state.UserInfo.AlumniID,
                    JobTitle: this.objData.JobTitle,
                    CompanyName: this.objData.CompanyName,
                    CompanyAddress:   this.objData.CompanyAddress,
                    StartDate: this.objData.StartDate,
                    // EndDate: this.objData.EndDate,
                    isRelated:   this.objData.IsRelated,
                    LOS: this.computeLOS,
                    InfoID: this.JobID
                }
                axios.post(`api/accountsetting`,  data)
                .then((res) =>{
                    if(res.data == 'success'){
                        this.mgetCareerInfo()
                        this.jobDialog = false
                        this.objData = {}
                        Swal.fire({
                            title: 'Added Successfully',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 3000
                        });
                    }else{
                        Swal.fire({
                            title: "There's something happened",
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        });
                    }
                })
            }
            
        },

        mgetAccounts(){
            this.profileData = []
            let id = this.$store.state.UserInfo.AlumniID
            axios.get(`api/accountsetting?method=GET_PROFILE&&ID=${id}`)
            .then((res)=>{
                this.user = res.data[0]
                this.isPrivateTrigger = this.user.isPrivate
                this.profileData.push({
                    label: 'ID',
                    value: this.user.AlumniID,
                    isDisabled: 1,
                    isEditable: 'no',
                })
                this.profileData.push({
                    label: 'First Name',
                    value: this.user.FirstName,
                    isDisabled: 1,
                    isEditable: 'no',
                })
                this.profileData.push({
                    label: 'Middle Name',
                    value: this.user.MiddleName,
                    isDisabled: 1,
                    isEditable: 'no',
                })
                this.profileData.push({
                    label: 'Last Name',
                    value: this.user.LastName,
                    isDisabled: 1,
                    isEditable: 'no',
                })
                this.profileData.push({
                    label: 'Suffix',
                    value: this.user.Suffix == '' ? 'N/A' : this.user.Suffix,
                    isDisabled: 1,
                    isEditable: 'no',
                })
                this.profileData.push({
                    label: 'Birth Date',
                    value: moment(this.user.BirthDate).format('YYYY-MM-DD'),
                    isDisabled: 1,
                    isEditable: 'yes',
                })
                this.profileData.push({
                    label: 'Age',
                    value: this.user.Age,
                    isDisabled: 1,
                    isEditable: 'no',
                })
                this.profileData.push({
                    label: 'Username',
                    value: this.user.Username,
                    isDisabled: 1,
                    isEditable: 'no',
                })
                this.profileData.push({
                    label: 'Password',
                    value: this.user.Password,
                    isDisabled: 1,
                    isEditable: 'yes',
                })
                this.profileData.push({
                    label: 'Email',
                    value: this.user.Email,
                    isDisabled: 1,
                    isEditable: 'yes',
                })
                this.profileData.push({
                    label: 'Contact Number',
                    value: this.user.ContactNumber,
                    isDisabled: 1,
                    isEditable: 'yes'
                    
                })
                this.profileData.push({
                    label: 'Course Graduated',
                    value: this.user.UserTypeID == 1 ? 'N/A' : this.user.CourseName,
                    isDisabled: 1,
                    isEditable: 'no'
                })
               
                
            })
        },

        mgetPictures(){
            this.overlay = true
            let userID = this.$store.state.UserInfo.AlumniID
            axios.get(`api/accountsetting?method=GET_PICTURE&&userID=${userID}`)
            .then((res) =>{
                this.ImageURL = res.data
                this.overlay = false
            })
        },


        updateProfilePic(pic){
            this.overlay = true
            let id = this.$store.state.UserInfo.AlumniID
            let oldPic = this.$store.state.UserInfo.Image
            axios.put(`api/accountsetting/update?method=UPDATE_PIC&&oldPic=${oldPic}&&newPic=${pic}&&id=${id}`)
            .then((res) =>{
                console.log(res.data);
                if(res.data == 'success'){
                    this.overlay = false
                    this.getProfilePic()
                    this.mgetPictures()
                    
                    Swal.fire({
                        title: 'Success',
                        text: 'Profile picture was updated!',
                        showConfirmButton: false,
                        icon: 'success',
                        timer: 3000
                    })
                }
                
            })
        },


        getProfilePic(){
            let userID = this.$store.state.UserInfo.AlumniID
                axios.get(`api/imagelist?id=${userID}`)
                .then((res) => {
                    this.$store.commit('UpdateProfilePic', res.data[0].ImageName)
                    this.loading = false
                    // console.log(this.loading);
                })
        },


        mDelete(){
            let data = {
                AlumniID: this.$store.state.UserInfo.AlumniID,
                method: 'delete'
            }
            Swal.fire({
                title: "Are you sure?",
                text: "User will be deleted",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "<span style='color: white;'>NO</span>",
                confirmButtonText: "<span style='color: white;'>YES</span>",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.overlay = true
                    axios.put(`api/accounts/update`, data)
                    .then((res)=>{
                        // console.log(res.data);
                        if(res.data == 'deleted'){
                            this.mLogout()
                            Swal.fire({
                                title: 'Success',
                                text: 'Data was deleted',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 3000
                            }).then(()=>{
                                this.overlay = false
                            });
                        }else{
                            Swal.fire({
                                title: 'Error',
                                text: 'Something happens upon deleting ',
                                showConfirmButton: false,
                                icon: 'error',
                                timer: 3000
                            }).then(()=>{
                                this.overlay = false
                            });
                        }
                    })
                    
                }
            })
        },

        mLogout(){
            if(this.$route.path != '/'){
                this.$router.push('/')
            }
            this.$store.commit('Logout');
        },

        deleteImage(id){
            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently deleted",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "<span style='color: white;'>NO</span>",
                confirmButtonText: "<span style='color: white;'>YES</span>",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) =>{
                if(result.isConfirmed){
                    this.overlay = true
                    let userID = this.$store.state.UserInfo.AlumniID
                    axios.put(`api/accountsetting/update?method=PICTURE&&ImgID=${id}&&userID=${userID}`)
                    .then((res) =>{
                        if(res.data = 'deleted'){
                            Swal.fire({
                                title: 'Success',
                                text: 'Data was deleted',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 3000
                            }).then(()=>{
                                this.overlay = false
                                this.mgetPictures()
                            });
                        }
                    })
                }
            })
            
        },


        mPrivateAccount(){
            let data = {
                AlumniID: this.$store.state.UserInfo.AlumniID,
                method: 'PRIVATE'
            }
            if(this.isPrivateTrigger == 0){
                axios.put(`api/accountsetting/update`, data)
                .then((res) =>{
                    if(res.data == 'success'){
                        this.mgetAccounts()
                        Swal.fire({
                            title: 'SUCCESS',
                            text: 'Account was set to private',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 3000
                        })
                    }else{
                        Swal.fire({
                            title: 'ERROR',
                            text: 'Something error happen ',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        })
                    }
                })
            }else if(this.isPrivateTrigger == 1){
                let data = {
                    AlumniID: this.$store.state.UserInfo.AlumniID,
                    method: 'PUBLIC'
                }
                axios.put(`api/accountsetting/update`, data)
                .then((res) =>{
                    if(res.data == 'success'){
                        this.mgetAccounts()
                        Swal.fire({
                            title: 'SUCCESS',
                            text: 'Account was set to public',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 3000
                        })
                    }else{
                        Swal.fire({
                            title: 'ERROR',
                            text: 'Something error happen ',
                            showConfirmButton: false,
                            icon: 'error',
                            timer: 3000
                        })
                    }
                })
            }

        }

    },
}
</script>


<style scoped>
/* This is for documentation purposes and will not be needed in your application */
#create .v-speed-dial {
position: absolute;
}

#create .v-btn--floating {
position: relative;
}



.radio-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  border: 1px solid GRAY;
  border-radius: 10px;
}
</style>