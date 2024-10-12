<template>
    <v-container fluid fill-height >
        <v-layout align-center justify-center>
            <v-card
            elevation="20"
            class="mx-auto pt-3 pb-3 pr-3 pl-3"
            width="600"
            color="#4c3c3c"
            >
                <v-row no-gutters>
                    <v-col
                        cols="4"
                        md="4"
                        sm="12"
                        xs="12"
                        align="center"
                        v-bind:style="loginStyle"
                    >
                        <v-row>
                            <v-col align-center justify-center>
                                <v-img
                                    alt="img"
                                    max-height="300"
                                    max-width="300"
                                    src="images/design2.png"
                                />
                            </v-col>
                        </v-row>

                        <div
                            class="mt-4"
                            style="margin: auto; text-align: center;"
                        >
                            <p class="infotext">This is an online system to organise  alumni data and boost  alumni engagement efforts.</p>
                        </div>

                        <div style="margin: auto; width: 80%"></div>

                    </v-col>

                    <v-col
                        cols="8"
                        md="8"
                        sm="12"
                        xs="12"
                        align="center"
                    >

                    <br/>

                    <template>
                    <v-img
                        contain
                        max-height="600"
                        max-width="500"
                        src="images/ALCATRACK-MANAGEMENT-SYSTEM.png"
                    ></v-img>
                    </template>

                    <v-form ref="form">
                        <v-card flat class="pt-n10" dark color="#4c3c3c" >
                            <v-card-text class="pb-0">
                                <v-text-field
                                    v-model="user_name"
                                    :rules="[() => !!user_name || 'Required']"
                                    dense
                                    outlined
                                    label="Username"
                                    prepend-icon="mdi-account"
                                ></v-text-field>

                                <v-text-field
                                    v-model="pass_word"
                                    :rules="[() => !!pass_word || 'Required']"
                                    dense
                                    outlined
                                    label="Password"
                                    prepend-icon="mdi-lock"
                                    :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="showPass = !showPass"
                                    :type="showPass ? 'text' : 'password'"
                                ></v-text-field>
                            </v-card-text>
                            <h5 >
                                <p>
                                    <a style="color:#c5aa6a"  @click="mRegister()">Don't have account yet? Register here!</a>
                                </p>
                            </h5>
                            <v-spacer></v-spacer>
                            <v-btn
                                class="text-right"
                                @click="mLogin()"
                            >Login</v-btn>
                        </v-card>
                    </v-form>
                    </v-col>
                </v-row>
            </v-card>


            <template>
              <v-dialog v-model="registerDialog" max-width="700px" persistent>
                <v-form ref="regForm" lazy-validation>
                  <v-card >
                    <v-card-title style="background-color: #c5aa6a; color:white" >REGISTRATION
                      <v-spacer/>
                      <span class="cursor" @click="mCloseRegDialog()">❌</span>
                    </v-card-title>
                    <v-card-text class="pb-0">
                      <v-tabs v-model="tab" >
                        <v-tab>Personal Info
                          <v-icon>mdi-account-tie</v-icon>
                        </v-tab>
                        <v-tab disabled>Job Info
                          <v-icon>mdi-briefcase-account</v-icon>
                        </v-tab>
                      </v-tabs>

                          <v-card flat  v-if="tab != 1">
                            <v-card-text class="pb-0">
                              <v-row no-gutters> 
                                <v-col   v-for="(items1,index1) in PersonalInfoRow1" :key="index1" >
                                  <v-text-field 
                                    @keypress="isChar($event)"
                                    @keydown="preventSpace($event,items1.value)"
                                    dense 
                                    outlined 
                                    :label="items1.Label"
                                    v-model="items1.value"
                                  />
                                </v-col>
                              </v-row>
                              
                              <v-row no-gutters> 
                                <v-col  v-for="(items2,index2) in PersonalInfoRow2" :key="index2" >
                                  <v-menu v-if="items2.Label == 'Birth Date'"
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
                                          label="Date of Birth"
                                          prepend-inner-icon="mdi-calendar"
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
                                  <v-text-field v-else-if="items2.Label =='Age'"
                                    readonly
                                    dense 
                                    outlined 
                                    :label="items2.Label"
                                    v-model="ageComputed"
                                  />
                                  <v-text-field v-else
                                    @keypress="isChar($event)" 
                                    @keydown="preventSpace($event,items2.value)" 
                                    dense 
                                    outlined 
                                    :label="items2.Label"
                                    v-model="items2.value"
                                  />
                                </v-col>
                              </v-row>

                              <v-row no-gutters > 
                                <v-col v-for="(items3,index3) in PersonalInfoRow3" :key="index3" >
                                  <v-text-field
                                    v-if="items3.Label == 'Email'"
                                    :rules="[
                                      v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) || 'e.g. example123@gmail.com'
                                    ]"
                                    hint="e.g. example123@gmail.com"
                                    outlined 
                                    dense
                                    @keydown="preventSpace($event,items3.value)"
                                    :label="items3.Label"
                                    v-model="items3.value"
                                  />

                                  <v-text-field
                                    @keydown="preventSpace($event,items3.value)" 
                                    v-else-if="items3.Label == 'Password'"
                                    dense 
                                    outlined 
                                    :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="showPass = !showPass"
                                    :type="showPass ? 'text' : 'password'"
                                    :label="items3.Label"
                                    v-model="items3.value"
                                  />

                                  <v-text-field
                                    @keydown="preventSpace($event,items3.value)" 
                                    v-else
                                    dense 
                                    outlined 
                                    :label="items3.Label"
                                    v-model="items3.value"
                                  />

                                 
                                </v-col>
                              </v-row>

                              <v-row no-gutters align="center" justify="center"> 
                                <v-col cols="6" align="center" justify="center" v-for="(items4,index4) in PersonalInfoRow4" :key="index4" >
                                  <!-- <v-select v-if="items4.Label == 'Course Graduated'"
                                  v-model="selectedCourse"
                                  item-text="CourseName"
                                  item-value="CourseID"
                                  :items="avail_courses"
                                  label="Course graduated"
                                  dense 
                                  outlined
                                  /> -->

                                  <v-text-field 
                                    @keydown="preventSpace($event,items4.value)"
                                    label="Contact Number"
                                    maxlength="11"
                                    hint="e.g. 09123456789"
                                    dense 
                                    outlined
                                    @keypress="isNumber($event)"
                                    v-model="items4.value"
                                  />
                                  <!-- <v-text-field 
                                    @keypress="isNumber($event)"
                                    @keydown="preventSpace($event,items4.value)"
                                    v-else
                                    maxlength="4"
                                    hint="e.g. 2024"
                                    dense 
                                    outlined 
                                    :label="items4.Label"
                                    v-model="items4.value"
                                  /> -->

                                  
                                </v-col>
                              </v-row>
                              
                            </v-card-text>
                          </v-card>


                          <v-card v-else flat>
                            <v-card-text>
                              <v-row no-gutters v-for="(jobItem, jobIndex) in JobInfo" :key="jobIndex">
                                <v-col >
                                  <v-text-field
                                    dense 
                                    outlined 
                                    :label="jobItem.Label"
                                    v-model="jobItem.value"
                                    :hint="jobItem.hint"
                                  />
                                </v-col>
                                <v-col v-if="jobItem.Label == 'Job Title'" cols="3" >
                                  <div class="radio-container">
                                    <span class="mb-0">Related to your course?</span>
                                    <v-radio-group v-model="isrelatedToCourse" row class="mt-0 pt-0">
                                      <v-radio
                                        class="mt-0"
                                        value="yes"
                                        label="Yes"
                                      ></v-radio>
                                      <v-radio
                                        class="mt-0"
                                        value="no"
                                        label="No"
                                      ></v-radio>
                                    </v-radio-group>
                                  </div>
                                </v-col>
                              </v-row>
                              <v-row no-gutters align="center" justify="center">
                                <v-col cols="6">
                                  <v-menu 
                                    v-model="menuStart"
                                    :close-on-content-click="false"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto">
                                    <template v-slot:activator="{on,attrs}">
                                      <v-text-field
                                          v-model="StartFormatDate"
                                          hide-details
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
                                <!-- <v-col cols="6">
                                  <v-menu 
                                    v-model="menuEnd"
                                    :close-on-content-click="false"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto">
                                    <template v-slot:activator="{on,attrs}">
                                      <v-text-field
                                          v-model="EndFormatDate"
                                          hide-details
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
                                </v-col> -->
                              </v-row>
                            </v-card-text>
                          </v-card>


                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn :disabled="tab != 1 ? isButtonEnabled : isSubmitEnabled" @click = submitReg()>{{ tab == 1 ? 'Submit' : 'Next' }}</v-btn>
                     
                    </v-card-actions>


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
                </v-form>
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

        </v-layout>
    </v-container>
</template>
<script>
import axios from 'axios';
// import CryptoJS from 'vue-cryptojs'
import CryptoJS from 'crypto-js'
import Swal from 'sweetalert2'
import moment from "moment";
export default {
    data() {
        return{
          JobInfo:[
            {Label:'Company Name', value:''},
            {Label:'Company Address', value:''},
            {Label:'Job Title', value:''},
            // {Label:'Industry', value:''},
            // {Label:'Length of service', value:''},
            // {Label: 'Start Date', value:'' ,col: 6},
            // {Label: 'End Date', value: '' , col: 6}
          ],
          PersonalInfoRow1 : [
            {Label:'Surname', value: ''},
            {Label:'First Name', value:''},
            {Label:'Middle Name', value:''},
          ],
          PersonalInfoRow2 : [
            {Label:'Suffix', value:''},
            {Label:'Birth Date', value:''},
            {Label:'Age', value:''},
          ],
          PersonalInfoRow3 : [
            {Label:'Username', value:''},
            {Label:'Password', value:''},
            {Label:'Email', value:''},
            
          ],
          PersonalInfoRow4 : [
            {Label:'Contact Number', value:''},
            // {Label:'Course Graduated', value: ''},
            // {Label:'Batch Year', value:''},
          ],
          tab: '',
          menu1: false,
          menuStart: false,
          menuEnd: false,
          EndFormatDate: '',
          endDate: '',
          StartFormatDate: '',
          formatFirstDate:'',
          birthDate: '',
          age: '',
          startDate:'',
          first_name: '',
          middle_name: '',
          surname: '',
          suffix: '',
          register_username: '',
          register_password: '',
          email: '',
          contact_number: '',
          batch: '',
          selectedCourse:'',
          isrelatedToCourse: null,
          registerDialog: false,

          overlay: false,
          showPass: false,
          user_name: '',
          pass_word: '',
          secret: '123#$%',
          contactMaxLen: 11,
          
          user: [],
          avail_courses: [],
          regData: [],
          regCData: [],

          imageName: '',

          loginStyle: {
              backgroundColor: "white",
              borderRadius: "10px 0px 0px 10px",
              borderBottom: "20px solid white",
              borderTop: "20px solid white",
          },
        }
    },

    created() {
      this.mgetCourses()
      
    },

    computed: {
      ageComputed() {
        if (!this.formatFirstDate) {
          return '';
        }

        const currentDate = moment();
        const birthMoment = moment(this.birthDate);

        const ageYears = currentDate.diff(birthMoment, 'years');


        return ageYears;
       
      },

      computeLOS(){
        if(this.startDate && this.endDate){
          const start = moment(this.startDate, 'YYYY-MM');
          const end = moment(this.endDate, 'YYYY-MM');

          let diff = end.diff(start, 'month', true);

          diff = Math.round(diff);

          let years = Math.floor(diff / 12);
          let remainingMonths = diff % 12;

          // Format the result
          if (years > 0 && remainingMonths > 0) {
            return `${years} Year/s and ${remainingMonths} Month/s`;
          } else if (years > 0) {
            return `${years} Year/s`;
          } else if (remainingMonths > 0) {
            return `${remainingMonths} Month/s`;
          } else {
            return '0';
          }
        }
        
      },


      getMinEndDate(){
        if (!this.startDate) {
          return null;
        }
        
          const startMonth = new Date(this.startDate).getMonth();
          const minEndDate = new Date(this.startDate);
          minEndDate.setMonth(startMonth);
          return minEndDate.toISOString().slice(0, 7);
      },



      disabledDate(){
        if(!this.startDate){
          return true
        }else{
          return false
        }
      },


      isButtonEnabled(){
        let allFieldsFilled  = [...this.PersonalInfoRow1,...this.PersonalInfoRow2,...this.PersonalInfoRow3,...this.PersonalInfoRow4];
        allFieldsFilled.forEach(element => {
          switch (element.Label) {
            case 'Course Graduated':
            allFieldsFilled[`CourseGraduated`] = this.selectedCourse
              break;
            case 'Birth Date':
            allFieldsFilled[`BirthDate`] = this.formatFirstDate
              break;
            case 'Age':
            allFieldsFilled[`Age`] = this.ageComputed
              break;
            default:
              allFieldsFilled[`${element.Label}`] = element.value;
          }
        })
        if (allFieldsFilled[`Age`] == ''  && allFieldsFilled[`BirthDate`] == '' 
          || allFieldsFilled[`Contact Number`] == ''  || allFieldsFilled[`Email`] == ''
          || allFieldsFilled[`First Name`] == '' || allFieldsFilled[`Password`] == ''
          || allFieldsFilled[`Surname`] == '' || allFieldsFilled[`Username`] == '') {
            return true
        }else{
            return false
        }
        
      },
      isSubmitEnabled(){
        let data = [...this.JobInfo]
          data.forEach( element =>{
            let items={
              isRelated: this.isrelatedToCourse,
              StartDate: this.StartFormatDate,
              // EndDate: this.EndFormatDate
            }
            data[`${element.Label}`] = element.value;
            Object.assign(data,items)
          })
          if (data['isRelated'] == null || data['Company Address'] == ''|| data['Company Name'] == ''
            || data['StartDate'] == '' || data['Job Title'] == '') {
            return true
          }else{
            return false
          }
      }

    },

    watch: {
    },

    methods: {
        mRegister(){
          this.registerDialog = true
          this.tab = 0
        },


        mLogin(){
            if(this.$refs.form.validate()){
                this.overlay = true
                axios.get(`api/alumniaccount?Username=${this.user_name}&&Password=${this.pass_word}&&Process=login`).then((res) =>{
                    //  console.log(res.data);
                    if(res.data.length == 0){
                      Swal.fire({
                        title: 'Error',
                        text: 'User not exist!',
                        showConfirmButton: false,
                        icon: 'error',
                        timer: 2000
                      });
                    }else{
                      let data = res.data[0]
                      axios.get(`api/imagelist?id=${data.AlumniID}`)
                      .then((rec) => {
                        // console.log(rec.data,data);
                        if(rec.data.length == 0){
                          
                          this.user = {
                            AlumniID:   data.AlumniID,
                            Username:   CryptoJS.AES.encrypt(data.UserName, this.secret).toString(),
                            Password:   CryptoJS.AES.encrypt(data.Password, this.secret).toString(),
                            LastName:   data.LastName,
                            FirstName:  data.FirstName,
                            MiddleName: data.MiddleName,
                            Suffix:     data.Suffix,
                            Email:      CryptoJS.AES.encrypt(data.Email, this.secret).toString(),
                            ContactNumber:CryptoJS.AES.encrypt(data.ContactNumber, this.secret).toString(),
                            CourseName: data.CourseName,
                            Batch:      data.Batch,
                            UserType:   data.UserTypeName,
                            Image:      'blank.png'
                          }
                        }else{
                          this.user = {
                            AlumniID:   data.AlumniID,
                            Username:   CryptoJS.AES.encrypt(data.UserName, this.secret).toString(),
                            Password:   CryptoJS.AES.encrypt(data.Password, this.secret).toString(),
                            LastName:   data.LastName,
                            FirstName:  data.FirstName,
                            MiddleName: data.MiddleName,
                            Suffix:     data.Suffix,
                            Email:      CryptoJS.AES.encrypt(data.Email, this.secret).toString(),
                            ContactNumber:CryptoJS.AES.encrypt(data.ContactNumber, this.secret).toString(),
                            CourseName: data.CourseName,
                            Batch:      data.Batch,
                            UserType:   data.UserTypeName,
                            Image:      rec.data[0].ImageName
                          }
                        }
                        Swal.fire({
                          title: 'Welcome ' +  this.user.FirstName,
                          text: 'You are successfully logged in!',
                          showConfirmButton: false,
                          icon: 'success',
                          timer: 2000
                        }).then(()=>{
                          this.$store.commit('Login_Info', this.user)
                          this.$router.push('/')
                        })
                      })
                    }
                }).then(()=>{
                    this.overlay = false
                })
            }
        },

        // getProfilePic(){
        //   let userID = this.$store.state.UserInfo.AlumniID
        //     if(userID != undefined){
        //       axios.get(`api/imagelist?id=${userID}`)
        //       .then((res) => {
        //         if(res.data.length != 0){
        //           this.ImageName = res.data[0].ImageName
        //         }else{
        //           this.ImageName = 'blank.png'
        //         }
        //         console.log(this.ImageName);
        //       })
        //     }
        // },

        mgetCourses(){
            axios.get('api/course').then((res =>{
                this.avail_courses = res.data
            }))
        },

        updateFormattedDates(){
          this.formatFirstDate = this.birthDate
          this.menu1 = false
        },

        updateStartDate(){
          this.StartFormatDate = this.startDate
          this.menuStart = false
        },

        // updateEndDate(){
        //   this.EndFormatDate = this.endDate
        //   this.menuEnd = false
        // },

        isNumber(e) {
          let char = String.fromCharCode(e.keyCode);
          if (/^[0-9]+$/.test(char)) return true;
          else e.preventDefault();
        },

        isChar(e) {
          let char = String.fromCharCode(e.keyCode);
          if (/^[a-zA-Z\s]+$/.test(char)) return true;
          else e.preventDefault();
        },

        preventSpace(e,data){
          if (e.key === ' ' && data.length === 0) {
            e.preventDefault();
            return false;
          }
        },



        submitReg(){
          const modifiedData = {};
          const modifedJobInfo = {};
          if(this.tab == 0){
            this.tab = 1
          }else{
            this.regData = [...this.PersonalInfoRow1,...this.PersonalInfoRow2,...this.PersonalInfoRow3,...this.PersonalInfoRow4];
            this.regData.forEach((element, index) => {
              switch (element.Label) {
                case 'Course Graduated':
                  modifiedData[`CourseGraduated`] = this.selectedCourse
                  break;
                case 'Birth Date':
                  modifiedData[`BirthDate`] = this.formatFirstDate
                  break;
                case 'Age':
                  modifiedData[`Age`] = this.ageComputed
                  break;
                default:
                  modifiedData[`${element.Label}`] = element.value;
              }
            })

            this.regCData = [...this.JobInfo]
              this.regCData.forEach( element =>{
                let isRelated={
                  isRelated: this.isrelatedToCourse,
                  StartDate: this.StartFormatDate,
                  // EndDate: this.EndFormatDate,
                  LOS: this.computeLOS
                }
                modifedJobInfo[`${element.Label}`] = element.value;
                Object.assign(modifedJobInfo,isRelated)
              })

              
            return this.insertRegister(modifiedData,modifedJobInfo)

            
          }
        },


        insertRegister(PerInfo,JobInfo){
          this.overlay = true
          let data = {PerInfo,JobInfo}
          axios.post(`api/alumniaccount?`, data)
          .then((res)=>{
            console.log(res.data);
            if(res.data == 'Account already exist!'){
              Swal.fire({
                title: res.data,
                text: "There's already account for this user",
                showConfirmButton: false,
                icon: 'error',
                timer: 3000
              }).then(()=>{
                this.overlay = false
              });
            }else if(res.data == 'Username already exist!'){
              Swal.fire({
                title: res.data,
                text: 'Try to use different Username',
                showConfirmButton: false,
                icon: 'error',
                timer: 3000
              }).then(()=>{
                this.overlay = false
              });
            }else if(res.data =='Register first'){
              Swal.fire({
                title: 'Need to register in Master!',
                text: 'Please reach admin for registration',
                showConfirmButton: false,
                icon: 'error',
                timer: 3000
              }).then(()=>{
                this.overlay = false
              });
            }else{
              this.mCloseRegDialog()
              Swal.fire({
                title: 'Successfully registerd',
                text: 'You may now log in',
                showConfirmButton: false,
                icon: 'success',
                timer: 3000
              })
            }
            
          })
        },

        mCloseRegDialog(){
          this.registerDialog = false
          this.overlay = false
          this.formatFirstDate = ''
          this.selectedCourse = ''
          this.isrelatedToCourse = null
          let info =  [...this.PersonalInfoRow1,...this.PersonalInfoRow2,...this.PersonalInfoRow3,...this.PersonalInfoRow4];
          info.forEach(element => {
             element.value = ''
          });

          let job = [...this.JobInfo]
          job.forEach(element => {
            element.value = ''
          });
        }
    },
}
</script>

<style>

.infotext {
  margin: 1px;
  font-family: cursive;
  font-weight: bold;
  /* color: #c5aa6a; */
  position: relative;
  animation-name: fadeInOpacity;
  animation-duration: 3s;
  animation-fill-mode: forwards;
}

/* @keyframes example2 {
  from {
    bottom: -100px;
  }
  to {
    bottom: 0px;
  }
} */

@keyframes fadeInOpacity {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

.img2 {
  position: relative;
  animation-name: fadeInOpacity;
  animation-duration: 3s;
  animation-fill-mode: forwards;
}

@keyframes example1 {
  from {
    top: -100px;
  }
  to {
    top: 0px;
  }
}

.img {
  position: relative;
  animation-name: example;
  animation-duration: 3s;
  animation-fill-mode: forwards;
}


img {
  width: 100%;
  height: auto;
}


.radio-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.radio-container span {
  margin-bottom: 16px;
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